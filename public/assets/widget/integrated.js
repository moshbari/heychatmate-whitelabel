
if (typeof chatbotTogglerss === 'undefined' || chatbotTogglerss === null) {
    const chatbotTogglerss = document.querySelector(".chatbot-toggler");
    chatbotTogglerss.addEventListener("click", () => document.body.classList.toggle("show-chatbot"));
}

if (typeof closeBtnss === 'undefined' || closeBtnss === null) {
    const closeBtnss = document.querySelector(".close-btn");
    closeBtnss.addEventListener("click", () => document.body.classList.remove("show-chatbot"));
}

  const numericCharacters = '0123456789';
  const key = '9876543210';

function encryptCrypto(text) {
  if (typeof text !== 'string' || !/^\d+$/.test(text)) {
    throw new TypeError('Input must be a numeric string');
  }
  return text.split('').map(char => {
    const index = numericCharacters.indexOf(char);
    return index === -1 ? char : key[index]; // Replace with corresponding char in key
  }).join('');
}

function decryptCrypto(text) {
  if (typeof text !== 'string' || !/^\d+$/.test(text)) {
    throw new TypeError('Input must be a numeric string');
  }
  return text.split('').map(char => {
    const index = key.indexOf(char);
    return index === -1 ? char : numericCharacters[index]; // Replace with corresponding char in numericCharacters
  }).join('');
}
jQuery(document).ready(function () {

  adjustScroll();
  console.log(window.channelID + decryptCrypto(sessionStorage.getItem("qqdatas")));
  console.log(window.eventlID + decryptCrypto(sessionStorage.getItem("qqdatas")));
});


jQuery.getScript('https://js.pusher.com/7.0/pusher.min.js', function () {

  //Pusher
  const pusher = new Pusher(window.keys, {
    cluster: 'ap2'
  });
  const channel = pusher.subscribe(window.channelID + decryptCrypto(sessionStorage.getItem("qqdatas")));

  //Receive messages
  channel.bind(window.eventlID + decryptCrypto(sessionStorage.getItem("qqdatas")), function (data) {
    console.log(data);
    jQuery.post(hostUrl + "embed/receive", {
      _token: window.csrf,
      uid: sessionStorage.getItem("key_id"),
      message: data.message,
    })
      .done(function (res) {
        console.log(res);
        jQuery(".chatbox").append(res);
        playSound(hostUrl + "assets/notification4.mp3");
        adjustScroll();
      });
  });

  //Broadcast messages


  jQuery(document).on('click', '#send-btn', function (event) {

    event.preventDefault();
    handleChatEntry();

  });

  jQuery(document).on('keypress', '#reply', function (event) {
    if (event.which === 13) {
      event.preventDefault();
      handleChatEntry();
    }
  });

  function handleChatEntry() {
    var inpts = jQuery("#reply").val();

    if (inpts.length === 0) {
      return false;
    }
    jQuery("#reply").val('');
    jQuery(".chatbox").append(`<li class="chat outgoing">
  <div>` + inpts + `</div>
</li>`);
    adjustScroll();
    setTimeout(
      jQuery(".chatbox").append(`
        <li class="chat incoming" id="typing-dots">
          <img src="` + thumb + `" alt="" class="admin-icon">
          <p class="dot-typing"></p>
        </li>`), 1000);

    setTimeout(
      adjustScroll(), 1100);

    jQuery.ajax({
      url: hostUrl + "embed/broadcast",
      method: 'POST',
      headers: {
        'X-Socket-Id': pusher.connection.socket_id
      },
      data: {
        _token: window.csrf,
        uid: sessionStorage.getItem("key_id"),
        message: inpts,
      }
    }).done(function (res) {

      jQuery("#typing-dots").remove();
      var randID = Math.floor(Math.random() * 10000000) + 1;
      if (window.typeEffect == 1) {
        var element = document.createElement('li');
        element.className = "chat incoming";
        element.innerHTML = `<img src="${thumb}" alt="" class="admin-icon"><div id="${randID}"></div>`;
        jQuery(".chatbox").append(element);

        var typed = new Typed(document.getElementById(randID), {
          strings: [res],
          typeSpeed: 50,
          showCursor: false,
          onComplete: function () {
            adjustScroll();
          }
        });
      } else {
        jQuery(".chatbox").append(res);
      }
      //$(".chatbox").append(res);
      adjustScroll();

    });
  }


});


function adjustScroll() {
  var height = 0;
  jQuery('.chatbox .chat').each(function (i, value) {
    height += parseInt(jQuery(this).height());
  });

  height += '20';

  jQuery('.chatbox').animate({
    scrollTop: height
  });
}



function playSound(url) {
  const audio = new Audio(url);
  audio.play();
}

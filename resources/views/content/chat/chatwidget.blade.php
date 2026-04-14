(function() {

document.addEventListener("DOMContentLoaded", function() {

window.channelID = "chat-";
window.eventlID = "event-";
window.typeEffect = {{$assistant->type_effect}};


window.csrf = "{{ csrf_token() }}";
window.hostUrl = "{{ url('/') }}/";
window.thumb = "{{ asset('assets/img/avatars/' . $assistant->avatar) }}";


if ({{$assistant->type_effect}} == "1") {
loadScriptIfNotExists("https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js");
}

function createChatWidget() {
const link = document.createElement("link");
link.rel = "stylesheet";
link.href = "{{ route('chat.widget.styles', $assistant->slug) }}";

document.head.appendChild(link);

link.onload = function() {
const chatWrapper = document.createElement("div");
chatWrapper.className = "dd-chat-wrapper";

const togglerButton = document.createElement("button");
togglerButton.className = "chatbot-toggler";

const floatingText = document.createElement("div");
floatingText.className = "hey-floating-text";
floatingText.textContent = "{{$assistant->floating_text}}";

const span1 = document.createElement("span");
span1.className = "material-symbols-rounded";

const span2 = document.createElement("span");
span2.className = "material-symbols-outlined";
span2.textContent = "close";

togglerButton.appendChild(span1);
togglerButton.appendChild(span2);

const img1 = document.createElement("img");
img1.className = "chat-btn-icon";
img1.src = "{{ $assistant->chat_icon != ""?asset('assets/img/icons/hey-icons/'.$assistant->chat_icon): asset('assets/img/icons/hey-icons/chat-rect-white.png')}}";

span1.appendChild(img1);

const chatbotDiv = document.createElement("div");
chatbotDiv.className = "chatbot";

const header = document.createElement("header");

const h2 = document.createElement("h2");
h2.textContent = "{{ $assistant->chat_title }}";

const closeSpan = document.createElement("span");
closeSpan.className = "close-btn material-symbols-outlined";
closeSpan.textContent = "close";

header.appendChild(h2);
header.appendChild(closeSpan);

chatbotDiv.appendChild(header);


chatWrapper.appendChild(togglerButton);
if ("{{$assistant->floating_text}}" != null) {
chatWrapper.appendChild(floatingText);
}

chatWrapper.appendChild(chatbotDiv);

document.body.appendChild(chatWrapper);


if (sessionStorage.getItem("formSubmitted") === "1") {



loadScriptIfNotExists(
"{{ asset('assets/widget/integrated.js?v=' . rand(1, 1000)) }}");


createChatboxAndInput(chatbotDiv);

} else {
createForm(chatbotDiv);
const script = document.createElement("script");
script.src = "{{ asset('assets/widget/form.js') }}";
document.body.appendChild(script);
}
};
}

window.keys = "{{ config('broadcasting.connections.pusher.key') }}";
function createForm(chatbotDiv) {
const formWrapper = document.createElement("div");
formWrapper.className = "form-wrapper";

const form = document.createElement("form");

const nameLabel = document.createElement("label");
nameLabel.textContent = "Name:";
const nameInput = document.createElement("input");
nameInput.className = "css-input";
nameInput.type = "text";
nameInput.placeholder = "Name";
nameInput.name = "name";
nameInput.required = true;

const emailLabel = document.createElement("label");
emailLabel.textContent = "Email:";
const emailInput = document.createElement("input");
emailInput.className = "css-input";
emailInput.type = "email";
emailInput.placeholder = "Email";
emailInput.name = "customer_email";
emailInput.required = true;


const phoneLabel = document.createElement("label");
phoneLabel.textContent = "Phone Number:";
const phoneInput = document.createElement("input");
phoneInput.className = "css-input";
phoneInput.type = "text";
phoneInput.placeholder = "Phone Number";
phoneInput.name = "customer_phone";
phoneInput.required = true;

const submitButton = document.createElement("button");
submitButton.className = "testbutton";
submitButton.type = "submit";
submitButton.textContent = "Submit";

// form.appendChild(nameLabel);
form.appendChild(nameInput);
// form.appendChild(emailLabel);
form.appendChild(emailInput);
@if ($assistant->phone_field)
form.appendChild(phoneInput);
@endif

form.appendChild(submitButton);

formWrapper.appendChild(form);
chatbotDiv.appendChild(formWrapper);

form.addEventListener("submit", function(event) {
event.preventDefault();
const formData = new FormData(event.target);


formData.append('_token', csrf);
formData.append('uid', sessionStorage.getItem("key_id"));


fetch(hostUrl + 'widgets/info', {
method: 'POST',
body: formData
})
.then(response => response.json())
.then(res => {
if (res.status == 1) {
sessionStorage.setItem("formSubmitted", "1");
formWrapper.remove(); // Remove form after submission
createChatboxAndInput(chatbotDiv); // Show chatbox and input
} else {
document.getElementById('err').innerHTML =
'Please wait some moments and try again.';
}
})
.catch(error => {
console.error('Error:', error);
document.getElementById('err').innerHTML =
'An error occurred. Please try again later.';
});

});
}


function createChatboxAndInput(chatbotDiv) {
const chatboxUl = document.createElement("ul");
chatboxUl.className = "chatbox";

const incomingLi = document.createElement("li");
incomingLi.className = "chat incoming";

const chatIconSpan = document.createElement("img");
chatIconSpan.className = "admin-icon";
chatIconSpan.src = window.thumb;


const chatMessageP = document.createElement("div");
chatMessageP.innerHTML = '{!! $assistant->first_reply !!}';

incomingLi.appendChild(chatIconSpan);
incomingLi.appendChild(chatMessageP);

chatboxUl.appendChild(incomingLi);

const chatInputDiv = document.createElement("div");
chatInputDiv.className = "chat-input";

const textarea = document.createElement("textarea");
textarea.placeholder = "Enter a message...";
textarea.id = "reply";
textarea.spellcheck = false;
textarea.required = true;

const sendButtonSpan = document.createElement("span");
sendButtonSpan.id = "send-btn";
sendButtonSpan.className = "material-symbols-rounded";
sendButtonSpan.textContent = "send";

chatInputDiv.appendChild(textarea);
chatInputDiv.appendChild(sendButtonSpan);

chatbotDiv.appendChild(chatboxUl);
chatbotDiv.appendChild(chatInputDiv);
loadScriptIfNotExists(
"{{ asset('assets/widget/integrated.js?v=' . rand(1, 1000)) }}");
}

// Start by creating the chat widget
createChatWidget();

function removeScript() {
const scriptTags = document.getElementsByTagName("script");
for (let i = 0; i < scriptTags.length; i++) {
    if (scriptTags[i].src.includes("{{ asset('assets/widget/form.js') }}")) {
    scriptTags[i].remove(); // Remove the script element from the DOM
    break; // Exit the loop after removing the script
    }
    }
    }

    function loadScriptIfNotExists(scriptUrl) {
    const scriptTags=document.getElementsByTagName("script");
    let scriptExists=false;

    for (let i=0; i < scriptTags.length; i++) {
    if (scriptTags[i].src.includes("integrated.js")) {
    scriptExists=true;
    break;
    }
    }
    console.log(scriptExists);

    if (!scriptExists) {
    // Script does not exist, so load it
    const script=document.createElement("script");
    script.src=scriptUrl;
    document.body.appendChild(script);
    }
    }


    function checkAndSetKey() {
    const key='key_id' ;

    if (!sessionStorage.getItem(key)) {
    fetch("{{ route('chat.widget.create', $assistant->slug) }}")
    .then(response=> response.json())
    .then(data => {
    const newKey = data.key_id;
    const qqdata = data.qq_data;
    sessionStorage.setItem(key, newKey);
    sessionStorage.setItem('qqdatas', encryptCrypto(qqdata.toString()));
    console.log('Key has been set:', newKey);
    })
    .catch(error => {
    console.error('Error fetching the key:', error);
    });
    } else {
    const existingKey = sessionStorage.getItem(key);
    setTimeout(() => {
    fetch("{{ route('chat.widget.oldchats') }}?uid=" + existingKey)
    .then(response => {
    if (!response.ok) {
    throw new Error('Network response was not ok');
    }
    return response.text(); // Change to response.text() to get HTML content
    })
    .then(html => {
    // Assuming you have a chatbox element with the class "chatbox"
    const chatbox = document.querySelector('.chatbox');
    chatbox.insertAdjacentHTML('beforeend', html); // Append the HTML to the chatbox
    autoScroll();
    })
    .catch(error => {
    console.log('Error Loading old Chats:', error);
    });
    console.log('Existing key:', existingKey);
    },500)

    }
    }

    checkAndSetKey();


    });


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
    function autoScroll() {
    var height = 0;
    jQuery('.chatbox .chat').each(function (i, value) {
    height += parseInt(jQuery(this).height());
    });

    height += '20';

    jQuery('.chatbox').animate({
    scrollTop: height
    });
    }
    function loadScript(url, callback) {
    var script = document.createElement('script');
    script.src = url;
    script.onload = callback;
    script.onerror = function() {
    console.error('Failed to load script:', url);
    };
    document.head.appendChild(script);
    }


    // Check if jQuery is already loaded
    if (typeof jQuery === 'undefined') {
    // Load jQuery
    loadScript('https://code.jquery.com/jquery-3.6.0.min.js', function() {
    console.log('jQuery loaded successfully.');
    });
    }

    })();
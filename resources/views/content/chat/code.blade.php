(function () {


    window.c1 = window.c1 || {};
    var iframe2 = document.createElement('div');
    iframe2.id = "iframe2";
    var styles = {
        "border": "0px",
        "background": "none!important",
        "background-color": "transparent!important",
        "pointer-events": "none",
        "z-index": "2147483639",
        "position": "fixed",
        "bottom": "0px",
        "width": window.c1.iframeWidth,
        "height": window.c1.iframeHeight,
        "overflow": "hidden",
        "opacity": "1",
        "max-width": "100%",
        "right": "0px",
        "max-height": "100%",
        "color-scheme": "auto",
    };
    Object.assign(iframe2.style, styles);
    var iframe1 = document.createElement('iframe');


    iframe1.src = '{{route('chat.button',$assistant->slug)}}?domain='+window.location.href;
    iframe1.id = "iframe1";
    iframe1.allow = "autoplay; camera; microphone";
    iframe1.sandbox="allow-same-origin allow-scripts allow-popups allow-forms sandbox allow-popups-to-escape-sandbox allow-downloads allow-modals allow-popups allow-presentation allow-top-navigation-by-user-activation";

    //iframe1.sandbox="allow-storage-access-by-user-activation allow-scripts allow-same-origin";
    var styles = {
        "pointer-events": "all",
        "background": "none",
        "border": "0px",
        "float": "none",
        "position": "absolute",
        "inset": "0px",
        "width": "100%",
        "height": "100%",
        "margin": "0px",
        "padding": "0px",
        "min-height": "0px"
    };
    Object.assign(iframe1.style, styles);
    iframe2.appendChild(iframe1);
    document.querySelector('body').appendChild(iframe2);

    {{-- window.addEventListener("message", function(event) {
    if (event.origin !== "http://localhost") return;
    switch(event.data) {
    case "open":
    document.getElementById("iframe2").style.height = "750px";
    break;
    case "close":
    document.getElementById("iframe2").style.height = "150px";
    break;
    }


    // Set height of parent div based on message from iframe
    }); --}}

})();


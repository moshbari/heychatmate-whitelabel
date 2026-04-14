// chatbox.js

(function () {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'https://app.heychatmate.com/integrated/abd6629e3b0813e981b5f4bce9fd38a51caa2166', true); // Change '/path/to/laravel/route' to the actual Laravel route
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Create chatbox div
                var chatboxDiv = document.createElement('div');
                chatboxDiv.id = 'chatbox';
                chatboxDiv.innerHTML = xhr.responseText;

                // Append chatbox div to body
                document.body.appendChild(chatboxDiv);
            } else {
                console.error('Failed to fetch chatbox content');
            }
        }
    };
    xhr.send();
})();

const chatbotTogglerss = document.querySelector(".chatbot-toggler");
const closeBtnss = document.querySelector(".close-btn");
closeBtnss.addEventListener("click", () => document.body.classList.remove("show-chatbot"));
chatbotTogglerss.addEventListener("click", () => document.body.classList.toggle("show-chatbot"));

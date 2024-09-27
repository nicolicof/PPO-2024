const chatMessages = document.getElementById('chat-messages');

function scrollToBottom() {
	chatMessages.scrollTop = chatMessages.scrollHeight;
}

window.onload = scrollToBottom;

const form = document.querySelector('.chat_form form');
form.addEventListener('submit', function() {
	setTimeout(scrollToBottom, 100);
});

const textarea = document.querySelector('.chat-container section form textarea');
const section = document.querySelector('.chat-container section');

textarea.addEventListener('focus', () => {
	section.classList.add('focused');
});

textarea.addEventListener('blur', () => {
	section.classList.remove('focused');
});

function ajustarAltura(textarea) {
	textarea.style.height = 'auto';
	textarea.style.height = (textarea.scrollHeight) + 'px';
}
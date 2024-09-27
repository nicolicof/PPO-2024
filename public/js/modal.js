function createModal(modalId, title, formHtml) {
	const modal = document.createElement('div');
	modal.id = modalId;
	modal.className = 'modal';

	const modalContent = document.createElement('div');
	modalContent.className = 'modal-content';

	const closeSpan = document.createElement('span');
	closeSpan.className = 'close';
	closeSpan.innerHTML = '&times;';
	modalContent.appendChild(closeSpan);

	const modalTitle = document.createElement('h2');
	modalTitle.textContent = title;
	modalContent.appendChild(modalTitle);

	const form = document.createElement('form');
	form.innerHTML = formHtml;
	modalContent.appendChild(form);

	modal.appendChild(modalContent);
	document.body.appendChild(modal);

	closeSpan.onclick = function() {
		modal.classList.remove("show");
		document.body.removeChild(modal);
	}

	window.onclick = function(event) {
		if (event.target == modal) {
			modal.classList.remove("show");
			document.body.removeChild(modal);
		}
	}

	return modal;
}

document.getElementById("openModal").onclick = function() {
	const formHtml = `
		<label for="email">Novo Email:</label>
		<input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($user['email']); ?>"><br><br>
		<label for="password">Nova Senha:</label>
		<input type="password" id="password" name="password" required><br><br>
		<button type="button" id="confirmUpdateBtn">Atualizar</button>
	`;

	const modal = createModal('myModal', 'Alterar Dados', formHtml);
	modal.classList.add("show");

	document.getElementById("confirmUpdateBtn").onclick = function() {
		modal.classList.remove("show");
		document.body.removeChild(modal);
		createVerificationModal();
	}
}

function createVerificationModal() {
	const formHtml = `
		<label for="current_email">Email Atual:</label>
		<input type="email" id="current_email" name="current_email" required><br><br>
		<label for="current_password">Senha Atual:</label>
		<input type="password" id="current_password" name="current_password" required><br><br>
		<button type="submit" name="confirm_update">Confirmar Atualização</button>
	`;

	const modal = createModal('verificationModal', 'Verificação', formHtml);
	modal.classList.add("show");
}
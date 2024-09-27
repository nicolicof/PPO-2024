<?php
require '../php/process_profile.php'
?>
<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="../public/css/style.css" />
		<title>SDIP</title>
		<style>
			.modal {
				position: fixed;
				z-index: 1;
				left: 0;
				top: 0;
				width: 100%;
				height: 100%;
				overflow: auto;
				background-color: rgba(0, 0, 0, 0.6);
				padding-top: 80px;
				visibility: hidden;
			}
			.modal.show {
				opacity: 1;
				visibility: visible;
			}
			.modal-content {
				display:flex;
				flex-direction: column;
				background-color: #fff;
				border: 1px solid #e6e6e6;
				border-radius: 4px;
				margin: 5% auto;
				padding: 20px 32px 42px 32px;
				width: 390px;
			}
			.modal-content h2{
				margin-top: 22px;
				font-size: 24px;
			}
			.modal-content form{
				margin-top: 32px;
				display: flex;
				flex-direction: column;
				gap: 22px
			}
			.modal-content form div{
				width: 100%;
				display: flex;
				flex-direction: column;
				gap: 8px
			}
			.modal-content form div input{
				background-color: #E3E3E3;
				border: 1px solid #DBDBDB;
			}
			.modal-content form div input:focus{
				border: 1px solid #2563EB;
			}
			.modal-content form button{
				background-color: #2563EB;
				border: 1px solid #2563EB;
				margin-top: 12px;
				padding: 15px 0;
			}
			.modal-content form button:hover{
				background-color: #1659e9;
			}
			.modal-content form button:active{
				background-color: #1453db;
			}
			.close {
				color: #aaa;
				align-self: flex-end;
				font-size: 28px;
				font-weight: bold;
			}
			.close:hover,
			.close:focus {
				color: black;
				text-decoration: none;
				cursor: pointer;
			}
			#openModal{
				grid-row: 3;
				cursor: pointer;
				justify-self: flex-start;
				padding: 8px 24px 8px 24px;
				background-color: #2563EB;
				border: 1px solid #1659e9;
			}
			#openModal:hover{
				background-color: #1659e9;
			}

			#openModal:active{
				background-color: #1453db;
			}
		</style>
	</head>
	<body>
		<header>
			<div class="header">
				<div class="logo">
					<span>SDIP</span>
					<span>- Sistema de Denúncias de Infraestruturas Públicas</span>
				</div>
				<a class="perfil_btn" href="./address_search.php"><img src="../public/img/search_white.svg">Procurar</a>
			</div>
		</header>
		<main>
			<div>
				<div class="perfil_container">
					<div class="perfil-info">
						<h1>Seus dados, <?php echo htmlspecialchars($user['name']); ?>:</h1>
						<ul>
							<li>Email: <?php echo htmlspecialchars($user['email']); ?></li>
							<li>Senha: <?php echo htmlspecialchars("xxxxxxxx"); ?></li>
							<li>Cidade: <?php echo htmlspecialchars($user['city']); ?></li>
						</ul>
						<button id="openModal">Alterar Dados</button>
						<form method="post">
							<button class="red-btn" type="submit" name="logout">Sair <img src="../public/img/exit.svg" alt="Sair" /></button>
						</form>
					</div>
					<div class="perfil_relatos">
						<h2>Denúncias feitas por você</h2>
						<div class="relatos-bx">
							<?php if (!empty($denuncias)): ?>
								<?php foreach ($denuncias as $denuncia): ?>
									<div>
										<div>
											<p><?php echo htmlspecialchars($denuncia['nome_local']); ?></p>
											<p><?php echo htmlspecialchars($denuncia['rua']); ?></p>
										</div>
										<a href="chat.php?denuncia_id=<?php echo htmlspecialchars($denuncia['denuncia_id']); ?>">
											<button class="blue-btn">Ver denúncia</button>
										</a>
									</div>
								<?php endforeach; ?>
							<?php else: ?>
								<p>Você ainda não fez nenhuma denúncia.</p>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</main>
		<script>
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
					<div>
						<label for="email">Email</label>
						<input type="email" placeholder="Seu novo email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
					</div>
					<div>
						<label for="password">Senha</label>
						<input type="password" placeholder="Sua nova senha" id="password" name="password">
					</div>
					<button type="button" id="confirmUpdateBtn">Atualizar</button>
				`;
				const modal = createModal('myModal', 'Seus novos dados', formHtml);
				modal.classList.add("show");
				document.getElementById("confirmUpdateBtn").onclick = function() {
					modal.classList.remove("show");
					document.body.removeChild(modal);
					createVerificationModal();
				}
			}
			function createVerificationModal() {
				const formHtml = `
					<div>
						<label for="current_email">Email</label>
						<input type="email" id="current_email" placeholder="Seu antigo email" name="current_email" required>
					</div>
					<div>
						<label for="current_password">Senha</label>
						<input type="password" id="current_password" placeholder="Sua antiga senha" name="current_password" required>
					</div>
					<button type="submit" name="confirm_update">Atualizar</button>
				`;
				const modal = createModal('verificationModal', 'Autentifique-se', formHtml);
				modal.classList.add("show");
			}
		</script>
	</body>
</html>

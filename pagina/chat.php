<?php
require '../php/process_chat.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="../public/css/style.css" />
		<script src="../public/js/filter.js" defer></script>
		<script src="../public/js/chat.js" defer></script>
		<title>SDIP</title>
	</head>
	<body>
		<header>
			<div class="header">
				<div class="logo">
					<span>SDIP</span>
					<span>- Sistema de Denúncias de Infraestruturas Públicas</span>
				</div>
        <div style="display: flex;gap: 12px;">
          <a class="perfil_btn" href="./address_search.php"><img src="../public/img/search_white.svg">Procurar estrutura</a>
          <a class="perfil_btn" href="profile.php"><img src="../public/img/perfil.svg"/>Perfil</a>
        </div>
			</div>
		</header>
		<main>
			<div>
				<h1 class="assunto-do-chat">Assunto: <?php echo htmlspecialchars($denuncia['assunto']); ?></h1>
				<div class="chat-container">
					<div class="chat-ms" id="chat-messages">
						<?php
						$last_date = null;
						foreach ($messages as $message):
							$current_date = date('Y-m-d', strtotime($message['mensagem_data']));
							if ($last_date !== $current_date):
								?>
								<p class="data"><?php echo date('d/m/Y', strtotime($current_date)); ?></p>
								<?php
								$last_date = $current_date;
							endif;
							$message_class = $message['special'] == $is_special_user ? 'direita' : 'esquerda';
							?>
							<div class="<?php echo $message_class; ?>" style="align-self: <?php echo $message['special'] == $is_special_user ? 'flex-end' : 'flex-start'; ?>;">
								<p><?php echo htmlspecialchars($message['mensagem']); ?></p>
								<span><?php echo date('H:i', strtotime($message['mensagem_data'])); ?></span>
							</div>
						<?php endforeach; ?>
					</div>
					<section class="chat_form" aria-label="Formulário">
						<form onsubmit="return verificarTexto()" action="chat.php?denuncia_id=<?php echo htmlspecialchars($denuncia_id); ?>" method="post">
							<textarea name="reclamacao" id="reclamacao" maxlength="350" placeholder="Digite aqui" oninput="ajustarAltura(this)" required></textarea>
							<button class="send-btn">
								<img src="../public/img/send.svg" class="send-icon" alt="Enviar" />
							</button>
						</form>
					</section>
				</div>
			</div>
		</main>
	</body>
</html>

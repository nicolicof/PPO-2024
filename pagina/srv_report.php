<?php
session_start();
require '../php/checker.php';
runChecks();
checkLogin();
require '../php/db.php';
$id_denuncia = intval($_GET['denuncia_id']);
$sql = "SELECT d.id, d.assunto, d.classificacao, d.created_at, u.name AS nome_usuario, u.email
        FROM denuncia d
        JOIN users u ON d.user_id = u.id
        WHERE d.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_denuncia);
$stmt->execute();
$result = $stmt->get_result();
$denuncia = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="../public/css/style.css" />
		<title>SDIP</title>
		<style>
			.rp-info{
				display:flex;
				flex-direction: column;
				padding: 20px;
				width: 764px;
				border-radius: 4px;
				background-color: #e6e6e6;
				border: 1px solid #D9D9D9;
			}

			.rp-info h1{
				font-size: 22px;
				margin: 8px 0;
			}

			.full-info{
				margin: 18px 0 24px 0;
			}
			
			.info-list{
				display: flex;
				gap: 12px;
				flex-direction: column;
			}
			.info-list > *{
				font-size: 16px;
			}
			.rp-info a{
				align-self: flex-end;
				justify-self: flex-end;
				padding: 11px 28px;
				border-radius: 4px;
				font-size: 16px;
				line-height: 1;
				color: white;
				font-weight: 700;
				border: 1px solid #1659e9;
				background-color: #2563EB;
			}

			.rp-info a:hover{
				background-color: #1659e9;
			}

			.rp-info a:active{
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
				<a class="perfil_btn" href="profile.php"><img src="../public/img/perfil.svg" alt="Perfil" />Perfil</a>
			</div>
		</header>
		<main>
			<div>
				<div class="rp-info">
					<h1>Informações da denúncia:</h1>
					<div class="full-info">
						<ul class="info-list">
							<li><strong>Assunto:</strong> <?php echo htmlspecialchars($denuncia['assunto']); ?></li>
							<li><strong>Classificação:</strong> <?php echo htmlspecialchars($denuncia['classificacao']); ?></li>
							<li><strong>Emitido por:</strong> <?php echo htmlspecialchars($denuncia['nome_usuario']); ?> (<?php echo htmlspecialchars($denuncia['email']); ?>)</li>
							<li><strong>Data de Emissão:</strong> <?php echo date("d/m/Y (H:i)", strtotime($denuncia['created_at'])); ?></li>
						</ul>
					</div>
					<a href="chat.php?denuncia_id=<?php echo htmlspecialchars($denuncia['id']); ?>" class="chat-button">Acessar Chat</a>
				</div>
			</div>
		</main>
	</body>
</html>
<?php
$stmt->close();
$conn->close();
?>

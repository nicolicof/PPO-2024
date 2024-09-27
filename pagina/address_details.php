<?php
  session_start();
  require '../php/checker.php';
  runChecks();
  checkLogin();
  if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $address_id = intval($_GET['id']);
    require '../php/db.php';
    $sql = "SELECT * FROM enderecos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $address_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      $address = $result->fetch_assoc();
    }
  } else {
    header('address_search.php');
    exit();
  }
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../public/css/style.css" />
    <title>SDIP</title>
  </head>
  <body>
    <header>
      <div class="header">
        <div class="logo">
          <span>SDIP</span>
          <span>- Sistema de Denúncias de Infraestruturas Públicas</span>
        </div>
        <a class="perfil_btn" href="profile.php">
          <img src="../public/img/perfil.svg" alt="Perfil">Perfil
        </a>
      </div>
    </header>
    <main>
      <div>
        <div class="local_vw">
          <div class="local_info">
            <h1><?php echo htmlspecialchars($address['nome_local']); ?></h1>
            <h2><?php echo htmlspecialchars($address['rua']); ?></h2>
            <p>Estado: <?php echo htmlspecialchars($address['estado']); ?></p>
            <p>Criação: <?php echo htmlspecialchars($address['criacao']); ?></p>
            <p>Governo: <?php echo htmlspecialchars($address['governo']); ?></p>
            <p>Investimento: <?php echo "R$ " . number_format($address['investimento'], 2, ',', '.'); ?></p>
          </div>
          <div class="local_actions">
            <button id="voltar">
              <img src="../public/img/voltar.svg" alt="Voltar">Voltar
            </button>
            <a href="report.php?address_id=<?php echo $address_id; ?>">Denunciar</a>
          </div>
        </div>
      </div>
    </main>
    <script>
      document.getElementById('voltar').addEventListener('click', function () {
        window.history.back();
      });
    </script>
  </body>
</html>

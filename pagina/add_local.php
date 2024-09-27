<?php
require '../php/checker.php';
runChecks();
$error = isset($_SESSION["error"]) ? $_SESSION["error"] : null;
$success = isset($_SESSION["success"]) ? $_SESSION["success"] : null;
unset($_SESSION["error"]);
unset($_SESSION["success"]);
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  require '../php/db.php';
  $nome_local = trim($_POST['nome_local']);
  $rua = trim($_POST['rua']);
  $estado = !empty($_POST['estado']) ? trim($_POST['estado']) : null;
  $criacao = !empty($_POST['criacao']) ? trim($_POST['criacao']) : null;
  $governo = !empty($_POST['governo']) ? trim($_POST['governo']) : null;
  $investimento = !empty($_POST['investimento']) ? trim($_POST['investimento']) : null;
  if (empty($nome_local) || empty($rua)) {
    $_SESSION["error"] = "Os campos 'Nome do Local' e 'Rua' são obrigatórios.";
    header("Location: add_endereco.php");
    exit;
  }
  $sql = "INSERT INTO enderecos (nome_local, rua, estado, criacao, governo, investimento) 
          VALUES (?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssssd", $nome_local, $rua, $estado, $criacao, $governo, $investimento);
  if ($stmt->execute()) {
    $endereco_id = $stmt->insert_id;
    header("Location: report.php?address_id=" . $endereco_id);
    exit;
  } else {
    $_SESSION["error"] = "Erro ao adicionar o endereço. Tente novamente.";
    header("Location: add_endereco.php");
    exit;
  }
  $stmt->close();
  $conn->close();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../public/css/style.css">
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
      <section class="form-area" aria-label="Formulário">
        <h1 style="font-size: 24px; margin: 0">Novo Endereço</h1>
        <form action="add_local.php" style="display:grid; grid-template-columns: 1fr 1fr; width: 664px; row-gap: 22px; column-gap: 22px; padding: 20px; border-radius: 4px; background-color: #e6e6e6; border: 1px solid #D9D9D9;" autocomplete="off" method="POST">
          <?php if ($error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
          <?php elseif ($success): ?>
            <p class="success"><?php echo htmlspecialchars($success); ?></p>
          <?php endif; ?>
          <div style="grid-column: 1 / -1">
            <label for="nome_local">Local</label>
            <input type="text" id="nome_local" name="nome_local" placeholder="Nome do Local" required>
          </div>
          <div style="grid-column: 1 / -1">
            <label for="rua">Rua</label>
            <input type="text" id="rua" name="rua" placeholder="Rua" required>
          </div>
          <div>
            <label for="estado">Estado (Sigla)</label>
            <input type="text" id="estado" name="estado" placeholder="Estado (ex: SP)" maxlength="2">
          </div>
          <div>
            <label for="criacao">Data de Criação</label>
            <input type="date" id="criacao" name="criacao">
          </div>
          <div>
            <label for="governo">Governo Fundador</label>
            <input type="text" id="governo" name="governo" placeholder="Governo">
          </div>
          <div>
            <label for="investimento">Investimento</label>
            <input type="number" step="0.01" id="investimento" name="investimento" placeholder="Valor do Investimento">
          </div>
          <button style="grid-column: 1/-1" class="blue-btn" type="submit">Adicionar Endereço</button>
        </form>
      </section>
    </div>
  </main>
</body>
</html>

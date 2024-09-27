<?php
  session_start();
  require '../php/checker.php';
  runChecks();
  checkLogin();

  if (isset($_GET['address_id']) && is_numeric($_GET['address_id'])) {
    $address_id = $_GET['address_id'];
    $_SESSION['address_id'] = $address_id;
    require '../php/db.php';

    $sql = "SELECT * FROM enderecos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $address_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $address = $result->fetch_assoc();
    } else {
      header("Location: error.php?message=Address not found");
      exit();
    }
  } else {
    exit();
  }
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../public/css/style.css" />
    <script src="../public/js/filter.js" defer></script>
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
        <div class="denunciar-container">
          <div>
            <div class="denunciar-info">
              <h1><?php echo htmlspecialchars($address['nome_local']); ?></h1>
              <h2><?php echo htmlspecialchars($address['rua']); ?></h2>
            </div>
            <section aria-label="Formulário">
              <form onsubmit="return verificarTexto()" class="denunciar-form" action="../php/process_report.php" method="POST">
                <div>
                  <label for="assunto">Assunto</label>
                  <input type="text" placeholder="Ex: goteiras, paredes quebradas..." maxlength="60" name="assunto" id="assunto" required />
                </div>
                <div>
                  <label for="classificacao">Classificação</label>
                  <select name="classificacao" id="classificacao" required>
                    <option value="estrutura">Estrutura</option>
                    <option value="saneamento">Saneamento</option>
                    <option value="seguranca">Segurança</option>
                  </select>
                </div>
                <div>
                  <label for="reclamacao">Descrição</label>
                  <textarea name="reclamacao" id="reclamacao" maxlength="350" placeholder="Digite o seu comentário. Máximo de 350 caracteres" required></textarea>
                </div>
                <button type="submit">Enviar</button>
              </form>
            </section>
          </div>
        </div>
      </div>
    </main>
  </body>
</html>

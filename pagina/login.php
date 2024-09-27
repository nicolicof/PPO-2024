<?php
  require '../php/checker.php';
  runChecks();
	$error = isset($_SESSION["error"]) ? $_SESSION["error"] : null;
  unset($_SESSION["error"]);
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
      </div>
    </header>
    <main>
      <div>
        <section class="form-area" aria-label="Formulário">
          <h1>Entre na sua conta</h1>
          <form action="../php/process_login.php" autocomplete="off" method="POST">
            <?php if ($error): ?>
              <p class="error"> <?php echo htmlspecialchars($error); ?> </p>
            <?php endif; ?>
            <div>
              <label for="name">Nome</label>
              <input type="name" autocomplete="off" id="name" name="name" placeholder="Seu nome" required>
            </div>
            <div>
              <label for="password">Senha</label>
              <input type="password" autocomplete="off" id="password" name="password" placeholder="Sua senha" required>
            </div>
            <button class="blue-btn" type="submit">Entrar</button>
          </form>
          <p>Não tem conta? <a class="link" href="./register.php">Cadastre-se</a></p>  
        </section>
      </div>
    </main>
    <script>
      window.onload = function() {
        document.getElementById("name").value = "";
        document.getElementById("password").value = "";
      };
    </script>
  </body>
</html>

<?php
require '../php/checker.php';
runChecks();
$error = isset($_SESSION["error"]) ? $_SESSION["error"] : null;
unset($_SESSION["error"]);
?>
<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/public/css/style.css" />
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
          <h1>Crie a sua conta</h1>
          <form action="/php/process_register.php" method="POST" autocomplete="off">
            <?php if ($error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <div>
              <label for="nome">Nome</label>
              <input type="text" autocomplete="off" id="nome" name="nome" placeholder="Seu nome" required />
            </div>
            <div>
              <label for="email">Email</label>
              <input type="email" autocomplete="off" id="email" name="email" placeholder="exemplo@email.com" required />
            </div>
            <div>
              <label for="password">Senha</label>
              <input type="password" autocomplete="off" id="password" name="password" placeholder="Sua senha" required />
            </div>
            <div>
              <label for="cidade">Cidade</label>
              <input type="text" autocomplete="off" id="cidade" name="cidade" placeholder="Sua cidade" required />
            </div>
            <button class="blue-btn" type="submit">Cadastrar</button>
          </form>
          <p>Já tem conta? <a class="link" href="./login.php">Entre</a></p>
        </section>
      </div>
    </main>
  </body>
</html>

<?php
  require '../php/checker.php';
  runChecks();
  checkLogin();
?>
<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../public/css/style.css" />
    <script src="../public/js/search.js" defer></script>
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
          <img src="../public/img/perfil.svg" alt="Perfil" />Perfil
        </a>
      </div>
    </header>
    <main>
      <div>
        <h1 id="search_title">
          Encontre a infraestrutura pelo <span>nome</span> ou <span>endereço</span>
        </h1>
        <div class="search-container">
          <input type="text" id="campo_busca" placeholder="Digite aqui para buscar" />
          <div id="address-list"></div>
        </div>
      </div>
    </main>
  </body>
</html>

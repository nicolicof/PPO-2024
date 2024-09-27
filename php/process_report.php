<?php
require "./db.php";
require "checker.php";
checkLogin();

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $assunto = $_POST["assunto"];
    $descricao = $_POST["reclamacao"];
    $classificacao = $_POST["classificacao"];
    $user_id = $_SESSION["user_id"];
    $address_id = $_SESSION["address_id"];

    $sql =
        "INSERT INTO denuncia (address_id, assunto, descricao, classificacao, user_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssi", $address_id, $assunto, $descricao, $classificacao, $user_id);

    if ($stmt->execute()) {
        $denuncia_id = $stmt->insert_id;

        $sql =
            "INSERT INTO chat (denuncia_id, user_id, mensagem) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $denuncia_id, $user_id, $descricao);
        $stmt->execute();

        header("Location: ../pagina/chat.php?denuncia_id=" . $denuncia_id);
        exit();
    } else {
        echo "Erro ao enviar a denúncia.";
    }
}
?>

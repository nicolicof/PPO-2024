<?php
session_start();
require 'checker.php';
require 'db.php';
runChecks();
checkLogin();

$user_id = $_SESSION['user_id'];

$sql = "SELECT name, email, password, city FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Erro ao buscar informações do usuário.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_update'])) {
    $current_email = $_POST['current_email'];
    $current_password = $_POST['current_password'];
    $new_email = $_POST['email'];
    $new_password = $_POST['password'];

    if ($current_email === $user['email'] && $current_password === $user['password']) {
        $sqlUpdate = "UPDATE users SET email = ?, password = ? WHERE id = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param('ssi', $new_email, $new_password, $user_id);

        if ($stmtUpdate->execute()) {
            header('Location: perfil.php');
            exit();
        } else {
            echo "Erro ao atualizar os dados do usuário.";
        }
    } else {
        echo "Email ou senha atuais incorretos.";
    }
}

$sqlDenuncias = "SELECT d.id AS denuncia_id, d.descricao, e.nome_local, e.rua 
                 FROM denuncia d 
                 JOIN enderecos e ON d.address_id = e.id 
                 WHERE d.user_id = ?";
$stmtDenuncias = $conn->prepare($sqlDenuncias);
$stmtDenuncias->bind_param('i', $user_id);
$stmtDenuncias->execute();
$resultDenuncias = $stmtDenuncias->get_result();
$denuncias = $resultDenuncias->fetch_all(MYSQLI_ASSOC);

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}
?>
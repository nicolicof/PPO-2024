<?php
session_start();
require 'checker.php';
runChecks();
checkLogin();

require 'db.php';

$user_id = $_SESSION['user_id'];
$is_special_user = $_SESSION["user_special"];
$denuncia_id = intval($_GET['denuncia_id']);

$sql_denuncia = "SELECT assunto, descricao AS reclamacao, created_at AS denuncia_data FROM denuncia WHERE id = ?";
$stmt_denuncia = $conn->prepare($sql_denuncia);
$stmt_denuncia->bind_param("i", $denuncia_id);
$stmt_denuncia->execute();
$denuncia_result = $stmt_denuncia->get_result();
$denuncia = $denuncia_result->fetch_assoc();

$sql_mensagens = "SELECT c.mensagem, c.created_at AS mensagem_data, u.name, u.id AS user_id, u.special FROM chat c LEFT JOIN users u ON c.user_id = u.id WHERE c.denuncia_id = ? ORDER BY c.created_at ASC";
$stmt_mensagens = $conn->prepare($sql_mensagens);
$stmt_mensagens->bind_param("i", $denuncia_id);
$stmt_mensagens->execute();
$messages = $stmt_mensagens->get_result()->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $mensagem = $_POST['reclamacao'];

    $sql = "INSERT INTO chat (denuncia_id, user_id, mensagem) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $denuncia_id, $user_id, $mensagem);

    if ($stmt->execute()) {
        header("Location: chat.php?denuncia_id=" . $denuncia_id);
        exit();
    } else {
        echo "Erro ao enviar a mensagem.";
    }
}
?>

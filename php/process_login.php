<?php
require "./db.php";

session_start();    

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if ($password === $user["password"]) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];
            $_SESSION["logged_in"] = true;
            $_SESSION["user_special"] = $user["special"];

            if ($user["special"] == 1) {
                header("Location: ../pagina/srv_list.php");
            } else {
                header("Location: ../pagina/address_search.php");
            }
            exit();
        } else {
            $_SESSION["error"] = "Senha incorreta";
            header("Location: ../pagina/login.php");
            exit();
        }
    } else {
        $_SESSION["error"] = "Úsuario não encontrado";
        header("Location: ../pagina/login.php");
        exit();
    }
} else {
    header("Location: ../pagina/login.php");
    exit();
}
?>

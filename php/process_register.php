<?php
require "./db.php";
session_start();
$erro = "";
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        !empty($_POST["nome"]) &&
        !empty($_POST["email"]) &&
        !empty($_POST["password"]) &&
        !empty($_POST["cidade"])
    ) {
        $name = $_POST["nome"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $city = $_POST["cidade"];

        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION["message"] = "Email já está cadastrado";
            session_destroy();
            header("Location: ../pagina/register.php");
            exit();
        } else {
            $sql =
                "INSERT INTO users (name, email, password, city) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $name, $email, $password, $city);

            if ($stmt->execute()) {
                $user_id = $conn->insert_id;
                $_SESSION["user_id"] = $user_id;
                $_SESSION["user_name"] = $name;
                $_SESSION["logged_in"] = true;

                header("Location: ../pagina/address_search.php");
                exit();
            } else {
                $_SESSION["message"] = "Erro ao cadastrar: " . $conn->error;
                header("Location: ../pagina/register.php");
                exit();
            }
        }
    }
}
?>

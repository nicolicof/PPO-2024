<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function checkLogin()
{
    if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
        $_SESSION["error_message"] =
            "Você precisa estar logado para acessar esta página.";
        header("Location: ../pagina/login.php");
        exit();
    }
}

function checkLoginAttempts($max_attempts = 5, $timeout_duration = 900)
{
    if (!isset($_SESSION["login_attempts"])) {
        $_SESSION["login_attempts"] = 0;
        $_SESSION["last_attempt_time"] = time();
    }

    if ($_SESSION["login_attempts"] >= $max_attempts) {
        $elapsed_time = time() - $_SESSION["last_attempt_time"];
        if ($elapsed_time < $timeout_duration) {
            $_SESSION["error_message"] =
                "Muitas tentativas falhadas. Tente novamente mais tarde.";
            header("Location: login.php");
            exit();
        } else {
            $_SESSION["login_attempts"] = 0;
        }
    }
}

function recordFailedLoginAttempt()
{
    $_SESSION["login_attempts"] += 1;
    $_SESSION["last_attempt_time"] = time();
}

function checkUserAgent()
{
    if (!isset($_SESSION["user_agent"])) {
        $_SESSION["user_agent"] = $_SERVER["HTTP_USER_AGENT"];
    } elseif ($_SESSION["user_agent"] !== $_SERVER["HTTP_USER_AGENT"]) {
        session_unset();
        session_destroy();
        $_SESSION["error_message"] =
            "Mudança de navegador detectada. Faça login novamente.";
        header("Location: login.php");
        exit();
    }
}

function escapeInput($input)
{
    return htmlspecialchars(strip_tags($input), ENT_QUOTES, "UTF-8");
}

function runChecks()
{
    checkLoginAttempts();
    checkUserAgent();
}

function secureQuery($conn, $sql, $params, $types = "")
{
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        throw new Exception("Erro ao preparar a query: " . $conn->error);
    }

    if (!empty($types)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    return $stmt;
}
?>

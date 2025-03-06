<?php
require_once __DIR__ . '/db_connect.php';
session_start();

error_log("Iniciando index.php - Sessão: " . json_encode($_SESSION));

if (isset($_SESSION['user_id'])) {
    error_log("Sessão existe, redirecionando para profile.php");
    header("Location: /profile.php");
    exit();
}

// Código de login...
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    $user = db_query("users?email=eq.$email&is_active=eq.true");
    if (is_array($user) && !empty($user) && password_verify($password, $user[0]['password'])) {
        $_SESSION['user_id'] = $user[0]['id'];
        header("Location: /profile.php");
        exit();
    } else {
        $error = "Credenciais inválidas!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login - Nick Dwtyay, Ltd.</title>
    <link rel="stylesheet" href="/api/style.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <div class="form-group">
                <label>E-mail:</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Senha:</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Entrar</button>
        </form>
        <p>Não tem conta? <a href="/register.php">Crie uma</a></p>
    </div>
</body>
</html>

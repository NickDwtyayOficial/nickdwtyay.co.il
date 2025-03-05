<?php
require_once 'db_connect.php';
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: /profile.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($email) && !empty($password)) {
        $user = db_query("users?email=eq.$email");

        if (is_array($user) && !empty($user) && isset($user[0]['password'])) {
            if (password_verify($password, $user[0]['password'])) {
                $_SESSION['user_id'] = $user[0]['id'];
                header("Location: /profile.php");
                exit();
            } else {
                $error = "Credenciais inválidas!";
            }
        } else {
            $error = "Usuário não encontrado!";
        }
    } else {
        $error = "Preencha todos os campos!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
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
            <div class="form-group">
                <button type="submit">Entrar</button>
            </div>
        </form>
        <p>Não tem conta? <a href="/register.php">Crie uma</a></p>
    </div>
</body>
</html>

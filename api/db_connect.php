<?php
require_once 'db_connect.php';
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: /profile.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "E-mail inválido!";
    } elseif (empty($password)) {
        $error = "Digite a senha!";
    } else {
        $user = db_query("users?email=eq.$email&is_active=eq.true");

        if (is_array($user) && !empty($user) && isset($user[0]['id']) && isset($user[0]['password'])) {
            $stored_hash = $user[0]['password'];
            if (password_verify($password, $stored_hash)) {
                $_SESSION['user_id'] = $user[0]['id']; // UUID como string
                $_SESSION['role'] = $user[0]['role'];
                header("Location: /profile.php");
                exit();
            } else {
                $error = "Senha incorreta!";
            }
        } else {
            $error = "Usuário não encontrado ou inativo!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Nick Dwtyay, Ltd.</title>
    <link rel="stylesheet" href="/api/style.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST" novalidate>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit">Entrar</button>
            </div>
        </form>
        <p>Não tem conta? <a href="/register.php">Crie uma</a></p>
    </div>
</body>
</html>

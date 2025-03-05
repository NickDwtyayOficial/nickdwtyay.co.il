<?php
require_once 'db_connect.php';
session_start();

// Redireciona se já está logado
if (isset($_SESSION['user_id'])) {
    header("Location: /profile.php"); // Ajuste para caminho absoluto
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($email) && !empty($password)) {
        // Busca o usuário pelo e-mail com sintaxe correta do Supabase
        $user = db_query("users?email=eq.$email");

        // Debug (opcional): Descomente para ver o resultado bruto
        // echo "Resposta do Supabase: " . print_r($user, true) . "<br>";

        // Verifica se o resultado é válido e tem dados
        if (is_array($user) && !empty($user) && isset($user[0]['password'])) {
            if (password_verify($password, $user[0]['password'])) {
                $_SESSION['user_id'] = $user[0]['id'];
                header("Location: /profile.php"); // Caminho absoluto
                exit();
            } else {
                $error = "Credenciais inválidas!";
            }
        } else {
            $error = "Usuário não encontrado ou erro na consulta!";
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
    <link rel="stylesheet" href="/api/style.css"> <!-- Ajuste o caminho -->
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
        <p>Não tem conta? <a href="/register.php">Crie uma</a></p> <!-- Ajuste o caminho -->
    </div>
</body>
</html>

<?php
require_once __DIR__ . '/db_connect.php'; // Conexão com o banco de dados

// Verifica se o token foi passado
if (isset($_GET['token'])) {
    $recovery_token = $_GET['token'];

    // Verifica se o token existe no banco de dados
    $user = db_query("users?recovery_token=eq.$recovery_token");
    if (is_array($user) && !empty($user)) {
        $user = $user[0]; // Pega o primeiro usuário encontrado
    } else {
        echo "<p>Token inválido ou expirado.</p>";
        exit();
    }
} else {
    echo "<p>Token não fornecido.</p>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pega a nova senha
    $new_password = $_POST['new_password'];

    // Atualiza a senha no banco de dados
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
    db_query("UPDATE users SET password = '$hashed_password', recovery_token = NULL WHERE id = '{$user['id']}'");

    echo "<p>Senha atualizada com sucesso! Agora você pode <a href='/'>fazer login</a>.</p>";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Redefinir Senha - Nick Dwtyay, Ltd.</title>
    <link rel="stylesheet" href="/api/style.css">
</head>
<body>
    <div class="container">
        <h2>Redefinir Senha</h2>

        <form method="POST">
            <div class="form-group">
                <label>Nova Senha:</label>
                <input type="password" name="new_password" required>
            </div>
            <button type="submit">Redefinir Senha</button>
        </form>
    </div>
</body>
</html>

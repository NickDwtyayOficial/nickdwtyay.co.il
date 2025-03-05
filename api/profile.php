<?php
require_once 'db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /");
    exit();
}

$user_id = $_SESSION['user_id'];
$user = db_query("users?id=eq.$user_id");

if (!is_array($user) || empty($user)) {
    session_destroy();
    header("Location: /");
    exit();
}

$user_data = $user[0];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Perfil - Nick Dwtyay, Ltd.</title>
    <link rel="stylesheet" href="/api/style.css">
</head>
<body>
    <div class="container">
        <h2>Perfil</h2>
        <p><strong>Nome:</strong> <?php echo htmlspecialchars($user_data['first_name']); ?></p>
        <p><strong>Sobrenome:</strong> <?php echo htmlspecialchars($user_data['last_name']); ?></p>
        <p><strong>Endereço:</strong> <?php echo htmlspecialchars($user_data['address'] ?: 'Não informado'); ?></p>
        <p><strong>Telefone:</strong> <?php echo htmlspecialchars($user_data['phone'] ?: 'Não informado'); ?></p>
        <p><strong>E-mail:</strong> <?php echo htmlspecialchars($user_data['email']); ?></p>
        <p><strong>Criado em:</strong> <?php echo htmlspecialchars($user_data['created_at']); ?></p>
        <a href="/logout.php">Sair</a>
    </div>
</body>
</html>

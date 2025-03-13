<?php
session_start();
require_once __DIR__ . '/db_connect.php';

// Ativar logs de erro para depuração
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Log da sessão para depuração
error_log("Iniciando profile.php - Sessão: " . json_encode($_SESSION));

// Verificar se a sessão do usuário está ativa e válida
if (!isset($_SESSION['user_id']) || !is_numeric($_SESSION['user_id'])) {
    error_log("Erro: Sessão não encontrada ou ID de usuário inválido. Redirecionando para login.");
    header("Location: /");
    exit();
}

$user_id = (int) $_SESSION['user_id'];
error_log("Buscando usuário com ID: $user_id");

// Buscar usuário no banco de dados
$user = db_query("users?id=eq.$user_id&is_active=eq.true");
error_log("Resultado da query: " . json_encode($user));

// Verificar se a consulta retornou um usuário válido
if (!$user || !is_array($user) || count($user) === 0 || !isset($user[0]['id']) || $user[0]['id'] !== $user_id) {
    error_log("Erro: Usuário não encontrado ou sessão inválida.");
    session_destroy();
    header("Location: /login.php?error=session_invalid");
    exit();
}

$user_data = $user[0];
error_log("Usuário carregado com sucesso: " . json_encode($user_data));
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <footer class="footer">
        NICK DWTYAY, LTD.<br>
        "Americas and Middle East Cybersecurity Software and Technology Solutions Development Company."<br>
        <a href="/Terms.php">Terms</a> |
        <a href="/Privacy_Policy.php">Privacy Policy</a> |
        All Rights Reserved | © 2006 - 2025 Nick Dwtyay, Ltd.
    </footer>
</body>
</html>

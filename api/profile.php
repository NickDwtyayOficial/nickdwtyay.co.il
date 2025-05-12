<?php
session_start();
require_once __DIR__ . '/db_connect.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_COOKIE['user_id']) && !isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    error_log("Sessão restaurada via cookie - user_id: " . $_SESSION['user_id']);
}

error_log("Iniciando profile.php - Sessão: " . json_encode($_SESSION));

// Verifica se a sessão existe e não está vazia
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    error_log("Erro: Sessão não encontrada ou ID inválido. Redirecionando.");
    header("Location: /");
    exit();
}

$user_id = $_SESSION['user_id']; // UUID como string
error_log("Buscando usuário com ID: $user_id");

$user = db_query("users?id=eq.$user_id&is_active=eq.true");
error_log("Resultado da query: " . json_encode($user));

if (!$user || !is_array($user) || count($user) === 0 || !isset($user[0]['id']) || $user[0]['id'] !== $user_id) {
    error_log("Erro: Usuário não encontrado ou sessão inválida.");
    session_destroy();
    if (isset($_COOKIE['user_id'])) {
        setcookie('user_id', '', time() - 3600, '/', '', true, true);
    }
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

      <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>

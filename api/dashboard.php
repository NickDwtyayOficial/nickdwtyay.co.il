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

error_log("Iniciando dashboard.php - Sessão: " . json_encode($_SESSION));

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    error_log("Erro: Sessão não encontrada ou ID inválido. Redirecionando.");
    header("Location: /");
    exit();
}

$user_id = $_SESSION['user_id'];
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
    <title>Dashboard</title>
</head>
<body>
    <h1>Bem-vindo ao Dashboard!</h1>
    <p>ID do usuário: <?php echo htmlspecialchars($user_data['id']); ?></p>
    <p>Nome: <?php echo htmlspecialchars($user_data['first_name'] . ' ' . $user_data['last_name']); ?></p>
    <a href="/logout.php">Sair</a>
</body>
</html>

<?php
session_start(); // Inicia a sessão
require_once __DIR__ . '/db_connect.php';

// Ativar logs de erro para depuração
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar cookie como fallback para sessão no Vercel
if (isset($_COOKIE['user_id']) && !isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    error_log("Sessão restaurada a partir do cookie - user_id: " . $_SESSION['user_id']);
}

// Log da sessão para depuração
error_log("Iniciando profile.php - Sessão: " . json_encode($_SESSION));

// Verificar se a sessão do usuário está ativa e válida
if (!isset($_SESSION['user_id']) || !is_numeric($_SESSION['user_id'])) {
    error_log("Erro: Sessão não encontrada ou ID de usuário inválido. Redirecionando para login.");
    header("Location: /login.php"); // Ajustado para /login.php como no original
    exit();
}

$user_id = (int) $_SESSION['user_id'];
error_log("Buscando usuário com ID: $user_id");

// Buscar usuário no banco de dados
$user = db_query("users?id=eq.$user_id&is_active=eq.true");
error_log("Resultado da query: " . json_encode($user));

// Verificar se a consulta retornou um usuário válido
if (!$user || !is_array($user) || count($user) === 0 || !isset($user[0]['id']) || $user[0]['id'] !== $user_id) {
    error_log("Erro: Usuário não encontrado ou sessão inválida. Destruindo sessão.");
    session_destroy();
    // Remove o cookie se existir
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
    <title>Perfil do Usuário</title>
</head>
<body>
    <h1>Bem-vindo ao seu perfil!</h1>
    <p>ID do usuário: <?php echo htmlspecialchars($user_data['id']); ?></p>
    <!-- Adicione mais dados do usuário conforme necessário -->
    <a href="/logout.php">Sair</a>
</body>
</html>

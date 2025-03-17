<?php
session_start();
require_once __DIR__ . '/db_connect.php';

if (isset($_COOKIE['user_id']) && !isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    error_log("Sessão restaurada via cookie - user_id: " . $_SESSION['user_id']);
}

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    error_log("Sessão não encontrada. Redirecionando para login.");
    header("Location: /index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
error_log("Dashboard acessado - user_id: $user_id");

// Consulta ao Supabase
$user = db_query("users?id=eq.$user_id&is_active=eq.true");
error_log("Resposta do Supabase no dashboard: " . json_encode($user));

if (isset($user['error'])) {
    error_log("Erro ao consultar usuário: " . $user['error']);
    session_destroy();
    setcookie('user_id', '', time() - 3600, '/', '', true, true);
    header("Location: /index.php?error=supabase_error");
    exit();
}

if (!$user || count($user) === 0) {
    error_log("Usuário não encontrado ou inativo para user_id: $user_id");
    session_destroy();
    setcookie('user_id', '', time() - 3600, '/', '', true, true);
    header("Location: /index.php?error=session_invalid");
    exit();
}

$user_data = $user[0];
error_log("Usuário carregado: " . json_encode($user_data));
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Nick Dwtyay, Ltd.</title>
    <link rel="stylesheet" href="/api/style.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; display: flex; }
        .sidebar { width: 200px; background: #333; color: white; height: 100vh; padding: 20px; }
        .sidebar a { color: white; text-decoration: none; display: block; margin: 10px 0; }
        .sidebar a:hover { color: #ddd; }
        .content { flex-grow: 1; padding: 20px; }
        .footer { background-color: #333; color: white; text-align: center; padding: 10px; position: fixed; bottom: 0; width: 100%; }
        .footer a { color: white; margin: 0 5px; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3>Bem-vindo, <?php echo htmlspecialchars($user_data['first_name']); ?></h3>
        <a href="/dashboard.php">Dashboard</a>
        <a href="/loja.php">Loja</a>
        <a href="/meus_posts.php">Meus Posts</a>
        <a href="/profile.php">Perfil</a>
        <a href="/logout.php">Sair</a>
    </div>
    <div class="content">
        <h1>Dashboard</h1>
        <p>Escolha uma opção no menu lateral para começar!</p>
    </div>
    <footer class="footer">
        NICK DWTYAY, LTD. | 
        <a href="/Terms.php">Terms</a> |
        <a href="/Privacy_Policy.php">Privacy Policy</a> |
        © 2006 - 2025 Nick Dwtyay, Ltd.
    </footer>
</body>
</html>

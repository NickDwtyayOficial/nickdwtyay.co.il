<?php
require_once __DIR__ . '/db_connect.php';
session_start();

error_log("Iniciando profile.php - Sessão: " . json_encode($_SESSION));

if (!isset($_SESSION['user_id'])) {
    error_log("Sessão não encontrada, redirecionando para login");
    header("Location: /");
    exit();
}

$user_id = $_SESSION['user_id'];
error_log("Buscando usuário com ID: $user_id");

// Busca o usuário
$user = db_query("users?id=eq.$user_id&is_active=eq.true");
error_log("Resultado da query: " . json_encode($user));

// Se a query falhar ou o usuário não existir, mostra erro e oferece logout
if (!is_array($user) || empty($user) || !isset($user[0]['id']) || $user[0]['id'] !== $user_id) {
    error_log("Usuário não encontrado ou inválido");
    $error = "Usuário não encontrado ou sessão inválida. Faça login novamente.";
    session_destroy();
} else {
    $user_data = $user[0];
    error_log("Usuário carregado com sucesso: " . json_encode($user_data));
}
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
        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <p><a href="/logout.php">Sair e fazer login novamente</a></p>
        <?php else: ?>
            <p><strong>Nome:</strong> <?php echo htmlspecialchars($user_data['first_name']); ?></p>
            <p><strong>Sobrenome:</strong> <?php echo htmlspecialchars($user_data['last_name']); ?></p>
            <p><strong>Endereço:</strong> <?php echo htmlspecialchars($user_data['address'] ?: 'Não informado'); ?></p>
            <p><strong>Telefone:</strong> <?php echo htmlspecialchars($user_data['phone'] ?: 'Não informado'); ?></p>
            <p><strong>E-mail:</strong> <?php echo htmlspecialchars($user_data['email']); ?></p>
            <p><strong>Criado em:</strong> <?php echo htmlspecialchars($user_data['created_at']); ?></p>
            <a href="/logout.php">Sair</a>
        <?php endif; ?>
    </div>
</body>
</html>

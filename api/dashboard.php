<?php
session_start([
    'cookie_lifetime' => 3600,
    'cookie_secure' => true,
    'cookie_httponly' => true,
    'cookie_samesite' => 'Strict',
    'use_strict_mode' => true
]);
require_once __DIR__ . '/db_connect.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

error_log("Iniciando dashboard.php - Sessão: " . json_encode($_SESSION));
error_log("Cookie user_id: " . ($_COOKIE['user_id'] ?? 'não definido'));

// Restaurar sessão via cookie
if (isset($_COOKIE['user_id']) && !isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    error_log("Sessão restaurada via cookie - user_id: " . $_SESSION['user_id']);
}

// Verificar sessão
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    error_log("Erro: Sessão não encontrada ou ID inválido. Redirecionando.");
    header("Location: /api/index.php?error=no_session");
    exit();
}

$user_id = $_SESSION['user_id'];
error_log("Buscando usuário com ID: $user_id");

// Query no Supabase com campos específicos
$user = db_query("users?id=eq.$user_id&is_active=eq.true&select=id,first_name,last_name");
error_log("Resultado da query: " . json_encode($user));

// Verificar resultado da query
if (!$user || !is_array($user) || count($user) === 0 || !isset($user[0]['id']) || $user[0]['id'] !== $user_id) {
    error_log("Erro: Usuário não encontrado ou sessão inválida.");
    session_destroy();
    if (isset($_COOKIE['user_id'])) {
        setcookie('user_id', '', time() - 3600, '/', '', true, true);
    }
    header("Location: /api/index.php?error=session_invalid");
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
    <title>Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; }
        nav { background: #333; color: white; padding: 10px; }
        nav ul { list-style: none; margin: 0; padding: 0; display: flex; justify-content: center; }
        nav ul li { margin: 0 20px; }
        nav ul li a { color: white; text-decoration: none; }
        .container { max-width: 1200px; margin: 20px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        .products { display: flex; flex-wrap: wrap; gap: 20px; }
        .product { border: 1px solid #ddd; padding: 10px; width: 200px; text-align: center; }
        .product img { max-width: 100%; height: auto; }
        .footer { background-color: #333; padding: 20px; text-align: center; font-size: 14px; color: #fff; width: 100%; position: relative; }
        .footer a { color: #fff; text-decoration: none; margin: 0 5px; }
        .footer a:hover { text-decoration: underline; }
        .error { color: red; text-align: center; }
        @media (max-width: 600px) {
            .container { margin: 10px; padding: 15px; }
            .products { flex-direction: column; align-items: center; }
            .product { width: 100%; max-width: 300px; }
       .products { display: none;  }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><a href="/api/index.php">Home</a></li>
            <li><a href="/api/dashboard.php">Loja</a></li>
            <li><a href="/api/post.php">Posts</a></li>
            <li><a href="/api/profile.php">Meu Perfil</a></li>
            <li><a href="/logout.php">Sair</a></li>
        </ul>
    </nav>
    <div class="container">
        <h1>Bem-vindo à Loja, <?php echo htmlspecialchars($user_data['first_name'] ?? 'Usuário'); ?>!</h1>
        <p>ID do usuário: <?php echo htmlspecialchars($user_data['id'] ?? 'N/A'); ?></p>
        <p>Nome: <?php echo htmlspecialchars(($user_data['first_name'] ?? '') . ' ' . ($user_data['last_name'] ?? '')); ?></p>
        <div class="products">
            <div class="product">
                <img src="https://via.placeholder.com/150" alt="Produto 1">
                <h3>Camiseta Básica</h3>
                <p>R$ 29,90</p>
                <button>Comprar</button>
            </div>
            <div class="product">
                <img src="https://via.placeholder.com/150" alt="Produto 2">
                <h3>Calça Jeans</h3>
                <p>R$ 79,90</p>
                <button>Comprar</button>
            </div>
            <div class="product">
                <img src="https://via.placeholder.com/150" alt="Produto 3">
                <h3>Tênis Casual</h3>
                <p>R$ 129,90</p>
                <button>Comprar</button>
            </div>
            <div class="product">
                <img src="https://via.placeholder.com/150" alt="Produto 4">
                <h3>Mochila Simples</h3>
                <p>R$ 49,90</p>
                <button>Comprar</button>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/@statsig/js-client@3/dist/statsig-js.min.js"></script>
<script>
    (async () => {
        const statsig = window.statsig;
        await statsig.initializeAsync('statsig-dwtyay', {
            userID: '<?php echo htmlspecialchars($_SESSION['user_id'] ?? ''); ?>'
        });
        const isGateEnabled = await statsig.checkGate('my_feature_gate');
        if (isGateEnabled) {
            console.log('Feature gate my_feature_gate is enabled!');
            // Mostrar conteúdo condicional
            document.querySelector('.products').style.display = 'block';
        } else {
            console.log('Feature gate my_feature_gate is disabled.');
            document.querySelector('.products').style.display = 'none';
        }
    })();
</script>
    

    
    <footer class="footer">
        NICK DWTYAY, LTD.<br>
        "Americas and Middle East Cybersecurity Software and Technology Solutions Development Company."<br>
        <a href="/Terms.php">Terms</a> |
        <a href="/Privacy_Policy.php">Privacy Policy</a> |
        All Rights Reserved © 2006 - 2025 Nick Dwtyay, Ltd.
    </footer>
</body>
</html>

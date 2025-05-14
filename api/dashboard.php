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
    <title>Dashboard</title>  <link rel="icon" href="https://static.nickdwtyay.com.br/static/favicon.ico" type="image/x-icon">
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
    <div class="container"><div class="dev-warning" style="text-align:center; margin:40px 0;">
    <img 
        src="https://cdn.pixabay.com/animation/2022/12/07/12/32/12-32-10-885_512.gif" 
        alt="Under Construction Worker" 
        style="width:180px; max-width:100%; margin-bottom:20px; display:inline-block;">
    <h2 style="color:#e67e22; margin-bottom:10px;">This page is under development</h2>
    <p style="font-size:18px; color:#555;">Please come back soon.<br>
        <span style="font-size: 80px; display: block; margin-top: 10px;">🛠️</span>
    </p>
    <p style="font-size:16px; color:#888;">
        <strong>
            <em>
                (A character with a sledgehammer is breaking rocks while we work!)
            </em>
        </strong>
    </p>
</div>



        <<h1>Hello, world!</h1>
<script src="https://cdn.jsdelivr.net/npm/@statsig/js-client@3/dist/statsig-js.min.js"></script>
<script>
    (async () => {
        const statsig = window.statsig;
        await statsig.initializeAsync('secret-9ZwnEzWO1lP0zLfAPOijPsXTSnoiBkiUg8ILmtcgp7Q', {
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

    <script src="/api/static/statsig-js.min.js" defer></script>
    <script>
        (async () => {
            if (typeof window.statsig === 'undefined') {
                console.error('Statsig SDK failed to load.');
                document.querySelector('.products').style.display = 'block'; // Fallback: show products
                return;
            }
            try {
                await window.statsig.initializeAsync('client-WA7hJS8vXPG4k3WEXJ6V4raziKM5xH4WFc08sYT38qQ', {
                    userID: '<?php echo htmlspecialchars($_SESSION['user_id'] ?? ''); ?>'
                });
                const isGateEnabled = await window.statsig.checkGate('my_feature_gate');
                if (isGateEnabled) {
                    console.log('Feature gate my_feature_gate is enabled!');
                    document.querySelector('.products').style.display = 'block';
                } else {
                    console.log('Feature gate my_feature_gate is disabled.');
                    document.querySelector('.products').style.display = 'none';
                }
            } catch (error) {
                console.error('Statsig initialization failed:', error);
                document.querySelector('.products').style.display = 'block'; // Fallback
            }
        })();
    </script>

    
 <?php include __DIR__ . '/includes/footer.php'; ?></body>
</html>

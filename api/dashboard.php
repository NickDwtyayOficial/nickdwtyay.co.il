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
    <!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        nav { background: #333; color: white; padding: 10px; }
        nav ul { list-style: none; margin: 0; padding: 0; display: flex; }
        nav ul li { margin-right: 20px; }
        nav ul li a { color: white; text-decoration: none; }
        .container { max-width: 1200px; margin: 20px auto; padding: 0 20px; }
        .products { display: flex; flex-wrap: wrap; gap: 20px; }
        .product { border: 1px solid #ddd; padding: 10px; width: 200px; text-align: center; }
        .product img { max-width: 100%; height: auto; }
 }
        .top-nav { display: flex; justify-content: center; background-color: rgba(51, 51, 51, 0.9); padding: 10px 0; position: relative; z-index: 1; }
        .nav-link { padding: 10px 20px; color: #fff; text-decoration: none; transition: background-color 0.3s ease; }
        .nav-link:hover { background-color: #555; }
        .container { max-width: 400px; margin: 50px auto; background-color: rgba(255, 255, 255, 0.95); border: 1px solid #ccc; padding: 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); position: relative; z-index: 1; }
        h2 { text-align: center; color: #333; }
        .form-group { margin-bottom: 20px; width: 100%; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; }
        .form-group input { width: 100%; padding: 10px; font-size: 16px; border-radius: 5px; border: 1px solid #ccc; box-sizing: border-box; }
        .form-group button { width: 100%; padding: 10px; font-size: 16px; background-color: #4caf50; color: #fff; border: none; border-radius: 5px; cursor: pointer; }
        .form-group button:hover { background-color: #45a049; }
        .error { color: red; text-align: center; }



        
        .footer { background-color: rgba(51, 51, 51, 0.9); padding: 20px; text-align: center; font-size: 14px; color: #fff; width: 100%; position: relative; bottom: 0; z-index: 1; }
        .footer a { color: #fff; text-decoration: none; margin: 0 5px; }
        .footer a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <nav>
        <ul><li><a href="/api/home.php">Home</a></li>

            <li><a href="/api/dashboard.php">Loja</a></li>
            <li><a href="/api/post.php">Posts</a></li>
            <li><a href="/api/profile.php">Meu Perfil</a></li>
            <li><a href="/logout.php">Sair</a></li>
        </ul>
    </nav>
    <div class="container">
        <h1>Bem-vindo à Loja, <?php echo htmlspecialchars($user_data['first_name']); ?>!</h1>
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

    <a href="/logout.php">Sair</a>
<footer class="footer">
        NICK DWTYAY, LTD.<br>
        "Americas and Middle East Cybersecurity Software and Technology Solutions Development Company."<br>
        <a href="/Terms.php">Terms</a> |
        <a href="/Privacy_Policy.php">Privacy Policy</a> |
        All Rights Reserved | © 2006 - 2025 Nick Dwtyay, Ltd.
    </footer>
</body>
</html>

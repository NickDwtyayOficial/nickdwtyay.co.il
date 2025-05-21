<?php
session_start([
    'cookie_lifetime' => 3600,
    'cookie_secure' => true,
    'cookie_httponly' => true,
    'cookie_samesite' => 'Strict',
    'use_strict_mode' => true
]);
require_once __DIR__ . '/db_connect.php';

// Restore session from cookie if needed
if (isset($_COOKIE['user_id']) && !isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
}

// Authentication check
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("Location: /api/index.php?error=no_session");
    exit();
}

$user_id = $_SESSION['user_id'];
$user = db_query("users?id=eq.$user_id&is_active=eq.true&select=id,email,first_name,last_name")[0] ?? null;
if (!$user) die('User not found.');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST['type'];
    $content = filter_input(INPUT_POST, 'content', FILTER_DEFAULT);

    if (!empty($content)) {
        $params = [
            "user_id" => $user_id,
            "type" => $type,
            "content" => $content
        ];
        db_query("posts", $params, "POST");
    }
}

$posts = db_query("posts?user_id=eq.$user_id&order=created_at.desc");
if (isset($posts['error'])) die("Failed to fetch posts: " . $posts['error']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meus Posts</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; display: flex; }
        .sidebar { width: 200px; background: #333; color: white; height: 100vh; padding: 20px; }
        .sidebar a { color: white; text-decoration: none; display: block; margin: 10px 0; }
        .sidebar a:hover { color: #ddd; }
        .content { flex-grow: 1; padding: 20px; }
        .post { border: 1px solid #ddd; padding: 10px; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3>Meus Posts</h3>
        <a href="dashboard.php">Dashboard</a>
        <a href="loja.php">Loja</a>
        <a href="post.php">Meus Posts</a>
        <a href="logout.php">Sair</a>
    </div>
    <div class="content">
        <h1>Meus Posts</h1>
        <form method="POST" action="">
            <select name="tipo" required>
                <option value="texto">Texto</option>
                <option value="foto">Foto (URL)</option>
                <option value="video">Vídeo (URL)</option>
            </select>
            <textarea name="conteudo" placeholder="Digite seu texto ou URL da mídia" required></textarea>
            <button type="submit">Postar</button>
        </form>

        <h2>Seus Posts</h2>
        <?php foreach ($posts as $post): ?>
            <div class="post">
                <?php if ($post['tipo'] == 'texto'): ?>
                    <p><?php echo $post['conteudo']; ?></p>
                <?php elseif ($post['tipo'] == 'foto'): ?>
                    <img src="<?php echo $post['conteudo']; ?>" alt="Foto" style="max-width: 300px;">
                <?php elseif ($post['tipo'] == 'video'): ?>
                    <iframe width="300" height="200" src="<?php echo $post['conteudo']; ?>" frameborder="0" allowfullscreen></iframe>
                <?php endif; ?>
                <small>Postada em: <?php echo $post['data_criacao']; ?></small>
            </div>
        <?php endforeach; ?>
    </div>
  <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>

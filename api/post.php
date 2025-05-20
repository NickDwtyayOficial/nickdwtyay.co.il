<?php
session_start([
    'cookie_lifetime' => 3600,
    'cookie_secure' => true,
    'cookie_httponly' => true,
    'cookie_samesite' => 'Strict',
    'use_strict_mode' => true
]);
require_once __DIR__ . '/db_connect.php';

// Restaurar sessão via cookie, se necessário
if (isset($_COOKIE['user_id']) && !isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
}

// Verificação padrão de autenticação
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("Location: /api/index.php?error=no_session");
    exit();
 // Agora é um UUID

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo = $_POST['tipo'];
    $conteudo = filter_input(INPUT_POST, 'conteudo', FILTER_SANITIZE_STRING);

    if (!empty($conteudo)) {
        $params = [
            "usuario_id" => $usuario_id, // UUID
            "tipo" => $tipo,
            "conteudo" => $conteudo
        ];
        db_query("posts", $params, "POST");
    }
}

$posts = db_query("posts?usuario_id=eq.$usuario_id&order=data_criacao.desc");

if (isset($posts['error'])) {
    die("Erro ao consultar posts: " . $posts['error']);
}
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

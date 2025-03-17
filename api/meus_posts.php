<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['logado'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];
$sql = "SELECT id FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$usuario = $stmt->get_result()->fetch_assoc();
$usuario_id = $usuario['id'];

// Salvar novo post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo = $_POST['tipo'];
    $conteudo = filter_input(INPUT_POST, 'conteudo', FILTER_SANITIZE_STRING);

    if (!empty($conteudo)) {
        $sql = "INSERT INTO posts (usuario_id, tipo, conteudo) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $usuario_id, $tipo, $conteudo);
        $stmt->execute();
    }
}

// Buscar posts do usuário
$sql = "SELECT * FROM posts WHERE usuario_id = ? ORDER BY data_criacao DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$posts = $stmt->get_result();
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
        <a href="meus_posts.php">Meus Posts</a>
        <a href="sair.php">Sair</a>
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
        <?php while ($post = $posts->fetch_assoc()): ?>
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
        <?php endwhile; ?>
    </div>
</body>
</html>

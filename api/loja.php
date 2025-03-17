
<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['logado'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM produtos LIMIT 4"; // Pega até 4 produtos
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Loja</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; display: flex; }
        .sidebar { width: 200px; background: #333; color: white; height: 100vh; padding: 20px; }
        .sidebar a { color: white; text-decoration: none; display: block; margin: 10px 0; }
        .sidebar a:hover { color: #ddd; }
        .content { flex-grow: 1; padding: 20px; }
        .produto { border: 1px solid #ddd; padding: 10px; margin: 10px; width: 200px; float: left; }
        .produto img { max-width: 100%; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3>Loja</h3>
        <a href="dashboard.php">Dashboard</a>
        <a href="loja.php">Loja</a>
        <a href="meus_posts.php">Meus Posts</a>
        <a href="sair.php">Sair</a>
    </div>
    <div class="content">
        <h1>Loja Online</h1>
        <?php while ($produto = $result->fetch_assoc()): ?>
            <div class="produto">
                <img src="imagens/<?php echo $produto['imagem']; ?>" alt="<?php echo $produto['nome']; ?>">
                <h2><?php echo $produto['nome']; ?></h2>
                <p><?php echo $produto['descricao']; ?></p>
                <p>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
                <button>Comprar</button>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>


<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['logado'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];
$sql = "SELECT nome, sobrenome FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$usuario = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; display: flex; }
        .sidebar { width: 200px; background: #333; color: white; height: 100vh; padding: 20px; }
        .sidebar a { color: white; text-decoration: none; display: block; margin: 10px 0; }
        .sidebar a:hover { color: #ddd; }
        .content { flex-grow: 1; padding: 20px; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3>Bem-vindo, <?php echo $usuario['nome']; ?></h3>
        <a href="dashboard.php">Dashboard</a>
        <a href="loja.php">Loja</a>
        <a href="meus_posts.php">Meus Posts</a>
        <a href="sair.php">Sair</a>
    </div>
    <div class="content">
        <h1>Dashboard</h1>
        <p>Escolha uma opção no menu lateral para começar!</p>
    </div>
</body>
</html>

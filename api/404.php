<?php
http_response_code(404);
?>

<?php
$pageTitle = "404 erro";
$pageDescription = "Nick Dwtyay Ltd, is a Middle East-based Telecommunications, Cybersecurity Software and Technology Solution Development Company offering innovative solutions to businesses and individuals. Our partnerships in South America give us the opportunity to provide world-class services to our customers. essa página possivelmente está em manutenção e por isso você está visualizando ela";
include __DIR__ . '/includes/head.php';
?>

<body>
    <h1>Erro 404</h1>
    <p>Ops! A página que você procura não foi encontrada.</p>
    <p><a href="api/index.php">Voltar para a página inicial</a></p>

   <?php include __DIR__ . '/includes/footer.php'; ?>
</body>

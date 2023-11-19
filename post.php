<?php
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    // Aqui você pode buscar as informações da notícia com base no ID e exibi-las
    echo "<h2>Título da Notícia $id</h2>";
    echo "<p>Conteúdo da notícia $id</p>";
} else {
    echo "Notícia não encontrada.";
}
?>

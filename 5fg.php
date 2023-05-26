<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Tabela de Frangos</title>
	<link rel="stylesheet" href="style.css">
	<script>
		// Função para substituir vírgulas por pontos
		function substituirVirgulaPorPonto(elemento) {
			elemento.value = elemento.value.replace(',', '.');
		}
	</script>
</head>
<body>
	<h1>Tabela de Frangos</h1>
	<form action="salvar.php" method="post">
		<table>
			<tr>
				<th>Data</th>
				<th>Quantidade</th>
				<th>Peso (kg)</th>
				<th>Valor (R$)</th>
			</tr>
			<tr>
				<td><input type="date" name="data" required></td>
				<td><input type="number" name="quantidade" required></td>
				<td><input type="text" name="peso" required oninput="substituirVirgulaPorPonto(this)"></td>
				<td><input type="text" name="valor" required oninput="substituirVirgulaPorPonto(this)"></td>
			</tr>
		</table>
		<button type="submit">Adicionar</button>
	</form>
</body>
</html>

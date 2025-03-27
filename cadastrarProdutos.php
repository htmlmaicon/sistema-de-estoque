<?php
require_once 'produto.php';

$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['adicionar'])) {
    $msg = $produto->adicionar($_POST['nome'], $_POST['descricao'], $_POST['preco'], $_POST['quantidade']);
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Produto</title>
</head>
<body>
    <h2>Cadastrar Produto</h2>

    <?php if ($msg): ?>
        <p style="color: green;"><?= $msg ?></p>
    <?php endif; ?>

    <form method="POST" action="logout.php">
        <button type="submit">Logout</button>
    </form>
    <form method="POST">
        <input type="text" name="nome" placeholder="Nome" required>
        <textarea name="descricao" placeholder="Descrição" required></textarea>
        <input type="number" step="0.01" name="preco" placeholder="Preço" required>
        <input type="number" name="quantidade" placeholder="Quantidade" required>
        <button type="submit" name="adicionar">Cadastrar</button>
    </form>

    <a href="listar.php">Ver Produtos</a>
</body>
</html>

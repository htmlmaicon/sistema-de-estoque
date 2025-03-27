<?php
require_once 'produto.php';

// Excluir Produto
if (isset($_GET['excluir'])) {
    $produto->excluir($_GET['excluir']);
    header("Location: listar.php");
    exit;
}

// Editar Produto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editar'])) {
    $produto->editar($_POST['id'], $_POST['nome'], $_POST['descricao'], $_POST['preco'], $_POST['quantidade']);
    header("Location: listar.php");
    exit;
}

$produtos = $produto->listar();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Lista de Produtos</title>
</head>
<body>
    <h2>Produtos Cadastrados</h2>
    <a href="cadastrarProdutos.php">Voltar</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Preço</th>
            <th>Quantidade</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($produtos as $p): ?>
        <tr>
            <td><?= $p['id'] ?></td>
            <td><?= $p['nome'] ?></td>
            <td><?= $p['descricao'] ?></td>
            <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
            <td><?= $p['quantidade'] ?></td>
            <td>
                <a href="listar.php?editar=<?= $p['id'] ?>">Editar</a>
                <a href="listar.php?excluir=<?= $p['id'] ?>" onclick="return confirm('Tem certeza?')">Excluir</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <!-- Formulário de Edição -->
    <?php if (isset($_GET['editar'])):
        $produtoAtual = null;
        foreach ($produtos as $p) {
            if ($p['id'] == $_GET['editar']) {
                $produtoAtual = $p;
                break;
            }
        }
        if ($produtoAtual): ?>
            <h2>Editar Produto</h2>
            <form method="POST">
                <input type="hidden" name="id" value="<?= $produtoAtual['id'] ?>">
                <input type="text" name="nome" value="<?= $produtoAtual['nome'] ?>">
                <textarea name="descricao"><?= $produtoAtual['descricao'] ?></textarea>
                <input type="number" step="0.01" name="preco" value="<?= $produtoAtual['preco'] ?>">
                <input type="number" name="quantidade" value="<?= $produtoAtual['quantidade'] ?>">
                <button type="submit" name="editar">Atualizar</button>
            </form>
    <?php endif; endif; ?>
</body>
</html>

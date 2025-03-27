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
    $imagem_url = $_POST['imagem_atual'];

    // Verifica se um novo arquivo foi enviado
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $diretorio = "uploads/";
        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0777, true);
        }

        $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $nomeArquivo = uniqid() . "." . $extensao;
        $caminhoArquivo = $diretorio . $nomeArquivo;

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoArquivo)) {
            $imagem_url = $caminhoArquivo; // Atualiza a URL da imagem
        }
    }

    $produto->editar($_POST['id'], $_POST['nome'], $_POST['descricao'], $_POST['preco'], $_POST['quantidade'], $imagem_url);
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
            <th>Imagem</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Preço</th>
            <th>Quantidade</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($produtos as $p): ?>
        <tr>
            <td><?= $p['id'] ?></td>
            <td>
                <?php if (!empty($p['imagem_url'])): ?>
                    <img src="<?= $p['imagem_url'] ?>" alt="Imagem do Produto" width="80">
                <?php else: ?>
                    Sem imagem
                <?php endif; ?>
            </td>
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
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $produtoAtual['id'] ?>">
                <input type="hidden" name="imagem_atual" value="<?= $produtoAtual['imagem_url'] ?>">
                
                <input type="text" name="nome" value="<?= $produtoAtual['nome'] ?>" required>
                <textarea name="descricao" required><?= $produtoAtual['descricao'] ?></textarea>
                <input type="number" step="0.01" name="preco" value="<?= $produtoAtual['preco'] ?>" required>
                <input type="number" name="quantidade" value="<?= $produtoAtual['quantidade'] ?>" required>
                
                <label>Imagem Atual:</label><br>
                <?php if (!empty($produtoAtual['imagem_url'])): ?>
                    <img src="<?= $produtoAtual['imagem_url'] ?>" alt="Imagem do Produto" width="100"><br>
                <?php endif; ?>

                <label>Alterar Imagem:</label>
                <input type="file" name="imagem" accept="image/*">

                <button type="submit" name="editar">Atualizar</button>
            </form>
    <?php endif; endif; ?>
</body>
</html>

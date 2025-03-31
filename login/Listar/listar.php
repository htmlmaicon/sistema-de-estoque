<?php
require_once '../produto.php';

// Excluir Produto
if (isset($_GET['excluir'])) {
    $produto->excluir($_GET['excluir']);
    header("Location: listar.php");
    exit;
}

// Editar Produto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editar'])) {
    $imagem_url = $_POST['imagem_atual'];

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $diretorio = "uploads/";
        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0777, true);
        }

        $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $nomeArquivo = uniqid() . "." . $extensao;
        $caminhoArquivo = $diretorio . $nomeArquivo;

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoArquivo)) {
            $imagem_url = $caminhoArquivo;
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
    <link rel="stylesheet" href="styles.css">
    <title>Lista de Produtos</title>
</head>
<body>
    <div class="produtos-container">
        <h2>🍻 Produtos Cadastrados</h2>
        
        <div class="acoes-header">
            <a href="../Cadastro/cadastrarProdutos.php">Voltar</a>
            <a href="../Baixa/index.php">Baixar Produtos</a>
        </div>

        <div class="produto-lista">
            <?php foreach ($produtos as $p): ?>
            <div class="produto-item">
                <div class="produto-imagem">
                    <?php if (!empty($p['imagem_url'])): ?>
                        <img src="<?= htmlspecialchars($p['imagem_url']) ?>" alt="Imagem do Produto">
                    <?php else: ?>
                        <div class="sem-imagem">🍺</div>
                    <?php endif; ?>
                </div>
                <div class="produto-info"><?= htmlspecialchars($p['id']) ?></div>
                <div class="produto-info"><?= htmlspecialchars($p['nome']) ?></div>
                <div class="produto-info"><?= htmlspecialchars($p['descricao']) ?></div>
                <div class="produto-info">R$ <?= number_format($p['preco'], 2, ',', '.') ?></div>
                <div class="produto-info"><?= htmlspecialchars($p['quantidade']) ?></div>
                <div class="produto-acoes">
                    <a href="listar.php?editar=<?= $p['id'] ?>" class="editar-btn">Editar</a>
                    <a href="listar.php?excluir=<?= $p['id'] ?>" class="excluir-btn" onclick="return confirm('Tem certeza?')">Excluir</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php if (isset($_GET['editar'])):
            $produtoAtual = null;
            foreach ($produtos as $p) {
                if ($p['id'] == $_GET['editar']) {
                    $produtoAtual = $p;
                    break;
                }
            }
            if ($produtoAtual): ?>
            <div class="editar-form">
                <h3>Editar Produto</h3>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($produtoAtual['id']) ?>">
                    <input type="hidden" name="imagem_atual" value="<?= htmlspecialchars($produtoAtual['imagem_url']) ?>">
                    
                    <div class="form-group">
                        <label>Nome:</label>
                        <input type="text" name="nome" value="<?= htmlspecialchars($produtoAtual['nome']) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Descrição:</label>
                        <textarea name="descricao" required><?= htmlspecialchars($produtoAtual['descricao']) ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Preço:</label>
                        <input type="number" step="0.01" name="preco" value="<?= htmlspecialchars($produtoAtual['preco']) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Quantidade:</label>
                        <input type="number" name="quantidade" value="<?= htmlspecialchars($produtoAtual['quantidade']) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Imagem Atual:</label>
                        <?php if (!empty($produtoAtual['imagem_url'])): ?>
                            <img src="<?= htmlspecialchars($produtoAtual['imagem_url']) ?>" alt="Imagem do Produto" class="imagem-preview">
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label>Alterar Imagem:</label>
                        <input type="file" name="imagem" accept="image/*">
                    </div>
                    
                    <button type="submit" name="editar" class="btn-atualizar">Atualizar</button>
                </form>
            </div>
            <?php endif; endif; ?>
    </div>
</body>
</html>
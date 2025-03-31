<?php
require_once '../produto.php';

$msg = "";
$produtos = $produto->listar(); // Busca todos os produtos

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['baixar'])) {
    $produto_id = $_POST['produto_id'];
    $quantidade_vendida = $_POST['quantidade_vendida'];

    // Obtém a quantidade atual do produto
    $produtoSelecionado = $produto->buscarPorId($produto_id);
    if ($produtoSelecionado) {
        $quantidade_atual = $produtoSelecionado['quantidade'];

        if ($quantidade_vendida > 0 && $quantidade_vendida <= $quantidade_atual) {
            $nova_quantidade = $quantidade_atual - $quantidade_vendida;
            $produto->atualizarQuantidade($produto_id, $nova_quantidade);
            $msg = "Baixa realizada com sucesso!";
        } else {
            $msg = "Quantidade inválida!";
        }
    } else {
        $msg = "Produto não encontrado!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Baixar Produto</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Baixar Produto</h2>
        <a href="../Login/index.php" class="btn logout-btn">Logout</a>

        <?php if ($msg): ?>
            <p class="success-message"><?= $msg ?></p>
        <?php endif; ?>

        <form method="POST" class="form">
            <div class="form-group">
                <label for="produto_id">Produto</label>
                <select id="produto_id" name="produto_id" required>
                    <option value="">Selecione um produto</option>
                    <?php foreach ($produtos as $p): ?>
                        <option value="<?= $p['id'] ?>"><?= $p['nome'] ?> (Disponível: <?= $p['quantidade'] ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="quantidade_vendida">Quantidade Vendida</label>
                <input type="number" id="quantidade_vendida" name="quantidade_vendida" min="1" required>
            </div>

            <button type="submit" name="baixar" class="btn">Baixar</button><br/><br/>
        </form>

        <a href="../Listar/listar.php" class="btn">Ver Produtos</a>
    </div>
</body>
</html>

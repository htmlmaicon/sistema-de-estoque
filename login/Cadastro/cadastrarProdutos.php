<?php
require_once '../produto.php';

$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['adicionar'])) {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];

    // Verifica se um arquivo foi enviado
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $diretorio = "../Listar/uploads/";
        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0777, true); // Cria a pasta se não existir
        }

        $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $nomeArquivo = uniqid() . "." . $extensao;
        $caminhoArquivo = $diretorio . $nomeArquivo;

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoArquivo)) {
            $imagem_url = $caminhoArquivo; // Caminho salvo no banco
        } else {
            $msg = "Erro ao fazer upload da imagem.";
        }
    } else {
        $imagem_url = null; // Caso não tenha imagem
    }

    $msg = $produto->adicionar($nome, $descricao, $preco, $quantidade, $imagem_url);
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Produto</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Cadastrar Produto</h2>
    <a href="../Login/login.php">Logout</a>
    <?php if ($msg): ?>
        <p style="color: green;"><?= $msg ?></p>
    <?php endif; ?>


    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="nome" placeholder="Nome" required>
        <textarea name="descricao" placeholder="Descrição" required></textarea>
        <input type="number" step="0.01" name="preco" placeholder="Preço" required>
        <input type="number" name="quantidade" placeholder="Quantidade" required>
        <input type="file" name="imagem" accept="image/*" required> <!-- Campo para upload -->
        <button type="submit" name="adicionar">Cadastrar</button>
    </form>

    <a href="../Listar/listar.php">Ver Produtos</a>
</body>
</html>

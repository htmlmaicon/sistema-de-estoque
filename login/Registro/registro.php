<?php
require '../autenticacao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];
    $apelido = $_POST['apelido'];

    if ($autenticado->registrar($nome, $senha, $apelido)) {
        $mensagem = "Usuário cadastrado com sucesso! Redirecionando para login...";
        header("refresh:3;url=../Login/login.php"); // Aguarda 3 segundos antes de redirecionar
    } else {
        $mensagem = "Erro ao cadastrar usuário. Tente novamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Registro</title>
</head>
<body>
    <div class="login-container">
        <img src="../imagens/logot.svg" alt="Logo" class="logo" style="width: 200px; display: block; margin: 0 auto;">
        <h1 class="titulo">Registro de Usuário</h1>
        
        <?php if (isset($mensagem)) : ?>
            <p style="color: <?= strpos($mensagem, 'sucesso') !== false ? 'green' : 'red' ?>;">
                <?= $mensagem ?>
            </p>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

            <label for="apelido">Apelido:</label>
            <input type="text" id="apelido" name="apelido" required>

            <button type="submit">Registrar</button>
        </form>
        
        <p>Já tem uma conta? <a href="../Login/login.php" class="destaque">Faça login aqui</a>.</p>
        
        <footer>
            <p>&copy; 2025 Seu Site. Todos os direitos reservados.</p>
        </footer>
    </div>
</body>
</html>
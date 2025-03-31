<?php
require '../autenticacao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    if ($autenticado->login($nome, $senha)) {
        header("Location: ../Cadastro/cadastrarProdutos.php");
        exit();
    } else {
        $erro = "Nome de usuário ou senha incorretos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Login</title>
</head>
<body>
    <div class="login-container">
        <img src="../imagens/logot.svg" alt="Logo" class="logo" style="width: 200px; display: block; margin: 0 auto;">
        <h1 class="titulo">Login</h1>
        
        <?php if (isset($erro)) { echo "<p style='color: red;'>$erro</p>"; } ?>
        
        <form method="POST" action="">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

            <a href="#" class="esqueci-senha">Esqueci minha senha</a>
            
            <button type="submit">Entrar</button>
        </form>
        <p>Não tem uma conta? <a href="../Registro/registro.php" class="destaque">Registre-se aqui</a>.</p>
        
        <footer>
            <p>&copy; 2025 Seu Site. Todos os direitos reservados.</p>
        </footer>
    </div>
</body>
</html>
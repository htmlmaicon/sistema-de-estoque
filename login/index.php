<?php
require 'Autenticacao.php';

$autenticado->protegerPagina();

$usuario_nome = $_SESSION['usuario_nome'];
$usuario_apelido = $_SESSION['usuario_apelido'];
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Página Inicial</title>
</head>

<body>
    <h1>Bem-vindo, <?php echo htmlspecialchars($usuario_apelido); ?>!</h1>
    <p>Você está logado como <strong><?php echo htmlspecialchars($usuario_nome); ?></strong>.</p>
    <form method="POST" action="logout.php">
        <button type="submit">Logout</button>
    </form>
</body>

</html>
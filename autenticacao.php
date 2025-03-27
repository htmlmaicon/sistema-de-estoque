<?php
// Incluindo o arquivo bd.php que contém a classe Database
require 'bd.php';

class Autenticacao
{
    private $pdo_login;
    private $pdo_produtos;

    public function __construct($pdo_login, $pdo_produtos)
    {
        $this->pdo_login = $pdo_login;
        $this->pdo_produtos = $pdo_produtos;
    }

    public function registrar($nome, $senha, $apelido)
    {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        try {
            $stmt = $this->pdo_login->prepare("SELECT * FROM usuarios WHERE nome = :nome");
            $stmt->bindParam(':nome', $nome);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "Nome de usuário já utilizado.";
            }

            $stmt = $this->pdo_login->prepare("INSERT INTO usuarios (nome, senha, apelido) VALUES (:nome, :senha, :apelido)");
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':senha', $senhaHash);
            $stmt->bindParam(':apelido', $apelido);

            if ($stmt->execute()) {
                return "Usuário registrado com sucesso!";
            } else {
                return "Erro ao registrar o usuário.";
            }
        } catch (PDOException $e) {
            return "Erro: " . $e->getMessage();
        }
    }

    public function login($nome, $senha)
    {
        try {
            $stmt = $this->pdo_login->prepare("SELECT * FROM usuarios WHERE nome = :nome");
            $stmt->bindParam(':nome', $nome);
            $stmt->execute();

            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario && password_verify($senha, $usuario['senha'])) {
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                $_SESSION['usuario_apelido'] = $usuario['apelido'];
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    public function logout()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }

    public function protegerPagina()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: login.php");
            exit();
        }
    }
}

// Criando a instância de Database e passando as conexões para a classe Autenticacao
$db = new Database();
$autenticado = new Autenticacao($db->pdo_login, $db->pdo_produtos);
?>

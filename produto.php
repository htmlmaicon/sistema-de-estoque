<?php
require_once 'bd.php';

class Produto {
    private $pdo;

    public function __construct($pdo_produtos) {
        $this->pdo = $pdo_produtos;
    }

    public function adicionar($nome, $descricao, $preco, $quantidade) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO produtos (nome, descricao, preco, quantidade) VALUES (:nome, :descricao, :preco, :quantidade)");
            $stmt->execute([
                ':nome' => $nome,
                ':descricao' => $descricao,
                ':preco' => $preco,
                ':quantidade' => $quantidade
            ]);
            return "Produto cadastrado com sucesso!";
        } catch (PDOException $e) {
            return "Erro ao cadastrar: " . $e->getMessage();
        }
    }

    public function listar() {
        $stmt = $this->pdo->query("SELECT * FROM produtos");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function excluir($id) {
        $stmt = $this->pdo->prepare("DELETE FROM produtos WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function editar($id, $nome, $descricao, $preco, $quantidade) {
        $stmt = $this->pdo->prepare("UPDATE produtos SET nome=:nome, descricao=:descricao, preco=:preco, quantidade=:quantidade WHERE id=:id");
        return $stmt->execute([
            ':id' => $id,
            ':nome' => $nome,
            ':descricao' => $descricao,
            ':preco' => $preco,
            ':quantidade' => $quantidade
        ]);
    }
}

// Certificando-se de passar a conexão correta (pdo_produtos)
$produto = new Produto($db->pdo_produtos);
?>

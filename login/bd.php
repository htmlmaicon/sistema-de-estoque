<?php
class Database {
    private $host = 'localhost';
    private $dbname_login = 'login_db';  // Banco de dados para login
    private $dbname_produtos = 'produtos_db';  // Banco de dados para produtos
    private $username = 'root';
    private $password = '';
    
    public $pdo_login;
    public $pdo_produtos;

    public function __construct() {
        try {
            // Conexão para Login
            $this->pdo_login = new PDO("mysql:host={$this->host};dbname={$this->dbname_login}", $this->username, $this->password);
            $this->pdo_login->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Conexão para Produtos
            $this->pdo_produtos = new PDO("mysql:host={$this->host};dbname={$this->dbname_produtos}", $this->username, $this->password);
            $this->pdo_produtos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            die("Erro na conexão: " . $e->getMessage());
        }
    }
}

$db = new Database();

// Exemplo de uso das conexões:
$pdoLogin = $db->pdo_login;
$pdoProdutos = $db->pdo_produtos;
?>

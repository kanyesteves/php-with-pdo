<?php
class ConnDataBase {
    private $host = '192.168.2.1';
    private $db = 'loja';
    private $user = 'root';
    private $pass = '132567';
    private $charset = 'utf8';
    private $pdo;
    private $error;

    public function __construct() {
        $dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);

        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            die('FALHA NA CONEXAO: ' . $this->error);

        }
    }

    public function getConnection() {
        return $this->pdo;
    }
}
?>

<?php
class Estoque {
    private $pdo;

    public function __construct(ConnDataBase $database) {
        $this->pdo = $database->getConnection();
    }

    public function atualizarEstoque($json) {
        $produtos = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            die('JSON inválido');
        }

        $this->pdo->beginTransaction();

        try {
            foreach ($produtos as $produto) {
                $id         = $produto['id'];
                $produto    = $produto['produto'];
                $quantidade = $produto['quantidade'];
                $cor        = $produto['cor'];
                $tamanho    = $produto['tamanho']
                $deposito   = $produto['deposito']
                $data       = $produto['data_disponibilidade']

                $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM estoque WHERE id = ?');
                $stmt->execute([$id]);
                $exists = $stmt->fetchColumn();

                if ($exists) {
                    $stmt = $this->pdo->prepare('UPDATE estoque SET produto = ?, cor = ?, tamanho = ?, deposito = ?, data_disponibilidade = ?, quantidade = ? WHERE id = ?');
                    $stmt->execute([$produto, $cor, $tamanho, $deposito, $data, $quantidade, $id]);

                } else {
                    $stmt = $this->pdo->prepare('INSERT INTO produtos (cor, produto, tamanho, deposito, data_disponibilidade, quantidade) VALUES (?, ?, ?, ?, ?, ?)');
                    $stmt->execute([$produto, $cor, $tamanho, $deposito, $data, $quantidade]);

                }
            }
            $this->pdo->commit();

        } catch (Exception $e) {
            $this->pdo->rollBack();
            die('Erro ao atualizar o estoque: ' . $e->getMessage());

        }
    }
}

$database = new Database();
$estoque = new Estoque($database);


$json = '[
    { id = 1, "produto": "10.01.0419", "cor": "00", "tamanho": "P", "deposito": "DEP1", "data_disponibilidade": "2023-05-01", "quantidade": 15 },
    { id = 2, "produto": "11.01.0568", "cor": "08", "tamanho": "P", "deposito": "DEP1", "data_disponibilidade": "2023-05-01", "quantidade": 2 },
    { id = 3, "produto": "11.01.0568", "cor": "08", "tamanho": "M", "deposito": "DEP1", "data_disponibilidade": "2023-05-01", "quantidade": 4 },
    { id = 4, "produto": "11.01.0568", "cor": "08", "tamanho": "G", "deposito": "1", "data_disponibilidade": "2023-05-01", "quantidade": 6 },
    { id = 5, "produto": "11.01.0568", "cor": "08", "tamanho": "P", "deposito": "DEP1", "data_disponibilidade": "2023-06-01", "quantidade": 8 },
    ]'

$estoque->atualizarEstoque($json);
?>

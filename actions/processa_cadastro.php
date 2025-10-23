<?php
// processa_cadastro.php
require_once './config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = $_POST['numero'] ?? '';
    $tipo = $_POST['tipo'] ?? '';
    $preco = $_POST['preco'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $ativo = isset($_POST['disponibilidade']) ? 1 : 0;
    $created_at = date('Y-m-d H:i:s');

    if ($numero && $tipo && $preco && $descricao) {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->getPdo();
            $stmt = $pdo->prepare('INSERT INTO quartos (numero, tipo, preco, descricao, ativo, created_at) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->execute([$numero, $tipo, $preco, $descricao, $ativo, $created_at]);
            header('Location: quartos.php?sucesso=1');
            exit();
        } catch (PDOException $e) {
            echo 'Erro ao cadastrar quarto: ' . $e->getMessage();
        }
    } else {
        echo 'Preencha todos os campos obrigatórios!';
    }
} else {
    echo 'Método inválido!';
}

<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    die('Acesso negado.');
}

require_once '../includes/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = $_POST['numero'] ?? '';
    $tipo = $_POST['tipo'] ?? '';
    $preco = $_POST['preco'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $ativo = isset($_POST['ativo']) ? 1 : 0;
    $created_at = date('Y-m-d H:i:s');


    if ($numero && $tipo && $preco && $descricao) {

        try {

            $sql = "INSERT INTO quartos (numero, tipo, preco, descricao, ativo, `created_at`) VALUES (?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssis", $numero, $tipo, $preco, $descricao, $ativo, $created_at);
            $stmt->execute();
            $stmt->close();
            $conn->close();

            header('Location: ../admin/quartos.php?sucesso=1');
            exit();
        } catch (Exception $e) {
            echo 'Erro ao cadastrar quarto: ' . $e->getMessage();
        }
    } else {
        echo 'Preencha todos os campos obrigatórios!';
    }
} else {
    echo 'Método inválido!';
}

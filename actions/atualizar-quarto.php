<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['usuario_id'])) {
    die('Acesso negado.');
}
require_once '../includes/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id_quarto = filter_input(INPUT_POST, 'id_quarto', FILTER_VALIDATE_INT);
    $numero = trim($_POST['numero'] ?? '');
    $tipo = trim($_POST['tipo'] ?? '');
    $preco = trim($_POST['preco'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $ativo = isset($_POST['ativo']) ? 1 : 0;

    $erros = [];
    if (!$id_quarto) $erros[] = "ID do quarto inválido.";
    if (empty($numero)) $erros[] = "O campo 'Número do Quarto' é obrigatório.";
    if (empty($tipo)) $erros[] = "O campo 'Tipo de Quarto' é obrigatório.";
    if (empty($preco) || !is_numeric($preco)) $erros[] = "O campo 'Preço por Noite' é obrigatório e numérico.";
    if (empty($descricao)) $erros[] = "O campo 'Descrição' é obrigatório.";

    if (!empty($erros)) {
        header("Location: ../admin/editar-quarto.php?id=$id_quarto&erro=validacao");
        exit();
    }

    try {
        $sql = "UPDATE quartos SET numero = ?, tipo = ?, preco = ?, descricao = ?, ativo = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) throw new Exception($conn->error); 

        $bind_result = $stmt->bind_param("ssdsii", $numero, $tipo, $preco, $descricao, $ativo, $id_quarto);
        if ($bind_result === false) throw new Exception($stmt->error); 

        $execute_result = $stmt->execute();
        if ($execute_result === false) throw new Exception($stmt->error); 
        $stmt->close();
        $conn->close();

        header('Location: ../admin/quartos.php?sucesso=editado');
        exit();
    } catch (Exception $e) {
        header('Location: ../admin/quartos.php?erro=editar');
        exit();
    }
} else {
    header('Location: ../admin/quartos.php'); 
    exit();
}

<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    die('Acesso negado.');
}
require_once '../includes/conexao.php';

$id_quarto = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id_quarto) {
    try {
        $sql = "DELETE FROM quartos WHERE id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            throw new Exception("Erro ao preparar a exclusão: " . $conn->error);
        }

        $stmt->bind_param("i", $id_quarto);

        $execute_result = $stmt->execute();

        if ($execute_result === false) {
            throw new Exception("Erro ao executar a exclusão: " . $stmt->error);
        }

        $linhas_afetadas = $stmt->affected_rows;

        $stmt->close();
        $conn->close();

        if ($linhas_afetadas > 0) {
            header('Location: ../admin/quartos.php?sucesso=excluido');
            exit();
        } else {
            header('Location: ../admin/quartos.php?erro=nao_encontrado_excluir');
            exit();
        }
    } catch (Exception $e) {
        header('Location: ../admin/quartos.php?erro=excluir');
        exit();
    }
} else {
    header('Location: ../admin/quartos.php?erro=id_invalido_excluir');
    exit();
}

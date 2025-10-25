<?php

session_start();
if (!isset($_SESSION['usuario_id'])) {
    die('Acesso negado.');
}
require_once '../includes/conexao.php';


$reserva_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);


if ($reserva_id) {
    try {

        $sql = "DELETE FROM reservas WHERE id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            throw new Exception("Erro ao preparar a exclusão da reserva: " . $conn->error);
        }


        $stmt->bind_param("i", $reserva_id);


        $execute_result = $stmt->execute();

        if ($execute_result === false) {
            throw new Exception("Erro ao executar a exclusão da reserva: " . $stmt->error);
        }


        $linhas_afetadas = $stmt->affected_rows;

        $stmt->close();
        $conn->close();


        if ($linhas_afetadas > 0) {
            header('Location: ../admin/reservas.php?sucesso=cancelado');
            exit();
        } else {

            header('Location: ../admin/reservas.php?erro=nao_encontrado_cancelar');
            exit();
        }
    } catch (Exception $e) {

        header('Location: ../admin/reservas.php?erro=cancelar');
        exit();
    }
} else {
    header('Location: ../admin/reservas.php?erro=id_invalido_cancelar');
    exit();
}

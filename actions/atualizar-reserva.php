<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    die('Acesso negado.');
}
require_once '../includes/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $reserva_id = filter_input(INPUT_POST, 'reserva_id', FILTER_VALIDATE_INT);
    $hospede_id = filter_input(INPUT_POST, 'hospede_id', FILTER_VALIDATE_INT);
    $hospede_nome = trim($_POST['hospede_nome'] ?? '');
    $hospede_cpf = trim($_POST['hospede_cpf'] ?? '');
    $hospede_email = trim($_POST['hospede_email'] ?? '');
    $hospede_telefone = trim($_POST['hospede_telefone'] ?? '');
    $quarto_id = filter_input(INPUT_POST, 'quarto_id', FILTER_VALIDATE_INT);
    $data_checkin = $_POST['data_checkin'] ?? '';
    $data_checkout = $_POST['data_checkout'] ?? '';
    $adultos = filter_input(INPUT_POST, 'adultos', FILTER_VALIDATE_INT) ?: 1;
    $criancas = filter_input(INPUT_POST, 'criancas', FILTER_VALIDATE_INT) ?: 0;
    $status = $_POST['status'] ?? 'pendente';

    $erros = [];
    if (!$reserva_id) $erros[] = "ID da reserva inválido.";
    if (!$hospede_id) $erros[] = "ID do hóspede inválido.";
    if (empty($hospede_nome)) $erros[] = "Nome do hóspede é obrigatório.";
    if (empty($hospede_cpf)) $erros[] = "CPF do hóspede é obrigatório.";
    if (empty($hospede_email) || !filter_var($hospede_email, FILTER_VALIDATE_EMAIL)) $erros[] = "Email do hóspede inválido ou vazio.";
    if (!$quarto_id) $erros[] = "Selecione um quarto.";
    if (empty($data_checkin)) $erros[] = "Data de Check-in é obrigatória.";
    if (empty($data_checkout)) $erros[] = "Data de Check-out é obrigatória.";

    if (!empty($erros)) {
        header('Location: ../admin/editar-reserva.php?id=' . $reserva_id . '&erro=validacao');
        exit;
    }

    try {
        $conn->begin_transaction();

        $sql_update_hospede = "UPDATE hospedes SET nome_completo = ?, cpf = ?, email = ?, telefone = ? WHERE id = ?";
        $stmt_update_hospede = $conn->prepare($sql_update_hospede);
        if ($stmt_update_hospede === false) throw new Exception("Erro prepare hospede update: " . $conn->error);
        $stmt_update_hospede->bind_param("ssssi", $hospede_nome, $hospede_cpf, $hospede_email, $hospede_telefone, $hospede_id);
        if (!$stmt_update_hospede->execute()) throw new Exception("Erro execute hospede update: " . $stmt_update_hospede->error);
        $stmt_update_hospede->close();

        $sql_update_reserva = "UPDATE reservas SET quarto_id = ?, data_checkin = ?, data_checkout = ?, adultos = ?, criancas = ?, status = ? WHERE id = ?";
        $stmt_update_reserva = $conn->prepare($sql_update_reserva);
        if ($stmt_update_reserva === false) throw new Exception("Erro prepare reserva update: " . $conn->error);

        $stmt_update_reserva->bind_param("issiisi", $quarto_id, $data_checkin, $data_checkout, $adultos, $criancas, $status, $reserva_id);

        if (!$stmt_update_reserva->execute()) throw new Exception("Erro execute reserva update: " . $stmt_update_reserva->error);
        $stmt_update_reserva->close();

        $conn->commit();

        header('Location: ../admin/reservas.php?sucesso=editado');
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        header('Location: ../admin/editar-reserva.php?id=' . $reserva_id . '&erro=db');
        exit();
    } finally {
        if (isset($conn) && $conn->ping()) {
            $conn->close();
        }
    }
} else {
    header('Location: ../admin/reservas.php');
    exit();
}

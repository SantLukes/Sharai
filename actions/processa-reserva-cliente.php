<?php

require_once '../includes/conexao.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $hospede_nome = trim($_POST['hospede_nome'] ?? '');
    $hospede_cpf = trim($_POST['hospede_cpf'] ?? '');
    $hospede_email = trim($_POST['hospede_email'] ?? '');
    $hospede_telefone = trim($_POST['hospede_telefone'] ?? '');


    $quarto_id = filter_input(INPUT_POST, 'quarto_id', FILTER_VALIDATE_INT);
    $data_checkin = $_POST['data_checkin'] ?? '';
    $data_checkout = $_POST['data_checkout'] ?? '';
    $adultos = filter_input(INPUT_POST, 'adultos', FILTER_VALIDATE_INT) ?: 1;
    $criancas = filter_input(INPUT_POST, 'criancas', FILTER_VALIDATE_INT) ?: 0;
    $status = 'pendente';


    $erros = [];
    if (empty($hospede_nome)) $erros[] = "Nome inválido.";
    if (empty($hospede_cpf)) $erros[] = "CPF inválido.";
    if (empty($hospede_email) || !filter_var($hospede_email, FILTER_VALIDATE_EMAIL)) $erros[] = "Email inválido.";
    if (empty($hospede_telefone)) $erros[] = "Telefone inválido.";
    if (!$quarto_id) $erros[] = "Quarto inválido.";
    if (empty($data_checkin)) $erros[] = "Data Check-in inválida.";
    if (empty($data_checkout)) $erros[] = "Data Check-out inválida.";

    if (!empty($erros)) {

        header('Location: ../sharan.php?erro=dados_invalidos');
        exit;
    }


    try {
        if (!$conn) {
            throw new Exception("Falha na conexão com o banco de dados.");
        }
        $conn->begin_transaction();


        $hospede_id = null;
        $sql_hospede = "SELECT id FROM hospedes WHERE cpf = ? OR email = ?";
        $stmt_hospede = $conn->prepare($sql_hospede);
        if ($stmt_hospede === false) throw new Exception("Erro prepare hospede select: " . $conn->error);
        $stmt_hospede->bind_param("ss", $hospede_cpf, $hospede_email);
        if (!$stmt_hospede->execute()) throw new Exception("Erro execute hospede select: " . $stmt_hospede->error);
        $resultado_hospede = $stmt_hospede->get_result();

        if ($resultado_hospede->num_rows > 0) {
            $hospede_existente = $resultado_hospede->fetch_assoc();
            $hospede_id = $hospede_existente['id'];
        } else {
            $sql_insert_hospede = "INSERT INTO hospedes (nome_completo, cpf, email, telefone) VALUES (?, ?, ?, ?)";
            $stmt_insert_hospede = $conn->prepare($sql_insert_hospede);
            if ($stmt_insert_hospede === false) throw new Exception("Erro prepare hospede insert: " . $conn->error);
            $stmt_insert_hospede->bind_param("ssss", $hospede_nome, $hospede_cpf, $hospede_email, $hospede_telefone);
            if (!$stmt_insert_hospede->execute()) throw new Exception("Erro execute hospede insert: " . $stmt_insert_hospede->error);
            $hospede_id = $stmt_insert_hospede->insert_id;
            $stmt_insert_hospede->close();
        }
        $stmt_hospede->close();


        $sql_reserva = "INSERT INTO reservas (quarto_id, hospede_id, data_checkin, data_checkout, adultos, criancas, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_reserva = $conn->prepare($sql_reserva);
        if ($stmt_reserva === false) throw new Exception("Erro prepare reserva insert: " . $conn->error);
        $stmt_reserva->bind_param("iisssis", $quarto_id, $hospede_id, $data_checkin, $data_checkout, $adultos, $criancas, $status);
        if (!$stmt_reserva->execute()) throw new Exception("Erro execute reserva insert: " . $stmt_reserva->error);
        $stmt_reserva->close();


        $conn->commit();

        header('Location: ../sharan.php?reserva=sucesso');
        exit();
    } catch (Exception $e) {
        if ($conn) $conn->rollback();
        error_log("Erro ao processar reserva do cliente: " . $e->getMessage());
        header('Location: ../sharan.php?erro=reserva');
        exit();
    } finally {
        if (isset($conn) && $conn->ping()) {
            $conn->close();
        }
    }
} else {
    header('Location: ../sharan.php');
    exit();
}

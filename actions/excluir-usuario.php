<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    die('Acesso negado.');
} {
}
require_once '../includes/conexao.php';

$usuario_id_excluir = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($usuario_id_excluir && isset($_SESSION['usuario_id']) && $usuario_id_excluir == $_SESSION['usuario_id']) {
    header('Location: ../admin/usuarios.php?erro=auto_excluir');
    exit();
}

if ($usuario_id_excluir) {
    try {
        $sql = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            throw new Exception("Erro ao preparar a exclusão do usuário: " . $conn->error);
        }

        $stmt->bind_param("i", $usuario_id_excluir);

        $execute_result = $stmt->execute();

        if ($execute_result === false) {

            throw new Exception("Erro ao executar a exclusão do usuário: " . $stmt->error);
        }

        $linhas_afetadas = $stmt->affected_rows;

        $stmt->close();
        $conn->close();

        if ($linhas_afetadas > 0) {
            header('Location: ../admin/usuarios.php?sucesso=excluido');
            exit();
        } else {
            header('Location: ../admin/usuarios.php?erro=nao_encontrado_excluir');
            exit();
        }
    } catch (Exception $e) {
        header('Location: ../admin/usuarios.php?erro=excluir');
        exit();
    }
} else {
    header('Location: ../admin/usuarios.php?erro=id_invalido_excluir');
    exit();
}

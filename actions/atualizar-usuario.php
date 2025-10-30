<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    die('Acesso negado.');
}
require_once '../includes/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $usuario_id = filter_input(INPUT_POST, 'usuario_id', FILTER_VALIDATE_INT);
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $nova_senha_pura = $_POST['senha'] ?? ''; 
    $nivel_acesso = $_POST['nivel_acesso'] ?? 'funcionario';

    $erros = [];
    if (!$usuario_id) $erros[] = "ID do usuário inválido.";
    if (empty($nome)) $erros[] = "Nome é obrigatório.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $erros[] = "E-mail inválido ou vazio.";
    if ($nivel_acesso !== 'admin' && $nivel_acesso !== 'funcionario') $erros[] = "Nível de acesso inválido.";

    if (!empty($erros)) {
        header('Location: ../admin/editar-usuario.php?id=' . $usuario_id . '&erro=validacao');
        exit;
    }

    try {
        $sql = "UPDATE usuarios SET nome = ?, email = ?, nivel_acesso = ?";
        $params_tipos = "sss";
        $params_valores = [$nome, $email, $nivel_acesso];

        if (!empty($nova_senha_pura)) {
            $novo_hash_senha = password_hash($nova_senha_pura, PASSWORD_DEFAULT);
            $sql .= ", senha = ?";
            $params_tipos .= "s";
            $params_valores[] = $novo_hash_senha;
        }

        $sql .= " WHERE id = ?";
        $params_tipos .= "i";
        $params_valores[] = $usuario_id;

        $stmt = $conn->prepare($sql);
        if ($stmt === false) throw new Exception("Erro ao preparar a atualização: " . $conn->error);

        $bind_result = $stmt->bind_param($params_tipos, ...$params_valores);
        if ($bind_result === false) throw new Exception("Erro ao vincular parâmetros: " . $stmt->error);

        $execute_result = $stmt->execute();
        if ($execute_result === false) {
            if ($conn->errno == 1062) {
                header('Location: ../admin/editar-usuario.php?id=' . $usuario_id . '&erro=email_duplicado');
                exit;
            } else {
                throw new Exception("Erro ao executar a atualização: " . $stmt->error);
            }
        }

        $stmt->close();
        $conn->close();

        header('Location: ../admin/usuarios.php?sucesso=editado');
        exit();
    } catch (Exception $e) {
        header('Location: ../admin/editar-usuario.php?id=' . $usuario_id . '&erro=db');
        exit();
    } finally {
        if (isset($conn) && $conn->ping()) {
            $conn->close();
        }
    }
} else {
    header('Location: ../admin/usuarios.php');
    exit();
}

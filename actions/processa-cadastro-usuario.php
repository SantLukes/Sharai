<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    die('Acesso negado.');
} {
}
require_once '../includes/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha_pura = $_POST['senha'] ?? '';
    $nivel_acesso = $_POST['nivel_acesso'] ?? 'funcionario';

    $erros = [];
    if (empty($nome)) $erros[] = "Nome é obrigatório.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $erros[] = "E-mail inválido ou vazio.";
    if (empty($senha_pura)) $erros[] = "Senha é obrigatória.";
    if ($nivel_acesso !== 'admin' && $nivel_acesso !== 'funcionario') $erros[] = "Nível de acesso inválido.";

    if (strlen($senha_pura) < 8) {
        $erros[] = "A senha deve ter pelo menos 8 caracteres.";
    }

    if (!empty($erros)) {
        header('Location: ../admin/cadastro-usuarios.php?erro=validacao');
        exit;
    }

    try {
        $hash_senha = password_hash($senha_pura, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nome, email, senha, nivel_acesso) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            if ($conn->errno == 1062) {
                header('Location: ../admin/cadastro-usuarios.php?erro=email_duplicado');
                exit;
            } else {
                throw new Exception("Erro ao preparar a inserção: " . $conn->error);
            }
        }

        $stmt->bind_param("ssss", $nome, $email, $hash_senha, $nivel_acesso);

        $execute_result = $stmt->execute();

        if ($execute_result === false) {
            if ($conn->errno == 1062) {
                header('Location: ../admin/cadastro-usuarios.php?erro=email_duplicado');
                exit;
            } else {
                throw new Exception("Erro ao executar a inserção: " . $stmt->error);
            }
        }

        $stmt->close();
        $conn->close();

        header('Location: ../admin/usuarios.php?sucesso=cadastrado');
        exit();
    } catch (Exception $e) {
        header('Location: ../admin/cadastro-usuarios.php?erro=db');
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

<?php

header('Content-Type: application/json');
session_start();

// ======== 1. CONEXÃO COM O BANCO ========
// 
// CAMINHO CORRETO (com base no seu print):
// Sobe de 'actions/' (../) -> entra em 'includes/'
//
include '../includes/conexao.php';
// A variável $conn (com a conexão) agora existe.


// ======== 2. CONFIGURAÇÃO DAS TABELAS ========
$tabela_usuarios = "usuarios";
$coluna_email = "email";
$coluna_senha = "senha";
$coluna_nome = "nome";

$resposta = [];

// ======== 3. LÓGICA DO LOGIN ========

try {
    if ($conn->connect_error) {
        throw new Exception('Falha na conexão com o banco.');
    }

    $email_digitado = $_POST['email'] ?? '';
    $senha_digitada = $_POST['senha'] ?? '';

    if (empty($email_digitado) || empty($senha_digitada)) {
        throw new Exception('Campos vazios.');
    }

    $sql = "SELECT id, $coluna_nome, $coluna_email, $coluna_senha 
            FROM $tabela_usuarios 
            WHERE $coluna_email = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email_digitado);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();
        $hash_do_banco = $usuario[$coluna_senha];

        if (password_verify($senha_digitada, $hash_do_banco)) {
            // Senha CORRETA!
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario[$coluna_nome];

            $resposta['status'] = 'success';
            
            // 
            // CAMINHO CORRETO (com base no seu print):
            // Sobe de 'actions/' (../) -> entra em 'admin/'
            //
            $resposta['redirect_url'] = '../admin/dashboard.php';
        
        } else {
            // Senha Incorreta
            $resposta['status'] = 'error';
            $resposta['field'] = 'senha';
            $resposta['message'] = 'Senha incorreta.';
        }
    } else {
        // E-mail NÃO ENCONTRADO
        $resposta['status'] = 'error';
        $resposta['field'] = 'email';
        $resposta['message'] = 'E-mail não encontrado.';
    }

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    $resposta['status'] = 'error';
    $resposta['field'] = 'geral';
    $resposta['message'] = 'Erro no servidor: ' . $e->getMessage();
}

// ======== 4. RESPONDE PARA O JAVASCRIPT ========
echo json_encode($resposta);
exit;
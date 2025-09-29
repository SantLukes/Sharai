<?php
require_once './config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->getPdo();
            $stmt = $pdo->prepare('INSERT INTO newsletter (id_email, email_cadastro) VALUES (NULL, ?)');
            $stmt->execute([$email]);
            // Sucesso: pode redirecionar ou retornar resposta para JS
            header('Location: index.html?newsletter=sucesso');
            exit();
        } catch (PDOException $e) {
            // Erro ao inserir
            header('Location: index.html?newsletter=erro');
            exit();
        }
    } else {
        // Email inválido
        header('Location: index.html?newsletter=erro');
        exit();
    }
} else {
    header('Location: index.html');
    exit();
}

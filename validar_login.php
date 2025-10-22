<?php
session_start();

// ======== 1. CONFIGURAÇÃO DO SEU AMBIENTE ========

$servidor = "localhost";
$usuario_db = "root";       
$senha_db = "";           
$banco = "Sharan-Hotel"; 

$tabela_usuarios = "usuarios"; // A tabela que criamos
$coluna_email = "email";       // A coluna com o e-mail
$coluna_senha = "senha";       // A coluna com a senha
$coluna_nome = "nome";         // A coluna com o nome do usuário

// ======== 2. LÓGICA DO LOGIN ========

// Conecta ao banco
$conn = new mysqli($servidor, $usuario_db, $senha_db, $banco);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Recebe os dados do formulário (do login.php)
$email_digitado = $_POST['email'];
$senha_digitada = $_POST['senha'];

// Prepara a consulta SQL para evitar injeção de SQL (mais seguro)
$sql = "SELECT id, $coluna_nome, $coluna_email, $coluna_senha 
        FROM $tabela_usuarios 
        WHERE $coluna_email = ?";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Erro ao preparar a consulta: " . $conn->error);
}

$stmt->bind_param("s", $email_digitado);
$stmt->execute();
$resultado = $stmt->get_result();

// Verifica se encontrou o e-mail
if ($resultado->num_rows === 1) {
    // E-mail encontrado. Agora, vamos buscar os dados.
    $usuario = $resultado->fetch_assoc();
    $hash_do_banco = $usuario[$coluna_senha];

    // ======== 3. VERIFICAÇÃO DA SENHA ========
    
    // CENÁRIO SEGURO (Recomendado)
    if (password_verify($senha_digitada, $hash_do_banco)) {
        // Senha CORRETA!
        
        // Armazena os dados do usuário na sessão
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario[$coluna_nome];
        
        // Redireciona para o painel de admin (COMO VOCÊ PEDIU)
        header("Location: http://localhost/Sharai/index.php#");
        exit; // Encerra o script
    } 
    
    // Verificação fallback para CENÁRIO INSEGURO (texto puro, se você não usou hash)
    else if ($senha_digitada === $hash_do_banco) {
        
        // Armazena os dados do usuário na sessão
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario[$coluna_nome];
        
        // Redireciona para o painel de admin (COMO VOCÊ PEDIU)
        header("Location: http://localhost/Sharai/index.php#");
        exit; // Encerra o script
        
    } else {
        // Senha incorreta
        // Manda o usuário de volta para o login com uma mensagem de erro
        header("Location: login.php?erro=senha");
        exit;
    }

} else {
    // E-mail não encontrado
    header("Location: login.php?erro=email");
    exit;
}

$stmt->close();
$conn->close();
?>
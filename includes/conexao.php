<?php
$servidor = "localhost";
$usuario_db = "root";
$senha_db = "";
$banco = "Sharan-Hotel";

// 1. Cria a conexão
$conn = new mysqli($servidor, $usuario_db, $senha_db, $banco);

// 2. Checa a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// 3. Define o charset
$conn->set_charset("utf8");
?>
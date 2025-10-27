<?php
$servidor = "localhost";
$usuario_db = "root";
$senha_db = "";
$banco = "Sharan-Hotel";

$conn = new mysqli($servidor, $usuario_db, $senha_db, $banco);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$conn->set_charset("utf8");

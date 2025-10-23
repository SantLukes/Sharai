<?php
// 1. Inicia a sessão 
session_start();

// 2. Limpa todas as variáveis da sessão 
session_unset();

// 3. Destrói completamente a sessão
session_destroy();

// 4. Manda o usuário de volta para a tela de login

header("Location: login.php");
exit;

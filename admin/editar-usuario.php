<?php

session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
$nome_do_usuario_logado = $_SESSION['usuario_nome'];

include '../includes/conexao.php';


$usuario_id_editar = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$usuario_editar = null;

if (!$usuario_id_editar) {
    header("Location: usuarios.php?erro=id_invalido");
    exit;
}


$sql = "SELECT id, nome, email, nivel_acesso FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id_editar);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $usuario_editar = $resultado->fetch_assoc();
} else {

    header("Location: usuarios.php?erro=nao_encontrado");
    exit;
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Editar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/styles/style-admin.css">
    <script src="../assets/js/admin-script.js" defer></script>
</head>

<body>
    <div class="tela">
        <div class="menu-lateral">
            <img src="../assets/Imagem/sharai-logo.png" alt="Logo Sharan">
            <a href="../index.php">Dashboard</a>
            <a href="quartos.php">Quartos</a>
            <a href="reservas.php">Reservas</a>
            <a href="usuarios.php" class="ativo">Usuários</a>
            <p>Para encerrar a sessão, clique no botão abaixo.</p>
            <a href="logout.php">Sair</a>
        </div>

        <div class="conteudo">
            <div class="topo">
                <h4>Painel Administrativo</h4>
                <div>
                    <span class="me-3">Olá, <?php echo htmlspecialchars($nome_do_usuario_logado); ?></span>
                </div>
            </div>

            <div class="caixa-formulario shadow p-4 rounded mt-4">
                <h3 class="mb-4">Editar Usuário do Painel</h3>

                <form action="../actions/atualizar-usuario.php" method="POST" id="form-usuario" novalidate>
                    <input type="hidden" name="usuario_id" value="<?php echo $usuario_editar['id']; ?>">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo htmlspecialchars($usuario_editar['nome']); ?>">
                        <div class="invalid-feedback">Nome completo é obrigatório.</div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail (Login)</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($usuario_editar['email']); ?>">
                        <div class="invalid-feedback">Digite um e-mail válido.</div>
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label">Nova Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" aria-describedby="senhaHelp">
                        <div id="senhaHelp" class="form-text">Deixe em branco para não alterar. Mínimo 8 caracteres se preenchido.</div>
                        <div class="invalid-feedback">A nova senha deve ter pelo menos 8 caracteres.</div>
                    </div>
                    <div class="mb-3">
                        <label for="nivel_acesso" class="form-label">Nível de Acesso</label>
                        <select class="form-control" id="nivel_acesso" name="nivel_acesso">
                            <option value="">Selecione</option>
                            <option value="funcionario" <?php echo ($usuario_editar['nivel_acesso'] == 'funcionario') ? 'selected' : ''; ?>>Funcionário</option>
                            <option value="admin" <?php echo ($usuario_editar['nivel_acesso'] == 'admin') ? 'selected' : ''; ?>>Administrador</option>
                        </select>
                        <div class="invalid-feedback">Selecione o nível de acesso.</div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary botao-adicionar">Salvar Alterações</button>
                        <a href="usuarios.php" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
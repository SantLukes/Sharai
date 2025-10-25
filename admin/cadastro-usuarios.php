<?php

session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
$nome_do_usuario_logado = $_SESSION['usuario_nome'];
?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Cadastro de Usuário</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous" />

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

                <h3 class="mb-4">Cadastro de Usuário do Painel</h3>

                <form action="../actions/processa-cadastro-usuario.php" method="POST" id="form-usuario" novalidate>
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" id="nome" name="nome">
                        <div class="invalid-feedback">Nome completo é obrigatório.</div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail (Login)</label>
                        <input type="email" class="form-control" id="email" name="email">
                        <div class="invalid-feedback">Digite um e-mail válido.</div>
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha">
                        <div class="invalid-feedback">Senha é obrigatória (mínimo 8 caracteres).</div>
                    </div>
                    <div class="mb-3">
                        <label for="nivel_acesso" class="form-label">Nível de Acesso</label>
                        <select class="form-control" id="nivel_acesso" name="nivel_acesso">
                            <option value="">Selecione</option>
                            <option value="funcionario">Funcionário</option>
                            <option value="admin">Administrador</option>
                        </select>
                        <div class="invalid-feedback">Selecione o nível de acesso.</div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary botao-adicionar">Cadastrar Usuário</button>
                        <a href="usuarios.php" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
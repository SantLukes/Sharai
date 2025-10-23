<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Dashboard</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha3_84-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous" />
    
    <link rel="stylesheet" href="assets/styles/style-admin.css">

    <script src="assets/js/admin-script.js" defer></script>

</head>

<body>

    <div class="tela">

        <div class="menu-lateral">
            <img src="assets/Imagem/sharai-logo.png" alt="Logo Sharan">

            <a href="index.php" class="ativo">Dashboard</a>
            <a href="admin/quartos.php">Quartos</a>
            <a href="admin/reservas.php">Reservas</a>
            <a href="admin/usuarios.php">Usuários</a>
            
            <p>Para encerrar a sessão, clique no botão abaixo.</p>
            <a href="admin/logout.php">Sair</a> 
        </div>

        <div class="conteudo">
            <div class="topo">
                <h4>Painel Administrativo</h4>
                <div>
                    <span class="me-3">Olá, Admin</span>
                </div>
            </div>

            <div class="mt-5">
                <div class="caixa-grafico">
                    <h5>Resumo de Reservas (últimos meses)</h5>
                    </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
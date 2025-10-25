<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: admin/login.php");
    exit;
}
$nome_do_usuario_logado = $_SESSION['usuario_nome'];
include 'includes/conexao.php';

$total_quartos = 0;
$total_reservas = 0;
$total_usuarios = 0;

if ($conn) {
    $result_quartos = $conn->query("SELECT COUNT(*) AS total FROM quartos");
    if ($result_quartos) {
        $total_quartos = $result_quartos->fetch_assoc()['total'];
    }
    $result_reservas = $conn->query("SELECT COUNT(*) AS total FROM reservas");
    if ($result_reservas) {
        $total_reservas = $result_reservas->fetch_assoc()['total'];
    }
    $result_usuarios = $conn->query("SELECT COUNT(*) AS total FROM usuarios");
    if ($result_usuarios) {
        $total_usuarios = $result_usuarios->fetch_assoc()['total'];
    }
    $conn->close();
} else {
    error_log("Erro de conexão no Dashboard (index.php)");
}
?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles/style-admin.css">
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
                    <span class="me-3">Olá, <?php echo htmlspecialchars($nome_do_usuario_logado); ?></span>
                </div>
            </div>

            <div class="container-fluid mt-4">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card text-center shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title">Quartos Cadastrados</h5>
                                <p class="display-4 fw-bold"><?php echo $total_quartos; ?></p>
                                <a href="admin/quartos.php" class="btn btn-sm botao-adicionar">Ver Quartos</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card text-center shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title">Reservas Totais</h5>
                                <p class="display-4 fw-bold"><?php echo $total_reservas; ?></p>
                                <a href="admin/reservas.php" class="btn btn-sm botao-adicionar">Ver Reservas</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card text-center shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title">Usuários do Painel</h5>
                                <p class="display-4 fw-bold"><?php echo $total_usuarios; ?></p>
                                <a href="admin/usuarios.php" class="btn btn-sm botao-adicionar">Ver Usuários</a>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="row mt-4">
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                <h5 class="card-title text-center">Quartos</h5>
                                <canvas id="chartQuartos"
                                    data-total="<?php echo $total_quartos; ?>"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                <h5 class="card-title text-center">Reservas</h5>
                                <canvas id="chartReservas"
                                    data-total="<?php echo $total_reservas; ?>"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                <h5 class="card-title text-center">Usuários</h5>
                                <canvas id="chartUsuarios"
                                    data-total="<?php echo $total_usuarios; ?>"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="assets/js/admin-script.js" defer></script>
</body>

</html>
<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
$nome_do_usuario_logado = $_SESSION['usuario_nome'];
include '../includes/conexao.php';

$sql = "SELECT
            r.id,
            r.data_checkin,
            r.data_checkout,
            r.status,
            h.nome_completo AS nome_hospede,
            q.numero AS numero_quarto,
            q.tipo AS tipo_quarto
        FROM
            reservas AS r
        JOIN
            hospedes AS h ON r.hospede_id = h.id
        JOIN
            quartos AS q ON r.quarto_id = q.id
        ORDER BY
            r.data_checkin ASC";

$resultado = $conn->query($sql);

if ($resultado === false) {
    error_log("Erro SQL em reservas.php: " . $conn->error);
    $resultado = null;
}
?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gerenciamento de Reservas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/styles/style-admin.css">
    <script src="../assets/js/admin-script.js" defer></script>
</head>

<body>
    <div class="tela">
        <div class="menu-lateral">
            <img src="../assets/Imagem/sharai-logo.png" alt="Logo Sharan">
            <a href="../sharan.php">Dashboard</a>
            <a href="quartos.php">Quartos</a>
            <a href="reservas.php" class="ativo">Reservas</a>
            <a href="usuarios.php">Usuários</a>
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

            <div class="area-tabela">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>Lista de Reservas</h5>
                    <a href="cadastro-reserva.php" class="btn btn-primary btn-sm botao-adicionar">+ Adicionar Nova</a>
                </div>

                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Hóspede</th>
                            <th>Quarto</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($resultado && $resultado->num_rows > 0) {
                            while ($reserva = $resultado->fetch_assoc()) {
                                $checkin = new DateTime($reserva['data_checkin']);
                                $checkout = new DateTime($reserva['data_checkout']);
                                $checkin_formatado = $checkin->format('d/m/Y');
                                $checkout_formatado = $checkout->format('d/m/Y');
                                $quarto_info = $reserva['numero_quarto'] . ' - ' . $reserva['tipo_quarto'];
                        ?>
                                <tr>
                                    <td><?php echo $reserva['id']; ?></td>
                                    <td><?php echo htmlspecialchars($reserva['nome_hospede']); ?></td>
                                    <td><?php echo htmlspecialchars($quarto_info); ?></td>
                                    <td><?php echo $checkin_formatado; ?></td>
                                    <td><?php echo $checkout_formatado; ?></td>
                                    <td><?php echo htmlspecialchars(ucfirst($reserva['status'])); ?></td>
                                    <td>
                                        <a href="editar-reserva.php?id=<?php echo $reserva['id']; ?>" class="btn btn-info btn-sm text-white">Editar</a>
                                        <a href="../actions/cancelar-reserva.php?id=<?php echo $reserva['id']; ?>" class="btn btn-danger btn-sm">Cancelar</a>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center'>Nenhuma reserva encontrada.</td></tr>";
                        }
                        if ($conn) {
                            $conn->close();
                        }
                        ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <div id="modalConfirmacaoOverlay" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-header">
                <h3 id="modalTitulo">Confirmar Ação</h3>
                <button id="modalFecharBtn" class="modal-fechar">&times;</button>
            </div>
            <div class="modal-body">
                <p id="modalMensagem">Tem certeza que deseja continuar?</p>
                <p id="infoItemExcluir" class="info-extra"></p>
            </div>
            <div class="modal-footer">
                <button id="modalCancelarBtn" class="btn-cancelar">Cancelar</button>
                <a href="#" id="modalConfirmarBtn" class="btn-confirmar">Confirmar</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
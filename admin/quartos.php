<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
$nome_do_usuario_logado = $_SESSION['usuario_nome'];
include '../includes/conexao.php';
$sql = "SELECT id, numero, tipo, preco, updated_at FROM quartos ORDER BY id ASC";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gerenciamento de quartos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/styles/style-admin.css">
    <script src="../assets/js/admin-script.js" defer></script>
</head>

<body>
    <div class="tela">
        <div class="menu-lateral">
            <img src="../assets/Imagem/sharai-logo.png" alt="Logo Sharan">
            <a href="../index.php">Dashboard</a>
            <a href="quartos.php" class="ativo">Quartos</a>
            <a href="reservas.php">Reservas</a>
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
                    <h5>Lista de Quartos</h5>
                    <a href="cadastro-quartos.php" class="btn btn-primary btn-sm botao-adicionar">+ Adicionar Novo</a>
                </div>
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Número</th>
                            <th>Tipo</th>
                            <th>Preço</th>
                            <th>Atualizado em</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($resultado && $resultado->num_rows > 0) {
                            while ($quarto = $resultado->fetch_assoc()) {
                                $data = new DateTime($quarto['updated_at']);
                                $data_formatada = $data->format('d/m/Y H:i');
                                $preco_formatado = 'R$ ' . number_format($quarto['preco'], 2, ',', '.');
                        ?>
                                <tr>
                                    <td><?php echo $quarto['id']; ?></td>
                                    <td><?php echo htmlspecialchars($quarto['numero']); ?></td>
                                    <td><?php echo htmlspecialchars($quarto['tipo']); ?></td>
                                    <td><?php echo $preco_formatado; ?></td>
                                    <td><?php echo $data_formatada; ?></td>
                                    <td>
                                        <a href="editar-quarto.php?id=<?php echo $quarto['id']; ?>" class="btn btn-info btn-sm text-white">Editar</a>
                                        <a href="../actions/excluir-quarto.php?id=<?php echo $quarto['id']; ?>" class="btn btn-danger btn-sm">Excluir</a>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>Nenhum quarto cadastrado.</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="modalConfirmacaoOverlay" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-header">
                <h3>Confirmar Exclusão</h3>
                <button id="modalFecharBtn" class="modal-fechar">&times;</button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir este quarto? Esta ação não pode ser desfeita.</p>
                <p id="infoQuartoExcluir" class="info-extra"></p>
            </div>
            <div class="modal-footer">
                <button id="modalCancelarBtn" class="btn-cancelar">Cancelar</button>
                <a href="#" id="modalConfirmarBtn" class="btn-confirmar">Confirmar Exclusão</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
$nome_do_usuario_logado = $_SESSION['usuario_nome'];
include '../includes/conexao.php';

$sql = "SELECT id, nome, email, nivel_acesso, data_criacao FROM usuarios ORDER BY nome ASC";
$resultado = $conn->query($sql);

if ($resultado === false) {
    error_log("Erro SQL em usuarios.php: " . $conn->error);
    $resultado = null;
}
?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gerenciamento de Usuários</title>
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

            <div class="area-tabela">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>Lista de Usuários</h5>
                    <a href="cadastro-usuarios.php" class="btn btn-primary btn-sm botao-adicionar">+ Adicionar Novo</a>
                </div>

                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email (Login)</th>
                            <th>Nível</th>
                            <th>Criado em</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($resultado && $resultado->num_rows > 0) {
                            while ($usuario = $resultado->fetch_assoc()) {
                                $data = new DateTime($usuario['data_criacao']);
                                $data_formatada = $data->format('d/m/Y H:i');
                        ?>
                                <tr>
                                    <td><?php echo $usuario['id']; ?></td>
                                    <td><?php echo htmlspecialchars($usuario['nome']); ?></td>
                                    <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                                    <td><?php echo htmlspecialchars(ucfirst($usuario['nivel_acesso'])); ?></td>
                                    <td><?php echo $data_formatada; ?></td>
                                    <td>
                                        <a href="editar-usuario.php?id=<?php echo $usuario['id']; ?>" class="btn btn-info btn-sm text-white">Editar</a>
                                        <a href="../actions/excluir-usuario.php?id=<?php echo $usuario['id']; ?>" class="btn btn-danger btn-sm">Excluir</a>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>Nenhum usuário encontrado.</td></tr>";
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <div id="modalConfirmacaoOverlay" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-header">
                <h3 id="modalTitulo">Confirmar Ação</h3> <button id="modalFecharBtn" class="modal-fechar">&times;</button>
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
</body>

</html>
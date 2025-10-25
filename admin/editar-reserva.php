<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
$nome_do_usuario_logado = $_SESSION['usuario_nome'];

include_once '../includes/conexao.php';
$reserva_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$reserva = null;
$hospede = null;
$quartos_disponiveis = [];

if (!$reserva_id) {
    header("Location: reservas.php?erro=id_invalido");
    exit;
}

if (isset($conn) && $conn) {
    $sql_reserva_hospede = "SELECT r.*, h.nome_completo, h.cpf, h.email, h.telefone 
                            FROM reservas r 
                            JOIN hospedes h ON r.hospede_id = h.id 
                            WHERE r.id = ?";
    $stmt_reserva = $conn->prepare($sql_reserva_hospede);
    if ($stmt_reserva) {
        $stmt_reserva->bind_param("i", $reserva_id);
        $stmt_reserva->execute();
        $resultado_reserva = $stmt_reserva->get_result();
        if ($resultado_reserva->num_rows === 1) {
            $reserva = $resultado_reserva->fetch_assoc();
            $hospede = [
                'id' => $reserva['hospede_id'],
                'nome_completo' => $reserva['nome_completo'],
                'cpf' => $reserva['cpf'],
                'email' => $reserva['email'],
                'telefone' => $reserva['telefone']
            ];
        } else {
            $stmt_reserva->close();
            header("Location: reservas.php?erro=nao_encontrada");
            exit;
        }
        $stmt_reserva->close();
    } else {
        error_log("Erro ao preparar consulta de reserva/hospede: " . $conn->error);
    }

    $sql_quartos = "SELECT id, numero, tipo FROM quartos WHERE ativo = 1 ORDER BY numero ASC";
    $resultado_quartos = $conn->query($sql_quartos);
    if ($resultado_quartos && $resultado_quartos->num_rows > 0) {
        while ($quarto_db = $resultado_quartos->fetch_assoc()) {
            $quartos_disponiveis[] = $quarto_db;
        }
    }
    $conn->close();
} else {
    error_log("Erro: Falha ao conectar ao banco de dados em editar-reserva.php");
}
if ($reserva === null) {
    header("Location: reservas.php?erro=nao_encontrada");
    exit;
}
?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Editar Reserva</title>
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

            <div class="caixa-formulario shadow p-4 rounded mt-4">
                <h3 class="mb-4">Editar Reserva</h3>
                <form action="../actions/atualizar-reserva.php" method="POST" id="form-reserva" novalidate>
                    <input type="hidden" name="reserva_id" value="<?php echo $reserva['id']; ?>">
                    <input type="hidden" name="hospede_id" value="<?php echo $hospede['id']; ?>">

                    <h5 class="mb-3">Dados do Hóspede</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="hospede_nome" class="form-label">Nome Completo</label>
                            <input type="text" class="form-control" id="hospede_nome" name="hospede_nome" value="<?php echo htmlspecialchars($hospede['nome_completo']); ?>">
                            <div class="invalid-feedback">Nome completo é obrigatório.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="hospede_cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control" id="hospede_cpf" name="hospede_cpf" value="<?php echo htmlspecialchars($hospede['cpf']); ?>">
                            <div class="invalid-feedback">CPF é obrigatório.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="hospede_email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="hospede_email" name="hospede_email" value="<?php echo htmlspecialchars($hospede['email']); ?>">
                            <div class="invalid-feedback">Digite um e-mail válido.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="hospede_telefone" class="form-label">Telefone</label>
                            <input type="text" class="form-control" id="hospede_telefone" name="hospede_telefone" value="<?php echo htmlspecialchars($hospede['telefone']); ?>">
                            <div class="invalid-feedback">Telefone é obrigatório.</div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-3">Dados da Reserva</h5>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="quarto_id" class="form-label">Quarto</label>
                            <select class="form-control" id="quarto_id" name="quarto_id">
                                <option value="">Selecione um quarto...</option>
                                <?php
                                if (!empty($quartos_disponiveis)) {
                                    foreach ($quartos_disponiveis as $quarto_db) {
                                        $texto_opcao = $quarto_db['numero'] . ' - ' . $quarto_db['tipo'];
                                        $selected = ($quarto_db['id'] == $reserva['quarto_id']) ? 'selected' : '';
                                        echo '<option value="' . $quarto_db['id'] . '" ' . $selected . '>' . htmlspecialchars($texto_opcao) . '</option>';
                                    }
                                } else {
                                    echo '<option value="" disabled>Nenhum quarto ativo encontrado.</option>';
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback">Selecione um quarto.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="data_checkin" class="form-label">Data Check-in</label>
                            <input type="date" class="form-control" id="data_checkin" name="data_checkin" value="<?php echo $reserva['data_checkin']; ?>">
                            <div class="invalid-feedback">Data de Check-in é obrigatória.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="data_checkout" class="form-label">Data Check-out</label>
                            <input type="date" class="form-control" id="data_checkout" name="data_checkout" value="<?php echo $reserva['data_checkout']; ?>">
                            <div class="invalid-feedback">Data de Check-out é obrigatória e deve ser após o Check-in.</div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="adultos" class="form-label">Adultos</label>
                            <select class="form-control" id="adultos" name="adultos">
                                <option value="">Selecione</option>
                                <option value="1" <?php echo ($reserva['adultos'] == 1) ? 'selected' : ''; ?>>1</option>
                                <option value="2" <?php echo ($reserva['adultos'] == 2) ? 'selected' : ''; ?>>2</option>
                                <option value="3" <?php echo ($reserva['adultos'] == 3) ? 'selected' : ''; ?>>3</option>
                            </select>
                            <div class="invalid-feedback">Selecione o número de adultos.</div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="criancas" class="form-label">Crianças</label>
                            <select class="form-control" id="criancas" name="criancas">
                                <option value="">Selecione</option>
                                <option value="0" <?php echo ($reserva['criancas'] == 0) ? 'selected' : ''; ?>>0</option>
                                <option value="1" <?php echo ($reserva['criancas'] == 1) ? 'selected' : ''; ?>>1</option>
                                <option value="2" <?php echo ($reserva['criancas'] == 2) ? 'selected' : ''; ?>>2</option>
                                <option value="3" <?php echo ($reserva['criancas'] == 3) ? 'selected' : ''; ?>>3</option>
                            </select>
                            <div class="invalid-feedback">Selecione o número de crianças.</div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="">Selecione</option>
                                <option value="pendente" <?php echo ($reserva['status'] == 'pendente') ? 'selected' : ''; ?>>Pendente</option>
                                <option value="confirmada" <?php echo ($reserva['status'] == 'confirmada') ? 'selected' : ''; ?>>Confirmada</option>
                                <option value="cancelada" <?php echo ($reserva['status'] == 'cancelada') ? 'selected' : ''; ?>>Cancelada</option>
                                <option value="checkin" <?php echo ($reserva['status'] == 'checkin') ? 'selected' : ''; ?>>Check-in</option>
                                <option value="checkout" <?php echo ($reserva['status'] == 'checkout') ? 'selected' : ''; ?>>Check-out</option>
                            </select>
                            <div class="invalid-feedback">Selecione o status da reserva.</div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary botao-adicionar">Salvar Alterações</button>
                        <a href="reservas.php" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
$nome_do_usuario_logado = $_SESSION['usuario_nome'];

$caminho_conexao = '../includes/conexao.php';
if (!file_exists($caminho_conexao)) {
    die("ERRO FATAL: Arquivo de conexão NÃO ENCONTRADO.");
}
include $caminho_conexao;

if (!isset($conn) || $conn === null || $conn->connect_error) {
    die("ERRO FATAL: Falha na conexão MySQLi. Verifique o arquivo conexao.php.");
}

$id_quarto = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$quarto = null;

if ($id_quarto) {
    $sql = "SELECT id, numero, tipo, preco, descricao, ativo FROM quartos WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) die("Erro no prepare: " . $conn->error);

    $bind_result = $stmt->bind_param("i", $id_quarto);
    if ($bind_result === false) die("Erro no bind_param: " . $stmt->error);

    $execute_result = $stmt->execute();
    if ($execute_result === false) die("Erro no execute: " . $stmt->error);

    $resultado = $stmt->get_result();
    if ($resultado === false) die("Erro no get_result: " . $stmt->error);

    if ($resultado->num_rows === 1) {
        $quarto = $resultado->fetch_assoc();
    } else {
        header("Location: quartos.php?erro=nao_encontrado&id_tentado=$id_quarto");
        exit;
    }
    $stmt->close();
} else {
    header("Location: quartos.php?erro=id_invalido");
    exit;
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Editar Quarto</title>
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

            <div class="caixa-formulario shadow p-4 rounded mt-4">
                <h3 class="mb-4">Editar Quarto</h3>

                <?php if ($quarto): ?>
                    <form action="../actions/atualizar-quarto.php" method="POST">
                        <input type="hidden" name="id_quarto" value="<?php echo $quarto['id']; ?>">
                        <div class="mb-3">
                            <label for="numero" class="form-label">Número do Quarto</label>
                            <input type="text" class="form-control" id="numero" name="numero"
                                value="<?php echo htmlspecialchars($quarto['numero']); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo de Quarto</label>
                            <select class="form-control" id="tipo" name="tipo">
                                <option value="">Selecione</option>
                                <option value="Solteiro 1" <?php echo (strtolower(trim($quarto['tipo'])) == 'simples') ? 'selected' : ''; ?>>Solteiro 1</option>
                                <option value="Casal 1" <?php echo (isset($quarto['tipo']) && strtolower(trim($quarto['tipo'])) == 'casal 1') ? 'selected' : ''; ?>>Casal 1</option>
                                <option value="Casal 2" <?php echo (strtolower(trim($quarto['tipo'])) == 'duplo') ? 'selected' : ''; ?>>Casal 2</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="preco" class="form-label">Preço por Noite</label>
                            <input type="number" class="form-control" id="preco" name="preco" step="0.01"
                                value="<?php echo htmlspecialchars($quarto['preco']); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="3"><?php echo htmlspecialchars($quarto['descricao']); ?></textarea>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="ativo" name="ativo" value="1"
                                <?php echo ($quarto['ativo'] == 1) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="ativo">Quarto Ativo</label>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary botao-adicionar">Salvar Alterações</button>
                            <a href="quartos.php" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                <?php else: ?>
                    <p class="text-danger">Erro: Não foi possível carregar os dados do quarto.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
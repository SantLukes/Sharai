<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Cadastro de Quartos</title>
    
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
                    <span class="me-3">Olá, Admin</span>
                </div>
            </div>

            <div class="caixa-formulario shadow p-4 rounded mt-4">
                
                <h3 class="mb-4">Cadastro de Quartos</h3>

                <form action="../actions/processa_cadastro.php" method="POST">

                    <div class="mb-3">
                        <label for="numero" class="form-label">Número do Quarto</label>
                        <input type="text" class="form-control" id="numero" name="numero">
                    </div>

                    <div class="mb-3">
                        <label for="tipo" class="form-label">Tipo de Quarto</label>
                        <select class="form-control" id="tipo" name="tipo">
                            <option value="">Selecione</option>
                            <option value="Simples">Solteiro 1</option>
                            <option value="Duplo">Casal 2</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="preco" class="form-label">Preço por Noite</label>
                        <input type="number" class="form-control" id="preco" name="preco" step="0.01">
                    </div>

                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="ativo" name="ativo" value="1">
                        <label class="form-check-label" for="ativo">Quarto Ativo</label>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary botao-adicionar">Cadastrar</button>
                        
                        <a href="quartos.php" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
            
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
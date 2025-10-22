<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Cadastro de quartos</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="./styles/style-admin.css">
    <script src="script.js" defer></script>

</head>

<body>

    <div class="menu-lateral">
        <h2 class="titulo-menu">Sharan Admin</h2>
        <a href="#">Dashboard</a>
        <a href="#">Quartos</a>
        <a href="#">Reservas</a>
        <a href="#">Usuários</a>
    </div>

    <!-- CONTEÚDO PRINCIPAL -->
    <div class="conteudo-pagina">
        <div class="container">
            <h1 class="titulo-pagina mb-4">Cadastro de Quartos</h1>

            <div class="caixa-formulario shadow p-4 rounded">
                <form action="processa_cadastro.php" method="POST">

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
                        <input type="checkbox" class="form-check-input" id="disponibilidade" name="disponibilidade" value="1">
                        <label class="form-check-label" for="disponibilidade">Quarto Ativo</label>
                    </div>

                    <div class="botoes">
                        <button type="submit" class="btn btn-salvar">Cadastrar</button>
                        <button type="reset" class="btn btn-cancelar">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</body>

</html>
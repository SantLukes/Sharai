<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./styles/quarto.css">
    <script src="script.js" defer></script>
     <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
      crossorigin="anonymous"
    />
</head>

<body>


    <header>

        <?php

        include './header.php';

        ?>
    </header>



    <main>

        <div class="container-quarto-form">

            <h1>Cadastrar quartos</h1>



            <form action="processa_cadastro.php" method="POST">
                <div class="mb-3">
                    <label for="numero" class="form-label">Número do Quarto</label>
                    <input type="text" class="form-control" id="numero" name="numero">
                </div>
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo de Quarto</label>
                    <select class="form-control" id="tipo" name="tipo">
                        <option value="">Casa 1</option>
                        <option value="Simples">Solteiro 1</option>
                        <option value="Duplo">Casal 2</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="preco" class="form-label">Preço por Noite</label>
                    <input type="number" class="form-control" id="preco" name="preco">
                </div>
                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea class="form-control" id="descricao" name="descricao"></textarea>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="disponibilidade" name="disponibilidade" value="1">
                    <label class="form-check-label" for="disponibilidade">Quarto Ativo</label>
                </div>
                <button type="submit" class="btn btn-primary">Cadastrar</button>
                <button type="reset" class="btn btn-secondary">Cancelar</button>
            </form>
        </div>

    </main>


    <footer>
        <?php
        include './foooter.php';
        ?>
    </footer>


</body>

</html>
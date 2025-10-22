<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gerenciamento de quartos</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="./styles/style-admin.css">
    <script src="script.js" defer></script>

</head>

<body>

    <div class="tela">

        <!-- MENU LATERAL -->
        <div class="menu-lateral">
            <div class="titulo-menu">Painel Sharan</div>
            <a href="#">Dashboard</a>
            <a href="#">Quartos</a>
            <a href="#">Reservas</a>
            <a href="#">Usuários</a>
        </div>

        <!-- CONTEÚDO PRINCIPAL -->
        <div class="conteudo">
            <div class="topo">
                <h4>Painel Administrativo</h4>
            </div>

            <div class="area-tabela">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>Lista de Quartos</h5>
                    <button class="btn btn-primary btn-sm">+ Adicionar Novo</button>
                </div>

                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Quarto</th>
                            <th>Preço</th>
                            <th>Atualizado em</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Hotel Sharan Beach</td>
                            <td>Fortaleza</td>
                            <td>20/10/2025 12:45</td>
                            <td>
                                <button class="btn btn-info btn-sm text-white">Editar</button>
                                <button class="btn btn-danger btn-sm">Excluir</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Sharan Premium</td>
                            <td>São Paulo</td>
                            <td>19/10/2025 16:20</td>
                            <td>
                                <button class="btn btn-info btn-sm text-white">Editar</button>
                                <button class="btn btn-danger btn-sm">Excluir</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <nav>
                    <ul class="pagination justify-content-end">
                        <li class="page-item disabled"><a class="page-link">Anterior</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">Próximo</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>


</body>

</html>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Login</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="./styles/style-admin.css">
    <script src="admin-script.js" defer></script>

</head>

<body>

    <div class="tela-login">

        <div class="lado-esquerdo">

            <div class="logo-login">
                <img src=" ./Imagem/sharai-logo.png" alt="Logo Sharan Admin">
            </div>

            <div class="texto-login">
                <h2>Bem-vindo ao</h2>
                <h1>Sharan Admin</h1>
                <p>Gerencie hotéis, reservas e usuários em um só lugar.</p>
            </div>
        </div>


        <div class="lado-direito">
            <div class="caixa-login shadow">
                <h3 class="mb-4 text-center">Entrar na conta</h3>

                <form action="validar_login.php" method="POST" id="login-form">

                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input
                            type="email"
                            class="form-control"
                            placeholder="Digite seu e-mail"
                            id="email"
                            name="email">
                        <div class="invalid-feedback">
                            Por favor, digite um e-mail válido.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input
                            type="password"
                            class="form-control"
                            placeholder="Digite sua senha"
                            id="senha"
                            name="senha">
                        <div class="invalid-feedback">
                            Por favor, digite sua senha.
                        </div>
                    </div>

                    <button type="submit" class="btn btn-login w-100 mt-2">Acessar</button>
                </form>

                <p class="texto-rodape mt-3 text-center">© 2024 Your Company. Designed By Teste.</p>
            </div>
        </div>

</body>

</html>
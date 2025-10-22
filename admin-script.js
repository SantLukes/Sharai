document.addEventListener("DOMContentLoaded", function () {
  
  const loginForm = document.getElementById("login-form");
  const emailInput = document.getElementById("email");
  const passwordInput = document.getElementById("senha");

  // 2. Função para validar o formato do e-mail 
  function isValidEmail(email) {
    const re =
      /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
  }

  // 3. Adicionar o "ouvinte" de submit
  loginForm.addEventListener("submit", function (event) {
    // 4. Parar o envio do formulário IMEDIATAMENTE
    event.preventDefault();

    // 5. Resetar os erros (esconder todos antes de checar)
    emailInput.classList.remove("is-invalid");
    passwordInput.classList.remove("is-invalid");

    // 6. Pegar os valores dos campos
    const email = emailInput.value.trim();
    const password = passwordInput.value.trim();

    let isValid = true; // Nossa "bandeira" de validação

    // 7. Validar o e-mail
    if (email === "") {
      isValid = false;
      emailInput.classList.add("is-invalid"); // Mostra o erro
    } else if (!isValidEmail(email)) {
      isValid = false;
      emailInput.classList.add("is-invalid"); // Mostra o erro

      // Opcional: mudar a mensagem de erro específica
      // emailInput.nextElementSibling.textContent = "Por favor, digite um formato de e-mail válido.";
    }

    // 8. Validar a senha
    if (password === "") {
      isValid = false;
      passwordInput.classList.add("is-invalid"); // Mostra o erro
    }

    // 9. Se tudo estiver válido...
    if (isValid) {
      // ...envia o formulário para o 'validar_login.php'
      loginForm.submit();
    }

    // Se 'isValid' for false, o script termina aqui
    // e o usuário vê as mensagens de erro.
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const loginForm = document.getElementById("login-form");
  const emailInput = document.getElementById("email");
  const passwordInput = document.getElementById("senha");
  const submitButton = loginForm.querySelector('button[type="submit"]');

  const emailFeedback = emailInput.nextElementSibling;
  const passwordFeedback = passwordInput.nextElementSibling;

  const defaultEmailError = emailFeedback.textContent;
  const defaultPasswordError = passwordFeedback.textContent;

  function isValidEmail(email) {
    const re =
      /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
  }

  function showError(input, feedback, message) {
    input.classList.add("is-invalid");
    feedback.textContent = message;
  }

  function resetErrors() {
    emailInput.classList.remove("is-invalid");
    passwordInput.classList.remove("is-invalid");
    emailFeedback.textContent = defaultEmailError;
    passwordFeedback.textContent = defaultPasswordError;
  }

  loginForm.addEventListener("submit", async function (event) {
    event.preventDefault();
    resetErrors();

    // A. Validação de FRONT-END

    const email = emailInput.value.trim();
    const password = passwordInput.value.trim();
    let frontEndIsValid = true;

    if (email === "" || !isValidEmail(email)) {
      frontEndIsValid = false;
      showError(emailInput, emailFeedback, defaultEmailError);
    }
    if (password === "") {
      frontEndIsValid = false;
      showError(passwordInput, passwordFeedback, defaultPasswordError);
    }

    if (!frontEndIsValid) {
      return;
    }

    // B. Validação de BACK-END (AJAX / Fetch)

    submitButton.disabled = true;
    submitButton.textContent = "Aguarde...";

    try {
      // --- CORREÇÃO APLICADA AQUI ---
      // O script agora lê o 'action' do seu formulário HTML,
      // que já tem o caminho correto ('../actions/validar_login.php').
      const response = await fetch(loginForm.action, {
        method: "POST",
        body: new FormData(loginForm),
      });

      const data = await response.json();

      if (data.status === "success") {
        // SUCESSO! Login válido

        // 1. Muda o visual do botão para "Sucesso"
        submitButton.textContent = "Sucesso! Redirecionando...";
        submitButton.classList.remove("btn-login"); // Remove sua classe de cor padrão
        submitButton.classList.add("btn-success"); // Adiciona classe verde do Bootstrap

        // 2. Espera 2 segundos (2000ms)
        setTimeout(() => {
          // 3. Redireciona o usuário
          window.location.href = data.redirect_url;
        }, 2000);
      } else if (data.status === "error") {
        // ERRO! Login inválido
        if (data.field === "email") {
          showError(emailInput, emailFeedback, data.message);
        } else if (data.field === "senha") {
          showError(passwordInput, passwordFeedback, data.message);
        } else {
          alert(data.message);
        }

        // Reativa o botão APENAS se der erro
        submitButton.disabled = false;
        submitButton.textContent = "Acessar";
      }
    } catch (error) {
      // Erro de rede
      console.error("Erro no fetch:", error);
      alert("Não foi possível conectar ao servidor.");

      // Reativa o botão APENAS se der erro
      submitButton.disabled = false;
      submitButton.textContent = "Acessar";
    }
  });
});

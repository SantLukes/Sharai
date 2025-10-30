document.addEventListener("DOMContentLoaded", function () {
  const loginForm = document.getElementById("login-form");
  if (loginForm) {
    const emailInput = loginForm.querySelector("#email");
    const passwordInput = loginForm.querySelector("#senha");
    const submitButton = loginForm.querySelector('button[type="submit"]');
    const emailFeedback = emailInput ? emailInput.nextElementSibling : null;
    const passwordFeedback = passwordInput
      ? passwordInput.nextElementSibling
      : null;
    const defaultEmailError = emailFeedback
      ? emailFeedback.textContent
      : "Erro no e-mail.";
    const defaultPasswordError = passwordFeedback
      ? passwordFeedback.textContent
      : "Erro na senha.";

    function isValidEmailLogin(email) {
      const re =
        /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(String(email).toLowerCase());
    }
    function showErrorLogin(input, feedback, message) {
      if (input) input.classList.add("is-invalid");
      if (feedback) feedback.textContent = message;
    }
    function resetErrorsLogin() {
      if (emailInput) emailInput.classList.remove("is-invalid");
      if (passwordInput) passwordInput.classList.remove("is-invalid");
      if (emailFeedback) emailFeedback.textContent = defaultEmailError;
      if (passwordFeedback) passwordFeedback.textContent = defaultPasswordError;
    }

    loginForm.addEventListener("submit", async function (event) {
      event.preventDefault();
      resetErrorsLogin();
      const email = emailInput ? emailInput.value.trim() : "";
      const password = passwordInput ? passwordInput.value.trim() : "";
      let frontEndIsValid = true;
      if (email === "" || !isValidEmailLogin(email)) {
        frontEndIsValid = false;
        showErrorLogin(emailInput, emailFeedback, defaultEmailError);
      }
      if (password === "") {
        frontEndIsValid = false;
        showErrorLogin(passwordInput, passwordFeedback, defaultPasswordError);
      }
      if (!frontEndIsValid) return;
      if (submitButton) {
        submitButton.disabled = true;
        submitButton.textContent = "Aguarde...";
      }
      try {
        const response = await fetch(loginForm.action, {
          method: "POST",
          body: new FormData(loginForm),
        });
        const data = await response.json();
        if (data.status === "success") {
          if (submitButton) {
            submitButton.textContent = "Sucesso! Redirecionando...";
            submitButton.classList.remove("btn-login");
            submitButton.classList.add("btn-success");
          }
          setTimeout(() => {
            window.location.href = data.redirect_url;
          }, 2000);
        } else if (data.status === "error") {
          if (data.field === "email")
            showErrorLogin(emailInput, emailFeedback, data.message);
          else if (data.field === "senha")
            showErrorLogin(passwordInput, passwordFeedback, data.message);
          else alert(data.message || "Erro desconhecido.");
          if (submitButton) {
            submitButton.disabled = false;
            submitButton.textContent = "Acessar";
          }
        }
      } catch (error) {
        console.error("Erro fetch login:", error);
        alert("Não foi possível conectar ou processar resposta.");
        if (submitButton) {
          submitButton.disabled = false;
          submitButton.textContent = "Acessar";
        }
      }
    });
  }

  const formCadastroQuarto = document.getElementById("form-cadastro-quarto");
  if (formCadastroQuarto) {
    const numeroInput = document.getElementById("numero");
    const tipoInput = document.getElementById("tipo");
    const precoInput = document.getElementById("preco");
    const descricaoInput = document.getElementById("descricao");
    const camposQuartoValidar = [
      numeroInput,
      tipoInput,
      precoInput,
      descricaoInput,
    ];

    function showQuartoError(input, message) {
      if (!input) return;
      input.classList.add("is-invalid");
      const feedback = input.parentElement.querySelector(".invalid-feedback");
      if (feedback) {
        feedback.textContent = message;
        feedback.style.display = "block";
      }
    }
    function resetQuartoErrors() {
      camposQuartoValidar.forEach((input) => {
        if (input) {
          input.classList.remove("is-invalid");
          const feedback =
            input.parentElement.querySelector(".invalid-feedback");
          if (feedback) feedback.style.display = "none";
        }
      });
    }
    if (numeroInput) {
      numeroInput.addEventListener("input", function (event) {
        this.value = this.value.replace(/[^0-9]/g, "");
      });
    }
    formCadastroQuarto.addEventListener("submit", function (event) {
      resetQuartoErrors();
      let isValid = true;
      const numero = numeroInput ? numeroInput.value.trim() : "";
      const tipo = tipoInput ? tipoInput.value : "";
      const preco = precoInput ? precoInput.value.trim() : "";
      const descricao = descricaoInput ? descricaoInput.value.trim() : "";

      if (numero === "") {
        isValid = false;
        showQuartoError(numeroInput, "Número obrigatório.");
      } else if (!/^\d+$/.test(numero)) {
        isValid = false;
        showQuartoError(numeroInput, "Apenas números.");
      } else if (numero.length > 10) {
        isValid = false;
        showQuartoError(numeroInput, "Máximo 10 caracteres.");
      }
      if (tipo === "") {
        isValid = false;
        showQuartoError(tipoInput, "Selecione o tipo.");
      }
      if (preco === "") {
        isValid = false;
        showQuartoError(precoInput, "Preço obrigatório.");
      } else {
        const precoNumerico = parseFloat(preco);
        if (isNaN(precoNumerico)) {
          isValid = false;
          showQuartoError(precoInput, "Preço inválido.");
        } else if (precoNumerico < 0) {
          isValid = false;
          showQuartoError(precoInput, "Preço não pode ser negativo.");
        } else if (precoNumerico > 9999.99) {
          isValid = false;
          showQuartoError(precoInput, "Preço muito alto (máx 9999.99).");
        }
      }
      if (descricao === "") {
        isValid = false;
        showQuartoError(descricaoInput, "Descrição obrigatória.");
      }
      if (!isValid) event.preventDefault();
    });
  }

  const formReserva = document.getElementById("form-reserva");
  if (formReserva) {
    const hospedeNomeInput = document.getElementById("hospede_nome");
    const hospedeCpfInput = document.getElementById("hospede_cpf");
    const hospedeEmailInput = document.getElementById("hospede_email");
    const hospedeTelefoneInput = document.getElementById("hospede_telefone");
    const quartoIdInput = document.getElementById("quarto_id");
    const dataCheckinInput = document.getElementById("data_checkin");
    const dataCheckoutInput = document.getElementById("data_checkout");
    const adultosInput = document.getElementById("adultos");
    const criancasInput = document.getElementById("criancas");
    const statusInput = document.getElementById("status");
    const camposReservaValidar = [
      hospedeNomeInput,
      hospedeCpfInput,
      hospedeEmailInput,
      hospedeTelefoneInput,
      quartoIdInput,
      dataCheckinInput,
      dataCheckoutInput,
      adultosInput,
      criancasInput,
      statusInput,
    ];

    hospedeCpfInput?.addEventListener("input", (e) => {
      let v = e.target.value.replace(/\D/g, "");
      v = v
        .replace(/(\d{3})(\d)/, "$1.$2")
        .replace(/(\d{3})(\d)/, "$1.$2")
        .replace(/(\d{3})(\d{1,2})$/, "$1-$2");
      e.target.value = v;
    });
    hospedeTelefoneInput?.addEventListener("input", (e) => {
      let v = e.target.value.replace(/\D/g, "");
      v = v
        .replace(/^(\d{2})(\d)/, "($1) $2")
        .replace(/(\d{5})(\d{4})$/, "$1-$2");
      e.target.value = v;
    });
    hospedeNomeInput?.addEventListener("input", (e) => {
      const regexInvalidos = /[^A-Za-zÀ-ÿ\s]/g;
      e.target.value = e.target.value.replace(regexInvalidos, "");
    });

    function showReservaError(input, message) {
      if (!input) return;
      input.classList.add("is-invalid");
      const feedback = input.parentElement.querySelector(".invalid-feedback");
      if (feedback) {
        feedback.textContent = message;
        feedback.style.display = "block";
      }
    }
    function resetReservaErrors() {
      camposReservaValidar.forEach((input) => {
        if (input) {
          input.classList.remove("is-invalid");
          const feedback =
            input.parentElement.querySelector(".invalid-feedback");
          if (feedback) {
            feedback.style.display = "none";
            if (input.id === "hospede_nome")
              feedback.textContent = "Nome completo é obrigatório.";
            if (input.id === "hospede_cpf")
              feedback.textContent = "CPF é obrigatório.";
            if (input.id === "hospede_email")
              feedback.textContent = "Digite um e-mail válido.";
            if (input.id === "hospede_telefone")
              feedback.textContent = "Telefone é obrigatório.";
            if (input.id === "data_checkout")
              feedback.textContent =
                "Data de Check-out obrigatória e deve ser após o Check-in.";
          }
        }
      });
    }

    function isValidEmailReservaAdmin(email) {
      const re =
        /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(String(email).toLowerCase());
    }

    function validarCPFAdmin(cpfStr) {
      const s = cpfStr.replace(/\D/g, "");
      if (s.length !== 11 || /^(\d)\1+$/.test(s)) return false;
      let soma = 0;
      for (let i = 0; i < 9; i++) soma += parseInt(s[i]) * (10 - i);
      let resto = (soma * 10) % 11;
      if (resto === 10 || resto === 11) resto = 0;
      if (resto !== parseInt(s[9])) return false;
      soma = 0;
      for (let i = 0; i < 10; i++) soma += parseInt(s[i]) * (11 - i);
      resto = (soma * 10) % 11;
      if (resto === 10 || resto === 11) resto = 0;
      return resto === parseInt(s[10]);
    }

    formReserva.addEventListener("submit", function (event) {
      resetReservaErrors();
      let isValid = true;
      const nome = hospedeNomeInput ? hospedeNomeInput.value.trim() : "";
      const cpf = hospedeCpfInput ? hospedeCpfInput.value.trim() : "";
      const email = hospedeEmailInput ? hospedeEmailInput.value.trim() : "";
      const telefone = hospedeTelefoneInput
        ? hospedeTelefoneInput.value.trim()
        : "";
      const quartoId = quartoIdInput ? quartoIdInput.value : "";
      const checkin = dataCheckinInput ? dataCheckinInput.value : "";
      const checkout = dataCheckoutInput ? dataCheckoutInput.value : "";
      const adultos = adultosInput ? adultosInput.value : "";
      const criancas = criancasInput ? criancasInput.value : "";
      const status = statusInput ? statusInput.value : "";

      const somenteLetras = /^[A-Za-zÀ-ÿ\s]+$/;

      if (nome === "") {
        isValid = false;
        showReservaError(hospedeNomeInput, "Nome obrigatório.");
      } else if (nome.length < 2 || !somenteLetras.test(nome)) {
        isValid = false;
        showReservaError(hospedeNomeInput, "Nome inválido (somente letras).");
      }
      if (cpf === "") {
        isValid = false;
        showReservaError(hospedeCpfInput, "CPF obrigatório.");
      } else if (!validarCPFAdmin(cpf)) {
        isValid = false;
        showReservaError(hospedeCpfInput, "CPF inválido.");
      }
      if (email === "") {
        isValid = false;
        showReservaError(hospedeEmailInput, "E-mail obrigatório.");
      } else if (!isValidEmailReservaAdmin(email)) {
        isValid = false;
        showReservaError(hospedeEmailInput, "E-mail inválido.");
      }
      if (telefone.replace(/\D/g, "").length < 10) {
        isValid = false;
        showReservaError(
          hospedeTelefoneInput,
          "Telefone inválido (mín. 10 dígitos)."
        );
      }

      if (quartoId === "") {
        isValid = false;
        showReservaError(quartoIdInput, "Selecione quarto.");
      }
      if (checkin === "") {
        isValid = false;
        showReservaError(dataCheckinInput, "Check-in obrigatório.");
      }
      if (checkout === "") {
        isValid = false;
        showReservaError(dataCheckoutInput, "Check-out obrigatório.");
      }
      if (adultos === "") {
        isValid = false;
        showReservaError(adultosInput, "Selecione adultos.");
      }
      if (criancas === "") {
        isValid = false;
        showReservaError(criancasInput, "Selecione crianças.");
      }
      if (status === "") {
        isValid = false;
        showReservaError(statusInput, "Selecione status.");
      }

      if (checkin !== "" && checkout !== "") {
        const dataCheckinObj = new Date(checkin + "T00:00:00");
        const dataCheckoutObj = new Date(checkout + "T00:00:00");
        if (dataCheckoutObj <= dataCheckinObj) {
          isValid = false;
          showReservaError(
            dataCheckoutInput,
            "Check-out deve ser após Check-in."
          );
        }
      }
      if (!isValid) event.preventDefault();
    });
  }

  const formUsuario = document.getElementById("form-usuario");
  if (formUsuario) {
    const nomeInput = document.getElementById("nome");
    const emailInput = document.getElementById("email");
    const senhaInput = document.getElementById("senha");
    const nivelAcessoInput = document.getElementById("nivel_acesso");
    const isEditForm =
      formUsuario.querySelector('input[name="usuario_id"]') !== null;
    const camposUsuarioValidar = [
      nomeInput,
      emailInput,
      senhaInput,
      nivelAcessoInput,
    ];

    nomeInput?.addEventListener("input", (e) => {
      const regexInvalidos = /[^A-Za-zÀ-ÿ\s]/g;
      e.target.value = e.target.value.replace(regexInvalidos, "");
    });

    function showUsuarioError(input, message) {
      if (!input) return;
      input.classList.add("is-invalid");
      const feedback = input.parentElement.querySelector(".invalid-feedback");
      if (feedback) {
        feedback.textContent = message;
        feedback.style.display = "block";
      }
    }
    function resetUsuarioErrors() {
      camposUsuarioValidar.forEach((input) => {
        if (input) {
          input.classList.remove("is-invalid");
          const feedback =
            input.parentElement.querySelector(".invalid-feedback");
          if (feedback) {
            feedback.style.display = "none";
            if (input.id === "nome")
              feedback.textContent = "Nome completo é obrigatório.";
            if (input.id === "email")
              feedback.textContent = "Digite um e-mail válido.";
            if (input.id === "senha" && isEditForm)
              feedback.textContent = "Nova senha: min 8 caracteres.";
            else if (input.id === "senha" && !isEditForm)
              feedback.textContent = "Senha obrigatória (min 8 caracteres).";
          }
        }
      });
    }
    function isValidEmailUsuario(email) {
      const re =
        /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(String(email).toLowerCase());
    }

    formUsuario.addEventListener("submit", function (event) {
      resetUsuarioErrors();
      let isValid = true;
      const nome = nomeInput ? nomeInput.value.trim() : "";
      const email = emailInput ? emailInput.value.trim() : "";
      const senha = senhaInput ? senhaInput.value : "";
      const nivelAcesso = nivelAcessoInput ? nivelAcessoInput.value : "";

      const somenteLetras = /^[A-Za-zÀ-ÿ\s]+$/;

      if (nome === "") {
        isValid = false;
        showUsuarioError(nomeInput, "Nome obrigatório.");
      } else if (nome.length < 2 || !somenteLetras.test(nome)) {
        isValid = false;
        showUsuarioError(
          nomeInput,
          "Nome inválido (mín. 2 caracteres, só letras)."
        );
      }

      if (email === "") {
        isValid = false;
        showUsuarioError(emailInput, "E-mail obrigatório.");
      } else if (!isValidEmailUsuario(email)) {
        isValid = false;
        showUsuarioError(emailInput, "E-mail inválido.");
      }

      if (!isEditForm) {
        if (senha === "") {
          isValid = false;
          showUsuarioError(senhaInput, "Senha obrigatória.");
        } else if (senha.length < 8) {
          isValid = false;
          showUsuarioError(senhaInput, "Senha: min 8 caracteres.");
        }
      } else {
        if (senha !== "" && senha.length < 8) {
          isValid = false;
          showUsuarioError(senhaInput, "Nova senha: min 8 caracteres.");
        }
      }

      if (nivelAcesso === "") {
        isValid = false;
        showUsuarioError(nivelAcessoInput, "Selecione o nível.");
      }

      if (!isValid) event.preventDefault();
    });
  }

  const modalConfirmacaoOverlay = document.getElementById(
    "modalConfirmacaoOverlay"
  );
  if (modalConfirmacaoOverlay) {
    const modalBox = modalConfirmacaoOverlay.querySelector(".modal-box");
    const modalFecharBtn = document.getElementById("modalFecharBtn");
    const modalCancelarBtn = document.getElementById("modalCancelarBtn");
    const modalConfirmarBtn = document.getElementById("modalConfirmarBtn");
    const infoItemExcluir = document.getElementById("infoItemExcluir");
    const modalMensagem = document.getElementById("modalMensagem");
    const modalTitulo = modalBox
      ? modalBox.querySelector(".modal-header h3")
      : null;

    function mostrarModal() {
      if (modalConfirmacaoOverlay)
        modalConfirmacaoOverlay.classList.add("visivel");
    }
    function esconderModal() {
      if (modalConfirmacaoOverlay)
        modalConfirmacaoOverlay.classList.remove("visivel");
      if (modalConfirmarBtn) modalConfirmarBtn.setAttribute("href", "#");
      if (infoItemExcluir) infoItemExcluir.textContent = "";
    }
    const actionButtons = document.querySelectorAll(
      ".area-tabela a.btn-danger"
    );
    actionButtons.forEach((button) => {
      button.addEventListener("click", function (event) {
        event.preventDefault();
        const actionUrl = this.getAttribute("href");
        const buttonText = this.textContent.trim();
        if (modalTitulo) modalTitulo.textContent = `Confirmar ${buttonText}`;
        if (modalMensagem)
          modalMensagem.textContent = `Tem certeza que deseja ${buttonText.toLowerCase()} este item? Esta ação não pode ser desfeita.`;
        if (modalConfirmarBtn)
          modalConfirmarBtn.textContent = `Confirmar ${buttonText}`;
        try {
          const row = this.closest("tr");
          if (row && row.cells.length > 1) {
            const itemInfo = row.cells[1].textContent;
            if (infoItemExcluir)
              infoItemExcluir.textContent = `Item: ${itemInfo}`;
          } else if (infoItemExcluir) infoItemExcluir.textContent = "";
        } catch (e) {
          console.error("Erro modal info:", e);
          if (infoItemExcluir) infoItemExcluir.textContent = "";
        }
        if (modalConfirmarBtn)
          modalConfirmarBtn.setAttribute("href", actionUrl);
        mostrarModal();
      });
    });
    if (modalFecharBtn) modalFecharBtn.addEventListener("click", esconderModal);
    if (modalCancelarBtn)
      modalCancelarBtn.addEventListener("click", esconderModal);
    modalConfirmacaoOverlay.addEventListener("click", function (event) {
      if (event.target === modalConfirmacaoOverlay) esconderModal();
    });
  }

  const ctxQuartos = document.getElementById("chartQuartos");
  const ctxReservas = document.getElementById("chartReservas");
  const ctxUsuarios = document.getElementById("chartUsuarios");
  if (ctxQuartos || ctxReservas || ctxUsuarios) {
    const corPrimaria = "rgba(193, 155, 112, 0.8)";
    const chartOptions = {
      responsive: true,
      maintainAspectRatio: false,
      cutout: "70%",
      plugins: { legend: { display: false }, tooltip: { enabled: true } },
    };
    if (ctxQuartos) {
      const totalQuartos = parseInt(ctxQuartos.dataset.total) || 0;
      new Chart(ctxQuartos, {
        type: "doughnut",
        data: {
          labels: ["Quartos"],
          datasets: [
            {
              data: [totalQuartos],
              backgroundColor: [corPrimaria],
              borderColor: [corPrimaria],
              borderWidth: 1,
            },
          ],
        },
        options: chartOptions,
      });
    }
    if (ctxReservas) {
      const totalReservas = parseInt(ctxReservas.dataset.total) || 0;
      new Chart(ctxReservas, {
        type: "doughnut",
        data: {
          labels: ["Reservas"],
          datasets: [
            {
              data: [totalReservas],
              backgroundColor: [corPrimaria],
              borderColor: [corPrimaria],
              borderWidth: 1,
            },
          ],
        },
        options: chartOptions,
      });
    }
    if (ctxUsuarios) {
      const totalUsuarios = parseInt(ctxUsuarios.dataset.total) || 0;
      new Chart(ctxUsuarios, {
        type: "doughnut",
        data: {
          labels: ["Usuários"],
          datasets: [
            {
              data: [totalUsuarios],
              backgroundColor: [corPrimaria],
              borderColor: [corPrimaria],
              borderWidth: 1,
            },
          ],
        },
        options: chartOptions,
      });
    }
  }
});

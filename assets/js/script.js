// Validacão de e-mail Newsletter

document.addEventListener("DOMContentLoaded", function () {
  const botao = document.querySelector(".botao-email-footer");
  const inputEmail = document.querySelector("input[name='email']");
  const modalSucesso = document.querySelector(".modal-confirmacao");
  const modalErro = document.querySelector(".modal-erro");
  const closeButtons = document.querySelectorAll(".close-modal");
  const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  function validarEmail(email) {
    return regexEmail.test(email);
  }

  function mostrarModal(modal) {
    modal.style.display = "flex";
  }

  function esconderModal(modal) {
    modal.style.display = "none";
  }

  function limparFormulario() {
    inputEmail.value = "";
  }

  botao.addEventListener("click", function (event) {
    event.preventDefault();

    const email = inputEmail.value.trim();

    if (email === "") {
      console.error("Erro: Campo de e-mail está vazio.");
      mostrarModal(modalErro);
    } else if (!validarEmail(email)) {
      console.error("Erro: Formato de e-mail inválido. Email digitado:", email);
      mostrarModal(modalErro);
    } else {
      console.log("Sucesso: E-mail válido. Inscrição realizada para:", email);
      limparFormulario();
      mostrarModal(modalSucesso);
    }
  });

  // Event listeners para fechar os modais
  closeButtons.forEach((button) => {
    button.addEventListener("click", function () {
      esconderModal(modalSucesso);
      esconderModal(modalErro);
    });
  });

  // Fechar modais ao clicar fora deles
  window.addEventListener("click", function (event) {
    if (event.target === modalSucesso) {
      esconderModal(modalSucesso);
    }
    if (event.target === modalErro) {
      esconderModal(modalErro);
    }
  });

  // Fechar modais com a tecla ESC
  window.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
      esconderModal(modalSucesso);
      esconderModal(modalErro);
    }
  });
});

// Validacão de e-mail Newsletter

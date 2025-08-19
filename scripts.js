// Variáveis

const emailInput = document.getElementById("email-newsletter-validacao");
const formulario = document.getElementById("formulario-newsletter");
const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
const mensagemValidacaoSucesso = document.getElementById(
  "mensagem-validacao-sucesso"
);
const mensagemValidacaoErro = document.getElementById(
  "mensagem-validacao-erro"
);

// Variáveis

formulario.addEventListener("submit", function (event) {
  event.preventDefault(); // Impede o envio do formulário

  const emailValue = emailInput.value;
  console.log("Email enviado: " + emailValue);
  if (regexEmail.test(emailValue)) {
    // Se o email for válido
    mensagemValidacaoSucesso.classList.remove("hidden");
    mensagemValidacaoErro.classList.add("hidden");
    emailInput.value = ""; // Limpa o campo de email
  } else {
    // Se o email for inválido
    mensagemValidacaoErro.classList.remove("hidden");
    mensagemValidacaoSucesso.classList.add("hidden");
  }
});



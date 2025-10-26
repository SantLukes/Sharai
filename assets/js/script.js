document.addEventListener("DOMContentLoaded", function () {
  console.log("[SCRIPT] Iniciado");

  const botaoVerificar = document.getElementById(
    "botao-verificar-disponibilidade"
  );
  const modalErro = document.querySelector(".modal-erro");
  const mensagemErro = modalErro?.querySelector(".mensagem-erro");
  const botaoErroFechar = modalErro?.querySelector(".botao-erro-fechar");
  const modalHospede = document.querySelector(".modal-hospede");
  const formFinalizarReserva = document.querySelector(
    ".formulario-finalizar-reserva"
  );

  let podeMostrarErro = false;

  function esconderErro() {
    if (!modalErro) return;
    modalErro.classList.remove("visivel");
    console.log("[ERRO] Modal escondida");
  }

  function mostrarErro(msg) {
    if (mensagemErro) mensagemErro.textContent = msg || "Ocorreu um erro.";
    modalErro.classList.add("visivel");
    console.log("[ERRO] Modal exibida:", msg);
  }

  botaoErroFechar?.addEventListener("click", () => {
    console.log("[ERRO] Clique no botão OK detectado");
    esconderErro();
  });

  modalErro?.addEventListener("click", (e) => {
    if (e.target === modalErro) {
      console.log("[ERRO] Clique fora da modal detectado");
      esconderErro();
    }
  });

  function mostrarModalHospede() {
    modalHospede?.classList.add("visivel");
  }
  function esconderModalHospede() {
    modalHospede?.classList.remove("visivel");
  }

  modalHospede?.addEventListener("click", (e) => {
    if (e.target === modalHospede) esconderModalHospede();
  });
  modalHospede
    ?.querySelector(".modal-fechar")
    ?.addEventListener("click", esconderModalHospede);
  modalHospede
    ?.querySelector(".modal-cancelar")
    ?.addEventListener("click", esconderModalHospede);

  botaoVerificar?.addEventListener("click", function () {
    podeMostrarErro = true;

    const entrada =
      document.getElementById("reserva-entrada")?.value.trim() || "";
    const saida = document.getElementById("reserva-saida")?.value.trim() || "";
    const quarto =
      document.getElementById("reserva-quarto")?.value.trim() || "";
    const adultos =
      document.getElementById("reserva-adultos")?.value.trim() || "";
    const criancas =
      document.getElementById("reserva-criancas")?.value.trim() || "";

    if (!entrada || !saida || !quarto || !adultos || criancas === "") {
      mostrarErro("Preencha todos os campos antes de continuar!");
      return;
    }

    const checkin = new Date(entrada + "T00:00:00");
    const checkout = new Date(saida + "T00:00:00");
    const hoje = new Date();
    hoje.setHours(0, 0, 0, 0);

    if (checkin < hoje) {
      mostrarErro("A data de entrada não pode ser anterior a hoje!");
      return;
    }
    if (checkout <= checkin) {
      mostrarErro("A data de saída deve ser posterior à data de entrada!");
      return;
    }

    formFinalizarReserva
      ?.querySelector(".campo-finalizar-quarto-id")
      ?.setAttribute("value", quarto);
    formFinalizarReserva
      ?.querySelector(".campo-finalizar-checkin")
      ?.setAttribute("value", entrada);
    formFinalizarReserva
      ?.querySelector(".campo-finalizar-checkout")
      ?.setAttribute("value", saida);
    formFinalizarReserva
      ?.querySelector(".campo-finalizar-adultos")
      ?.setAttribute("value", adultos);
    formFinalizarReserva
      ?.querySelector(".campo-finalizar-criancas")
      ?.setAttribute("value", criancas);

    mostrarModalHospede();
  });

  console.log("[SCRIPT] Listeners registrados");
});

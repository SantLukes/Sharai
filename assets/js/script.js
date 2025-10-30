document.addEventListener("DOMContentLoaded", function () {
  console.log("[SCRIPT] Iniciado");

  if (
    typeof flatpickr !== "undefined" &&
    typeof datasReservadasPorQuarto !== "undefined"
  ) {
    const campoEntrada = document.getElementById("reserva-entrada");
    const campoSaida = document.getElementById("reserva-saida");
    const selectQuarto = document.getElementById("reserva-quarto");

    let instanciaEntrada, instanciaSaida;

    // --------------------- Função que inicializa os calendários ---------------------
    function inicializarCalendarios(datasBloqueadas = []) {
      if (instanciaEntrada) instanciaEntrada.destroy();
      if (instanciaSaida) instanciaSaida.destroy();

      instanciaEntrada = flatpickr(campoEntrada, {
        dateFormat: "Y-m-d",
        locale: "pt",
        disable: datasBloqueadas,
        minDate: "today",
        showMonths: 2,
        onChange: function (datasSelecionadas) {
          if (datasSelecionadas.length > 0) {
            const dataCheckin = datasSelecionadas[0];

            let dataMinimaSaida = new Date(dataCheckin);

            dataMinimaSaida.setDate(dataMinimaSaida.getDate() + 1);

            instanciaSaida.set("minDate", dataMinimaSaida);

            instanciaSaida.open();
          }
        },
      });

      instanciaSaida = flatpickr(campoSaida, {
        dateFormat: "Y-m-d",
        locale: "pt",
        disable: datasBloqueadas,
        minDate: "today",
        showMonths: 2,
      });
    }
    selectQuarto?.addEventListener("change", () => {
      const idQuarto = selectQuarto.value;
      const datasBloqueadas = datasReservadasPorQuarto[idQuarto] || [];
      inicializarCalendarios(datasBloqueadas);
    });

    inicializarCalendarios();
  } else {
    console.warn(
      "[FLATPICKR] Flatpickr ou datasReservadasPorQuarto não encontrados."
    );
  }

  // --------------------- ELEMENTOS PRINCIPAIS ---------------------
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
  const modalSucesso = document.querySelector(".modal-sucesso");
  const botaoSucessoFechar = modalSucesso?.querySelector(
    ".botao-sucesso-fechar"
  );

  // --------------------- FUNÇÕES DE ERRO ---------------------
  function esconderErro() {
    modalErro?.classList.remove("visivel");
  }

  function mostrarErro(msg) {
    if (mensagemErro)
      mensagemErro.textContent = msg || "Ocorreu um erro inesperado.";
    modalErro?.classList.add("visivel");
  }

  botaoErroFechar?.addEventListener("click", esconderErro);
  modalErro?.addEventListener("click", (e) => {
    if (e.target === modalErro) esconderErro();
  });

  // --------------------- MODAL HÓSPEDE ---------------------
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

  // --------------------- MODAL SUCESSO ---------------------
  function mostrarSucesso(msg) {
    modalSucesso?.classList.add("visivel");
    modalSucesso.querySelector(".mensagem-sucesso").textContent =
      msg || "Sua reserva foi realizada com sucesso!";
  }
  function esconderSucesso() {
    modalSucesso?.classList.remove("visivel");
  }
  botaoSucessoFechar?.addEventListener("click", esconderSucesso);
  modalSucesso?.addEventListener("click", (e) => {
    if (e.target === modalSucesso) esconderSucesso();
  });

  // --------------------- VERIFICAÇÃO DA DISPONIBILIDADE ---------------------
  botaoVerificar?.addEventListener("click", function () {
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

    const datasBloqueadasDoQuarto = datasReservadasPorQuarto[quarto] || [];

    if (datasBloqueadasDoQuarto.length > 0) {
      let dataAtual = new Date(checkin);
      let conflitoEncontrado = false;

      while (dataAtual < checkout) {
        const ano = dataAtual.getFullYear();
        const mes = String(dataAtual.getMonth() + 1).padStart(2, "0");
        const dia = String(dataAtual.getDate()).padStart(2, "0");
        const dataString = `${ano}-${mes}-${dia}`;

        if (datasReservadasPorQuarto[quarto].includes(dataString)) {
          conflitoEncontrado = true;
          break;
        }

        dataAtual.setDate(dataAtual.getDate() + 1);
      }

      if (conflitoEncontrado) {
        mostrarErro(
          "Datas indisponíveis! O quarto selecionado já está reservado para o período escolhido. Por favor, ajuste as datas ou escolha outro quarto."
        );
        return;
      }
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

  // --------------------- VALIDAÇÃO MODAL HÓSPEDE ---------------------
  if (formFinalizarReserva) {
    const nome = formFinalizarReserva.querySelector(".campo-finalizar-nome");
    const cpf = formFinalizarReserva.querySelector(".campo-finalizar-cpf");
    const email = formFinalizarReserva.querySelector(".campo-finalizar-email");
    const telefone = formFinalizarReserva.querySelector(
      ".campo-finalizar-telefone"
    );
    const botaoConfirmar =
      formFinalizarReserva.querySelector(".botao-confirmar");

    const tocados = new Set();
    let envioTentado = false;

    cpf.addEventListener("input", (e) => {
      let v = e.target.value.replace(/\D/g, "");
      v = v
        .replace(/(\d{3})(\d)/, "$1.$2")
        .replace(/(\d{3})(\d)/, "$1.$2")
        .replace(/(\d{3})(\d{1,2})$/, "$1-$2");
      e.target.value = v;
      validarCampos();
    });
    telefone.addEventListener("input", (e) => {
      let v = e.target.value.replace(/\D/g, "");
      v = v
        .replace(/^(\d{2})(\d)/, "($1) $2")
        .replace(/(\d{5})(\d{4})$/, "$1-$2");
      e.target.value = v;
      validarCampos();
    });
    nome.addEventListener("input", (e) => {
  
      const regexInvalidos = /[^A-Za-zÀ-ÿ\s]/g;

      e.target.value = e.target.value.replace(regexInvalidos, ""); 
      
      validarCampos();
    });
    email.addEventListener("input", validarCampos);

    [nome, cpf, email, telefone].forEach((el) => {
      el.addEventListener("blur", () => {
        tocados.add(el);
        validarCampos(true);
      });
    });

    function validarCampos(mostrarErros = false) {
      const vNome = nome.value.trim();
      const vCPF = cpf.value.trim();
      const vEmail = email.value.trim();
      const vTel = telefone.value.trim();

      const somenteLetras = /^[A-Za-zÀ-ÿ\s]+$/;
      const emailValido = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

      const nomeOk = vNome.length >= 2 && somenteLetras.test(vNome);
      const cpfOk = validarCPF(vCPF);
      const emailOk = emailValido.test(vEmail);
      const telOk = vTel.replace(/\D/g, "").length >= 10;

      const deveExibir = (el, ok) => {
        if ((tocados.has(el) || envioTentado) && !ok) el.classList.add("erro");
        else el.classList.remove("erro");
      };

      deveExibir(nome, nomeOk);
      deveExibir(cpf, cpfOk);
      deveExibir(email, emailOk);
      deveExibir(telefone, telOk);

      const valido = nomeOk && cpfOk && emailOk && telOk;
      botaoConfirmar.disabled = !valido;
      botaoConfirmar.style.opacity = valido ? "1" : "0.6";
      botaoConfirmar.style.cursor = valido ? "pointer" : "not-allowed";

      return valido;
    }

    function validarCPF(cpfStr) {
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

    botaoConfirmar.disabled = true;
    botaoConfirmar.style.opacity = "0.6";
    botaoConfirmar.style.cursor = "not-allowed";

    formFinalizarReserva.addEventListener("submit", function (event) {
      event.preventDefault();
      envioTentado = true;

      if (!validarCampos(true)) return;

      console.log("[VALIDAÇÃO] Tudo certo! Exibindo sucesso...");
      esconderModalHospede();
      mostrarSucesso("Sua reserva foi confirmada com sucesso!");

      setTimeout(() => {
        formFinalizarReserva.submit();
      }, 2000);
    });
  }

  console.log("[SCRIPT] Listeners registrados");
});

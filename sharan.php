<?php
include_once 'includes/conexao.php';
$quartos_para_reserva = [];
if (isset($conn) && $conn) {
  $sql_quartos_res = "SELECT id, numero, tipo FROM quartos WHERE ativo = 1 ORDER BY numero ASC";
  $resultado_quartos_res = $conn->query($sql_quartos_res);
  if ($resultado_quartos_res && $resultado_quartos_res->num_rows > 0) {
    while ($quarto_res = $resultado_quartos_res->fetch_assoc()) {
      $quartos_para_reserva[] = $quarto_res;
    }
  }
  $conn->close();
} else {
  error_log("Erro de conexão no sharan.php ao buscar quartos.");
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Página Principal-Sharai</title>
  <link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap"
    rel="stylesheet" />

  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
    integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer" />
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
    crossorigin="anonymous" />
  <link rel="stylesheet" href="assets/styles/style.css" />
</head>

<body>
  <div class="header">
    <div class="container-header">
      <div class="navbar">
        <img
          src="assets/Imagem/sharai-logo.png"
          alt="logo sharai"
          class="logo-sharan" />
        <ul class="nav-menu">
          <li><a href="sharan.php" class="menu-home">HOME</a></li>
          <li><a href="#">POST DETAIL</a></li>
          <li><a href="#">PAGES</a></li>
          <li><a href="#">PROJECTS</a></li>
          <li><a href="admin/quartos.php">SHORTCODES</a></li>
        </ul>
      </div>
    </div>
  </div>
  <main>
    <div>
      <form action="#" method="POST" class="select-sharan formulario-busca-reserva">
        <p class="reserva">Reserva</p>
        <div class="entrada-saida">
          <p class="text-checkbox">Entrada/Saída</p>
          <div class="input-entrada-saida">
            <input type="date" id="reserva-entrada" name="entrada" placeholder="Data de Entrada" />
            <input type="date" id="reserva-saida" name="saida" placeholder="Data de Saída" />
          </div>
          <div class="error-message" id="error-data"></div>
        </div>

        <div class="quarto">
          <p class="text-checkbox">Quarto</p>
          <div class="select-quarto">
            <select id="reserva-quarto" name="quarto_id">
              <option value="">Selecione o Quarto</option>
              <?php
              if (!empty($quartos_para_reserva)) {
                foreach ($quartos_para_reserva as $quarto_res) {
                  $texto_opcao_res = $quarto_res['numero'] . ' - ' . $quarto_res['tipo'];
                  echo '<option value="' . $quarto_res['id'] . '">' . htmlspecialchars($texto_opcao_res) . '</option>';
                }
              } else {
                echo '<option value="" disabled>Nenhum quarto disponível.</option>';
              }
              ?>
            </select>
          </div>
          <div class="error-message" id="error-quarto"></div>
        </div>

        <div class="adulto">
          <p class="text-checkbox">Adulto</p>
          <div class="select-adulto">
            <select id="reserva-adultos" name="adultos">
              <option value="">Selecione</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
            </select>
          </div>
          <div class="error-message" id="error-adultos"></div>
        </div>
        <div class="crianca">
          <p class="text-checkbox">Criança</p>
          <div class="select-crianca">
            <select id="reserva-criancas" name="criancas">
              <option value="">Selecione</option>
              <option value="0">0</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
            </select>
          </div>
          <div class="error-message" id="error-criancas"></div>
        </div>
        <button type="button" class="botao-enviar" id="botao-verificar-disponibilidade">ENVIAR</button>
      </form>
    </div>

    <div class="sobre">
      <div class="container-sobre">
        <div class="texto-sobre">
          <h1>SOBRE</h1>
          <h2>Sobre</h2>
          <div class="linha-decorativa"></div>
          <p class="p1-destaque">
            We will be so proud to be our guest.Lorem Ipsum is simply<br />
            dummy text of the printing.
          </p>
          <p class="p2-texto">
            Lorem Ipsum is simply dummy text of the printing and typesetting
            industry. Lorem Ipsum<br />
            has been the typesetting industry's standard dummy text ever since
            the when.Lorem<br />
            Ipsum is simply dummy text of the printing and typesetting
            industry.
          </p>
        </div>
        <div class="container-icones">
          <div class="icones">
            <img src="assets/Imagem/restaurante.png" />
            <div class="icones-texto">
              <h4>Restaurante</h4>
              <p>Lorem ipsum dolor sit<br />piscing sed nonmy</p>
            </div>
          </div>
          <div class="icones">
            <img src="assets/Imagem/spa.png" />
            <div class="icones-texto">
              <h4>Wellness & Spa</h4>
              <p>Lorem ipsum dolor sit<br />piscing sed nonmy</p>
            </div>
          </div>
        </div>
        <div class="container-icones">
          <div class="icones">
            <img src="assets/Imagem/wifi.png" />
            <div class="icones-texto">
              <h4>Free Wifi</h4>
              <p>Lorem ipsum dolor sit<br />piscing sed nonmy</p>
            </div>
          </div>
          <div class="icones">
            <img src="assets/Imagem/jogos.png" />
            <div class="icones-texto">
              <h4>Espaco de jogos</h4>
              <p>Lorem ipsum dolor sit<br />piscing sed nonmy</p>
            </div>
          </div>
        </div>
        <div><button class="botao-about">SAIBA MAIS</button></div>
      </div>
      <div>
        <div><img src="assets/Imagem/backabout.png" class="img-backabout" /></div>
      </div>
    </div>
    <div class="acomodacoes">
      <div class="acomodacoes-texto">
        <h1>ACOMODAÇÕES</h1>
        <h2>Acomodações</h2>
        <div class="acomodacoes-linha"></div>
        <ul>
          <li class="texto-todos">TODOS</li>
          <li class="acomodacoes-separacao">/</li>
          <li class="acomodacoes-lista">CASAL</li>
          <li class="acomodacoes-separacao">/</li>
          <li class="acomodacoes-lista">SOLTEIRO</li>
          <li class="acomodacoes-separacao">/</li>
          <li class="acomodacoes-lista">SUÍTE</li>
        </ul>
      </div>
      <div class="container-option">
        <div class="acomodacoes-option">
          <div class="container-imagem-option">
            <img src="assets/Imagem/casal01.png" />
          </div>
          <div>
            <p class="option-preco">R$ 299,00/NOITE</p>
          </div>
          <div class="option-rodape">
            <div class="option-detalhes">
              <p><img src="assets/Imagem/Icon-tamanho.png" /> tamanho 30m²</p>
              <p><img src="assets/Imagem/icon-adultos.png" /> Adultos: 3</p>
            </div>
            <button class="option-botao">SAIBA MAIS</button>
          </div>
        </div>
        <div class="acomodacoes-option">
          <div class="container-imagem-option">
            <img src="assets/Imagem/solteiro1.png" />
          </div>
          <div>
            <p class="option-preco">R$ 199,00/NOITE</p>
          </div>
          <div class="option-rodape">
            <div class="option-detalhes">
              <p><img src="assets/Imagem/Icon-tamanho.png" /> tamanho 30m²</p>
              <p><img src="assets/Imagem/icon-adultos.png" /> Adultos: 3</p>
            </div>
            <button class="option-botao">SAIBA MAIS</button>
          </div>
        </div>
        <div class="acomodacoes-option">
          <div class="container-imagem-option">
            <img src="assets/Imagem/casal02.png" />
          </div>
          <div>
            <p class="option-preco">R$ 299,00/NOITE</p>
          </div>
          <div class="option-rodape">
            <div class="option-detalhes">
              <p><img src="assets/Imagem/Icon-tamanho.png" /> tamanho 30m²</p>
              <p><img src="assets/Imagem/icon-adultos.png" /> Adultos: 3</p>
            </div>
            <button class="option-botao">SAIBA MAIS</button>
          </div>
        </div>
      </div>
    </div>
  </main>
  <footer>
    <div class="footer">
      <div class="container-footer">
        <div class="footer-initial-text">
          <h4>NEWSLETTER</h4>
          <p>Never Miss Anything From Construx By Signing Up To Our Newsletter.</p>
        </div>
        <div>
          <form class="input-footer" id="newsletter-form">
            <input type="email" name="email" placeholder="DIGITE SEU EMAIL" />
            <div><button type="submit" class="botao-email-footer">ENVIAR</button></div>
          </form>
        </div>

      </div>
      <div class="barra-central-footer"></div>
      <div class="container-desc-footer">
        <div class="desc-footer">
          <img src="assets/Imagem/logo-footer.png" class="logo-footer" />
          <p>Today we can tell you, thanks to your <br /> passion, hard work creativity, and <br /> expertise, you delivered us the most <br /> beautiful house great looks.</p>
          <div class="footer-icons">
            <a href="#"><img src="assets/Imagem/facebook-icon.png" alt="Facebook" /></a>
            <a href="#"><img src="assets/Imagem/wifi-icon.png" alt="RSS" /></a>
            <a href="#"><img src="assets/Imagem/linkedin-icon.png" alt="LinkedIn" /></a>
            <a href="#"><img src="assets/Imagem/google-icon.png" alt="Google" /></a>
            <a href="#"><img src="assets/Imagem/instagram-icon.png" alt="Instagram" /></a>
          </div>
        </div>
        <div class="desc-footer-links">
          <h4>LINKS</h4>
          <ul>
            <li><a href="#">ABOUT</a></li>
            <li><a href="#">GALLERY</a></li>
            <li><a href="#">BLOG</a></li>
            <li><a href="#">PORTFOLIO</a></li>
            <li><a href="#">CONTACT US</a></li>
            <li><a href="#">FAQ</a></li>
          </ul>
        </div>
        <div class="desc-footer-acomodacoes">
          <h4>ACOMODAÇÕES</h4>
          <ul>
            <li><a href="#">CLASSIC</a></li>
            <li><a href="#">SUPERIOR</a></li>
            <li><a href="#">DELUX</a></li>
            <li><a href="#">MASTER</a></li>
            <li><a href="#">LUXURY</a></li>
            <li><a href="#">BANQUET HALLS</a></li>
          </ul>
        </div>
        <div class="desc-footer-faleconosco">
          <h4>FALE CONOSCO</h4>
          <ul>
            <li><img src="assets/Imagem/endereco-icon.png" alt="adress" class="desc-footer-faleconosco-icons" />92 Princess Road,parkvenue, Greater<br /> London NW18JR, United Kingdom</li>
            <li><img src="assets/Imagem/email-icon.png" alt="mail" class="desc-footer-faleconosco-icons" />sharandemo@gmail.com</li>
            <li><img src="assets/Imagem/telefone-icon.png" alt="phone" class="desc-footer-faleconosco-icons" />(+0091) 912-3456-073</li>
            <li><img src="assets/Imagem/impress-icon.png" alt="impress" class="desc-footer-faleconosco-icons" /> (+0091) 912-3456-084</li>
          </ul>
        </div>
      </div>
      <div class="footer-end">
        <p>© 2024 Your Company. Designed By Teste.</p>
      </div>
    </div>
  </footer>

  <div class="modal-sobreposicao modal-hospede">
    <div class="modal-caixa">
      <div class="modal-cabecalho">
        <h3>Detalhes do Hóspede</h3>
        <button class="modal-botao-fechar modal-fechar">&times;</button>
      </div>
      <div class="modal-corpo">
        <form class="formulario-finalizar-reserva" action="actions/processa-reserva-cliente.php" method="POST" novalidate>
          <input type="hidden" class="campo-finalizar-quarto-id" name="quarto_id">
          <input type="hidden" class="campo-finalizar-checkin" name="data_checkin">
          <input type="hidden" class="campo-finalizar-checkout" name="data_checkout">
          <input type="hidden" class="campo-finalizar-adultos" name="adultos">
          <input type="hidden" class="campo-finalizar-criancas" name="criancas">

          <div class="grupo-formulario">
            <label for="campo-nome-finalizar">Nome Completo</label>
            <input type="text" id="campo-nome-finalizar" class="campo-formulario campo-finalizar-nome" name="hospede_nome" maxlength="80" autocomplete="off">
            <span class="mensagem-erro">Nome obrigatório (somente letras).</span>
          </div>

          <div class="grupo-formulario">
            <label for="campo-cpf-finalizar">CPF</label>
            <input type="text" id="campo-cpf-finalizar" class="campo-formulario campo-finalizar-cpf" name="hospede_cpf" maxlength="14" autocomplete="off">
            <span class="mensagem-erro">CPF inválido.</span>
          </div>

          <div class="grupo-formulario">
            <label for="campo-email-finalizar">E-mail</label>
            <input type="email" id="campo-email-finalizar" class="campo-formulario campo-finalizar-email" name="hospede_email" maxlength="100" autocomplete="off">
            <span class="mensagem-erro">Digite um e-mail válido.</span>
          </div>

          <div class="grupo-formulario">
            <label for="campo-telefone-finalizar">Telefone</label>
            <input type="tel" id="campo-telefone-finalizar" class="campo-formulario campo-finalizar-telefone" name="hospede_telefone" maxlength="15" autocomplete="off">
            <span class="mensagem-erro">Telefone inválido.</span>
          </div>

          <div class="modal-rodape">
            <button type="button" class="botao-cancelar modal-cancelar">Cancelar</button>
            <button type="submit" class="botao-confirmar modal-confirmar">Confirmar Reserva</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal-sobreposicao modal-erro">
    <div class="modal-caixa-erro">
      <h3>⚠️ Atenção</h3>
      <p class="mensagem-erro">Preencha todos os campos antes de continuar!</p>
      <button class="botao-erro-fechar">OK</button>
    </div>
  </div>
  <div class="modal-sucesso">
    <div class="modal-caixa-sucesso">
      <div class="icone-check">
        <svg viewBox="0 0 52 52">
          <circle class="check-circulo" cx="26" cy="26" r="25" fill="none" />
          <path class="check-marca" fill="none" d="M14 27l7 7 17-17" />
        </svg>
      </div>
      <h3>Reserva Confirmada!</h3>
      <p class="mensagem-sucesso">Sua reserva foi realizada com sucesso 🎉</p>
      <button class="botao-sucesso-fechar">OK</button>
    </div>
  </div>
  <script src="assets/js/script.js?v=20251027"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
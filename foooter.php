<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="./styles/style.css">
<script src="script.js" defer></script>
<body>

    <footer>
        <div class="footer">
            <div class="container-footer">
                <div class="footer-initial-text">
                    <h4>NEWSLETTER</h4>
                    <p>
                        Never Miss Anything From Construx By Signing Up To Our Newsletter.
                    </p>
                </div>
                <div>
                    <form
                        action="processa_newsletter.php"
                        method="POST"
                        class="input-footer">
                        <input type="email" name="email" placeholder="DIGITE SEU EMAIL" />
                        <div><button class="botao-email-footer">ENVIAR</button></div>
                    </form>
                </div>

                <div class="modal-confirmacao">
                    <div class="modal-content">
                        <div class="modal-header-sucesso">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <h3 class="modal-content">Inscrição realizada com sucesso!</h3>
                        <p>Você foi cadastrado na nossa newsletter.</p>

                        <button class="close-modal" type="button" data-modal="modal-1">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>

                <div class="modal-erro">
                    <div class="modal-content">
                        <div class="modal-header-erro">
                            <i class="fa-solid fa-circle-xmark"></i>
                        </div>

                        <h3 class="modal-content">Ooops!</h3>
                        <p>Email inválido. Tente novamente.</p>

                        <button class="close-modal" type="button" data-modal="modal-1">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="barra-central-footer"></div>
            <div class="container-desc-footer">
                <div class="desc-footer">
                    <img src="./Imagem/logo-footer.png" class="logo-footer" />
                    <p>
                        Today we can tell you, thanks to your <br />
                        passion, hard work creativity, and <br />
                        expertise, you delivered us the most <br />
                        beautiful house great looks.
                    </p>
                    <div class="footer-icons">
                        <a href="#"><img src="./Imagem/facebook-icon.png" alt="Facebook" /></a>
                        <a href="#"><img src="./Imagem/wifi-icon.png" alt="RSS" /></a>
                        <a href="#"><img src="./Imagem/linkedin-icon.png" alt="LinkedIn" /></a>
                        <a href="#"><img src="./Imagem/google-icon.png" alt="Google" /></a>
                        <a href="#"><img src="./Imagem/instagram-icon.png" alt="Instagram" /></a>
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
                        <li>
                            <img
                                src="./Imagem/endereco-icon.png"
                                alt="adress"
                                class="desc-footer-faleconosco-icons" />
                            92 Princess Road,parkvenue, Greater<br />
                            London NW18JR, United Kingdom
                        </li>
                        <li>
                            <img
                                src="./Imagem/email-icon.png"
                                alt="mail"
                                class="desc-footer-faleconosco-icons" />
                            sharandemo@gmail.com
                        </li>
                        <li>
                            <img
                                src="./Imagem/telefone-icon.png"
                                alt="phone"
                                class="desc-footer-faleconosco-icons" />
                            (+0091) 912-3456-073
                        </li>
                        <li>
                            <img
                                src="./Imagem/impress-icon.png"
                                alt="impress"
                                class="desc-footer-faleconosco-icons" />
                            (+0091) 912-3456-084
                        </li>
                    </ul>
                </div>
            </div>

            <div class="footer-end">
                <p>© 2024 Your Company. Designed By Teste.</p>
            </div>
        </div>
    </footer>


</body>

</html>
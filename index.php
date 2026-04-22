<?php
session_start();

require "conexao.php";
// 🔒 proteção de login
if (!isset($_SESSION["logado"])) {
    header("Location: login.php");
    exit;
}

$usuario = $_SESSION["usuario"];

// 🍽️ CARDÁPIO
// $cardapio = [
//     ["nome" => "Espresso Tradicional", "descricao" => "Café intenso e aromático.", "preco" => "R$ 7,00", "icone" => "", "imagem" => "img/1.jpg"],
//     ["nome" => "Cappuccino Cremoso", "descricao" => "Espresso + leite + espuma.", "preco" => "R$ 12,00", "icone" => "", "imagem" => "img/2.jpg"],
//     ["nome" => "Mocha Especial", "descricao" => "Café com chocolate e chantilly.", "preco" => "R$ 15,00", "icone" => "", "imagem" => "img/3.jpg"],
//     ["nome" => "Croissant Artesanal", "descricao" => "Massa leve e amanteigada.", "preco" => "R$ 11,00", "icone" => "", "imagem" => "img/4.jpg"],
//     ["nome" => "Fatia de Bolo", "descricao" => "Sabores variados do dia.", "preco" => "R$ 13,00", "icone" => "", "imagem" => "img/5.jpg"],
//     ["nome" => "Brownie de Chocolate", "descricao" => "Textura macia com cobertura crocante.", "preco" => "R$ 11,00", "icone" => "", "imagem" => "img/6.jpg"],
//     ["nome" => "Sanduíche Natural", "descricao" => "Pão integral com pasta leve e folhas frescas.", "preco" => "R$ 14,00", "icone" => "", "imagem" => "img/4.jpg"],
//     ["nome" => "Suco Tropical", "descricao" => "Coquetel de frutas frescas com toque cítrico.", "preco" => "R$ 9,00", "icone" => "", "imagem" => "img/5.jpg"],
// ];

$sql = "SELECT * FROM produtos";
$stmt = $conn->query($sql);
$cardapio = $stmt->fetch_all(MYSQLI_ASSOC);



// 🕒 HORÁRIOS
$horarios = [
    "Segunda a Sexta" => "08:00 - 20:00",
    "Sábado" => "09:00 - 22:00",
    "Domingo" => "09:00 - 18:00"
];

// 📩 CONTATO
$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $assunto = trim($_POST["assunto"] ?? "");
    $texto = trim($_POST["mensagem"] ?? "");

    if ($nome && $email && $assunto && $texto) {
        $mensagem = "Obrigado <b>$nome</b>! Mensagem enviada com sucesso ☕";
    } else {
        $mensagem = "Preencha todos os campos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles.css/styles.css">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css" />
    
    <title>☕ Lumora Café</title>
</head>

<body>

    <!-- ================= HEADER ================= -->
    <header class="topo">
        <div class="container navbar">

            <a href="#inicio" class="logo">
                ☕ Lumora Café
            </a>

            <nav>
                <ul class="menu">
                    <li><a href="#inicio">Início</a></li>
                    <li><a href="#sobre">Sobre</a></li>
                    <li><a href="#cardapio">Cardápio</a></li>
                    <li><a href="#contato">Contato</a></li>
                </ul>
            </nav>
      

            <div>
                👤 <?= htmlspecialchars($usuario) ?>
                <a href="logout.php" class="btn-logout">Sair</a>
            </div>

        </div>
    </header>

    <!-- ================= BEM-VINDO ================= -->
    <section id="inicio" class="welcome">
        <div class="welcome-box">
            <h2>Bem-vindo ao <span>Lumora Café</span></h2>
            <p>Sabores especiais, ambiente acolhedor e café preparado na medida certa para o seu dia.</p>
            <a href="#cardapio" class="btn-welcome">Ver Cardápio</a>
        </div>
    </section>

    <section id="destaques">
        <div class="grid">
            <div class="card">
                <h3>☕ Café do Dia</h3>
                <p>Prove a seleção especial do barista, feita para surpreender seu paladar.</p>
            </div>
            <div class="card">
                <h3>🥐 Pão de Queijo Quentinho</h3>
                <p>Acompanhamento perfeito: crocante por fora e macio por dentro.</p>
            </div>
            <div class="card">
                <h3>🍫 Chocolate Artesanal</h3>
                <p>Essa é a combinação ideal de sabor e conforto para sua pausa.</p>
            </div>
        </div>
    </section>

    <!-- ================= HERO ================= -->


    <!-- ================= SOBRE ================= -->
    <section class="sobre" id="sobre">
        <div class="container sobre-grid">
            <div class="sobre-card">
                <h3>História com sabor</h3>
                <p>Desde a primeira xícara, nossa cafeteria serve receitas caseiras com ingredientes selecionados e um toque artesanal.</p>
            </div>
            <div class="sobre-card">
                <h3>Feito para você</h3>
                <p>Cada bebida e sobremesa é preparada para combinar calor, cremosidade e aquele aroma especial que conquista clientes.</p>
            </div>
            <div class="sobre-card">
                <h3>Ambiente acolhedor</h3>
                <p>Um espaço confortável para trabalhar, conversar ou relaxar enquanto aproveita nosso cardápio de sabores brasileiros.</p>
            </div>
        </div>
    </section>


    <!-- ================= CARDÁPIO ================= -->
    <section id="cardapio">
        <h2>Veja Nosso Cardápio</h2>

        <div class="grid">
            <?php foreach ($cardapio as $item): ?>
                <div class="card">
                
                    <img class="img-cafe" src="<?= $item['imagem'] ?>">
                    <h3><?= $item['icone'] ?> <?= $item['nome'] ?></h3>
                    <p><?= $item['descricao'] ?></p>
                    <b><?= $item['preco'] ?></b>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- ================= HORÁRIOS ================= -->
    <section class="horarios">
        <div class="container horarios-box">
            <h2>🕒 Horários</h2>

            <?php foreach ($horarios as $dia => $hora): ?>
                <div class="linha-horario">
                    <strong><?= $dia ?>:</strong>
                    <span><?= $hora ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- ================= CONTATO ================= -->
    <section id="contato" class="contato">
        <div class="container contato-grid">
            <div class="contato-info">
                <h2>📩 Contato</h2>
                <p>Fale conosco para fazer seu pedido ou tirar dúvidas. Estamos prontos para atender você!</p>

                <ul class="lista-contato">
                    <li><strong>Endereço:</strong> Rua do Café, 123</li>
                    <li><strong>Telefone:</strong> (11) 2345-6789</li>
                    <li><strong>Email:</strong> contato@lumoracafe.com</li>
                </ul>

                <?php if ($mensagem): ?>
                    <div class="alerta"><?= $mensagem ?></div>
                <?php endif; ?>
            </div>

            <div class="form-box">
                <form method="POST">
                    <div class="campo">
                        <input name="nome" placeholder="Nome" required>
                    </div>
                    <div class="campo">
                        <input name="email" placeholder="Email" type="email" required>
                    </div>
                    <div class="campo">
                        <input name="assunto" placeholder="Assunto" required>
                    </div>
                    <div class="campo">
                        <textarea name="mensagem" placeholder="Mensagem" rows="6" required></textarea>
                    </div>
                    <button type="submit">Enviar</button>
                </form>
            </div>
        </div>
    </section>

    <!-- ================= DEPOIMENTOS ================= -->
    <section class="depoimentos">
        <div class="container">
            <div class="secao-titulo">
                <h2>Depoimentos</h2>
                <p>Veja o que nossos clientes dizem sobre a experiência na Lumora Café.</p>
            </div>

            <div class="swiper">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    <div class="swiper-slide">
                        <div class="depoimento-card">
                            <div class="cliente-topo">
                                <div class="cliente-foto">A</div>
                                <div>
                                    <h3>Ana Silva</h3>
                                    <p>Cliente fiel</p>
                                </div>
                            </div>
                            <div class="estrelas">★★★★★</div>
                            <p class="texto-depoimento">“Melhor café da cidade. O ambiente é aconchegante e o atendimento impecável.”</p>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="depoimento-card">
                            <div class="cliente-topo">
                                <div class="cliente-foto">A</div>
                                <div>
                                    <h3>Ana Silva</h3>
                                    <p>Cliente fiel</p>
                                </div>
                            </div>
                            <div class="estrelas">★★★★★</div>
                            <p class="texto-depoimento">“Melhor café da cidade. O ambiente é aconchegante e o atendimento impecável.”</p>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="depoimento-card">
                            <div class="cliente-topo">
                                <div class="cliente-foto">A</div>
                                <div>
                                    <h3>Ana Silva</h3>
                                    <p>Cliente fiel</p>
                                </div>
                            </div>
                            <div class="estrelas">★★★★★</div>
                            <p class="texto-depoimento">“Melhor café da cidade. O ambiente é aconchegante e o atendimento impecável.”</p>
                        </div>
                    </div>
                
                    <div class="swiper-slide">
                        <div class="depoimento-card">
                            <div class="cliente-topo">
                                <div class="cliente-foto">A</div>
                                <div>
                                    <h3>Ana Silva</h3>
                                    <p>Cliente fiel</p>
                                </div>
                            </div>
                            <div class="estrelas">★★★★★</div>
                            <p class="texto-depoimento">“Melhor café da cidade. O ambiente é aconchegante e o atendimento impecável.”</p>
                        </div>
                    </div>
                
                    <div class="swiper-slide">
                        <div class="depoimento-card">
                            <div class="cliente-topo">
                                <div class="cliente-foto">A</div>
                                <div>
                                    <h3>Ana Silva</h3>
                                    <p>Cliente fiel</p>
                                </div>
                            </div>
                            <div class="estrelas">★★★★★</div>
                            <p class="texto-depoimento">“Melhor café da cidade. O ambiente é aconchegante e o atendimento impecável.”</p>
                        </div>
                    </div>
                
                    <div class="swiper-slide">
                        <div class="depoimento-card">
                            <div class="cliente-topo">
                                <div class="cliente-foto">A</div>
                                <div>
                                    <h3>Ana Silva</h3>
                                    <p>Cliente fiel</p>
                                </div>
                            </div>
                            <div class="estrelas">★★★★★</div>
                            <p class="texto-depoimento">“Melhor café da cidade. O ambiente é aconchegante e o atendimento impecável.”</p>
                        </div>
                    </div>
                
                    
                </div>
                <!-- If we need pagination -->
                <div class="swiper-pagination"></div>

                <!-- If we need navigation buttons -->
                <div class="buttons-swipper">
                    <div class="swiper-button-prev"><</div>
                    <div class="swiper-button-next">></div>
                </div>

                <!-- If we need scrollbar -->

    </section>

    <!-- ================= FOOTER ================= -->
<style>
.footer {
    background-color: #2B1D1A;
    color: #F5E6D8;
    margin-top: 60px;
    font-family: 'Segoe UI', sans-serif;
}

.footer-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    padding: 50px;
    gap: 30px;
}

/* TITULOS */
.footer-col h2,
.footer-col h3 {
    color: #B08968;
    margin-bottom: 10px;
}

/* TEXTO */
.footer-col p {
    font-size: 14px;
    line-height: 1.6;
}

/* LINKS */
.footer-col a {
    display: block;
    text-decoration: none;
    color: #F5E6D8;
    margin: 6px 0;
    transition: 0.3s;
}

.footer-col a:hover {
    color: #B08968;
    padding-left: 5px;
}

/* REDES */
.social a {
    display: inline-block;
    margin-right: 10px;
    background: #4E342E;
    padding: 7px 12px;
    border-radius: 6px;
    transition: 0.3s;
}

.social a:hover {
    background: #B08968;
    color: #2B1D1A;
}

/* FINAL */
.footer-bottom {
    text-align: center;
    padding: 18px;
    background: #1F1412;
    font-size: 13px;
}
</style>

<footer class="footer">
    <div class="footer-container">

        <div class="footer-col">
            <h2>Lumora Café ☕</h2>
            <p>Um espaço aconchegante para quem ama café de verdade.</p>
        </div>

        <div class="footer-col">
            <h3>Navegação</h3>
            <a href="#">Início</a>
            <a href="#">Cardápio</a>
            <a href="#">Sobre</a>
            <a href="#">Contato</a>
        </div>

        <div class="footer-col">
            <h3>Contato</h3>
            <p>Email: carlensromelus120@gmail.com</p>
            <p>Telefone: (11) 99999-9999</p>
        </div>

        <div class="footer-col">
            <h3>Redes</h3>
            <div class="social">
                <a href="#">Instagram</a>
                <a href="#">Facebook</a>
                <a href="#">WhatsApp</a>
            </div>
        </div>

    </div>

    <div class="footer-bottom">
        <p>© 2026 Lumora Café</p>
    </div>
</footer>

    <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
    <script src="./script.js"></script>
</body>

</html>
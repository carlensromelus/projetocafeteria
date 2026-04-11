
<?php
$cardapio = [
    [
        "nome" => "Espresso Tradicional",
        "descricao" => "Café intenso e aromático, extraído na medida certa.",
        "preco" => "R$ 7,00",
        "icone" => "☕"
    ],
    [
        "nome" => "Cappuccino Cremoso",
        "descricao" => "Mistura perfeita de espresso, leite vaporizado e espuma.",
        "preco" => "R$ 12,00",
        "icone" => "🥛"
    ],
    [
        "nome" => "Mocha Especial",
        "descricao" => "Café com chocolate, leite e um toque irresistível de chantilly.",
        "preco" => "R$ 15,00",
        "icone" => "🍫"
    ],
    [
        "nome" => "Croissant Artesanal",
        "descricao" => "Massa leve e amanteigada, ideal para acompanhar seu café.",
        "preco" => "R$ 11,00",
        "icone" => "🥐"
    ],
    [
        "nome" => "Fatia de Bolo do Dia",
        "descricao" => "Sabores variados preparados fresquinhos todos os dias.",
        "preco" => "R$ 13,00",
        "icone" => "🍰"
    ],
    [
        "nome" => "Pão de Queijo Gourmet",
        "descricao" => "Casquinha crocante por fora e macio por dentro.",
        "preco" => "R$ 9,00",
        "icone" => "🧀"
    ]
];
$horarios = [
    "Segunda a Sexta" => "08:00 - 20:00",
    "Sábado" => "09:00 - 22:00",
    "Domingo" => "09:00 - 18:00"
];

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = htmlspecialchars(trim($_POST["nome"] ?? ""));
    $email = htmlspecialchars(trim($_POST["email"] ?? ""));
    $assunto = htmlspecialchars(trim($_POST["assunto"] ?? ""));
    $texto = htmlspecialchars(trim($_POST["mensagem"] ?? ""));

    if (!empty($nome) && !empty($email) && !empty($assunto) && !empty($texto)) {
        $mensagem = "Obrigado, <strong>$nome</strong>! Sua mensagem foi recebida com sucesso.";
    } else {
        $mensagem = "Por favor, preencha todos os campos do formulário.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lumora Café - Cafeteria</title>
    <link rel="stylesheet" href="style.css/styles.css">
  
</head>
<body>

<header class="topo">
    <div class="container navbar">
        <div class="logo">
            <img src="img/logo.jpeg" alt="Logo Lumora Café">
            <span>Lumora Café</span>
        </div>
        <nav>
            <ul class="menu">
                <li><a href="#inicio">Início</a></li>
                <li><a href="#sobre">Sobre</a></li>
                <li><a href="#cardapio">Cardápio</a></li>
                <li><a href="#contato">Contato</a></li>
            </ul>
        </nav>
    </div>
</header>

    <section class="hero" id="inicio">
        <div class="container hero-conteudo">
            <div class="hero-texto">
                <span class="tag">Sabor • Conforto • Qualidade</span>
                <h1>O melhor café da sua rotina começa aqui.</h1>
                <p>
                    Na Café Aroma, cada xícara é preparada com carinho, grãos selecionados
                    e um ambiente acolhedor para transformar seu dia.
                </p>
                <div class="hero-botoes">
                    <a href="#cardapio" class="btn">Ver Cardápio</a>
                    <a href="#contato" class="btn btn-secundario">Reservar Mesa</a>
                </div>
            </div>

            <div class="hero-card">
                <h3>Destaque da Casa</h3>
                <p class="bebida">Cappuccino Cremoso</p>
                <p>Espuma aveludada, café intenso e canela na medida certa.</p>
                <span class="preco-destaque">R$ 12,00</span>
            </div>
        </div>
    </section>

    <section class="sobre" id="sobre">
        <div class="container">
            <div class="secao-titulo">
                <span>Sobre nós</span>
                <h2>Mais que café, uma experiência.</h2>
            </div>

            <div class="sobre-grid">
                <div class="sobre-card">
                    <h3>🌱 Grãos selecionados</h3>
                    <p>
                        Trabalhamos com cafés especiais para entregar sabor, aroma e qualidade em cada preparo.
                    </p>
                </div>
                <div class="sobre-card">
                    <h3>🪑 Ambiente acolhedor</h3>
                    <p>
                        Um espaço pensado para reuniões, estudos, encontros e momentos de pausa.
                    </p>
                </div>
                <div class="sobre-card">
                    <h3>🍰 Acompanhamentos artesanais</h3>
                    <p>
                        Bolos, doces e salgados feitos para harmonizar perfeitamente com nossas bebidas.
                    </p>
                </div>
            </div>
        </div>
    </section>

    

    <section class="cardapio" id="cardapio">
        <div class="container">
            <div class="secao-titulo">
                <span>Nosso cardápio</span>
                <h2>Favoritos da cafeteria</h2>
            </div>

            <div class="cards-produtos">
                <?php foreach ($cardapio as $item): ?>
                    <div class="produto">
                        <div class="icone"><?= $item["icone"]; ?></div>
                        <h3><?= $item["nome"]; ?></h3>
                        <p><?= $item["descricao"]; ?></p>
                        <span><?= $item["preco"]; ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="horarios">
        <div class="container">
            <div class="secao-titulo">
                <span>Horários</span>
                <h2>Estamos te esperando</h2>
            </div>

            <div class="horarios-box">
                <?php foreach ($horarios as $dia => $hora): ?>
                    <div class="linha-horario">
                        <strong><?= $dia; ?></strong>
                        <span><?= $hora; ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    

    <section class="contato" id="contato">
        <div class="container contato-grid">
            <div class="contato-info">
                <div class="secao-titulo alinhado-esquerda">
                    <span>Contato</span>
                    <h2>Fale com a nossa equipe</h2>
                </div>
                <p>
                    Quer reservar uma mesa, fazer uma encomenda ou tirar dúvidas?
                    Envie sua mensagem pelo formulário.
                </p>

                <ul class="lista-contato">
                    <li><strong>📍 Endereço:</strong> Rua das Flores, 123 - Centro</li>
                    <li><strong>📞 Telefone:</strong> (11) 99999-9999</li>
                    <li><strong>✉️ E-mail:</strong> contato@cafearoma.com</li>
                </ul>
            </div>

            <div class="form-box">
                <?php if (!empty($mensagem)): ?>
                    <div class="alerta"><?= $mensagem; ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="campo">
                        <label for="nome">Nome</label>
                        <input type="text" id="nome" name="nome" placeholder="Digite seu nome">
                    </div>

                    <div class="campo">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" placeholder="Digite seu e-mail">
                    </div>

                    <div class="campo">
                        <label for="assunto">Assunto</label>
                        <input type="text" id="assunto" name="assunto" placeholder="Ex: Reserva para 4 pessoas">
                    </div>

                    <div class="campo">
                        <label for="mensagem">Mensagem</label>
                        <textarea id="mensagem" name="mensagem" rows="5" placeholder="Escreva sua mensagem"></textarea>
                    </div>

                    <button type="submit" class="btn">Enviar mensagem</button>
                </form>
            </div>
        </div>
    </section>
    <section class="depoimentos" id="depoimentos">
    <div class="container">
        <div class="secao-titulo">
            <span>Depoimentos</span>
            <h2>O que nossos clientes dizem</h2>
        </div>

        <div class="depoimentos-grid">
            <div class="depoimento-card">
                <div class="cliente-topo">
                    <div class="cliente-foto">A</div>
                    <div>
                        <h3>Ana Souza</h3>
                        <p>Cliente fiel</p>
                    </div>
                </div>
                <div class="estrelas">★★★★★</div>
                <p class="texto-depoimento">
                    Ambiente maravilhoso, atendimento super atencioso e o cappuccino é simplesmente perfeito.
                    Sempre venho aqui quando quero relaxar e tomar um café especial.
                </p>
            </div>

            <div class="depoimento-card">
                <div class="cliente-topo">
                    <div class="cliente-foto">R</div>
                    <div>
                        <h3>Rafael Lima</h3>
                        <p>Empresário</p>
                    </div>
                </div>
                <div class="estrelas">★★★★★</div>
                <p class="texto-depoimento">
                    A Lumora Café tem um clima muito acolhedor. Ótimo lugar para reuniões e para passar a tarde.
                    O bolo do dia e o latte são meus favoritos.
                </p>
            </div>

            <div class="depoimento-card">
                <div class="cliente-topo">
                    <div class="cliente-foto">C</div>
                    <div>
                        <h3>Camila Rocha</h3>
                        <p>Designer</p>
                    </div>
                </div>
                <div class="estrelas">★★★★★</div>
                <p class="texto-depoimento">
                    O espaço é lindo, confortável e cheio de charme. Dá para sentir o cuidado em cada detalhe,
                    desde a decoração até a apresentação das bebidas.
                </p>
            </div>
        </div>
    </div>
</section>


    <footer class="rodape">
        <div class="container">
            <p>© <?php echo date("Y"); ?> Café Aroma - Todos os direitos reservados.</p>
        </div>
    </footer>

</body>
</html>

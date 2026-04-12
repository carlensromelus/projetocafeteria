<?php
session_start();

// 🔒 proteção de login
if (!isset($_SESSION["logado"])) {
    header("Location: login.php");
    exit;
}

$usuario = $_SESSION["usuario"];

// 🍽️ CARDÁPIO
$cardapio = [
    ["nome"=>"Espresso Tradicional","descricao"=>"Café intenso e aromático.","preco"=>"R$ 7,00","icone"=>"☕","imagem"=>"img/1.jpg"],
    ["nome"=>"Cappuccino Cremoso","descricao"=>"Espresso + leite + espuma.","preco"=>"R$ 12,00","icone"=>"🥛","imagem"=>"img/2.jpg"],
    ["nome"=>"Mocha Especial","descricao"=>"Café com chocolate e chantilly.","preco"=>"R$ 15,00","icone"=>"🍫","imagem"=>"img/3.jpg"],
    ["nome"=>"Croissant Artesanal","descricao"=>"Massa leve e amanteigada.","preco"=>"R$ 11,00","icone"=>"🥐","imagem"=>"img/4.jpg"],
    ["nome"=>"Fatia de Bolo","descricao"=>"Sabores variados do dia.","preco"=>"R$ 13,00","icone"=>"🍰","imagem"=>"img/5.jpg"],
];

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
<title>☕ Lumora Café</title>
<link rel="stylesheet" href="styles.css/styles">
</head>

<body>

<!-- ================= HEADER ================= -->
<header class="topo">
    <div class="container navbar">

        <div class="logo">
            ☕ Lumora Café
        </div>

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
<section class="welcome">
    <h2>Bem-vindo, <?= htmlspecialchars($usuario) ?> ☕</h2>
    <p>Você está logado no sistema da Lumora Café</p>
</section>

<!-- ================= HERO ================= -->
<section id="inicio">
    <h2>☕ O melhor café da cidade</h2>
    <p>Qualidade, conforto e sabor em cada xícara</p>
</section>

<!-- ================= SOBRE ================= -->
<section id="sobre">
    <h2>🌱 Sobre nós</h2>
    <p>Trabalhamos com cafés especiais e ambiente acolhedor.</p>
</section>

<!-- ================= CARDÁPIO ================= -->
<section id="cardapio">
    <h2>🍽️ Cardápio</h2>

    <div class="grid">
        <?php foreach ($cardapio as $item): ?>
            <div class="card">
                <img src="<?= $item['imagem'] ?>">
                <h3><?= $item['icone'] ?> <?= $item['nome'] ?></h3>
                <p><?= $item['descricao'] ?></p>
                <b><?= $item['preco'] ?></b>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ================= HORÁRIOS ================= -->
<section>
    <h2>🕒 Horários</h2>

    <?php foreach ($horarios as $dia => $hora): ?>
        <p><b><?= $dia ?>:</b> <?= $hora ?></p>
    <?php endforeach; ?>
</section>

<!-- ================= CONTATO ================= -->
<section id="contato">
    <h2>📩 Contato</h2>

    <?php if ($mensagem): ?>
        <p><?= $mensagem ?></p>
    <?php endif; ?>

    <form method="POST">
        <input name="nome" placeholder="Nome">
        <input name="email" placeholder="Email">
        <input name="assunto" placeholder="Assunto">
        <textarea name="mensagem" placeholder="Mensagem"></textarea>
        <button>Enviar</button>
    </form>
</section>

<!-- ================= DEPOIMENTOS ================= -->
<section>
    <h2>⭐ Depoimentos</h2>

    <p>“Melhor café da cidade” - Ana</p>
    <p>“Ambiente incrível” - Rafael</p>
    <p>“Muito aconchegante” - Camila</p>
</section>

<!-- ================= FOOTER ================= -->
<footer>
    <p>© <?= date("Y") ?> Lumora Café</p>
</footer>

</body>
</html>
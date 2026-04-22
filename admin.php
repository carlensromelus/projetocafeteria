<?php
session_start();
include("conexao.php");

// 🔒 proteção
if (!isset($_SESSION["logado"])) {
    header("Location: login.php");
    exit;
}

// =====================
// CADASTRAR PRODUTO
// =====================
if (isset($_POST["cadastrar"])) {

    $nome = $_POST["nome"];
    $descricao = $_POST["descricao"];
    $preco = $_POST["preco"];
    $imagem = $_POST["imagem"];
    $concact = "img/".$imagem;

    $stmt = $conn->prepare("INSERT INTO produtos (nome, descricao, preco, imagem) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $nome, $descricao, $preco, $concact);
    $stmt->execute();
}

// =====================
// EXCLUIR PRODUTO
// =====================
if (isset($_GET["excluir"])) {
    $id = $_GET["excluir"];
    $conn->query("DELETE FROM produtos WHERE id=$id");
}

// =====================
// EXCLUIR MENSAGEM
// =====================
if (isset($_GET["excluir_msg"])) {
    $id = $_GET["excluir_msg"];
    $conn->query("DELETE FROM mensagens WHERE id=$id");
}

// =====================
// BUSCAR DADOS
// =====================
$produtos = $conn->query("SELECT * FROM produtos");
$mensagens = $conn->query("SELECT * FROM mensagens ORDER BY data_envio DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Cafeteria</title>
    <link rel="stylesheet" href="admin.css">
</head>

<body>

<!-- NAVBAR --> 
<div class="navbar">
    <h1>Painel Admin ☕</h1>

    <div class="nav-links">
        <a href="admin.php">Dashboard</a>
        <a href="#">Produtos</a>
        <a href="#">Mensagens</a>

        <a href="logout.php" class="btn-sair">
            ⏻ Sair
        </a>
    </div>
</div>

<div class="container">

    <!-- ===================== -->
    <!-- CADASTRAR PRODUTO -->
    <!-- ===================== -->
    <div class="form-box">
        <h2>Adicionar Produto</h2>

        <form method="POST">
            <input type="text" name="nome" placeholder="Nome" required>
            <textarea name="descricao" placeholder="Descrição" required></textarea>
            <input type="text" name="preco" placeholder="Preço" required>
            <input type="text" name="imagem" placeholder="Nome da imagem (ex: cafe.jpg)" required>

            <button name="cadastrar">Cadastrar</button>
        </form>
    </div>

    <!-- ===================== -->
    <!-- LISTA PRODUTOS -->
    <!-- ===================== -->
    <div class="lista">
        <h2>Produtos ☕</h2>

        <?php while($p = $produtos->fetch_assoc()) { ?>
            <div class="card">
                <div class="info">
                    <h3><?php echo $p["nome"]; ?></h3>
                    <p><?php echo $p["descricao"]; ?></p>
                    <p class="preco">R$ <?php echo $p["preco"]; ?></p>
                </div>

                <a class="excluir" href="?excluir=<?php echo $p["id"]; ?>">
                    Excluir
                </a>
            </div>
        <?php } ?>
    </div>

    <!-- ===================== -->
    <!-- MENSAGENS -->
    <!-- ===================== -->
    <div class="lista">
        <h2>Mensagens Recebidas 📩</h2>

        <?php while($m = $mensagens->fetch_assoc()) { ?>
            <div class="card">
                <div class="info">
                    <h3><?php echo $m["nome"]; ?></h3>
                    <p><strong>Email:</strong> <?php echo $m["email"]; ?></p>
                    <p><strong>Assunto:</strong> <?php echo $m["assunto"]; ?></p>
                    <p><?php echo $m["mensagem"]; ?></p>
                    <p class="preco"><?php echo $m["data_envio"]; ?></p>
                </div>

                <a class="excluir" href="?excluir_msg=<?php echo $m["id"]; ?>">
                    Excluir
                </a>
            </div>
        <?php } ?>
    </div>

</div>

</body>
</html>
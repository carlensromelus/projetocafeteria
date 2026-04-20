<?php
session_start();
include("conexao.php");

// 🔒 proteção
if (!isset($_SESSION["logado"])) {
    header("Location: login.php");
    exit;
}

// CADASTRAR PRODUTO (SEGURO)
if (isset($_POST["cadastrar"])) {

    $nome = $_POST["nome"];
    $descricao = $_POST["descricao"];
    $preco = $_POST["preco"];
    $imagem = $_POST["imagem"];
    $concact = "img/".$imagem;

    $stmt = $conn->prepare("INSERT INTO produtos (nome, descricao, preco,imagem) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $nome, $descricao, $preco,$concact);
    $stmt->execute();
}

// EXCLUIR PRODUTO
if (isset($_GET["excluir"])) {
    $id = $_GET["excluir"];
    $conn->query("DELETE FROM produtos WHERE id=$id");
}

// BUSCAR
$produtos = $conn->query("SELECT * FROM produtos");
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Cafeteria</title>

<style>
body {
    margin:0;
    font-family: Arial;
    background:#EFEBE9;
}

/* NAVBAR */
.nav {
    background:#3E2723;
    padding:15px;
    display:flex;
    justify-content:space-between;
    color:white;
}

.nav a {
    color:white;
    text-decoration:none;
    margin-left:15px;
}

/* CONTAINER */
.container {
    display:flex;
    gap:20px;
    padding:20px;
}

/* FORM */
.form-box {
    width:30%;
    background:white;
    padding:20px;
    border-radius:10px;
}

.form-box h2 {
    color:#3E2723;
}

input, textarea {
    width:100%;
    padding:10px;
    margin:10px 0;
    border-radius:5px;
    border:1px solid #ccc;
}

button {
    width:100%;
    padding:10px;
    background:#6D4C41;
    color:white;
    border:none;
    border-radius:5px;
    cursor:pointer;
}

button:hover {
    background:#D7A86E;
}

/* LISTA */
.lista {
    width:70%;
}

.card {
    background:white;
    padding:15px;
    margin-bottom:15px;
    border-radius:10px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.info h3 {
    margin:0;
    color:#3E2723;
}

.preco {
    color:#6D4C41;
    font-weight:bold;
}

.excluir {
    background:red;
    color:white;
    padding:8px 12px;
    border-radius:5px;
    text-decoration:none;
}
</style>

</head>

<body>

<!-- NAVBAR -->
<div class="nav">
    <h3>☕ Cafeteria Admin</h3>
    <a href="logout.php">Sair</a>
</div>

<div class="container">

    <!-- FORM CADASTRO -->
    <div class="form-box">
        <h2>Adicionar Produto</h2>

        <form method="POST">
            <input type="text" name="nome" placeholder="Nome">
            <textarea name="descricao" placeholder="Descrição"></textarea>
            <input type="text" name="preco" placeholder="Preço">
            <input type="file" name="imagem" placeholder="Imagem">
            <button name="cadastrar">Cadastrar</button>
        </form>
    </div>

    <!-- LISTA PRODUTOS -->
    <div class="lista">
        <h2>Produtos</h2>

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

</div>

</body>
</html>
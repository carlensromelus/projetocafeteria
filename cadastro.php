<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

require "conexao.php";

$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"] ?? "");
    $senha = $_POST["senha"] ?? "";
    $role = "user";

    if ($email && $senha && $role) {

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
     
      
        // 🔍 verifica se email já existe
        $check = $conn->prepare("SELECT id FROM usuarios WHERE email=?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {

            $msg = "☕ Email já cadastrado!";

        } else {

            // 📝 insere no banco
            $stmt = $conn->prepare(
                "INSERT INTO usuarios (email, senha, role) VALUES (?, ?, ?)"
            );

            if ($stmt) {
                $stmt->bind_param("sss", $email, $senhaHash, $role);

                if ($stmt->execute()) {

                    // 🔥 LOGIN AUTOMÁTICO
                    $_SESSION["logado"] = true;
                    $_SESSION["usuario"] = $email;

                    header("Location: index.php");
                    exit;

                } else {
                    $msg = "❌ Erro ao cadastrar: " . $stmt->error;
                }

                $stmt->close();
            }
        }

        $check->close();

    } else {
        $msg = "⚠️ Preencha todos os campos!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Criar Conta</title>

<style>
* {
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family: Arial, sans-serif;
}

body {
    height:100vh;
    background:#EFEBE9;
    display:flex;
    justify-content:center;
    align-items:center;
}

.container {
    width:900px;
    height:520px;
    background:white;
    display:flex;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 15px 40px rgba(0,0,0,0.2);
}

.left {
    width:50%;
    background:url("https://images.unsplash.com/photo-1509042239860-f550ce710b93") no-repeat center;
    background-size:cover;
    position:relative;
}

.left::after {
    content:"";
    position:absolute;
    width:100%;
    height:100%;
    background:rgba(62,39,35,0.65);
}

.left-text {
    position:absolute;
    bottom:30px;
    left:30px;
    color:white;
    z-index:2;
    font-size:20px;
    font-weight:bold;
}

.right {
    width:50%;
    padding:40px;
    display:flex;
    flex-direction:column;
    justify-content:center;
}

.right h2 {
    color:#3E2723;
    margin-bottom:10px;
}

.right p {
    color:#777;
    font-size:14px;
    margin-bottom:20px;
}

input {
    padding:12px;
    margin-bottom:15px;
    border:1px solid #ddd;
    border-radius:5px;
    outline:none;
}

input:focus {
    border-color:#6D4C41;
}

button {
    padding:12px;
    background:#6D4C41;
    color:white;
    border:none;
    border-radius:5px;
    cursor:pointer;
    font-weight:bold;
}

button:hover {
    background:#D7A86E;
}

.link {
    margin-top:15px;
    font-size:13px;
    color:#6D4C41;
    text-align:center;
}

.link a {
    color:#6D4C41;
    text-decoration:none;
    font-weight:bold;
}

.msg {
    color:#3E2723;
    font-size:13px;
    margin-bottom:10px;
}
</style>

</head>

<body>

<div class="container">

    <div class="left">
        <div class="left-text">
            ☕ Crie sua conta
        </div>
    </div>

    <div class="right">
        <h2>Criar Conta</h2>
        <p>Cadastre-se com seu email</p>

        <?php if($msg) echo "<div class='msg'>$msg</div>"; ?>

        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="senha" placeholder="Senha" required>

            <button type="submit">Criar Conta</button>
        </form>

        <div class="link">
            Já tem conta? <a href="login.php">Entrar</a>
        </div>
    </div>

</div>

</body>
</html>
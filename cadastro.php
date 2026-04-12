<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start(); // 🔥 importante

require "conexao.php";

$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome  = trim($_POST["nome"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $senha = $_POST["senha"] ?? "";

    if ($nome && $email && $senha) {

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
                "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)"
            );

            if ($stmt) {
                $stmt->bind_param("sss", $nome, $email, $senhaHash);

                if ($stmt->execute()) {

                    // 🔥 LOGIN AUTOMÁTICO
                    $_SESSION["logado"] = true;
                    $_SESSION["usuario"] = $nome;

                    // 🚀 redireciona direto
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
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="cadastro.css">
<title>Criar Conta</title>
</head>

<body>

<h2>Criar Conta ☕</h2>

<p><?= $msg ?></p>

<form method="POST">

<input type="text" name="nome" placeholder="Nome">
<input type="email" name="email" placeholder="Email">
<input type="password" name="senha" placeholder="Senha">

<button type="submit">Criar Conta</button>

</form>

</body>
</html>
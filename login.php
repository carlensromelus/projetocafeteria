<?php
session_start();
require "conexao.php";

$erro = "";
$email = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = $_POST["email"] ?? "";
    $senha = $_POST["senha"] ?? "";

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $res = $stmt->get_result();

        if ($res->num_rows === 1) {
            $user = $res->fetch_assoc();

            if (password_verify($senha, $user["senha"])) {

                $_SESSION["logado"] = true;
                $_SESSION["usuario"] = $user["nome"];

                header("Location: index.php");
                exit;

            } else {
                $erro = "Senha incorreta";
            }

        } else {
            $erro = "Usuário não encontrado";
        }

    } else {
        $erro = "Erro na conexão com banco";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - Lumora Café</title>
<link rel="stylesheet" href="login.css">
</head>

<body>

<div class="login-container">
    <div class="login-box">

        <h2>☕ Lumora Café</h2>
        <p>Bem-vindo de volta</p>

        <form method="POST">

            <div class="campo">
                <label>Email</label>
                <input type="email" name="email"
                       value="<?= htmlspecialchars($email) ?>"
                       required>
            </div>

            <div class="campo">
                <label>Senha</label>
                <input type="password" name="senha" required>
            </div>

            <button type="submit" class="btn">Entrar</button>
        </form>

        <?php if (!empty($erro)): ?>
            <p style="color:red; margin-top:10px;">
                <?= $erro ?>
            </p>
        <?php endif; ?>

        <span class="extra">
            Não tem conta? <a href="cadastro.php">Criar conta</a>
        </span>

    </div>
</div>

</body>
</html>
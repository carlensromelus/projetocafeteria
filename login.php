<?php
session_start();

$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"] ?? "";
    $senha = $_POST["senha"] ?? "";

    // LOGIN SIMPLES (exemplo)
    if ($email === "admin@cafe.com" && $senha === "1234") {
        $_SESSION["logado"] = true;
        header("Location: index.php");
        exit;
    } else {
        $erro = "Email ou senha inválidos!";
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

        <form method="POST" action="">
            <div class="campo">
                <label>Email</label>
                <input type="email" name="email" placeholder="Digite seu email">
            </div>

            <div class="campo">
                <label>Senha</label>
                <input type="password" name="senha" placeholder="Digite sua senha">
            </div>

            <button type="submit" class="btn">Entrar</button>
        </form>

        <span class="extra">
            Não tem conta? <a href="#">Criar conta</a>
        </span>
    </div>
</div>

<div class="logout-container">
    <a href="logout.php" class="btn btn-sair">Sair</a>
</div>

</body>
<?php if (!empty($erro)): ?>
    <p style="color:red;"><?= $erro ?></p>
<?php endif; ?>

</html>

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
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($senha, $usuario["senha"])) {
            $_SESSION["logado"] = true;
            $_SESSION["usuario"] = $usuario["nome"];

            header("Location: index.php");
            exit;
        } else {
            $erro = "Senha incorreta!";
        }
    } else {
        $erro = "Usuário não encontrado!";
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
                <input 
                    type="email" 
                    name="email" 
                    placeholder="Digite seu email"
                    value="<?= htmlspecialchars($email) ?>"
                    required
                >
            </div>

            <div class="campo">
                <label>Senha</label>
                <input 
                    type="password" 
                    name="senha" 
                    placeholder="Digite sua senha"
                    required
                >
            </div>

            <button type="submit" class="btn">Entrar</button>
        </form>

        <?php if (!empty($erro)): ?>
            <p style="color:red; margin-top:10px;"><?= $erro ?></p>
        <?php endif; ?>

        <span class="extra">
            Não tem conta? <a href="#">Criar conta</a>
        </span>
    </div>
</div>

<?php if (isset($_SESSION["logado"]) && $_SESSION["logado"] === true): ?>
    <div class="logout-container">
        <a href="logout.php" class="btn btn-sair">Sair</a>
    </div>
<?php endif; ?>

</body>
</html>
```

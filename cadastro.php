<?php
require "conexao.php";

$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome  = trim($_POST["nome"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $senha = $_POST["senha"] ?? "";

    if ($nome && $email && $senha) {

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        // verifica email
        $check = $conn->prepare("SELECT id FROM usuarios WHERE email=?");

        if ($check) {
            $check->bind_param("s", $email);
            $check->execute();
            $res = $check->get_result();

            if ($res->num_rows > 0) {
                $msg = "☕ Este email já está cadastrado!";
            } else {

                $stmt = $conn->prepare(
                    "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)"
                );

                if ($stmt) {
                    $stmt->bind_param("sss", $nome, $email, $senhaHash);

                    $msg = $stmt->execute()
                        ? "☕ Cadastro realizado com sucesso!"
                        : "❌ Erro ao cadastrar usuário!";
                } else {
                    $msg = "❌ Erro na query SQL!";
                }
            }
        } else {
            $msg = "❌ Erro na conexão!";
        }

    } else {
        $msg = "⚠️ Preencha todos os campos!";
    }
}
?>
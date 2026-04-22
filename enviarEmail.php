<?php
require 'vendor/autoload.php';
include("conexao.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$txtNome = $_POST["txtNome"];
$txtAssunto = $_POST["txtAssunto"];
$txtEmail = $_POST["txtEmail"];
$txtMensagem = $_POST["txtMensagem"];

// 🔥 SALVAR NO BANCO
$sql = "INSERT INTO mensagens (nome, email, assunto, mensagem)
        VALUES ('$txtNome', '$txtEmail', '$txtAssunto', '$txtMensagem')";

$conn->query($sql);

// 📧 ENVIAR EMAIL
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'seu-email@gmail.com';
    $mail->Password = 'zvwj hvxg wnlp omwb';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('seu-email@gmail.com', 'Cafeteria');
    $mail->addAddress('seu-email@gmail.com');
    $mail->addReplyTo($txtEmail, $txtNome);

    $mail->isHTML(true);
    $mail->Subject = $txtAssunto;
    $mail->Body = "
        <h2>Nova mensagem ☕</h2>
        <p><b>Nome:</b> $txtNome</p>
        <p><b>Email:</b> $txtEmail</p>
        <p><b>Mensagem:</b><br>$txtMensagem</p>
    ";

    $mail->send();

    header("Location: sucesso.html");
    exit;

} catch (Exception $e) {
    echo "Erro: {$mail->ErrorInfo}";
}
?>
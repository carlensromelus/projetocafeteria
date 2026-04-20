<?php
require 'vendor/autoload.php'; // Certifique-se de incluir o autoloader do PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;// Recuperar dados do formulário
$txtNome = $_POST["txtNome"];
$txtAssunto = $_POST["txtAssunto"];
$txtEmail = $_POST["txtEmail"];
$txtMensagem = $_POST["txtMensagem"];// Configurar o PHPMailer
$mail = new PHPMailer(true);
try {
// Configurações do servidor SMTP
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'seu-email@gmail.com'; // Seu endereço de e-mail do Gmail
$mail->Password = 'sua-senha-de-aplicativo'; // Senha de aplicativo gerada
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;// Configurações do e-mail
$mail->setFrom('seu-email@gmail.com', $txtNome);
$mail->addAddress($txtEmail);
$mail->Subject = $txtAssunto;
$mail->Body = $txtMensagem;
$mail->isHTML(true);// Enviar o e-mail
$mail->send();
echo 'E-mail enviado com sucesso!';
} catch (Exception $e) {
echo "Erro ao enviar o e-mail: {$mail->ErrorInfo}";
}
?>
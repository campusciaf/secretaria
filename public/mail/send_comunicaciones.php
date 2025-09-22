<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';
	
$mail = new PHPMailer();
$mail->isSMTP(); 
$mail->SMTPDebug = 0; // Depuracion: 1 = Errores y Mensajes, 2 = Solo mensajes
$mail->SMTPAuth = true; // Autenticacion habilitada
$mail->SMTPSecure = 'ssl'; // Protocolo de conexion segura
$mail->Host = "mail.ciaf.digital"; // Servidor de correo saliente
$mail->Port = 465; // Para conexion con SSL
$mail->IsHTML(true);
$mail->Username = "contacto@ciaf.digital"; // Correo que usa el formulario para enviar
$mail->Password = "soluciones3.0"; // Contraseña del correo electronico
$mail->SetFrom("contacto@ciaf.digital"); // El mismo correo digitado arriba
$mail->Subject = "Contacto por formulario"; // Asunto del corrreo que recibira el cliente
$mail->Body = $_POST["contenido_correo"]; // Informacion que recibira el cliente en el correo
$mail->CharSet = 'UTF-8';
$separado_por_coma = explode(",", $_POST["destinatarios"]);

foreach($separado_por_coma as $email)
{
	$mail->AddAddress($email);
}
if(!$mail->Send()) 
{
	echo "Tu mensaje no ha podido ser enviado: ".$mail->ErrorInfo;

} else 
{
	echo "Mensaje enviado con exito";

}



?>
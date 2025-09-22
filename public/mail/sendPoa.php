<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

ini_set('max_execution_time', 600); //600 seconds = 10 minutes

function mensajePoa($correo_envia,$destinatarios,$cuerpo_mensaje,$meta,$asunto){

$mensaje="Nombre de la Meta: <b>" . $meta . "</b> <br>" . $cuerpo_mensaje . "<br><br>

			<center><img src='https://www.poa.ciaf.digital/public/img/firma.gif'></center>";
		
		
	$mail = new PHPMailer();
	$mail->CharSet = 'UTF-8';
	$mail->SetLanguage("es", 'language/phpmailer.lang-es.php');
	$mail->isSMTP(); 
	$mail->SMTPDebug = 0; // Depuracion: 1 = Errores y Mensajes, 2 = Solo mensajes
	$mail->SMTPAuth = true; // Autenticacion habilitada
	$mail->SMTPSecure = 'ssl'; // Protocolo de conexion segura
	$mail->Host = "mail.ciaf.digital"; // Servidor de correo saliente
	$mail->Port = 465; // Para conexion con SSL
	$mail->IsHTML(true);
	$mail->Username = "contacto@ciaf.digital"; // Correo que usa el formulario para enviar
	$mail->Password = "soluciones3.0"; // Contraseña del correo electronico
	$mail->SetFrom($correo_envia); // El mismo correo digitado arriba
	$mail->Subject = $asunto; // Asunto del corrreo que recibira el cliente
	$mail->Body = $mensaje; 
	$mail->AddAddress($destinatarios);
	echo $mail->Send();
	




}



?>
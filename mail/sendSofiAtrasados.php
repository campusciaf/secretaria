<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';


function enviar_correo($destino, $asunto, $mensaje){

	$mail = new PHPMailer();
	$mail->isSMTP(); 
	$mail->SMTPDebug = 0; // Depuracion: 1 = Errores y Mensajes, 2 = Solo mensajes
	$mail->SMTPAuth = true; // Autenticacion habilitada
	$mail->SMTPSecure = 'ssl'; // Protocolo de conexion segura
	$mail->Host = "mail.ciaf.digital"; // Servidor de correo saliente
	$mail->Port = 465; // Para conexion con SSL
	$mail->IsHTML(true);
	$mail->Username = "pagos@ciaf.digital"; // Correo que usa el formulario para enviar
	$mail->Password = "Ciaf5842."; // Contrase�a del correo electronico
	$mail->SetFrom("pagos@ciaf.edu.co"); // El mismo correo digitado arriba
	$mail->Subject = $asunto; // Asunto del corrreo que recibira el cliente
	$mail->Body = $mensaje; // Informacion que recibira el cliente en el correo
	$mail->CharSet = 'UTF-8';
	$mail->FromName = "CAMPUS";


	$mail->AddAddress($destino);

	return $mail->Send();

}
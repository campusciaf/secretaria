<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

//ini_set('max_execution_time', 600); //600 seconds = 10 minutes


// función donde se le envia la respuesta de la solicitud al docue
function correo_respuesta_solicitud($email,$respuesta,$docente,$fecha,$mensaje)
{
	$mail = new PHPMailer();
	$mail->CharSet = 'UTF-8';
	$mail->setLanguage("es");
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
	$mail->Subject = "Respuesta solicitud gastos de movilización"; // Asunto del corrreo que recibira el cliente
	$mail->Body = '<table width="650px" border="0" cellpadding="0" cellspacing="0" align="center" style="border: 1px solid #dfdfdf">
						<tr>
						<td>
							<table width="100%" border="0" style="margin-bottom: 15px; margin-top: 15px;">
										<tr>
											<td>
												<center><img src="https://www.ciaf.digital/imagenes/logo-evolucionado-mailing.png" style="width: 20%;"></center><br>	
														<p style="font: oblique bold 20px cursive;">
																Docente '.$docente.' este correo es para informale que su solicitud de gastos de movilización de la fecha '.$fecha.'
																ha sido  '.$respuesta.' <br/><br/>

																<span style="color: darkgray;">
																	<small>
																		'.$mensaje.'
																	</small>
																</span>
														</p>
											</td>
									</tr>
								</table>
									<table width="650px" cellpadding="10" cellspacing="0" align="center">
										<tr height="40px;" bgcolor="#2b7fbb">
											<td>
											<font size="4px" color="#fff"></font>
											</td>
										</tr>
										</tr>
											<td>
													<font color="#7f7f7f" face="Arial, Helvetica, sans-serif"> 
													<img src="https://www.ciaf.digital/iconos/tel.png"> Teléfono: (57+6) 3400100<br>
													<img src="https://www.ciaf.digital/iconos/referencias.png"><a href="https://www.ciaf.edu.co" target="_blank" style="color: #0868CA;text-decoration: none;"><b> www.ciaf.edu.co</b></a><br>
													<a href="https://goo.gl/neZMyH" style="color: gray; text-decoration: none;" target="_blank"><img src="https://www.ciaf.digital/iconos/ubicacion.png" > Carrera 6 No. 24-56 Pereira, Colombia</a>
													</font><br>
											</td>

										</tr>
									</table>
									<table width="650px" border="0" cellpadding="0" cellspacing="0" align="center" >
										<tr bgcolor="#064789">	
											<td>
											<img src="https://www.ciaf.digital/imagenes/logoevolucionad-CIAF-2.png" style="margin-left: 10px; width: 35%;"><br>
											</td>
											<td>
												<center><br><br>
													<a href="https://www.facebook.com/ComunidadCIAF" target="_blank"><img src="https://www.ciaf.digital/imagenes/r_face.png"></a>
													<a href="https://twitter.com/ComunidadCIAF" target="_blank"><img src="https://www.ciaf.digital/imagenes/r_twitter.png"></a>
													<a href="https://www.youtube.com/channel/UCgaRVYt3yzzlhbLZ1vhxCUQ" target="_blank"><img src="https://www.ciaf.digital/imagenes/r_youtube.png"></a>
													<img src="https://www.ciaf.digital/imagenes/r_whatsapp.png"><br><br>
												</center><br>
											</td>
										</tr>
									</table>
							</td>
						</tr>
					</table>'; // Informacion que recibira el cliente en el correo
	$mail->AddAddress($email);

	if(!$mail->Send()) 
	{
		return "Tu mensaje no ha podido ser enviado: ".$mail->ErrorInfo;

	}
	else 
	{
		return "1";
	}
}



?>
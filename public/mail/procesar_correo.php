<?php
	require 'send_docentes.php';
	// if donde entra cuando el docente va enviar un correo 
	if($_POST['guia']=="correo_docente")
	{
		if( $_POST['contenido']!="" )
		{
			if(correo_funcionario($_POST["validacion"],$_POST["correo_docente"],$_POST["asunto"],$_POST["contenido"],$_POST["destinatarios"])=="1")
			{
				echo 1;
			}
			else if(correo_funcionario($_POST["validacion"],$_POST["correo_docente"],$_POST["asunto"],$_POST["contenido"],$_POST["destinatarios"])=="3")
			{
				echo 3;
			}
		}
		else
		{
			echo 0;
		}	
	}

	// final if donde entra cuando el correo se va enviar de planeación
	if($_POST['guia']=="correo_planeacion")
	{

		if(correo_planeacion($_POST["correo_docente"],$_POST["asunto"],$_POST["contenido"],$_POST["destinatarios"])=="1")
		{
			echo 1;
		}
		else
		{
			echo 0 ;
		}
	}

if($_POST['guia']=="correo_funcionario")
	{
	
		
			if(correo_funcionario($_POST["validacion"],$_POST["correo"],$_POST["asunto"],$_POST["contenido"],$_POST["destinatarios"])=="1")
			{
				echo 1;
			}
	else if(correo_funcionario($_POST["validacion"],$_POST["correo"],$_POST["asunto"],$_POST["contenido"],$_POST["destinatarios"])=="3")
			{
				echo 3;
			}
			else
			{
				echo 0 ;
			}
	
	
	}
?>

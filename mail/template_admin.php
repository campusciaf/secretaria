<?php


function set_template($cvadministrativos_entrevista_direccion, $cvadministrativos_entrevista_fecha, $cvadministrativos_entrevista_hora, $cvadministrativos_entrevista_comentario){


    return <<<MESSAGE

    <div style='background-color: #f2f2f2'>
    <div style='width:90%; padding:2%; margin:auto'>
        <table width='90%' border='0' cellpadding='0' cellspacing='0' align='center'>
        </table>		
        <br>
        <div style='background-color: #fff'>
            <table width='100%' border='0' >
                <tr>
                    <td>
                    <center><br>	
                    <img src='http://ciaf.digital/cv/img/logo_nuevo.png'><br>	
                    </td>
                </tr>
            </table>
            <table width='100%' border='0' align='center'>
            <tr bgcolor='#064789'>
                <td align='center' style='padding: 10px'>
                <font size='4px' color='#fff'>Estimado(a) Interesado:</font>
                </td>
            </tr>
            </table>
            <table width='100%' cellpadding='20' cellspacing='0' align='center' border='0' bgcolor='#fff'>
            <tr>
                <td align='center'>
                <font size='4px' color='#064789' face='Arial, Helvetica, sans-serif'><b>Citación para entrevista</b></font>
                </td>
            </tr>
            <tr>
                <td style='text-align: center;'>
                <font size='3px' color='#212020' face='Arial, Helvetica, sans-serif'><b>Le anunciamos sobre su solicitud de interes para trabajar con nosotros. Estamos felices de informarle que hemos realizado un agendamiento para realizarle una entrevista, a continuación se le brindará información sobre la entrevista:</b></font><br>
                </td>
            </tr>
            <tr>
                <td style='text-align: center;'>
                <font size='3px' color='#212020' face='Arial, Helvetica, sans-serif'><b>Dirección de la entrevista:</b>$cvadministrativos_entrevista_direccion</font><br>
                </td>
            </tr>
            <tr>
                <td style='text-align: center;'>
                <font size='3px' color='#212020' face='Arial, Helvetica, sans-serif'><b>Fecha de la entrevista:</b>$cvadministrativos_entrevista_fecha</font><br>
                </td>
            </tr>
            <tr>
                <td style='text-align: center;'>
                <font size='3px' color='#212020' face='Arial, Helvetica, sans-serif'><b>Hora de la entrevista:</b>$cvadministrativos_entrevista_hora</font><br>
                </td>
            </tr>
            <tr>
                <td style='text-align: center;'>
                <font size='3px' color='#212020' face='Arial, Helvetica, sans-serif'><b>Comentarios:</b>$cvadministrativos_entrevista_comentario</font><br>
                </td>
            </tr>
            <tr>
                <td style='text-align: left;'>
                <font size='3px' color='#424040' face='Arial, Helvetica, sans-serif'>Este correo fue enviado automáticamente,agradecemos <b style='text-decoration:underline;'>no responder</b> este mensaje.</font><br>
                </td>
            </tr>
            <tr>
                <td style='text-align: left;'>
                <font size='3px' color='#424040' face='Arial, Helvetica, sans-serif'>Gracias por su atención.</font><br>
                </td>
            </tr>
            </table>
        </div>		
        <table width='100%' border='0' cellpadding='10' cellspacing='0' align='center' bgcolor='#fff'>
            <tr>
                <td bgcolor='#e6e6e6'>
                <font size='2px' color='#7f7f7f' face='Arial, Helvetica, sans-serif'>
                    Usted ha recibido este mensaje como respuesta automática del sistema para la entrevista,si ha recibido este mensaje por error, por favor haga caso omiso. Si desea reportar algun error puede escribir a 
                    <a href='#'><font size='2px' color='#064789'><b>sistemasdeinformacion@ciaf.edu.co</b></font></a>
                </font>
                </td>
            </tr>
        </table>
        <table width='100%' border='0' cellpadding='0' cellspacing='0' align='center' bgcolor='#fff' >
            <tr bgcolor='#064789'>	
                <td>
                <center>
                    <br><br>
                    <a href='https://es-la.facebook.com/ComunidadCIAF/' target='_blank'><img src='https://www.ciaf.edu.co/mercadeo/imagenes/r_face.png'></a>
                    <a href='https://twitter.com/ComunidadCIAF' target='_blank'><img src='https://www.ciaf.edu.co/mercadeo/imagenes/r_twitter.png'></a>
                    <a href='https://www.youtube.com/channel/UCgaRVYt3yzzlhbLZ1vhxCUQ' target='_blank'><img src='https://www.ciaf.edu.co/mercadeo/imagenes/r_youtube.png'></a>
                    <a href='https://www.ciaf.edu.co/inicio.php' target='_blank'><img src='https://www.ciaf.edu.co/mercadeo/imagenes/r_www.png'></a>
                    <br><br>
                </center>
                <br>
                </td>
            </tr>
        </table>	
    </div>
</div>
MESSAGE;
// $cvadministrativos_entrevista_direccion = "Nivel 1 - Técnica profesional en programación de software";
// $cvadministrativos_entrevista_fecha = "prueba";
// $cvadministrativos_entrevista_hora = "prueba";
// $cvadministrativos_entrevista_comentario = "prueba";
}
// echo set_template($cvadministrativos_entrevista_direccion, $cvadministrativos_entrevista_fecha, $cvadministrativos_entrevista_hora, $cvadministrativos_entrevista_comentario); 

?>
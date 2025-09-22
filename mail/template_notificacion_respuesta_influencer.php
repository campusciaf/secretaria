<?php

function set_template_notificacion_respuesta_influencer($docente_nombre_correo, $nombre_estudiante_correo){
return <<<MESSAGE
<div style='background-color: #fff'>
    <div style='max-width:600px; padding:2%; margin:auto'>
        <div style='background-color: #fff'>
            <table width='100%' border='0'>
                <tr style="background-image: url(https://ciaf.digital/tareas_cron/bg-bienestar.webp)">
                    <td>
                    <center><br>	
                    <img src='http://ciaf.digital/public/img/logo.webp' width="150px"><br><br>
                    </td>
                </tr>
            </table>
            <table width='100%' cellpadding='10' cellspacing='0' align='center' border='0' bgcolor='#fff'>
                <tr>
                    <td align='center'>
                        <font size='4px' color='#064789' face='Arial, Helvetica, sans-serif'>
                            <b> Influencer +</b>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td style='text-align: left;'>
                        <p style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #555;">
                            Estimado(a) <strong>$docente_nombre_correo</strong>,<br><br>
                            Se ha registrado una nueva <strong>respuesta</strong> al caso del estudiante:<br>
                            <strong>$nombre_estudiante_correo</strong>.<br><br>
                            Por favor ingrese a la plataforma para revisar los detalles completos de la conversación.
                        </p>    
                    </td>
                </tr>
            </table>
        </div>		
        <table width='100%' border='0' cellpadding='10' cellspacing='0' align='center' bgcolor='#fff' style="margin-top: 40px">
            <tr>
                <td bgcolor='#f4f2f2' colspan="2" style="padding: 1rem;">
                    <font size='2px' color='#7f7f7f' face='Arial, Helvetica, sans-serif'>
                        Usted ha recibido este mensaje como respuesta automática del sistema al ser parte de nuestra comunidad CIAF. 
                        Si ha recibido este mensaje por error, por favor haga caso omiso. 
                        Si desea reportar algún error puede escribir a
                        <a href='#'><font color='#064789'><b>campus@ciaf.edu.co</b></font></a> |
                        <a href='https://www.ciaf.edu.co/tratamiento_datos.php' target="_blank">
                            <font color='#064789'><b>POLÍTICAS DE TRATAMIENTO DE DATOS</b></font>
                        </a>
                    </font>
                </td>
            </tr>
            <tr bgcolor='#001550'>
                <td style="padding-left: 30px;">
                    <a href='https://es-la.facebook.com/ComunidadCIAF/' target='_blank'><img src='https://ciaf.digital/public/img/facebook.png' width="6%"></a>
                    <a href='https://twitter.com/ComunidadCIAF' target='_blank'><img src='https://ciaf.digital/public/img/logo_twitter.png' width="6%"></a>
                    <a href='https://www.youtube.com/channel/UCgaRVYt3yzzlhbLZ1vhxCUQ' target='_blank'><img src='https://ciaf.digital/public/img/youtube.png' width="6%"></a>
                    <a href='https://www.ciaf.edu.co/inicio.php' target='_blank'><img src='https://ciaf.digital/public/img/r_www.png' width="6%"></a>
                </td>
                <td>
                    <p style="font-family: arial, sans-serif; color: #efefef; font-size: 14px;">
                        <a target="_blank" href="https://ciaf.edu.co" style="color: #efefef;">www.ciaf.edu.co</a>
                    </p>
                </td>
            </tr>
        </table>	
    </div>
</div>
MESSAGE;
}
?>

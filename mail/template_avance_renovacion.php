<?php

function set_template($texto){
return <<<MESSAGE


<div style='background-color: #fff'>
<div style='max-width:740px; padding:2%; margin:auto'>

    <div style='background-color: #fff'>
        <table width='100%' border='0'>
            <tr style="background-image: url(https://ciaf.digital/tareas_cron/bg-bienestar.webp)">
                <td>
                <center><br>	
                <img src='http://ciaf.digital/public/img/logo-mail.jpg' width="150px"><br>	<br>
                </td>
            </tr>
        </table>
        <table width='100%' cellpadding='10' cellspacing='0' align='center' border='0' bgcolor='#fff'>
            <tr>
                <td align='center'>
                <font size='4px' color='#064789' face='Arial, Helvetica, sans-serif'><b>¡¡ Avance de la Renovación Financiera en el Campus Virtual !!</b></font>
                </td>
            </tr>
            <tr>
                <td>$texto</td>
            </tr>
                




        </table>

       
    </div>		
    <table width='100%' border='0' cellpadding='10' cellspacing='0' align='center' bgcolor='#fff'>
        <tr>
            <td bgcolor='#f4f2f2'>
            <font size='2px' color='#7f7f7f' face='Arial, Helvetica, sans-serif'>
                Usted ha recibido este mensaje como respuesta automática del sistema al ser parte de nuestra comunidad CIAF , si ha recibido este mensaje por error, por favor haga caso omiso. Si desea reportar algun error puede escribir a 
                <a href='#'><font size='2px' color='#064789'><b>campus@ciaf.edu.co</b></font></a> | 
                <a href='https://www.ciaf.edu.co/tratamiento_datos.php' target="_blank"><font size='2px' color='#064789'><b>POLITICA DE TRATAMIENTO DE DATOS</b></font></a>
                
            </font>
            </td>
        </tr>
    </table>

    <table width='100%' border='0' cellpadding='5' cellspacing='0' align='center' bgcolor='#fff' >
        <tr bgcolor='#001550' >	
            <td style="padding-left: 30px;">
           
               
                <a href='https://web.facebook.com/ComunidadCIAF' target='_blank'><img src='https://ciaf.edu.co/assets/image/facebook.webp' width='40px'></a>
                <a href='https://www.instagram.com/comunidadciaf/' target='_blank'><img src='https://ciaf.edu.co/assets/image/instagram.webp' width='40px'></a>
                <a href='https://www.tiktok.com/@comunidadciaf?lang=es' target='_blank'><img src='https://ciaf.edu.co/assets/image/tiktok.webp' width='40px'></a>
                <a href='https://www.youtube.com/channel/UCf6j5NaZbDKkdNpAtzbs9zA' target='_blank'><img src='https://ciaf.edu.co/assets/image/youtube.webp' width='40px'></a>
           
            
            <br>
            </td>
            <td>
            <p
                    style="
                        margin: 0;
                        -webkit-text-size-adjust: none;
                        -ms-text-size-adjust: none;
                        mso-line-height-rule: exactly;
                        font-family: arial, 'helvetica neue', helvetica, sans-serif;
                        line-height: 21px;
                        color: #333333;
                        font-size: 14px;
                    "
                >
                    <a
                        target="_blank"
                        href="https://ciaf.edu.co"
                        style="-webkit-text-size-adjust: none; -ms-text-size-adjust: none; mso-line-height-rule: exactly; text-decoration: none; color: #efefef; font-size: 14px;"
                    >
                        www.ciaf.edu.co
                    </a>
                </p>
            </td>
        </tr>
    </table>	
</div>
</div>

   
MESSAGE;
    }

?>



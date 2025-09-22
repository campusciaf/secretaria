<?php

function set_template($nombre_estudiante,$nombre_materia,$c1,$c2,$c3){
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
                <font size='5px' color='#fff'>$nombre_estudiante:</font>
                </td>
            </tr>
            </table>
            <table width='100%' cellpadding='20' cellspacing='0' align='center' border='0' bgcolor='#fff'>
            <tr>
                <td align='center'>
                <font size='4px' color='#064789' face='Arial, Helvetica, sans-serif'><b>¡¡ NOTA CALIFICADA !!</b></font>
                </td>
            </tr>
            <tr>
                <td> Te han calificado la materia:<strong> $nombre_materia </strong> <br><br> La nota del primer corte es: $c1 <br>La nota del segundo corte es: $c2 <br> La nota del tercer corte es: $c3  </td> 
            </tr>   
            
				
		
            <tr>
                <td style='text-align: left;'>
                <font size='3px' color='#424040' face='Arial, Helvetica, sans-serif'>Este correo fue enviado automáticamente, agradecemos <b style='text-decoration:underline;'>no responder</b> este mensaje.</font><br>
                </td>
            </tr>
            <tr>
                <td style='text-align: left;'>
                <font size='3px' color='#424040' face='Arial, Helvetica, sans-serif'>En CIAF creemos en el estudiante. Cuidar tu crédito es garantizar que mas personas puedan acceder a una financiación directa</font><br>
                </td>
            </tr>
            </table>
        </div>		
        <table width='100%' border='0' cellpadding='10' cellspacing='0' align='center' bgcolor='#fff'>
            <tr>
                <td bgcolor='#e6e6e6'>
                <font size='2px' color='#7f7f7f' face='Arial, Helvetica, sans-serif'>
                    Usted ha recibido este mensaje como respuesta automática del sistema al ser pre-aprobada su solicitud de financiación, si ha recibido este mensaje por error, por favor haga caso omiso. Si desea reportar algun error puede escribir a 
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
    }
    echo set_template("Christopher Arboleda", "Diseño web" , "0", "0", "0");
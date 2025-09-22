<?php 
function setTemplate($identificacion, $programa, $clave) {
    return <<<MESSAGE
    <div style='background-color: #f2f2f2'>
        <div style='width:90%; padding:2%; margin:auto'>
            <table width='90%' border='0' cellpadding='0' cellspacing='0' align='center'>
                <tr>
                    <td align='right'>
                        <br><br>
                        <a href='https://www.facebook.com/ComunidadCIAF' target='_blank'>
                            <img src='https://www.ciaf.digital/public/img/oncenter/r_face.png' alt='Facebook'>
                        </a>
                        <a href='https://twitter.com/ComunidadCIAF' target='_blank'>
                            <img src='https://www.ciaf.digital/public/img/oncenter/r_twitter.png' alt='Twitter'>
                        </a>
                        <a href='https://www.youtube.com/channel/UCgaRVYt3yzzlhbLZ1vhxCUQ' target='_blank'>
                            <img src='https://www.ciaf.digital/public/img/oncenter/r_youtube.png' alt='YouTube'>
                        </a>
                        <a href='https://www.ciaf.edu.co' target='_blank'>
                            <img src='https://www.ciaf.digital/public/img/oncenter/r_www.png' alt='Website'>
                        </a>
                    </td>
                </tr>
            </table>
            <br>
            <table width='96%' border='0' cellpadding='0' cellspacing='0' align='center' bgcolor='#fff'>
                <tr>
                    <td>
                        <table width='100%' border='0'>
                            <tr>
                                <td>
                                    <center>
                                        <br><img src='https://www.ciaf.digital/public/img/oncenter/logo_mailing.png' alt='Logo'><br>
                                    </center>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table width='100%' border='0' cellpadding='0' cellspacing='0' align='center' bgcolor='#fff'>
                <tr>
                    <td>
                        <center>
                            <br><img src='https://www.ciaf.digital/public/img/oncenter/banner-mailing.jpg' width='100%' alt='Banner'>
                        </center>
                    </td>
                </tr>
            </table>
            <table width='96%' cellpadding='10' cellspacing='0' align='center' border='0' bgcolor='#fff'>
                <tr>
                    <td width='60px'>
                        <font size='3px' color='#064789' face='Arial, Helvetica, sans-serif'><b>Programa</b></font>
                    </td>
                    <td>$programa</td>
                    <td>
                        <img src='https://www.ciaf.digital/public/img/oncenter/aceptado_peque.png' alt='Aceptado'>
                    </td>
                </tr>
                <tr>
                    <td width='60px'>
                        <font size='3px' color='#064789' face='Arial, Helvetica, sans-serif'><b>Usuario</b></font>
                    </td>
                    <td>$identificacion</td>
                    <td>
                        <img src='https://www.ciaf.digital/public/img/oncenter/aceptado_peque.png' alt='Aceptado'>
                    </td>
                </tr>
                <tr>
                    <td width='60px'>
                        <font size='3px' color='#064789' face='Arial, Helvetica, sans-serif'><b>Clave</b></font>
                    </td>
                    <td>$clave</td>
                    <td>
                        <img src='https://www.ciaf.digital/public/img/oncenter/aceptado_peque.png' alt='Aceptado'>
                    </td>
                </tr>
                <tr>
                    <td colspan='3'>
                        <center>
                            <a href='https://ciaf.digital/dale-un-giro-a-tu-vida/' target='_blank'>
                                <img src='https://www.ciaf.digital/public/img/oncenter/mensaje-mailing.jpg' alt='Mensaje'>
                            </a>
                        </center>
                    </td>
                </tr>
                <tr>
                    <td colspan='3'>
                        <div style='border-radius:10px;background-color:#ec2329;width:60%;padding:15px;margin:auto'>
                            <center>
                                <a href='https://ciaf.digital/dale-un-giro-a-tu-vida/' style='text-decoration:none;color:#fff;font-size:18px;font-family:tahoma' target='_blank'>Continua el proceso de Inscripción o matrícula</a>
                            </center>
                        </div>
                    </td>
                </tr>
            </table>
            <table width='100%' border='0' cellpadding='10' cellspacing='0' align='center' bgcolor='#fff'>
                <tr bgcolor='#2b7fbb'>
                    <td>
                        <font size='4px' color='#fff'>CONTACTO</font>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h2 style='color:#ec2329;font-family:Arial,Helvetica,sans-serif;margin-bottom:0px'>Llama ya y te damos más información:</h2>
                    </td>
                </tr>
                <tr>
                    <td>
                        <font size='3px' color='#064789' face='Arial, Helvetica, sans-serif'><b>Área de Información y Comunicaciones CIAF</b></font><br>
                        <font color='#7f7f7f' face='Arial, Helvetica, sans-serif'>
                            <img src='https://www.ciaf.digital/public/img/oncenter/tel.png' alt='Teléfono'> Teléfono: (57+6) 3400100<br>
                            <img src='https://www.ciaf.digital/public/img/oncenter/r_www.png' alt='Website'><a href='https://www.ciaf.edu.co' target='_blank' style='color: #0868CA'><b> www.ciaf.edu.co</b></a><br>
                            <img src='https://www.ciaf.digital/public/img/oncenter/street.png' alt='Dirección'> Carrera 14 No. 12-42 Pereira, Colombia
                        </font><br>
                    </td>
                </tr>
                <tr>
                    <td bgcolor='#e6e6e6'>
                        <font size='2px' color='#7f7f7f' face='Arial, Helvetica, sans-serif'>
                            Usted ha recibido este mensaje porque está inscrito en la base de datos de contactos de la Universidad CIAF o porque ha solicitado que se le envíe información de la Institución. Si desea darse de baja o actualizar sus datos puede escribir a
                            <a href='mailto:datospersonales@ciaf.edu.co'><font size='2px' color='#064789'><b>datospersonales@ciaf.edu.co</b></font></a>
                        </font>
                    </td>
                </tr>
            </table>
            <table width='100%' border='0' cellpadding='0' cellspacing='0' align='center' bgcolor='#fff'>
                <tr bgcolor='#064789'>
                    <td>
                        <center><br><br>
                            <a href='https://www.facebook.com/ComunidadCIAF' target='_blank'>
                                <img src='https://www.ciaf.digital/public/img/oncenter/r_face.png' alt='Facebook'>
                            </a>
                            <a href='https://twitter.com/ComunidadCIAF' target='_blank'>
                                <img src='https://www.ciaf.digital/public/img/oncenter/r_twitter.png' alt='Twitter'>
                            </a>
                            <a href='https://www.youtube.com/channel/UCgaRVYt3yzzlhbLZ1vhxCUQ' target='_blank'>
                                <img src='https://www.ciaf.digital/public/img/oncenter/r_youtube.png' alt='YouTube'>
                            </a>
                            <a href='https://www.ciaf.edu.co' target='_blank'>
                                <img src='https://www.ciaf.digital/public/img/oncenter/r_www.png' alt='Website'>
                            </a>
                        </center><br>
                    </td>
                </tr>
                <tr>
                    <td colspan='2' align='center'>
                        <br><font size='5px' color='#7f7f7f' face='Arial, Helvetica, sans-serif'><b>Emprendimiento e Innovación</b> | </font> Aprobados por el MINEDUCACIÓN<br><br>
                    </td>
                </tr>
            </table>
        </div>
    </div>
MESSAGE;
}

// $obj = setTemplate("1004681758", "programa", 24001);
// echo $obj;
?>

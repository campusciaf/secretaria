<?php

function set_template_sofi_atrasados($nombres, $valor){
return <<<MESSAGE
    <div style='background-color: #fff'>
        <div style='max-width:425px; padding:2%; margin:auto'>
            <div style='background-color: #fff'>
                <table width='100%' border='0'>
                    <tr>
                        <td>
                            <center>
                                <br>
                                <img src='http://ciaf.digital/mail/recursos/header_mail_atrasados.webp' width="100%"><br> <br>
                            </center>
                        </td>
                    </tr>
                </table>
                <table width='100%' cellpadding='10' cellspacing='0' align='center' border='0' bgcolor='#fff'>
                    <tr>
                        <td align='left' style='color: #001550; margin: 0; line-height: 36px; font-family: Oswald, sans-serif; font-size: 20px; font-weight: 900; font-style: italic; padding-left:2rem;'>
                            Hola $nombres
                        </td>
                    </tr>
                    <tr>
                        <td style='text-align: left; padding:0'>
                            <p style="margin: 0; line-height: 18px; mso-line-height-rule: exactly; font-family: Oswald, sans-serif; font-size: 15px; font-style: normal; color: #333333; padding: 0rem 4rem; transform: scaleY(1.1); text-align: justify">
                                Actualmente, presentas mora en la cuota de tu crédito educativo por valor de <b> $$valor</b>, te invitamos cordialmente a ponerte al día con tu obligación y nos ayudes a cuidar nuestro esquema de financiación que está basado en la confianza.
                            </p>
                        </td>
                    </tr>
                </table>
                <table width='100%' border='0' align='center'>
                    <tr>
                        <td>
                            <center>
                                <img src='http://ciaf.digital/mail/recursos/footer_sofi_atrasados.webp' width="100%" style="margin-top: -15px">
                            </center>
                        </td>
                    </tr>
                </table>
            </div>
            <table width='100%' border='0' cellpadding='10' cellspacing='0' align='center' bgcolor='#fff' style="margin-top: -8px">
                <tr>
                    <td bgcolor='#f4f2f2' colspan="2">
                        <font size='2px' color='#7f7f7f' face='Arial, Helvetica, sans-serif'>
                            Usted ha recibido este mensaje como respuesta automática del sistema al ser parte de nuestra comun  idad CIAF, si ha recibido este mensaje por error, por favor haga caso omiso. Si desea reportar algún error puede escribir a
                            <a href='#'>
                                <font size='2px' color='#064789'> <b> campus@ciaf.edu.co </b> </font>
                            </a> |
                            <a href='https://www.ciaf.edu.co/tratamiento_datos.php' target="_blank">
                                <font size='2px' color='#064789'><b>POLÍTICAS DE TRATAMIENTO DE DATOS</b></font>
                            </a>
                        </font>
                    </td>
                </tr>
                <tr bgcolor='#001550'>
                    <td style="padding-left: 30px;">
                        <a href='https://es-la.facebook.com/ComunidadCIAF/' target='_blank'>
                            <img src='https://www.ciaf.edu.co/mercadeo/imagenes/r_face.png'></a>
                        <a href='https://twitter.com/ComunidadCIAF' target='_blank'>
                            <img src='https://www.ciaf.edu.co/mercadeo/imagenes/r_twitter.png'></a>
                        <a href='https://www.youtube.com/channel/UCgaRVYt3yzzlhbLZ1vhxCUQ' target='_blank'>
                            <img src='https://www.ciaf.edu.co/mercadeo/imagenes/r_youtube.png'></a>
                        <a href='https://www.ciaf.edu.co/inicio.php' target='_blank'>
                            <img src='https://www.ciaf.edu.co/mercadeo/imagenes/r_www.png'></a>
                        <br>
                    </td>
                    <td>
                        <p style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;mso-line-height-rule: exactly;font-family: arial, 'helvetica neue', helvetica, sans-serif;line-height: 21px;color: #333333;font-size: 14px;">
                            <a target="_blank" href="https://ciaf.edu.co" style="-webkit-text-size-adjust: none; -ms-text-size-adjust: none; mso-line-height-rule: exactly; text-decoration: none; color: #efefef; font-size: 14px;">
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
//echo set_template_sofi_atrasados("David", "$ 300.000");
?>
<?php

function set_templateComunicadoDocente($mensaje, $docente)
{

    return <<<MESSAGE
    <div style='background-color: #f2f2f2'>
        <div style='width:90%; padding:2%; margin:auto'>
            <table width='90%' border='0' cellpadding='0' cellspacing='0' align='center'>
    
            </table>
            <br>
            <div style='background-color: #fff'>
                <table width='100%' border='0'>
                </table>
                <table width='81%' border='0' align='center'>
                    <!-- <tr height='0'>
                        <td align='right' style='padding: 0'>
                            <br><br>
                            <a href='https://es-la.facebook.com/ComunidadCIAF/' target='_blank'><img
                                    src='https://www.ciaf.edu.co/landing/public/img/facebook.png'></a>
                            <a href='https://www.instagram.com/comunidadciaf/' target='_blank'><img height="32px"
                                    width="32px" src='https://www.ciaf.edu.co/landing/public/img/instagram.png'></a>
                            <a href='https://www.youtube.com/channel/UCgaRVYt3yzzlhbLZ1vhxCUQ' target='_blank'><img
                                    src='https://www.ciaf.edu.co/landing/public/img/youtube.png'></a>
                            <br><br>
                        </td>
                    </tr> -->
                </table>
                <table class="texto" width='100%' cellpadding='20' cellspacing='0' align='center' border='0' bgcolor='#fff'>
                  <tr>
                    <td align="center"><h2>Este es un mensaje generado por el sistema, no contestar</h2></td>
                  </tr>
                    <tr>
                        <td align='left'>
    
                            <font size='4px' face='Arial, Helvetica, sans-serif'><b class="nombre_bienvenida">Hola Estudiante <br>Docente: $docente<b></font>
                        </td>
                    </tr>
                    <tr>
                        <td align='left'>
                            <font size='3px' face='Arial, Helvetica, sans-serif'>$mensaje</font>
                        </td>
                    </tr>
                    
                </table>
            </div>
            <table width='100%' border='0' cellpadding='10' cellspacing='0' align='center' bgcolor='#fff'>
    
                <tr>
                    <td bgcolor='#e6e6e6' style='text-align: center;'>
                        <font size='2px' color='#7f7f7f' face='Arial, Helvetica, sans-serif'>
                            Programas Profesional Universitarios por ciclos propedéuticos. Especializaciones a nivel de
                            posgrado. Vigilada Ministerio de Educación.SNIES 4825 <br>
                            <a style='color:#7f7f7f;' href="http://ciad.edu.co" target="_blank"
                                rel="noopener noreferrer">www.ciaf.edu.co</a> / contacto@ciaf.edu.co / Carrera 6 No 24-56
                            Pereira, Colombia
                        </font>
                    </td>
                </tr>
            </table>
    
            <table width='100%' border='0' cellpadding='0' cellspacing='0' align='center' bgcolor='#fff'>
                <tr bgcolor='#064789'>
                    <td>
                        <center>
    
                        </center>
                        <br>
                    </td>
                </tr>
            </table>
        </div>
    </div>
MESSAGE;

}

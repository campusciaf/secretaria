<?php

function template_reporte_faltas_directores( $usuario_nombre_director, $nombre_escuelas, $nombres_programas, $faltas_programas)
{
    $tabla_nombres_programas = "<table border='1' cellpadding='5' cellspacing='0' style='width:100%; border-collapse:collapse;'>";
    $tabla_nombres_programas .= "<thead><tr><th>Nombre del Programa</th><th>Faltas Reportadas</th></tr></thead><tbody>";
    foreach ($nombres_programas as $index => $programa) {
        $tabla_nombres_programas .= "<tr>";
        $tabla_nombres_programas .= "<td>" . $programa . "</td>";
        if (isset($faltas_programas[$index]) && $faltas_programas[$index] > 0) {
            $tabla_nombres_programas .= "<td>" . $faltas_programas[$index] . "</td>";
        } else {
            $tabla_nombres_programas .= "<td>No hay faltas reportadas esta semana</td>";
        }
        $tabla_nombres_programas .= "</tr>";
    }

    $tabla_nombres_programas .= "</tbody></table>";

    return <<<MESSAGE
    <div style='background-color: #fff'>
        <div style='max-width:600px; padding:2%; margin:auto'>
            <div style='background-color: #fff'>
                <table width='100%' border='0'>
                    <tr>
                        <td>
                            <center>
                                <br>
                                <img src='https://ciaf.digital/mail/recursos/logo_ciaf.jpg' width="30%"><br><br>
                            </center>
                        </td>
                    </tr>
                </table>
                <table width='100%' cellpadding='10' cellspacing='0' align='center' border='0' bgcolor='#fff'>
                    <tr>
                        <td align='left' style='color: #001550; margin: 0; line-height: 36px; font-family: Oswald, sans-serif; font-size: 20px; font-weight: 900; font-style: italic; padding-left:2rem;'>
                            Hola $usuario_nombre_director,
                        </td>
                    </tr>
                    <tr>
                        <td style='text-align: left; padding:0'>
                            <p style="margin: 0; line-height: 24px; mso-line-height-rule: exactly; font-family: Oswald, sans-serif; font-size: 15px; font-style: normal; color: #333333; padding: 1rem 4rem; transform: scaleY(1.1); text-align: justify">
                                A continuación, se mostrará su reporte semanal de inasistencias correspondientes a los programas asignados a la Escuela de <b>$nombre_escuelas</b>. En el reporte encontrará el detalle del resumen por programa:
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style='text-align: left; padding:0'>
                            $tabla_nombres_programas
                        </td>
                    </tr>
                    
                </table>
                
            </div>
            <table width='100%' border='0' cellpadding='10' cellspacing='0' align='center' bgcolor='#fff' style="margin-top: 40px">
                <tr>
                    <td bgcolor='#f4f2f2' colspan="2" style="padding: 1rem; line-height: 20px;" >
                        <font size='2px' color='#7f7f7f' face='Arial, Helvetica, sans-serif'>
                            Usted ha recibido este mensaje como respuesta automática del sistema al ser parte de nuestra comunidad CIAF. Si ha recibido este mensaje por error, por favor haga caso omiso. Si desea reportar algún error puede escribir a
                            <a href='#'>
                                <font size='2px' color='#064789'><b>campus@ciaf.edu.co</b></font>
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
                            <img src='https://ciaf.digital/public/img/facebook.png' width="6%"></a>
                        <a href='https://twitter.com/ComunidadCIAF' target='_blank'>
                            <img src='https://ciaf.digital/public/img/logo_twitter.png' width="6%"></a>
                        <a href='https://www.youtube.com/channel/UCgaRVYt3yzzlhbLZ1vhxCUQ' target='_blank'>
                            <img src='https://ciaf.digital/public/img/youtube.png' width="6%"></a>
                        <a href='https://www.ciaf.edu.co/inicio.php' target='_blank'>
                            <img src='https://ciaf.digital/public/img/r_www.png' width="6%"></a>
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

// $nombres_programas = [
//     "Nivel 1 - Técnica profesional en programación de software",
//     "Nivel 2 - Tecnología en desarrollo de software",
//     "Nivel 3 - Profesional en ingeniería de software",
//     "Nivelatorio Tecnología en Programación",
//     "Nivelatorio Ingeniería de Software - SENA"
// ];

// // Ejemplo de faltas asociadas a los programas
// $faltas_programas = [5, 2, 0, 3, 0];

// echo template_reporte_faltas_directores("Luis Ariosto Serna", "Ingeniería", $nombres_programas, $faltas_programas);

?>

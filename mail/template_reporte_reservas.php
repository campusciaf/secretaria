<?php

function template_reporte_reservas($nombres,$fechas, $horas, $detalles)
{
    $tabla_detalle = "
    <table width='95%' border='1' cellpadding='8' cellspacing='0' align='center' style='border-collapse: collapse; font-family: Arial, sans-serif; margin-top: 1rem'>
        <thead>
            <tr bgcolor='#001550' style='color: #fff; text-align: left;'>
                <th>Nombre</th>
                <th>Fecha de Reserva</th>
                <th>Hora</th>
                <th>Motivo de Reserva</th>
            </tr>
        </thead>
        <tbody>";
    $total = count($nombres);
    for ($i = 0; $i < $total; $i++) {
        $nombre = $nombres[$i];
        $fecha = $fechas[$i];
        $hora = $horas[$i];
        $detalle = $detalles[$i];

        $tabla_detalle .= "
            <tr>
                <td>{$nombre}</td>
                <td>{$fecha}</td>
                <td>{$hora}</td>
                <td>{$detalle}</td>
            </tr>
        ";
    }

    $tabla_detalle .= "</tbody></table>";
    return <<<MESSAGE
    <div style='background-color: #fff'>
        <div style='max-width:700px; padding:2%; margin:auto'>
            <table width='100%' border='0'>
                <tr>
                    <td>
                        <center>
                            <img src='https://ciaf.digital/mail/recursos/logo_ciaf.jpg' width="30%"><br><br>
                        </center>
                    </td>
                </tr>
            </table>
            <table width='100%' cellpadding='10' cellspacing='0' align='center' border='0' bgcolor='#fff'>
                <tr>
                    <td style='text-align: left; padding:0'>
                        <p style="font-family: Oswald, sans-serif; font-size: 15px; color: #333333; padding: 1rem 4rem; text-align: justify">
                            A continuación se muestra el reporte general de reservas registradas:
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        {$tabla_detalle}
                    </td>
                </tr>
            </table>

        
            <table width='100%' border='0' cellpadding='10' cellspacing='0' align='center' bgcolor='#fff' style="margin-top: 40px">
                <tr>
                    <td bgcolor='#f4f2f2' colspan="2" style="padding: 1rem;">
                        <font size='2px' color='#7f7f7f' face='Arial, Helvetica, sans-serif'>
                            Usted ha recibido este mensaje como respuesta automática del sistema al ser parte de nuestra comunidad CIAF. Si ha recibido este mensaje por error, por favor haga caso omiso. Si desea reportar algún error puede escribir a
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

// $nombres = ["Prueba 1", "Prueba 2"];
// $fechas = ["2025-07-09", "2025-07-14"];
// $horas = ["16:00", "12:00"];
// $detalles = ["FRISBY", "Lanzamiento Semillero Emprendimiento"];

// // Mostrar el resultado en el navegador
// echo template_reporte_reservas($nombres, $fechas, $horas, $detalles);


?>

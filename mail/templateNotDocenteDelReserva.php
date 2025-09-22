<?php
function template_a_docente_eliminacion_reserva($nombre_docente, $espacio, $fecha_hora)
{
return <<<MESSAGE
<div style='background-color: #fff; max-width:600px; padding:2%; margin:auto'>
    <center>
        <br>
        <img src='https://ciaf.digital/mail/recursos/logo_ciaf.jpg' width='30%'><br><br>
    </center>
    <div style='color: #c42929ff; font-family: Oswald, sans-serif; font-size: 20px; font-weight: 900; padding-left:2rem;'>
        Reserva de espacio y laboratorios
    </div>
    <p style='font-family: Oswald, sans-serif; font-size: 15px; color: #333; padding: 1rem 4rem; text-align: justify;'>
        Estimado(a) $nombre_docente,<br><br>
        Le informamos que la reserva realizada para <b>$espacio</b> en la fecha <b>$fecha_hora</b> ha sido eliminada, debido a que la <b>coordinación del programa programó una clase en ese mismo espacio.</b><br><br>
        En caso de que necesite reprogramar o gestionar otra reserva, puede hacerlo a través de [plataforma o procedimiento correspondiente]. 
        Si requiere apoyo adicional, quedamos atentos para asistirle.<br><br>
        Agradecemos su comprensión.
    </p>

    <div style='padding: 1rem; background-color: #f4f2f2; line-height: 20px; color: #7f7f7f;'>
        Usted ha recibido este mensaje como respuesta automatica del sistema al ser parte de nuestra comunidad CIAF,
        si ha recibido este mensaje por error, por favor haga caso omiso. Si desea reportar algun error puede escribir a:
        
        <a href='mailto:campus@ciaf.edu.co' style='color: #064789;'><b>campus@ciaf.edu.co</b></a> |
        <a href='https://www.ciaf.edu.co/tratamiento_datos.php' target='_blank' style='color: #064789;'><b>POLÍTICAS DE TRATAMIENTO DE DATOS</b></a>
    </div>
    <div style='background-color: #001550; padding: 10px; color: #fff; text-align: center;'>
        <a href='https://es-la.facebook.com/ComunidadCIAF/' target='_blank'><img src='https://ciaf.digital/public/img/facebook.png' width='6%'></a>
        <a href='https://twitter.com/ComunidadCIAF' target='_blank'><img src='https://ciaf.digital/public/img/logo_twitter.png' width='6%'></a>
        <a href='https://www.youtube.com/channel/UCgaRVYt3yzzlhbLZ1vhxCUQ' target='_blank'><img src='https://ciaf.digital/public/img/youtube.png' width='6%'></a>
        <a href='https://www.ciaf.edu.co/inicio.php' target='_blank'><img src='https://ciaf.digital/public/img/r_www.png' width='6%'></a><br>
        <a href='https://ciaf.edu.co' style='color: #efefef; font-size: 14px;'>www.ciaf.edu.co</a>
    </div>
</div>
MESSAGE;
}

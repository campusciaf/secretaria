<?php

function set_template($nombre,$id_egresados_caracterizacion){
return <<<MESSAGE
    <div style='background-color: #fff'>
        <div style='max-width:425px; padding:2%; margin:auto'>
            <div style='background-color: #fff'>

                <table width='100%' cellpadding='10' cellspacing='0' align='center' border='0' bgcolor='#fff'>
                    <tr>
                        <td><img src="https://ciaf.digital/public/img/header-rifa.webp" width="100%"></td>
                    </tr>
                    <tr>
                        <td align='center'>
                            <font size='4px' color='#064789' face='Arial, Helvetica, sans-serif'><b>Ya haces parte del sorteo. Esto apenas comienza…</b></font>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <center>
                                
                                <p>Hola,$nombre </p>

                                <p>¡Gracias por actualizar tus datos! Para nosotros es un orgullo seguir conectados contigo.
                                Tu historia en CIAF no se detiene… y este paso es solo el comienzo de lo que viene.</p>

                                <p>Revisa aquí tu número para participar en el sorteo del iPhone 📱👇</p>
                                <p style="font-size: 56px">$id_egresados_caracterizacion</p>

                                <p>Nos emociona saber que seguimos en el mismo equipo.
                                #SubeTuNivel #OrgulloCIAF</p>
                            
                                <img src="https://ciaf.digital/public/img/footer-rifa.webp" width="100%">
        
                            </center>

                        </td>
                    </tr>
                </table>
            </div>
            <table width='100%' border='0' cellpadding='10' cellspacing='0' align='center' bgcolor='#fff'>
                <tr>
                    <td bgcolor='#f4f2f2'>
                        <font size='2px' color='#7f7f7f' face='Arial, Helvetica, sans-serif'>
                            Usted ha recibido este mensaje como respuesta automática del sistema al ser parte de nuestra
                            comunidad CIAF , si ha recibido este mensaje por error, por favor haga caso omiso. Si desea
                            reportar algun error puede escribir a
                            <a href='#'>
                                <font size='2px' color='#064789'><b>campus@ciaf.edu.co</b></font>
                            </a> |
                            <a href='https://www.ciaf.edu.co/tratamiento_datos.php' target="_blank">
                                <font size='2px' color='#064789'><b>POLITICA DE TRATAMIENTO DE DATOS</b></font>
                            </a>
                        </font>
                    </td>
                </tr>
            </table>

        </div>
    </div>
MESSAGE;
}

?>
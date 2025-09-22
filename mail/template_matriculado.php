<?php

function set_template_matriculado($credencial_login,$identificacion_clave) {
return <<<MESSAGE
<div style='background-color: #f2f2f2; font-family: Arial, Helvetica, sans-serif; color: #444444;'>
    <div style='width:90%; padding:2%; margin:auto; max-width: 700px;'>
        <table width='100%' border='0' cellpadding='0' cellspacing='0' align='center' bgcolor='#fff'>
            <tr>
                <td style='text-align:center; padding: 20px 0;'>
                    <img src='https://ciaf.digital/public/img/oncenter/logo_nuevo.png' alt='Logo CIAF' style='max-width: 150px;'>
                </td>
            </tr>
            <tr>
                <td>
                    <img src='https://ciaf.digital/public/img/oncenter/desdehoy.png' alt='Banner Bienvenido CIAF' style='width:100%; height:auto;'>
                </td>
            </tr>
            <tr>
                <td style='padding: 20px; text-align:center;'>
                   <h2 style='color:#444444; font-weight: bold; margin-bottom: 10px;'>¡Bienvenido a CIAF!</h2><br>
                    <p style='font-style: italic; color:#666666; margin-top:0;'>
                    Nos alegra mucho que hayas elegido ser parte de esta comunidad.<br>
                    Estás por comenzar una experiencia retadora, creativa y tranformadora.</p>
                    <br>
                    <p style='font-style: italic; color:#666666; margin-top:0;'>
                    Decidiste soñar y diste el paso correcto para lograrlo.</p>
                    <p style='font-style: italic; color:#666666; margin-top:0;'>
                    A contuniación, te compartimos los datos de accesso a tu plataforma:</p>
                     <p style='color:#444444; margin: 5px 0;'><strong>Link:</strong> <a href='https://ciaf.digital/' target='_blank' style='color:#444444; text-decoration:underline;'>CIAF Virtual</a></p>
                    <table align='center' style='margin: 20px auto; font-size: 16px; color:#444444;'>
                        <tr>
                            <td style='padding: 5px 10px; font-weight: bold; color:#444444;'>Usuario:</td>
                            <td style='padding: 5px 10px;'> $credencial_login</td>
                        </tr>
                        <tr>
                            <td style='padding: 5px 10px; font-weight: bold; color:#444444;'>Contraseña:</td>
                            <td style='padding: 5px 10px;'> $identificacion_clave</td>
                        </tr>
                    </table>
                    <p style='color:#444444;'>!Estamos aquí para lo que necesites!</p>
                    <p><a href='https://www.ciaf.edu.co/inicio' target='_blank' style='color:#444444; text-decoration:none;'>https://www.ciaf.edu.co/inicio</a></p>
                </td>
            </tr>
            <tr>
                <td>
                    <img src='https://ciaf.digital/public/img/oncenter/formate.png' alt='Fórmate con propósito' style='width:100%; height:auto;'>
                </td>
            </tr>
        </table>
    </div>
</div>

MESSAGE;
}

// echo set_template_matriculado("ja.perez30@gmail.com", "1088019498");

?>

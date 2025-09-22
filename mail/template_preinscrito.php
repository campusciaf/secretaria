<?php

function set_template_preinscrito($identificacion, $clave) {
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
                    <img src='https://ciaf.digital/public/img/oncenter/bienvenido.png' alt='Banner Bienvenido CIAF' style='width:100%; height:auto;'>
                </td>
            </tr>
            <tr>
                <td style='padding: 20px; text-align:center;'>

                 <h2 style='color:#444444; font-weight: bold; margin-bottom: 10px;'>¿Estás listo para iniciar tu vida universitaria y transforma tu futuro?</h2>
                    <p style='font-style: italic; color:#666666; margin-top:0;'>Te invitamos a que diligencies la información de tu perfil para conocerte un poco más:</p>
                    <p style='color:#444444;'>Ingresa con los siguientes datos:</p>
                    <table align='center' style='margin: 20px auto; font-size: 16px; color:#444444;'>
                 
                    <p style='color:#444444; margin: 5px 0;'><strong>Usuario:</strong> $identificacion</p>
                    <p style='color:#444444; margin: 5px 0;'><strong>Contraseña:</strong> $clave</p>
                    <p style='color:#444444; margin: 20px 0;'>A este link:</p>
                    <p style='color:#444444;'><a href='https://ciaf.edu.co/onlogin' target='_blank' style='color:#444444; text-decoration:underline;'>https://ciaf.edu.co/onlogin</a></p>
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

// echo set_template_preinscrito("93082713128", "60618");

?>

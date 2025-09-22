<?php 
require_once "../modelos/Restaurar_contrasena.php";
require "../mail/send.php";
require "../mail/template_restablecer_clave.php";   
$restaurar = new Restablecer();
switch ($_GET['op']) {
    case 'consultaEstudiante':
        // datos que llegan del post.
        $cedula = $_POST["dato"];
        $tipo_usuario = $_POST["ubicacion"];
        $seleccion_nav = $_POST["seleccion_nav"];
        //consulta para buscar el usuario por correo o por cedula. y definir el roll
        $registro = $restaurar->consultaEstudiante($cedula, $tipo_usuario, $seleccion_nav);
        
        if(is_array($registro)){
            $data = array("exito" => 1, "info" => $registro);
        }else{
            $data = array("exito" => 0, "info" => "Usuario no existe.");
        }
        echo json_encode($data);
        break;
    case 'restablecer':
        $cedula = isset($_POST['global_cedula'])?$_POST['global_cedula']:"";
        $tipo_usuario = isset($_POST['global_id_ubicacion'])?$_POST['global_id_ubicacion']:"";
        $enviar_correo = isset($_POST['enviar_correo'])?$_POST['enviar_correo']:"";
        $correo_electronico = isset($_POST['global_usuario_login'])?$_POST['global_usuario_login']:"";
        $id = !empty($_POST['id_usuario_global']) ? $_POST['id_usuario_global'] : (!empty($_POST['global_id_credencial']) ? $_POST['global_id_credencial'] : "");

        $rspta = $restaurar->restablecerContrasena($id, $cedula, $tipo_usuario);
        if ($rspta) {
            $data = array("exito" => "1", "info" => "La contraseña se restablecio correctamente") ;
            if($enviar_correo == 1){
                $mensaje = set_template_restablecer_clave($correo_electronico, $cedula);
                enviar_correo($correo_electronico, "Cambio de contraseña", $mensaje);
            }   
        } else {
            $data = array("exito" => "0", "info" => "Error al restablecer la contraseña") ;
        }
        echo json_encode($data);
        break;
}
?>
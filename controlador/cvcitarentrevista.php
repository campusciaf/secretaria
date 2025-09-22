<?php

session_start();

require_once "../modelos/CvUsuario.php";
require_once "../cv/mail/send.php";
require_once "../cv/mail/template.php";
$usuario=new CvUsuario();
$error_vacios = Array("estatus"=>0,"valor"=>"hay campos vacios, debes llenarlos todos");
$id_usuario_cv = isset($_SESSION['id_usuario_cv'])?$_SESSION['id_usuario_cv']:"";
if(empty($id_usuario_cv)){die(json_encode(Array("estatus" => 0,"valor" => "Tu sesión ha caducado, Reinicia la pagina")));}
$nombre_usuario = isset($_POST["nombre_usuario"])? limpiarCadena($_POST["nombre_usuario"]):die(json_encode($error_vacios));
$celular_usuario = isset($_POST["celular_usuario"])? $_POST["celular_usuario"]:die(json_encode($error_vacios));
$mi_correo_electronico = isset($_POST["mi_correo_electronico"])?limpiarCadena($_POST["mi_correo_electronico"]):die(json_encode($error_vacios));
$correo_electronico = isset($_POST["correo_electronico"])? limpiarCadena($_POST["correo_electronico"]):die(json_encode($error_vacios));
$direccion_entrevista = isset($_POST["direccion_entrevista"])? limpiarCadena($_POST["direccion_entrevista"]):die(json_encode($error_vacios));
$fecha_entrevista = isset($_POST["fecha_entrevista"])? limpiarCadena($_POST["fecha_entrevista"]):die(json_encode($error_vacios));
$hora_entrevista = isset($_POST["hora_entrevista"])? limpiarCadena($_POST["hora_entrevista"]):die(json_encode($error_vacios));
$comentario_entrevista = isset($_POST["comentario_entrevista"])? limpiarCadena($_POST["comentario_entrevista"]):"";

if($nombre_usuario == "" || $celular_usuario == "" || $mi_correo_electronico=="" || $correo_electronico == "" || $direccion_entrevista == "" ||$fecha_entrevista=="" || $hora_entrevista==""){
    die(json_encode($error_vacios));
}

switch ($_GET["op"]){
	case 'citar_entrevista':
        $rspta=$cv_usuario->insertar_cita($nombre_usuario,$celular_usuario,$mi_correo_electronico,$correo_electronico,$direccion_entrevista,$fecha_entrevista,$hora_entrevista, $comentario_entrevista, $id_usuario_cv);
        if($rspta) {
            $mensaje = set_template($nombre_usuario,$celular_usuario,$mi_correo_electronico, $fecha_entrevista, $hora_entrevista, $direccion_entrevista,$comentario_entrevista);
            if(enviar_correo($correo_electronico,"Entrevista CIAF",$mensaje)){
                $inserto = Array(
                    "estatus" => 1,
                    "valor" => "Cita Agendada con exito"
                );
                echo json_encode($inserto);     
            }else{
                $inserto = Array(
                    "estatus" => 1,
                    "valor" => "Error al enviar el correo"
                );
                echo json_encode($inserto);
            }
        }else{
            $inserto = Array(
                "estatus" => 0,
                "valor" => "Usuario no se pudo actualizar"
            );
            echo json_encode($inserto); 
        }
	break;
}

?>
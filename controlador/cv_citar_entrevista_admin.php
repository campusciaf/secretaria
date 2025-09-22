<?php

session_start();

require_once "../modelos/CvAdmin.php";
require_once "../mail/send.php";
require_once "../mail/template_admin.php";
$usuario=new CvAdmin();
$error_vacios = Array("estatus"=>0,"valor"=>"hay campos vacios, debes llenarlos todos");

$id_usuario = isset($_SESSION['id_usuario'])?$_SESSION['id_usuario']:"";


if(empty($id_usuario)){die(json_encode(Array("estatus" => 0,"valor" => "Tu sesión ha caducado, Reinicia la pagina")));}



$cvadministrativos_correo_cv = isset($_POST["cvadministrativos_correo_cv"])? limpiarCadena($_POST["cvadministrativos_correo_cv"]):die(json_encode($error_vacios));

$cvadministrativos_entrevista_direccion = isset($_POST["cvadministrativos_entrevista_direccion"])? limpiarCadena($_POST["cvadministrativos_entrevista_direccion"]):die(json_encode($error_vacios));

$cvadministrativos_entrevista_fecha = isset($_POST["cvadministrativos_entrevista_fecha"])? limpiarCadena($_POST["cvadministrativos_entrevista_fecha"]):die(json_encode($error_vacios));

$cvadministrativos_entrevista_hora = isset($_POST["cvadministrativos_entrevista_hora"])? limpiarCadena($_POST["cvadministrativos_entrevista_hora"]):die(json_encode($error_vacios));

$cvadministrativos_entrevista_comentario = isset($_POST["cvadministrativos_entrevista_comentario"])? limpiarCadena($_POST["cvadministrativos_entrevista_comentario"]):"";
$id_cvadministrativos_cv = isset($_POST["id_cvadministrativos_cv"])? limpiarCadena($_POST["id_cvadministrativos_cv"]):"";


if($cvadministrativos_correo_cv == "" || $cvadministrativos_entrevista_direccion == "" ||$cvadministrativos_entrevista_fecha =="" || $cvadministrativos_entrevista_hora==""){
    die(json_encode($error_vacios));
}


switch ($_GET["op"]){
	case 'citar_entrevista':
        $rspta=$usuario->insertar_cita($cvadministrativos_entrevista_direccion, $cvadministrativos_entrevista_fecha, $cvadministrativos_entrevista_hora, $cvadministrativos_entrevista_comentario,$id_cvadministrativos_cv,$id_usuario);
        if($rspta) {
            $mensaje = set_template($cvadministrativos_entrevista_direccion, $cvadministrativos_entrevista_fecha, $cvadministrativos_entrevista_hora, $cvadministrativos_entrevista_comentario);
            
            if(enviar_correo($cvadministrativos_correo_cv,"Entrevista CIAF",$mensaje)){
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
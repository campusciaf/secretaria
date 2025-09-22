<?php
require_once "../modelos/Recordatoriodocente.php";
require ('../public/mail/sendmail.php');
require ('../public/mail/template.php');

$consulta=new Consulta();

switch ($_GET['op']) {
    case 'consulta':
        $jornada = $_POST['jornada'];
        $datos = $consulta->listar($jornada);
        $data['conte'] = '';

        for ($i=0; $i < count($datos); $i++) {
            $docen = $consulta->correodocete($datos[$i]['id_docente']);
            if (($i + 1) < count($datos)) {
                if ($docen['usuario_email_ciaf'] != "") {
                    $data['conte'] .= $docen['usuario_email_ciaf'].',';
                }
            }else{
                if ($docen['usuario_email_ciaf'] != "") {
                    $data['conte'] .= $docen['usuario_email_ciaf'];
                }
            }
            
        }

        echo json_encode($data);

        break;
    case 'enviar':
        $correos = $_POST['correos'];
        $text = $_POST['text'];
        $asunto = $_POST['asunto'];
        $corr = explode(",", $correos);

        
        $mensaje2 = set_templatedocente($text);
              
        for ($i=0; $i < count($corr); $i++) {

            if (enviar_correo($corr[$i],$asunto,$mensaje2)) {
                $data['status'] = "ok";
            } else {
                $data['status'] = "error";
            }
            

        }

        echo json_encode($data);

        break;
}

?>
<?php
require_once "../modelos/Mailing.php";
require ('../public/mail/sendPlantillas.php');
require ('../public/mail/templatePlantillas.php');
$mailing = new Mailing();
switch($_GET['op']){
    case 'listar':
        $datos = $mailing->listar();
        $data['conte'] = '<h3 class="mt-3 text-right">Diseños Recomendados</h3>';
        $data['conte'] .= '<div class="row">
                <div class="col-xs-12 col-sm-5 col-md-2 col-lg-2">
                    <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header justify-content-center">
                            <strong class="text-center">Crear Nueva</strong>
                        </div>
                        <div class="toast-body">
                            <img src="../public/img/p_1.png" width="100%"><br>
                            <button type="button" class="btn btn-success btn-xs btn-block " onclick="crear()" title="Crear plantilla">
                                <i class="fa fa-plus"></i>
                            </button>  
                        </div>
                    </div>
                </div>';
        for($i=0; $i < count($datos); $i++){
            $num = explode(" ", $datos[$i]['titulo']);
            $data['conte'] .= '<div class=" col-xs-12 col-sm-5 col-md-2 col-lg-2">
                <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header justify-content-center">
                        <strong class="text-center">'.$datos[$i]['titulo'].'</strong>
                    </div>
                    <div class="toast-body">
                        <img src="../public/img/estructura'.$num[1].'.png" width="100%"><br>
                        <div class="btn-group col-12" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-primary btn-xs" onclick="duplicar_estructura('.$datos[$i]['id'].')" title="Duplicar plantilla">
                                <i class="fa fa-copy"></i>
                            </button>
                            <button type="button" class="btn btn-success btn-xs" onclick="visualizar_estructura('.$datos[$i]['id'].')" title="Ver plantilla">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>';
        }
        $data['conte'] .= '</div>';
        echo json_encode($data);
    break;
    case 'visualizar_estructura':
        $id = $_POST['id'];
        $mailing->visualizar_estructura($id);
    break;
    case 'listardise':
        $datos = $mailing->listardise();
        $data['conte'] = '<h3 class="mt-3 mb-3">Tus diseños</h3>';
        $data['conte'] .= '<div class="row">';
        for ($i=0; $i < count($datos); $i++) {
            $data['conte'] .= '
            <div class="col-xs-12 col-sm-5 col-md-2 col-lg-2">
                <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <strong class="mr-auto text-center">'.$datos[$i]['titulo'].'</strong>
                        <button type="button" class="close" onclick="eliminarplantilla('.$datos[$i]['id'].')" title="Eliminar plantilla">
                            <i class="fa-solid fa-xmark text-danger"></i>
                        </button>
                    </div>
                    <div class="toast-body">
                        <img src="../public/img/'.$datos[$i]['miniatura'].'" width="100%"><br>
                        <div class="btn-group col-12" role="group" aria-label="Basic example">
                            <a href="mailingprev.php?id='.$datos[$i]['id'].'" type="submit" class="btn btn-warning btn-xs" title="Editar">
                                <i class="fa fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-success btn-xs" onclick="enviar_cor('.$datos[$i]['id'].')" title="Enviar Mail">
                                <i class="fa fa-share-square"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>';
        }
        $data['conte'] .= '</div>';
        echo json_encode($data);
    break;
    case 'duplicar':
        $id = $_POST['id'];
        $mailing->duplicar($id);
    break;
    case 'listarPre':
        $id = $_POST['id'];
        $datos = $mailing->listarPre($id);
        echo json_encode($datos);
    break;
    case 'mostarimg':
        $data['conte'] = "";
        $ruta = "../public/mailing";
        $ruta2 = "../public/repositorios";
        $data['conte'] .= '<div class="col-12 text-center">
            <div class="card collapsed-card">
                <div class="card-header border-1">
                    <h3 class="card-title"><i class="fas fa-images"></i> Banner</h3>
                    <div class="card-tools">
                        <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body cover" style="overflow: auto;">
                    <table class="table">
                        <tr>
                            <td>
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Agregar banner</button>
                            </td>
                        </tr>';
        $directorio = opendir($ruta);
        while ($archivo = readdir($directorio)) {
            if(!($archivo == '.' || $archivo == '..')){
                $data['conte'] .= '<tr>
                    <td><img width="100%" src="'.$ruta.'/'.$archivo.'"></td>
                </tr>';
            }
        }
        $data['conte'] .= '<tr>
                        <td></td>
                    </tr></table>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>';
        $data['conte'] .= '<div class="col-12 text-center">
            <div class="card collapsed-card">
                <div class="card-header border-1">
                    <h3 class="card-title"><i class="fas fa-images"></i> Imagenes</h3>
                    <div class="card-tools">
                        <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body cover" style="overflow: auto;">
                    <table class="table">
                        <tr>
                            <td>
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal2">Agregar imagenes</button>
                            </td>
                        </tr>';
        $directorio2 = opendir($ruta2);
        while($archivo2 = readdir($directorio2)){
            if($archivo2 == '.' || $archivo2 == '..'){}
            else {
                $data['conte'] .= '<tr>
                    <td><img width="100%" src="'.$ruta2.'/'.$archivo2.'"></td>
                </tr>';
            }   
        }
        $data['conte'] .= '<tr>
                        <td></td>
                        </tr></table>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>';
        echo json_encode($data);
    break;
    case 'editar':
        $id = $_POST['id'];
        $conte = $_POST['conte'];
        $titulo = $_POST['titulo'];
        $mailing->editar($id,$conte,$titulo);
    break;
    case 'enviarMail':
        $asunto = $_POST['asunto'];
        $id = $_POST['id'];
        $correos = $_POST['correos'];
        $corr = explode(",",$correos);
        $conte = $mailing->listarPre($id);
        $mensaje2 = set_template($conte['contenido']);
        for ($i=0; $i < count($corr); $i++) { 
            if (enviar_correo($corr[$i],$asunto,$mensaje2)) {
                $data['status'] = "ok";
            } else {
                $data['status'] = "Error";
            }
        }
        echo json_encode($data);
    break;
    case 'aggbanner':
        $target_path = '../public/mailing/';
        $img1path = $target_path .  $_FILES['img']['name'];
        if(move_uploaded_file($_FILES['img']['tmp_name'], $img1path)){
            $nombre_imagen = $_FILES['img']['name'];
            $data['status'] = "ok";
        }else {
            $data['status'] = "error";
        }
        echo json_encode($data);
    break;
    case 'aggimg':
        $target_path = '../public/repositorios/';
        $img1path = $target_path .  $_FILES['img']['name'];
        if(move_uploaded_file($_FILES['img']['tmp_name'], $img1path)){
            $nombre_imagen = $_FILES['img']['name'];
            $data['status'] = "ok";
        }else {
            $data['status'] = "error";
        }
        echo json_encode($data);
    break;
    case 'eliminarplantilla':
        $id = $_POST['id'];
        $mailing->eliminarplantilla($id);
    break;
    case 'crear':
        $mailing->crear();
    break;
}
?>
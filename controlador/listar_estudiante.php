<?php

require_once "../modelos/Listar_estudiante.php";
date_default_timezone_set("America/Bogota");	

$fecha=date('Y-m-d');
$hora=date('H:i:s');

$listar = new Listar();
switch ($_GET['op']) {

    case 'listar_estudiante':
        $data= Array();
        $fecha_actualizacion="";
        $registro=$listar->listarEstudiante();

        for ($i=0;$i<count($registro);$i++){

            if (file_exists('../files/estudiantes/'.$registro[$i]['credencial_identificacion'].'.jpg')) {
                $foto = '../files/estudiantes/'.$registro[$i]['credencial_identificacion'].'.jpg';
            } else {
                $foto = '../files/null.jpg';
            }
            

        if($registro[$i]['fecha_actualizacion']==NULL){
            $fecha_actualizacion="Sin fecha";
        }else{
            
            $fecha_actualizacion=$listar->fechaesp($registro[$i]['fecha_actualizacion']);
        }
        $foto_eliminar = $registro[$i]['credencial_identificacion'];

        $genero = $registro[$i]['genero'];
        $fecha_nacimiento = $registro[$i]['fecha_nacimiento'];
        $departamento_nacimiento = $registro[$i]['departamento_nacimiento'];
        $lugar_nacimiento = $registro[$i]['lugar_nacimiento'];
        $estado_civil = $registro[$i]['estado_civil'];
        $municipio = $registro[$i]['municipio'];
        $depar_residencia = $registro[$i]['depar_residencia'];
        $muni_residencia = $registro[$i]['muni_residencia'];

        

        $tipo_documento = $registro[$i]['tipo_documento'];
        $expedido_en = $registro[$i]['expedido_en'];
        $fecha_expedicion = $registro[$i]['fecha_expedicion'];
        $id_municipio_nac = $registro[$i]['id_municipio_nac'];
        $grupo_etnico = $registro[$i]['grupo_etnico'];
        $nombre_etnico = $registro[$i]['nombre_etnico'];
        $desplazado_violencia = $registro[$i]['desplazado_violencia'];
        $conflicto_armado = $registro[$i]['conflicto_armado'];
        $departamento_residencia = $registro[$i]['departamento_residencia'];
        $tipo_residencia = $registro[$i]['tipo_residencia'];
        $zona_residencia = $registro[$i]['zona_residencia'];
        $direccion = $registro[$i]['direccion'];
        $latitud = $registro[$i]['latitud'];
        $longitud = $registro[$i]['longitud'];
        $cod_postal = $registro[$i]['cod_postal'];
        $estrato = $registro[$i]['estrato'];
        $whatsapp = $registro[$i]['whatsapp'];
        $instagram = $registro[$i]['instagram'];
        $facebook = $registro[$i]['facebook'];
        $twiter = $registro[$i]['twiter'];
        $tipo_sangre = $registro[$i]['tipo_sangre'];
        

            $data [] = array(
                '0' => '<button onclick="mostrarEstudiante('.$registro[$i]['id_credencial'].')" class="btn btn-warning btn-xs"><i class="far fa-edit"></i></button> '.$registro[$i]['credencial_identificacion'],
                '1' => $registro[$i]['credencial_apellido'].' '.$registro[$i]['credencial_apellido_2'],
                '2' => $registro[$i]['credencial_nombre'].' '.$registro[$i]['credencial_nombre_2'],
                '3' => '<div class="tooltips">'.$registro[$i]['credencial_login'].'</div>',
                '4' => '<div class="tooltips">'.$registro[$i]['email'].'</div>',
                '5' => '<div class="tooltips">'.$registro[$i]['celular'],
                //.'<span class="tooltiptext">'.$registro[$i]['telefono'].'</span> </div>'
				'6' => '<div class="tooltips">'.$registro[$i]['barrio'].'<span class="tooltiptext">'.$registro[$i]['direccion'].'</span> </div>',
                '7' => '<img src="'.$foto.'" onclick="mostrar_foto_estudiante('.$foto_eliminar.')" height="30px" width="30px">',
                '8' => ($registro[$i]['credencial_condicion'] == "1")? '<div class="tooltips">Activo<span class="tooltiptext">'.$fecha_actualizacion.'</span> </div>' :'<span  class="label label-danger">Desactivado</span>',
                '9' => $genero,
                '10' => $fecha_nacimiento,
                '11' => $departamento_nacimiento,
                '12' => $lugar_nacimiento,
                '13' => $estado_civil,
                '14' => $municipio,
                '15' => $depar_residencia,
                '16' =>$tipo_documento,         
                '17' =>$expedido_en,            
                '18' =>$fecha_expedicion,       
                '19' =>$id_municipio_nac,       
                '20' =>$grupo_etnico,           
                '21' =>$nombre_etnico,          
                '22' =>$desplazado_violencia,   
                '23' =>$conflicto_armado,       
                '24' =>$departamento_residencia,
                '25' =>$tipo_residencia,        
                '26' =>$zona_residencia,       
                '27' =>$direccion,              
                '28' =>$latitud,                
                '29' =>$longitud,               
                '30' =>$cod_postal,             
                '31' =>$estrato,               
                '32' =>$whatsapp,              
                '33' =>$instagram,              
                '34' =>$facebook,               
                '35' =>$twiter,                 
                '36' =>$tipo_sangre,            
            );                     
        }              

        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
        // echo sizeof($data);

    break;
    
    case 'mostar':
        $id = $_POST['id'];
        $listar->mostrar($id);
        break;
    case 'editar':
        $tipo_docu = $_POST['tipo_docu'];
        $lugar_expe = $_POST['lugar_expe'];
        $fecha_expe = $_POST['fecha_expe'];
        $nombre_1 = $_POST['nombre_1'];
        $id = $_POST['id'];
        $nombre_2 = $_POST['nombre_2'];
        $apellido_1 = $_POST['apellido_1'];
        $apellido_2 = $_POST['apellido_2'];
        $fe_naci = $_POST['fe_naci'];
        $de_na = $_POST['de_na'];
        $mu_na = $_POST['mu_na'];
        $co_ciaf = $_POST['co_ciaf'];
        $co_per = $_POST['co_per'];
        $cel = $_POST['cel'];
        $tele = $_POST['tele'];
        $muni = $_POST['muni'];
        $dire = $_POST['dire'];
        $barrio = $_POST['barrio'];
        $tipo_resi = $_POST['tipo_resi'];
        $zo_re = $_POST['zo_re'];
        $what = $_POST['what'];
        $ins = $_POST['ins'];
        $face = $_POST['face'];
        $twi = $_POST['twi'];

        $listar->editar($tipo_docu,$lugar_expe,$fecha_expe,$nombre_1,$id,$nombre_2,$apellido_1,$apellido_2,$fe_naci,$de_na,$mu_na,$co_ciaf,$co_per,$cel,$tele,$muni,$dire,$barrio,$tipo_resi,$zo_re,$what,$ins,$face,$twi);

        break;

        case 'mostrar_foto_estudiante':
            $foto_eliminar_est = $_POST["foto_eliminar"];
            $data[0] = "";

            $foto = '../files/estudiantes/'.$foto_eliminar_est.'.jpg' ;

            if (file_exists('../files/estudiantes/'.$foto_eliminar_est.'.jpg')) {
                $foto = '../files/estudiantes/'.$foto_eliminar_est.'.jpg';
            } else {
                $foto = '../files/null.jpg';
            }
            $data[0] .='
            
            <img src="'.$foto.'" width="150px" height="120px">'.'
            <button type="button" class="tooltip-agregar btn btn-danger btn-xs float-md-right" onclick="eliminar_foto_estudiante('.$foto_eliminar_est.')"  title="Editar Programa" data-toggle="tooltip" data-placement="top"><i class="far fa-trash-alt"></i></button>';
            echo json_encode($data);
        break;

        case 'eliminar_foto_estudiante':
            $foto_eliminar_est = $_POST["foto_eliminar_est"];
            $eliminado= unlink('../files/estudiantes/'.$foto_eliminar_est.'.jpg'); 
            echo json_encode($eliminado);
            
        break;
}


?>
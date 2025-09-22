<?php
require_once "../modelos/Quedateabrircaso.php";
$consulta = new Abrircaso();
switch ($_GET['op']){
    case 'buscar_estudiante': //traemos los datos personales del estudiante
        $dato_a_buscar = $_POST['dato_busqueda']; /*tomamos el dato enviado desde js*/
        $rsta = $consulta->consultaEstudiante($dato_a_buscar);
        if(empty($rsta)){
            $data = array(
                'exito' => '0',
                'info' => 'Revisa el documento, no se encontraron datos.'
            );
        }else{
            //verificacion de la imagen
            if (file_exists('../files/estudiantes/'.$rsta['credencial_identificacion'].'.jpg')) {
                $foto = '../files/estudiantes/'.$rsta['credencial_identificacion'].'.jpg';
            } else {
                $foto = '../files/null.jpg';
            }
            $data = array(
                'exito' => '1',
                'info' => array(
                    'id_credencial' => $rsta["id_credencial"],
                    'nombre_estudiante' => $rsta["credencial_nombre"]." ".$rsta["credencial_nombre_2"],
                    'apellido_estudiante' => $rsta["credencial_apellido"]." ".$rsta["credencial_apellido_2"],
                    'tipo_identificacion' => $rsta["tipo_documento"],
                    'numero_documento' => $rsta["credencial_identificacion"],
                    'direccion' => $rsta["direccion"],
                    'celular' => $rsta["celular"],
                    'email' => $rsta["credencial_login"],
                    'foto' => $foto,
                )
            );
            $html = "";
            $html .='<div class="row">';
            $programas = $consulta->consultaProgramas($rsta["id_credencial"]); 
            for($i =0 ; $i < count($programas);$i++){
                $html .='<div class="col-6 borde rounded">
                            <b> Programa:</b><br> <a class=" box-profiledates profile-programa">'.$programas[$i]['fo_programa'].'</a>
                            <b>Semestre:</b> <a class="pull-right box-profiledates profile-semestre">'.$programas[$i]['semestre_estudiante'].'</a>
                        </div>';
            }
            $html .='</div>';
            $data['programas'] = $html;
        }
        
        echo(json_encode($data));
    break;
    case 'buscar_casos': //traemos los casos del estudiante
        $dato_a_buscar = $_POST['dato_busqueda']; /*tomamos el dato enviado desde js*/
        $rsta = $consulta->consultaCasos($dato_a_buscar);
		$data= Array();
        //print_r($rsta);
		for($i =0 ; $i < count($rsta);$i++){
            $icon = '';
            $rst = $consulta->consulta_casos($rsta[$i]["caso_id"]);
            $rst2 = $consulta->consulta_remisiones($rsta[$i]["caso_id"]);
            if ($rst || $rst2) {
                $icon = '<a href="quedatevercaso.php?op=verC&caso='.$rsta[$i]["caso_id"].'" target="_blank" type="submit" class="btn btn-primary"> <i class="fas fa-external-link-alt"></i> </a>';
            }else {
                $icon = "<div class='text-center'><span class='badge badge-danger'>Denegado</span></div>";
            }     
            if($rsta[$i]["caso_estado"] == "Cerrado"){
                $estado = "<div class='text-center'><span class='badge badge-danger'>".$rsta[$i]["caso_estado"]."</span></div>";   
            }else{
                $estado = "<div class='text-center'><span class='badge badge-success'>".$rsta[$i]["caso_estado"]."</span></div>";
            }
			$data[]=array(
				"0"=>$estado,
				"1"=>$rsta[$i]["categoria_caso"],
				"2"=>$rsta[$i]["caso_asunto"],
				"3"=>$rsta[$i]["created_at"],
				"4"=>$rsta[$i]["updated_at"],
				"5"=>$rsta[$i]["usuario_cargo"],
				"6"=>$icon
			);
		}
		$results = array(
			"sEcho"=>1, //Información para el datatables
			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
			"aaData"=>$data);
		echo json_encode($results);
    break;
    case 'listarCategorias': //Listar categorias de casos
        $rsta = $consulta->listarCategorias();
		$data= Array();
		$categorias = Array();
        
        if(empty($rsta)){
            $data = array(
                'exito' => '0',
                'info' => 'Revisa, no se encontraron datos.'
            );
        }else{
            //print_r($rsta);
            for($i =0 ; $i < count($rsta);$i++){
                $categorias[]=array($rsta[$i]["categoria_caso"]);
            }
            $data = array(
                'exito' => '1',
                'info' => $categorias
            );
        }
		echo json_encode($data);
    break;
    case 'guardarcaso': //guardar caso del estudiante
        $id_credencial = isset($_POST["id-estudiante"])?$_POST["id-estudiante"]:die(json_encode(array('exito' => '0','info' => 'El Estudiante No Tiene Identificación.')));
        $asunto_caso = isset($_POST["asunto-nuevo-caso"])?$_POST["asunto-nuevo-caso"]:"";
        $categoria_caso = isset($_POST["categoria-caso"])?$_POST["categoria-caso"]:"";
        $fecha_caso = isset($_POST["fecha_caso"])?$_POST["fecha_caso"]:"";
        $id_usuario = isset($_SESSION["id_usuario"])?$_SESSION["id_usuario"]:die(json_encode(array('exito' => '0','info' => 'Sesión Caducada, Vuelve Ha Iniciar.')));
        $rsta = $consulta->GuardarCaso($id_credencial, $asunto_caso, $categoria_caso, $id_usuario,$fecha_caso);
        
        if($rsta){
            $data = array(
                'exito' => '1',
                'info' => 'Caso Abierto Con Exito'
            );
        }else{
            $data = array(
                'exito' => '0',
                'info' => 'Error Al Abrir Caso'
            );
        }
        
        echo json_encode($data);
        /*echo "($id_credencial, $asunto_caso, $id_usuario)";*/
        
    break;
}

?>
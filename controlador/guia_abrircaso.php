<?php
require_once "../modelos/GuiaAbrircaso.php";
$consulta = new Guiaabrircaso();
switch ($_GET['op']){
    case 'buscar_docente': //traemos los datos personales del docente
        $dato_a_buscar = $_POST['dato_busqueda']; /*tomamos el dato enviado desde js*/
        $rsta = $consulta->guiaConsultaDocente($dato_a_buscar);
        if(empty($rsta)){
            $data = array(
                'exito' => '0',
                'info' => 'Revisa el documento, no se encontraron datos.'
            );
        }else{
            //verificacion de la imagen
            if (file_exists('../files/docentes/'.$rsta['usuario_identificacion'].'.jpg')) {
                $foto = '../files/docentes/'.$rsta['usuario_identificacion'].'.jpg';
            } else {
                $foto = '../files/null.jpg';
            }
            $data = array(
                'exito' => '1',
                'info' => array(
                    'id_credencial' => $rsta["id_usuario"],
                    'nombre_docente' => $rsta["usuario_nombre"]." ".$rsta["usuario_nombre_2"],
                    'apellido_docente' => $rsta["usuario_apellido"]." ".$rsta["usuario_apellido_2"],
                    'tipo_identificacion' => $rsta["usuario_tipo_documento"],
                    'numero_documento' => $rsta["usuario_identificacion"],
                    'direccion' => $rsta["usuario_direccion"],
                    'celular' => $rsta["usuario_celular"],
                    'email' => $rsta["usuario_login"],
                    'foto' => $foto,
                )
            );
            $html = "";
            $programas = $consulta->guiaConsultaProgramas($rsta["id_usuario"]); 
            for($i =0 ; $i < count($programas);$i++){
                $html .= '<li class="list-group-item border-0">
                        <b> Programa:</b><a class=" box-profiledates profile-programa"> '.$programas[$i]['nombre']. ' <br> <b> Materia:</b> ' . $programas[$i]['materia'] . '</a> <br>
                        <b> Semestre:</b><a class=" box-profiledates profile-programa"> '.$programas[$i]['semestre']. ' - <b> jornada:</b> ' . $programas[$i]['jornada'] . '</a>
                        </li>';
            }
            $data['programas'] = $html;
        }
        
        echo(json_encode($data));
    break;
    case 'buscar_casos': //traemos los casos del docente
        $dato_a_buscar = $_POST['dato_busqueda']; /*tomamos el dato enviado desde js*/
        $rsta = $consulta->guiaConsultaCasos($dato_a_buscar);
		$data= Array();
        //print_r($rsta);
		for($i =0 ; $i < count($rsta);$i++){
            $icon = '';
            $rst = $consulta->guiaConsulta_casos($rsta[$i]["caso_id"]);
            $rst2 = $consulta->guiaConsultaremisiones($rsta[$i]["caso_id"]);
            if ($rst || $rst2) {
                $icon = '<a href="guiavercaso.php?op=verC&caso='.$rsta[$i]["caso_id"].'" target="_blank" type="submit" class="btn btn-primary"> <i class="fas fa-external-link-alt"></i> </a>';
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
        $rsta = $consulta->guiaListarCategorias();
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
    case 'guardarcaso': //guardar caso del docente
        $id_docente = isset($_POST["id-docente"])?$_POST["id-docente"]:die(json_encode(array('exito' => '0','info' => 'El docente No Tiene Identificación.')));
        $asunto_caso = isset($_POST["asunto-nuevo-caso"])?$_POST["asunto-nuevo-caso"]:"";
        $categoria_caso = isset($_POST["categoria-caso"])?$_POST["categoria-caso"]:"";
        $fecha_caso = isset($_POST["fecha_caso"])?$_POST["fecha_caso"]:"";
        $id_usuario = isset($_SESSION["id_usuario"])?$_SESSION["id_usuario"]:die(json_encode(array('exito' => '0','info' => 'Sesión Caducada, Vuelve Ha Iniciar.')));
        $rsta = $consulta->GuiaGuardarCaso($id_docente, $asunto_caso, $categoria_caso, $id_usuario, $fecha_caso);
        if($rsta){
            $data = array( 'exito' => '1', 'info' => 'Caso Abierto Con Exito' );
        }else{
            $data = array( 'exito' => '0', 'info' => 'Error Al Abrir Caso' );
        }
        echo json_encode($data);
    break;
}

?>
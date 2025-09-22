<?php

session_start();

require_once "../modelos/CvUsuario.php";
$usuario=new CvUsuario();
$id_usuario=isset($_POST["id_usuario"])? limpiarCadena($_POST["id_usuario"]):"";
$usuario_identificacion = isset($_POST["identificacion"])?limpiarCadena($_POST["identificacion"]):"";
$usuario_nombre = isset($_POST["nombres"])? limpiarCadena($_POST["nombres"]):"";
$usuario_apellido=isset($_POST["apellidos"])? limpiarCadena($_POST["apellidos"]):"";
$usuario_clave=isset($_POST["clave"])? limpiarCadena($_POST["clave"]):"";
$usuario_email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$usuario_fecha_nacimiento=isset($_POST["usuario_fecha_nacimiento"])? limpiarCadena($_POST["usuario_fecha_nacimiento"]):"";

$usuario_departamento=isset($_POST["usuario_departamento"])? limpiarCadena($_POST["usuario_departamento"]):"";
$usuario_ciudad=isset($_POST["usuario_ciudad"])? limpiarCadena($_POST["usuario_ciudad"]):"";
$usuario_direccion=isset($_POST["usuario_direccion"])? limpiarCadena($_POST["usuario_direccion"]):"";
$usuario_celular=isset($_POST["usuario_celular"])? limpiarCadena($_POST["usuario_celular"]):"";
$usuario_imagen=isset($_POST["usuario_imagen"])? limpiarCadena($_POST["usuario_imagen"]):"";
$valorbusqueda=isset($_GET["valorbusqueda"])? limpiarCadena($_GET["valorbusqueda"]):"";
$tipobusqueda=isset($_GET["tipobusqueda"])? limpiarCadena($_GET["tipobusqueda"]):"";
$usuario_sexo=isset($_POST["sexo"])? limpiarCadena($_POST["sexo"]):"";

switch ($_GET["op"]){
    case 'registrar':
        $validar_mail = $usuario->validar_mail($usuario_email);
        if(count($validar_mail) == 0){
            $rspta = $usuario->registrarUsuario($usuario_identificacion, $usuario_nombre, $usuario_apellido, $usuario_email,$usuario_clave,$usuario_sexo);
            if($rspta){
                $clavehash = hash('sha256', $usuario_clave); 
                $rspta=$usuario->verificarfuncionario($usuario_email, $clavehash);
                $fetch = $rspta; 
                //Declaramos las variables de sesión
                $_SESSION['id_usuario']=$fetch["id_usuario"];
                $_SESSION['usuario_nombre']=$fetch["usuario_nombre"];
                $_SESSION['usuario_email']=$fetch["usuario_email"];
                $_SESSION['usuario_identificacion']=$fetch["usuario_identificacion"];
                $_SESSION['usuario_apellido']=$fetch["usuario_apellido"];
                $_SESSION['usuario_imagen']=$fetch["usuario_imagen"];

                //Obtenemos los permisos del usuario
                $marcados = $usuario->listarmarcados($fetch["id_usuario"]);
                //Declaramos el array para almacenar todos los permisos marcados
                $valores=array();
                //Almacenamos los permisos marcados en el array
                $i = 0;
                while($i < count($marcados)){
                    array_push($valores, $marcados[$i]["id_permiso"]);
                    $i++;
                }

                //Determinamos los accesos del usuario
                in_array(1,$valores)?$_SESSION['menuadmin']=1:$_SESSION['menuadmin']=0;
                in_array(2,$valores)?$_SESSION['usuario']=1:$_SESSION['usuario']=0;
                in_array(3,$valores)?$_SESSION['permiso']=1:$_SESSION['permiso']=0;

                echo json_encode(array('status'=> 'ok', 'descp' => 'El usuario se ha Registrado Correctamente'));
            }else{
                echo json_encode(array('status'=> 'error', 'descp' => 'El Usuario no se ha Registrado Correctamente'));    
            }
        }else{
            echo json_encode(array('status'=> 'error', 'descp' => 'El Correo Electronico ya existe'));
        }
    break;

	case 'guardaryeditar':
        if (!file_exists($_FILES['usuario_imagen']['tmp_name']) || !is_uploaded_file($_FILES['usuario_imagen']['tmp_name'])){
			$imagen = $_POST["imagenactual"];
            $rspta=$usuario->editar($id_usuario,$usuario_identificacion,$usuario_nombre,$usuario_apellido,$usuario_fecha_nacimiento,$usuario_departamento,$usuario_ciudad, $usuario_direccion,$usuario_celular,$usuario_email,$imagen,$_POST['permiso']);
                if($rspta) {
                    $inserto = Array(
                        "estatus" => 1,
                        "valor" => "Usuario actualizado"
                    );
                    echo json_encode($inserto);   
                }else{
                    $inserto = Array(
                        "estatus" => 0,
                        "valor" => "Usuario no se pudo actualizar"
                    );
                    echo json_encode($inserto); 
                }
		}else{
            $file_type = $_FILES['usuario_imagen']['type'];
            $allowed = array("image/jpeg", "image/jpg", "image/gif", "image/png");
            if(!in_array($file_type, $allowed)) {
                $inserto = Array(
                    "estatus" => 0,
                    "valor" => "Formato de imagen no reconocido"
                );
                echo json_encode($inserto);
                exit();
            }
            $target_path = '../files/usuarios/';
            $img1path = $target_path."".$usuario_identificacion.".jpg";
            if(move_uploaded_file($_FILES['usuario_imagen']['tmp_name'], $img1path)){
                $imagen = $usuario_identificacion.".jpg";
                $rspta=$usuario->editar($id_usuario,$usuario_identificacion,$usuario_nombre,$usuario_apellido,$usuario_fecha_nacimiento,$usuario_departamento,$usuario_ciudad, $usuario_direccion,$usuario_celular,$usuario_email,$imagen,$_POST['permiso']);
                if($rspta) {
                    $inserto = Array(
                        "estatus" => 1,
                        "valor" => "Usuario actualizado"
                    );
                    echo json_encode($inserto);   
                }else{
                    $inserto = Array(
                        "estatus" => 0,
                        "valor" => "Usuario no se pudo actualizar"
                    );
                    echo json_encode($inserto); 
                }
            }
        }
	break;
	case 'desactivar':
		$rspta=$usuario->desactivar($id_usuario);
		if($rspta==0){
			echo "1";
		}else{
			echo "0";
		}
 		//echo $rspta ? "Usuario Desactivado" : "Usuario no se puede desactivar";
	break;
	case 'activar':
		$rspta=$usuario->activar($id_usuario);
		if($rspta==0){
			echo "1";
		}else{
			echo "0";
		}
 		//echo $rspta ? "Usuario activado" : "Usuario no se puede activar";
	break;
	case 'contratar':
		$rspta=$usuario->contratar($id_usuario);
		if($rspta==0){
			echo "1";
		}else{
			echo "0";
		}

 		//echo $rspta ? "Usuario activado" : "Usuario no se puede activar";

	break;
	case 'desvincular':
		$rspta=$usuario->desvincular($id_usuario);
		if($rspta==0){
			echo "1";
		}else{
			echo "0";
		}
 		//echo $rspta ? "Usuario activado" : "Usuario no se puede activar";
	break;
	case 'mostrar':
        $rspta=$cv_usuario->mostrar($id_usuario_cv);
 		//Codificar el resultado utilizando json
        echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$usuario->listar();
 		//Vamos a declarar un array
        $data= Array();
        $reg=$rspta;
        for ($i=0;$i<count($reg);$i++){
            if($reg[$i]["estado"] == "interesado" || $reg[$i]["estado"] == "desvinculado"){
                $estado = '<button class="btn btn-success btn-flat btn-xs" onclick="contratar('.$reg[$i]["id_usuario"].')" title="contratar"><i class="fas fa-user-check"></i></button>';
            }elseif($reg[$i]["estado"] == "contratado"){
                $estado = '<button class="btn btn-warning btn-flat btn-xs" onclick="desvinculado('.$reg[$i]["id_usuario"].')" title="Desvinculado"><i class="fas fa-user-times"></i></button>';
            }else{
                $estado = "";
            }
        
            $editar = '<button class="btn btn-default btn-flat btn-xs" onclick="mostrar('.$reg[$i]["id_usuario"].')" title="editar"><i class="fas fa-pen"></i></button>';

            $data[]=array(
                "0"=>$editar.'<a class="btn btn-info btn-flat btn-xs" href="hoja_online.php?uid='.$reg[$i]["usuario_identificacion"].'" target="_blank" title="Ver hoja de vida"><i class="fas fa-eye"></i></a><button class="btn btn-primary btn-flat btn-xs" onclick="citar('.$reg[$i]["id_usuario"].',`'.$reg[$i]["usuario_email"].'` )" title="Citar a entrevista" data-toggle="modal" data-target="#modal-default"><i class="fas fa-envelope"></i></button>'.$estado.(($reg[$i]["usuario_condicion"])?

                    '<button class="btn btn-danger btn-xs btn-flat" onclick="desactivar('.$reg[$i]["id_usuario"].')" title="Desactivar"><i class="fas fa-lock-open"></i></button>':

                    '<button class="btn btn-primary btn-xs btn-flat" onclick="activar('.$reg[$i]["id_usuario"].')" title="Activar"><i class="fas fa-lock"></i></button>'),

                "1"=>$reg[$i]["usuario_nombre"] . " " . $reg[$i]["usuario_apellido"],
                "2"=>$reg[$i]["usuario_identificacion"],
                "3"=>$reg[$i]["telefono"],
                "4"=>$reg[$i]["usuario_email"],
                "5"=>"<img src='../files/usuarios/".$reg[$i]["usuario_imagen"]."' height='40px' width='40px' >",
                "6"=>($reg[$i]["usuario_condicion"])?'<span class="label bg-green">Activado</span>':
                '<span class="label bg-red">Desactivado</span>'
            );
            /*$usuario->editarpassword($reg[$i]["id_usuario"],$reg[$i]["usuario_identificacion"]);*/
        }

        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data
        );
        echo json_encode($results);
    break;
    case 'listarbusqueda':
        switch($tipobusqueda){
            case "porEstado":     
                $rspta=$usuario->listarPorEstado($valorbusqueda);
            break;
            case "porCategoria":
                $rspta=$usuario->listarPorCategoria($valorbusqueda);
            break;
            case "porArea":
                $rspta=$usuario->listarPorArea($valorbusqueda);
            break;
            case "porFecha":
                $rspta=$usuario->listarPorFecha($valorbusqueda);
            break;
        }
        //Vamos a declarar un array
        $data= Array();
        $reg=$rspta;
        for ($i=0;$i<count($reg);$i++){
            if($reg[$i]["estado"] == "interesado" || $reg[$i]["estado"] == "desvinculado"){

                $estado = '<button class="btn btn-success btn-flat btn-xs" onclick="contratar('.$reg[$i]["id_usuario"].')" title="contratar"><i class="fas fa-user-check"></i></button>';

            }elseif($reg[$i]["estado"] == "contratado"){
                $estado = '<button class="btn btn-warning btn-flat btn-xs" onclick="desvinculado('.$reg[$i]["id_usuario"].')" title="Desvincular"><i class="fas fa-user-times"></i></button>';

            }else{
                $estado = "0";
            }

            $editar = '<button class="btn btn-warning btn-flat btn-xs" onclick="mostrar('.$reg[$i]["id_usuario"].')" title="editar"><i class="fas fa-pen"></i></button>';

            $data[]=array(

                "0"=>$editar.'<a class="btn btn-info btn-flat btn-xs" href="hoja_online.php?uid='.$reg[$i]["usuario_identificacion"].'" target="_blank" title="Ver hoja de vida"><i class="fas fa-eye"></i></a><button class="btn btn-primary btn-flat btn-xs" onclick="citar('.$reg[$i]["id_usuario"].')" title="Citar a entrevista" data-toggle="modal" data-target="#modal-default"><i class="fas fa-envelope"></i></button>'.$estado.(($reg[$i]["usuario_condicion"])?

                    '<button class="btn btn-danger btn-xs btn-flat" onclick="desactivar('.$reg[$i]["id_usuario"].')" title="Desactivar"><i class="fas fa-lock-open"></i></button>':

                    '<button class="btn btn-primary btn-xs btn-flat" onclick="activar('.$reg[$i]["id_usuario"].')" title="Activar"><i class="fas fa-lock"></i></button>'),

                "1"=>$reg[$i]["usuario_nombre"] . " " . $reg[$i]["usuario_apellido"],
                "2"=>$reg[$i]["usuario_identificacion"],
                "3"=>$reg[$i]["telefono"],
                "4"=>$reg[$i]["usuario_email"],
                "5"=>"<img src='../files/usuarios/".$reg[$i]["usuario_imagen"]."' height='40px' width='40px' >",
                "6"=>($reg[$i]["usuario_condicion"])?'<span class="label bg-green">Activado</span>':
                '<span class="label bg-red">Desactivado</span>'
            );
            /*$usuario->editarpassword($reg[$i]["id_usuario"],$reg[$i]["usuario_clave"]);*/
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data
        );

        echo json_encode($results);
	break;

	case 'permisos':
		//Obtenemos todos los permisos de la tabla permisos
		require_once "../modelos/Permiso.php";
		$permiso = new Permiso();
		$rspta = $permiso->listar();
		//Obtener los permisos asignados al usuario
		$id=$_GET['id'];
		$marcados = $usuario->listarmarcados($id);
		//Declaramos el array para almacenar todos los permisos marcados
		$valores=array();
        $i = 0;
        while ($i < count($marcados)){
            array_push($valores, $marcados[$i]["id_permiso"]);
            $i++;
        }

        //	Mostramos la lista de permisos en la vista y si están o no marcados

		$j=0;
		while ($j < count($rspta)){
            $sw=in_array($rspta[$j]["id_permiso"],$valores)?'checked':'';
            if($j == 0){
                echo '<li> <input type="checkbox" '.$sw.'  name="permiso[]" value="'.$rspta[$j]["id_permiso"].'" required checked>'.$rspta[$j]["permiso_nombre"].'</li>';    
            }else{
                echo '<li> <input type="checkbox" '.$sw.'  name="permiso[]" value="'.$rspta[$j]["id_permiso"].'">'.$rspta[$j]["permiso_nombre"].'</li>';
            }
            $j++;
        }	

	break;
	case 'salir':
		//Limpiamos las variables de sesión   
        session_unset();
        //Destruìmos la sesión
        session_destroy();
        //Redireccionamos al login
        header("Location: ../index.php");
	break;
	case "selectDepartamento":	
		$rspta = $usuario->selectDepartamento();
		for ($i=0;$i<count($rspta);$i++){
            echo "<option value='" . $rspta[$i]["id_departamento"] . "'>" . $rspta[$i]["departamento"] . "</option>"; 
        }

	break;
	case "selectMunicipio":	
		$rspta = $usuario->selectMunicipio();
		for ($i=0;$i<count($rspta);$i++){
            echo "<option value='" . $rspta[$i]["id_municipio"] . "'>" . $rspta[$i]["municipio"] . "</option>";
        }
	break;	
}

?>
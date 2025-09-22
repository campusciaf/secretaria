<?php
session_start(); 
require_once "../modelos/Configurarcuenta.php";
$config = new Configuracion();

date_default_timezone_set("America/Bogota");	
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$mes_actual=date('Y-m')."-00";

$id_usuario = $_SESSION['id_usuario'];

switch ($_GET['op']) {

  case 'mostrar':
		$rspta=$config->mostrar($id_usuario);
 		echo json_encode($rspta);

	break;

  case "selectTipoSangre":	
		$rspta = $config->selectTipoSangre();
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["nombre_sangre"] . "'>" . $rspta[$i]["nombre_sangre"] . "</option>";
				}
	break;
  case "selectDepartamento":	
		$rspta = $config->selectDepartamento();
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["departamento"] . "'>" . $rspta[$i]["departamento"] . "</option>";
				}
	break;

  
	case "selectMunicipio":
		$departamento=$_POST["departamento"];
				
		if($departamento==""){
			$rspta = $config->selectDepartamentoMunicipioActivo($_SESSION['id_usuario']);
			$municipio_actual=$rspta["usuario_municipio_nacimiento"];
			echo "<option value='" . $municipio_actual . "'>" . $municipio_actual . "</option>";
		}
		else{
		$rspta2 = $config->selectDepartamentoDos($departamento);
		$id_departamento_final=$rspta2["id_departamento"];	
			
		$rspta = $config->selectMunicipio($id_departamento_final);
		echo "<option value=''>Seleccionar Municipio</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["municipio"] . "'>" . $rspta[$i]["municipio"] . "</option>";
				}
		}
	break;


    
case 'listarDatos':
    $datos = $config->listarDatos($id_usuario);
    if (file_exists("../files/usuarios/" . $datos['usuario_identificacion'] . ".jpg")) {
        $url = "../files/usuarios/" . $datos['usuario_identificacion'] . ".jpg";
    } else {
        $url = "../files/null.jpg";
    }
    $data['conte'] = '
    <div class="col-md-12 pt-4">
        <div class="card-widget widget-user">
            <div class="widget-user-header bg-primary">
                <h3 class="widget-user-username">'.$datos['usuario_nombre'].' '.$datos['usuario_nombre_2'].'</h3>
                <h5 class="widget-user-desc">'.$datos['usuario_apellido'].' '.$datos['usuario_apellido_2'].'</h5>
            </div>
            <div class="widget-user-image">
                <input type="hidden" id="documento_png">
                <input class="form-control mb-3 d-none" onchange="comprimirImagen(`nombre_imagen1`)" type="file" id="nombre_imagen1" name="nombre_imagen1" accept="image/png, image/jpeg, image/jpg">
                <input type="hidden" name="b_nombre_imagen1" id="b_nombre_imagen1">
                <img class="img-circle elevation-2 img_user" style="width:108px; height:108px"
                     src="' . $url . '?' . time() . '"
                     id="preview_nombre_imagen1" width="150px">
                <span>
                    <i class="btn btn-warning btn-xs edit-nombre_imagen1" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar" onclick="document.getElementById(`nombre_imagen1`).click();" role="button">
                        <i class="fas fa-edit"></i> Editar
                    </i>
                    <button class="btn btn-success d-none mt-2 rounded-0 btn_nombre_imagen1 guardar-nombre_imagen1" onclick="cambiarImagen(`nombre_imagen1`)"> Guardar </button>
                    <button class="btn btn-danger d-none mt-2 rounded-0 btn_nombre_imagen1 cancel-nombre_imagen1" onclick="cancelar_input(`nombre_imagen1`)"> Cancelar </button>
                </span>
            </div>
        </div>
    </div>';
    echo json_encode($data);
    break;
    case 'cambiarContra':
        $nueva = $_POST['nueva'];
        $anterior = $_POST['anterior'];
        $confirma = $_POST['confirma'];

        if ($nueva == $confirma) {
            $config->cambiarContra($id_usuario,$anterior,$nueva);
        } else {
            $data['status'] = "Error, las contraseñas no coincide.";

            echo json_encode($data);
        }

    break;
        
    case 'editarDatospersonales':
        $data= Array();
		$data["estado"] ="";

        $nombre1 = $_POST['usuario_nombre_p'];
        @$nombre2 = $_POST['usuario_nombre_2_p'];
        $apellido = $_POST['usuario_apellido_p'];
        @$apellido2 = $_POST['usuario_apellido_2_p'];
        $fecha_n = $_POST['usuario_fecha_nacimiento_p'];
        $depar_naci = $_POST['usuario_departamento_nacimiento_p'];
        $ciudad_naci = $_POST['usuario_municipio_nacimiento_p'];
        $tipo_sangre = $_POST['usuario_tipo_sangre_p'];
        $dirrecion = $_POST['usuario_direccion_p'];
        @$telefono = $_POST['usuario_telefono_p'];
        $celular = $_POST['usuario_celular_p'];

        $rspta=$config->editarDatospersonales($nombre1,$nombre2,$apellido,$apellido2,$fecha_n,$depar_naci,$ciudad_naci,$tipo_sangre,$dirrecion,$telefono,$celular,$fecha);

        $datos=$rspta ? "si" : "no";

        $data["estado"] = $datos;
        echo json_encode($data);
    
    break;

   

case 'cambiarImagen':
    $campo = isset($_POST["campo"]) ? $_POST["campo"] : "";
    $valor = isset($_POST["valor"]) ? $_POST["valor"] : "";
    $nombre_archivo = isset($_SESSION["usuario_identificacion"]) ? $_SESSION["usuario_identificacion"] . ".jpg" : "";
    if (empty($valor) || is_null($valor)) {
        $msg_errors = "Debes subir una imagen.";
        die(json_encode(array("exito" => 0, "info" => $msg_errors)));
    } elseif (empty($nombre_archivo)) {
        $msg_errors = "No se encontró el número de documento para guardar la imagen.";
        die(json_encode(array("exito" => 0, "info" => $msg_errors)));
    } else {
        $rspta =  $config->base64_to_jpeg($valor, "../files/usuarios/" . $nombre_archivo);
        if ($rspta) {
            $config->actualizarCampoBD($nombre_archivo, $_SESSION["id_usuario"]);
            $data = array("exito" => 1, "info" => "! Todo se ha guardado con exito ¡");
        } else {
            $data = array("exito" => 0, "info" => "Error en el guardado");
        }
        echo json_encode($data);
    }
    break;

}

?>
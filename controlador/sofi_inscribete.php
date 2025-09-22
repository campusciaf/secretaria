<?php
require_once "../modelos/SofiInscribete.php";
require_once "../Datacredito_Api/funciones.php";
require_once "../mail/send.php";
require_once "../public/sofi_mail/templatePreAprobado.php";
$inscribete = new SofiInscribete();
$datacredito_api = new DatacreditoApi();
$op = isset($_GET["op"])? $_GET["op"]:""; 
switch ($op) {
    case 'mostrarDepartamento':
        $departamentos = $inscribete->mostrarDepartamentos();
        echo json_encode($departamentos);
        break;
    case 'mostrarMunicipios':
        $id_departamento = isset($_POST["id_departamento"])?$_POST["id_departamento"]:"";
        $ciudades = $inscribete->mostrarMunicipios($id_departamento);
        echo json_encode($ciudades);
        break;
    case 'guardaryeditar':
        $tipo_documento = isset($_POST["tipo_documento"]) ? $_POST["tipo_documento"] : "";
        $numero_documento = isset($_POST["numero_documento"]) ? $_POST["numero_documento"] : "";
        $nombres = isset($_POST["nombres"]) ? $_POST["nombres"] : "";
        $apellidos = isset($_POST["apellidos"]) ? $_POST["apellidos"] : "";
        $primer_apellido = explode(" ", $apellidos);
        $primer_apellido = $primer_apellido[0];
        $fecha_nacimiento = isset($_POST["fecha_nacimiento"]) ? $_POST["fecha_nacimiento"] : die(array("estatus" => 0, "info" => "Debes ingresar tu fecha de nacimiento"));
        $estado_civil = isset($_POST["estado_civil"]) ? $_POST["estado_civil"] :"";
        $direccion = isset($_POST["direccion"]) ? $_POST["direccion"]:"";
        $ciudad = isset($_POST["ciudad"]) ? $_POST["ciudad"] : "";
        $estrato = isset($_POST["estrato"]) ? $_POST["estrato"] : "";
        $celular = isset($_POST["celular"]) ? $_POST["celular"] : "";
        $email = isset($_POST["email"]) ? $_POST["email"] : "";
        $personas_a_cargo = isset($_POST["personas_a_cargo"]) ? $_POST["personas_a_cargo"] : "0";
        $genero = isset($_POST["genero"]) ? $_POST["genero"] : "0";
        $numero_hijos = isset($_POST["numero_hijos"]) ? $_POST["numero_hijos"] : "0";
        $nivel_educativo = isset($_POST["nivel_educativo"]) ? $_POST["nivel_educativo"] : "0";
        $nacionalidad = isset($_POST["nacionalidad"]) ? $_POST["nacionalidad"] : "0";
        $ocupacion = isset($_POST["ocupacion"]) ? $_POST["ocupacion"] : "";
        $tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "Solicitante";
        $labora = isset($_POST["view2"]) ? $_POST["view2"] : "SI";
        //Ingresos
        $sector_laboral = isset($_POST["sector_laboral"]) ? $_POST['sector_laboral'] : "";
        $tiempo_servicio = isset($_POST["tiempo_servicio"]) ? $_POST['tiempo_servicio'] : "";
        $salario = isset($_POST["salario"]) ? $_POST['salario'] : "";
        $tipo_vivienda = isset($_POST["tipo_vivienda"]) ? $_POST['tipo_vivienda'] : "";
        //Codeudor
        $codeudornombre = isset($_POST["codeudornombre"]) ? $_POST["codeudornombre"] : "";
        $codeudortelefono = isset($_POST["codeudortelefono"]) ? $_POST["codeudortelefono"] : "";
        /*Referencias*/
        $familiarnombre = isset($_POST["familiarnombre"]) ? $_POST["familiarnombre"] : "";
        $familiartelefono = isset($_POST["familiartelefono"]) ? $_POST["familiartelefono"] : "";
        $idsolicitante = isset($idsolicitante) ? $idsolicitante : "0";
        $fechaActual = new DateTime(); 
        $fechaIngresada = new DateTime($fecha_nacimiento);
        $edad = $fechaActual->diff($fechaIngresada);
        $estado = "Pendiente";
        $id_persona = $inscribete->insertarSolicitud($tipo_documento, $numero_documento, $nombres, $apellidos, $fecha_nacimiento, $estado_civil, $direccion, $ciudad, $celular, $email, $personas_a_cargo, $ocupacion, $tipo, $estado, $idsolicitante, $labora, $genero, $numero_hijos, $nivel_educativo, $nacionalidad, $codeudornombre, $codeudortelefono, $estrato);
        if($id_persona){
            $ingresos = $inscribete->insertarIngresos($sector_laboral, $tiempo_servicio, $salario, $tipo_vivienda, $id_persona);
            if ($ingresos) {
                $referencias = $inscribete->insertar_referencia($familiarnombre, $familiartelefono, $id_persona);
                //echo $referencias; 
                if ($referencias) {
                    if ($edad->y < 18) {
                        $nombre_completo_acudiente = isset($_POST["nombre_completo_acudiente"]) ? $_POST["nombre_completo_acudiente"] : "";
                        $numero_documento_acudiente = isset($_POST["numero_documento_acudiente"]) ? $_POST["numero_documento_acudiente"] : "";
                        $fecha_expedicion_acudiente = isset($_POST["fecha_expedicion_acudiente"]) ? $_POST["fecha_expedicion_acudiente"] : "";
                        $parentesco = isset($_POST["parentesco"]) ? $_POST["parentesco"] : "";
                        $representante = $inscribete->InsertarReprensentante($nombre_completo_acudiente, $numero_documento_acudiente, $fecha_expedicion_acudiente, $parentesco, $id_persona);
                        if ($representante) {
                            $mensaje = set_template_preAprobar($nombres);
                            enviar_correo($email, "CIAF - Aprobación Crédito Educativo", $mensaje);
                            $data = array("estatus" => 1, "info" => "Solicitud Enviada Con éxito");
                        } else {
                            $data = array("estatus" => 0, "info" => "Error al insertar representante legal");
                        }
                    } else {
                        $mensaje = set_template_preAprobar($nombres);
                        enviar_correo($email, "CIAF - Aprobación Crédito Educativo", $mensaje);
                        $data = array("estatus" => 1, "info" => "Solicitud Enviada Con éxito");
                    }
                    $ultimo_score = $inscribete->obtenerUltimoScore($numero_documento);
                    $fecha_ultimo_score = isset($ultimo_score["create_dt"]) ? new DateTime($ultimo_score["create_dt"]) : new DateTime('2024-10-02 00:00:00');
                    $anios_diferencia = $fecha_ultimo_score->diff(new DateTime())->y;
                    $meses_diferencia = $fecha_ultimo_score->diff(new DateTime())->m;
                    $meses_diferencia = ($anios_diferencia * 12) + $meses_diferencia;
                    if ($meses_diferencia >= 4 && $edad->y >= 18) {
                        $dataToken = $datacredito_api->generarToken();
                        if (isset($dataToken['access_token'])) {
                            $token_datacredito = $dataToken['access_token'];
                            $resultadoServicio = $datacredito_api->consumirServicio($token_datacredito, $numero_documento, $primer_apellido);
                            if (isset($resultadoServicio['ReportHDCplus']['productResult']['responseCode'])) {
                                $codigo_respuesta = $resultadoServicio['ReportHDCplus']['productResult']['responseCode'];
                                if ($codigo_respuesta == "13") {
                                    $scoreValue = $resultadoServicio['ReportHDCplus']['models'][0]['scoreValue'];
                                    $inscribete->generarScoreDatacredito($id_persona, $numero_documento, $primer_apellido, $scoreValue);
                                } else if ($codigo_respuesta == "09") {
                                    $data = array("estatus" => 1, "info" => "El número de identificación enviado no existe en los archivos de validación de la base de datos.");
                                } else {
                                    $data = array("estatus" => 1, "info" => "Error Code#001: El API presenta fallas, informa al area de desarrollo.");
                                }
                            } else {                                                                                      
                                $data = array("estatus" => 1, "info" => $resultadoServicio);
                            }
                        } else {
                            $data = array("estatus" => 1, "info" => "Error Code#003: El API presenta fallas al generar credenciales, informa al area de desarrollo.");
                        }
                    } 
                } else {
                    $data = array("estatus" => 0, "info" => "Error al insertar las referencias");
                }
            } else {
                $data = array("estatus" => 0, "info" => "Error al insertar los ingresos");
            }
        }else{
            $data = array("estatus" => 0, "info" => "Error al insertar la solicitud");
        }
        echo json_encode($data);
        break;
}
?>
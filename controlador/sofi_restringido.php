<?php

require_once "../modelos/Sofi_Restringido.php";

$sofi_restringido = new Estado_Restringido();
error_reporting(1);


switch ($_GET["op"]) {

	case 'consultaEstudiante':
        $cedula = $_POST["cedula"];
        $registro = $sofi_restringido->consultaEstudiante($cedula);
        $data[0] = "";

            if ($registro['estado_ciafi'] == "1") {
                
                $data[0] .= "
                <input type='hidden' value='".$registro['id_credencial']."' id='id_cedula' readonly />
                
                <div class='form-group col-xl-12 col-lg-12 col-md-12 col-12'>
                            <label>Nombre:</label>		
                            <div class='input-group mb-3'>
                                <div class='input-group-prepend'>
                                    <span class='input-group-text'><i class='fas fa-user'></i></span>
                                </div>
                                <input type='text' value='" . $registro['credencial_nombre'] . ' ' . $registro['credencial_nombre_2'] . ' ' . $registro['credencial_apellido'] . ' ' . $registro['credencial_apellido_2'] . "' class='form-control' readonly />
                            </div>
                            </div>
                            
                    <div class='form-group col-xl-12 col-lg-12 col-md-12 col-12'>
                            <label>Estado:</label>		
                            <div class='input-group mb-3'>
                                <div class='input-group-prepend'>
                                    <span class='input-group-text'><i class='fas fa-check' style='color:green'></i></span>
                                </div>
                                <input type='text' value='Activo' id='estado' class='form-control' readonly />
                            </div>
                            </div>	
                            
                    <a name='desactivar' value='Desactivar'  class='btn btn-danger' onclick=estadoEst(0)>Desactivar</a>";
                            
                
            } else {
                
                    $data[0] .= "
                <input type='hidden' value='".$registro['id_credencial']."' id='id_cedula' readonly />
                
                <div class='form-group col-xl-12 col-lg-12 col-md-12 col-12'>
                            <label>Nombre:</label>		
                            <div class='input-group mb-3'>
                                <div class='input-group-prepend'>
                                    <span class='input-group-text'><i class='fas fa-user'></i></span>
                                </div>
                                <input type='text' value='" . $registro['credencial_nombre'] . ' ' . $registro['credencial_nombre_2'] . ' ' . $registro['credencial_apellido'] . ' ' . $registro['credencial_apellido_2'] . "' class='form-control' readonly />
                            </div>
                            </div>
                            
                    <div class='form-group col-xl-12 col-lg-12 col-md-12 col-12'>
                            <label>Estado:</label>		
                            <div class='input-group mb-3'>
                                <div class='input-group-prepend'>
                                    <span class='input-group-text'><i class='fas fa-times' style='color:red'></i></span>
                                </div>
                                <input type='text' value='Bloqueado' id='estado' class='form-control ' readonly />
                            </div>
                            </div>	
                            
                    <a name='activar' value='Activar'  class='btn btn-success' onclick=estadoEst(1)>Activar</a>";
                    // echo $datos;

            }
        // }

        echo json_encode($data);

        break;

        case 'estadoEst':
            $estado = $_POST["estado"];
            $cedula = $_POST["cedula"];
            $respuesta = $sofi_restringido->estadoEst($estado,$cedula);
            echo json_encode($data);
        break;


    }

// class ControllerEstadoRestringido
// {
//     public function consultaEstudiante($cedula)
//     {
//         $obj = new Estado_Restringido();
//         $obj->consultaEstudiante($cedula);
//     }
//     public function estadoEst($estado,$cedula)
//     {
//         $obj = new Estado_Restringido();
//         $obj->estadoEst($estado,$cedula);
//     }
// }


// switch ($_GET['op']) {
//     case 'consultaEstudiante':
//         $cedula = $_POST['cedula'];
//         $obj = new ControllerEstadoRestringido();
//         $obj->consultaEstudiante($cedula);
//         break;
//     case 'estadoEst':
//         $estado = $_POST['estado'];
//         $cedula = $_POST['cedula'];

//         $obj = new Estado_Restringido();
//         $obj->estadoEst($estado,$cedula);
//         break;
//     case 'prueba':
//         $cedula = "1088034238";
//         $estado = "0";
//         $obj->estadoEst($estado,$cedula);
//         break;
// }


?>
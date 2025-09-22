<?php

require_once "../modelos/IngresoCampusColaborador.php";
$consulta = new IngresoCampusColaborador();

switch ($_GET['op']) {


    case 'listar':
        $id_usuario = $_POST["id_usuario"];
        $fecha_ingreso = $_POST["fecha"];

		$rspta=$consulta->listar($id_usuario,$fecha_ingreso);
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
		
	
 		for ($i=0;$i<count($reg);$i++){
			
            $horaOriginal = $reg[$i]["hora"]; // Supongamos que la hora está en formato 24 horas, como "14:30:00"
            $horaFormatoAmPm = date("g:i A", strtotime($horaOriginal));

 			$data[]=array(                
            "0"=> $reg[$i]["id_ingresos"],
            "1"=> $consulta->fechaesp($reg[$i]["fecha"]),
            "2"=> $horaFormatoAmPm,
            "3"=> $reg[$i]["ip"],

            );
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

    case 'listarColaboradores': //mostrar el id especifico
        $rspta = $consulta->colaboradores();  
        
        echo "<option value=''>--Seleccionar colaborador --</option>";      
        for ($i = 0; $i < count($rspta); $i++) {
            $nombre=$rspta[$i]["usuario_nombre"] . ' ' . $rspta[$i]["usuario_nombre_2"] . ' ' . $rspta[$i]["usuario_apellido"] . ' ' . $rspta[$i]["usuario_apellido_2"];
            echo "<option value='" . $rspta[$i]["id_usuario"] . "'>" . $nombre . "</option>";
        }
        
    break;

    case "sinIngresos":
        $fecha_ingreso=$_POST["fecha"];
        
        $data = array();
        $data["datos"] = "";
        $colaboradores = $consulta->colaboradores();

        $data["datos"] .= '
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Colaboador</th>
                    <th scope="col">Ultimo ingreso</th>
                </tr>
            </thead>
            <tbody>';

        
                    for ($a = 0; $a < count($colaboradores); $a++) {
                        $id_usuario = $colaboradores[$a]["id_usuario"];

                        $verificar=$consulta->listar($id_usuario,$fecha_ingreso);
                        if (!empty($verificar)) {
                        
                        } else {
                            $data["datos"] .= '<tr>';
                                $data["datos"] .= '<td>';
                                    $datosusuario=$consulta->datosusuario($id_usuario);
                                    $nombre=$datosusuario["usuario_nombre"] . ' ' . $datosusuario["usuario_nombre_2"] . ' ' . $datosusuario["usuario_apellido"]  . ' ' . $datosusuario["usuario_apellido_2"];
                                    $data["datos"] .= $nombre;
                                $data["datos"] .= '</td>';

                                $registro = $consulta->ultimoRegistro($id_usuario);
                                // Verificamos si hay resultado y lo mostramos
                                if ($registro) {
                                    $data["datos"] .= '<td>';
                                        $data["datos"] .= $consulta->fechaesp($registro['fecha']) . ' ' . $registro['hora'];
                                    $data["datos"] .= '</td>';

                                } else {
                                    $data["datos"] .= '<td>';
                                        $data["datos"] .= 'No se encontró un ingreso';
                                    $data["datos"] .= '</td>';
                                }


                            $data["datos"] .= '</tr>';
                        }

                    }

                $data["datos"] .= '
            </tbody>
        </table>';

        echo json_encode($data);
    break;

}

?>
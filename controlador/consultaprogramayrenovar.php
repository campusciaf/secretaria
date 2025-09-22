<?php
require_once "../modelos/ConsultaProgramayRenovar.php";
$consulta = new Consulta();

require_once "../modelos/PorRenovar.php";
$por_renovar = new PorRenovar();

session_start();
switch ($_GET['op']) {
    case 'listar':
        $periodo_anterior = $consulta->cargarPeriodo();
        $array_jornadas = array(0 => "D01", 1 => "N01", 2 => "S01", 3 => "F01");
        //id_programa
        $id = $_POST['id'];
        $datos = $consulta->listar($id);
        $periodo = $_SESSION['periodo_actual'];
        $jornada1 = "D01";
        $jornada2 = "N01";
        $jornada3 = "S01";
        $jornada4 = "F01";
        $semestre = "1";
        $suma_1 = 0;
        $suma_2 = 0;
        $suma_3 = 0;
        $suma_4 = 0;
        $sumar_renovar = array_fill(0, 4 , 0);
        $data['table'] = "";
        //echo $datos['semestres'];
        for ($i = 0; $i < $datos['semestres']; $i++) {
            $semestre = $i + 1;
            if ($semestre == $datos['semestres']) {
                for ($a = 0; $a < count($array_jornadas); $a++) {
                    $datos_por_renovar = $consulta->consultaCantidadPorRenovar($id, $semestre, $array_jornadas[$a], $periodo_anterior);
                    //print_r($datos_por_renovar);
                    $cantidad_jornada[$i][$a] = 0;
                    for ($k=0; $k < count($datos_por_renovar); $k++) {
                        $ciclo = $datos_por_renovar[$k]["ciclo"];
                        $tabla = "materias" . $ciclo;
                        $id_estudiante = $datos_por_renovar[$k]["id_estudiante"];
                        $promedio_estudiante = $por_renovar->cargarDatosCalificaciones($tabla, $id_estudiante, $semestre);
                        for ($j = 0; $j < count($promedio_estudiante); $j++) {
                            $datos_por_renovar = $consulta->consultaCantidadPorRenovar($id, $semestre, $array_jornadas[$a], $periodo_anterior);
                            if($promedio_estudiante[$j]['promedio'] < 3) {
                                $cantidad_jornada[$i][$a]++;
                                $sumar_renovar[$a] = $sumar_renovar[$a] + 1;
                                break;
                            }
                        }
                    }
                }
            }else{
                for($a = 0; $a < count($array_jornadas); $a++){
                    $datos_por_renovar = $consulta->consultaCantidadPorRenovar($id, $semestre, $array_jornadas[$a], $periodo_anterior);
                    $cantidad_jornada[$i][$a] = count($datos_por_renovar);
                    $sumar_renovar[$a] = $sumar_renovar[$a] + $cantidad_jornada[$i][$a];
                }
            }
            //print_r($sumar_renovar); 
            $cantidad_jornada_1 = $consulta->consultaCantidad($id,$semestre,$jornada1,$periodo);
            $cantidad_jornada_2 = $consulta->consultaCantidad($id,$semestre,$jornada2,$periodo);
            $cantidad_jornada_3 = $consulta->consultaCantidad($id,$semestre,$jornada3,$periodo);
            $cantidad_jornada_4 = $consulta->consultaCantidad($id,$semestre,$jornada4,$periodo);
            $suma_1 = $suma_1 + $cantidad_jornada_1;
            $suma_2 = $suma_2 + $cantidad_jornada_2; 
            $suma_3 = $suma_3 + $cantidad_jornada_3; 
            $suma_4 = $suma_4 + $cantidad_jornada_4;
            $data["table"].="<tr>";
            $data["table"].="<td>".($i+1)."</td>";
            $data["table"].= "<td> <button class='btn btn-danger' onclick=listar_por_renovar('".$id."','".$semestre."','".$jornada1."') ><i class='fas fa-search'></i> </button> ".$cantidad_jornada[$i][0]." | <button onclick=consultaSemest('".$id."','".$semestre."','".$jornada1."') class='btn btn-success'><i class='fas fa-search'></i></button>".$cantidad_jornada_1." 
            </td>";
            $data["table"].= "<td><button class='btn btn-danger' onclick=listar_por_renovar('".$id."','" .$semestre. "','".$jornada2."')> <i class='fas fa-search'></i> </button> ".$cantidad_jornada[$i][1]." | <button onclick=consultaSemest('".$id."','".$semestre."','".$jornada2."') class='btn btn-success'><i class='fas fa-search'></i></button>".$cantidad_jornada_2."</td>";
            $data["table"].= "<td> <button class='btn btn-danger' onclick=listar_por_renovar('" . $id . "','" . $semestre . "','" . $jornada3 . "')><i class='fas fa-search'></i> </button> ".$cantidad_jornada[$i][2]." | <button onclick=consultaSemest('".$id."','".$semestre."','".$jornada3."') class='btn btn-success'><i class='fas fa-search'></i></button>".$cantidad_jornada_3."</td>";
            $data["table"].= "<td> <button class='btn btn-danger' onclick=listar_por_renovar('" . $id . "','" . $semestre . "','" . $jornada4 . "')><i class='fas fa-search'></i> </button> ".$cantidad_jornada[$i][3]."  | <button onclick=consultaSemest('".$id."','".$semestre."','".$jornada4."') class='btn btn-success'><i class='fas fa-search'></i></button>".$cantidad_jornada_4."</td>";
            $data["table"].="</tr>";
        }
        //print_r ($cantidad_jornada);
        $data["table"].="<tr style='color:green;'>";
        $data["table"].="<td><strong>Total</strong></td>";
        $data["table"].="<td> <button onclick=consultaTotalRenovar('" . $id . "','" . $jornada1 . "') class='btn btn-danger'><i class='fas fa-search'></i></button> ". $sumar_renovar[0]." | <button onclick=consultaTotal('".$id."','".$jornada1."') class='btn btn-success'><i class='fas fa-search'></i></button>".$suma_1."</td>";
        $data["table"].="<td> <button onclick=consultaTotalRenovar('" . $id . "','" . $jornada2 . "') class='btn btn-danger'><i class='fas fa-search'></i></button> " . $sumar_renovar[1] . " | <button onclick=consultaTotal('".$id."','".$jornada2."') class='btn btn-success'><i class='fas fa-search'></i></button>".$suma_2."</td>";

        $data["table"].= "<td><button onclick=consultaTotalRenovar('" . $id . "','" . $jornada3 . "') class='btn btn-danger'><i class='fas fa-search'></i></button> " . $sumar_renovar[2] . " | <button onclick=consultaTotal('".$id."','".$jornada3."') class='btn btn-success'><i class='fas fa-search'></i></button>".$suma_3."</td>";
        $data["table"].= "<td><button onclick=consultaTotalRenovar('" . $id . "','" . $jornada4 . "') class='btn btn-danger'><i class='fas fa-search'></i></button> " . $sumar_renovar[3] . " | <button onclick=consultaTotal('".$id."','".$jornada4."') class='btn btn-success'><i class='fas fa-search'></i></button>".$suma_4."</td>";
        $data["table"].="</tr>";
        echo json_encode($data);
    break;
    case 'listarEstudiante':
        $id = $_POST['id'];
        $semestre = $_POST['semestre'];
        $jornada = $_POST['jornada'];
        $periodo = $_SESSION['periodo_actual'];
        $consulta->listarEstudiante($id,$semestre,$jornada,$periodo);
    break;
    case 'listarTotal':
        $id = $_POST['id'];
        $jornada = $_POST['jornada'];
        $periodo = $_SESSION['periodo_actual'];
        $consulta->listarTotal($id,$jornada,$periodo);
    break;
    /* por renovar listar estudiante  */
    case 'listarPorRenovar':
        // Se toman las variables que vienen del get del datatable
        $id_programa = $_GET['id_programa']; 
        $semestre = $_GET['semestre'];
        $jornada = $_GET['jornada'];
        $periodo_anterior = $consulta->cargarPeriodo();
        $datos_por_renovar = $consulta->consultaCantidadPorRenovar($id_programa, $semestre, $jornada, $periodo_anterior);
        $data = array();
        $datos_programa = $consulta->listar($id_programa);
        if ($datos_programa["semestres"] == $semestre) {
            for ($i=0; $i < count($datos_por_renovar) ; $i++) {
                $ciclo = $datos_por_renovar[$i]["ciclo"];
                $tabla = "materias" . $ciclo;
                $id_estudiante = $datos_por_renovar[$i]["id_estudiante"];
                $promedio_estudiante = $por_renovar->cargarDatosCalificaciones($tabla, $id_estudiante, $semestre);
                for ($j = 0; $j < count($promedio_estudiante); $j++) {
                    if ($promedio_estudiante[$j]['promedio'] < 3) {
                        $datos_credencial = $consulta->cargarDatosCredencial($datos_por_renovar[$i]["id_credencial"]);
                        $nombre = $datos_credencial['credencial_nombre'] . ' ' . $datos_credencial['credencial_nombre_2'] . ' ' . $datos_credencial['credencial_apellido'] . ' ' . $datos_credencial['credencial_apellido_2'];
                        $nombre = strtoupper($nombre);   
                        $data[] = array(
                            "0" => $datos_credencial['credencial_identificacion'],
                            "1" => $nombre,
                            "2" => $datos_credencial['celular'],
                            "3" => $datos_credencial['credencial_login'],
                        );
                        break;
                    }
                }
            }
        }else{
            for ($i=0; $i < count($datos_por_renovar) ; $i++) {
                $datos_credencial = $consulta->cargarDatosCredencial($datos_por_renovar[$i]["id_credencial"]);
                $nombre = $datos_credencial['credencial_nombre'] . ' ' . $datos_credencial['credencial_nombre_2'] . ' ' . $datos_credencial['credencial_apellido'] . ' ' . $datos_credencial['credencial_apellido_2'];
                $nombre = strtoupper($nombre);
                //print_r($datos_por_renovar);
                // Llenamos el arreglo donde irán las variables que se mostrarán en el datatable		   
                $data[] = array(
                    "0" => $datos_credencial['credencial_identificacion'],
                    "1" => $nombre,
                    "2" => $datos_credencial['celular'],
                    "3" => $datos_credencial['credencial_login'],
                );
            }
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);
    break;
    case 'listarTotalPorRenovar':
        $id = $_POST['id'];
        $jornada = $_POST['jornada'];
        $periodo_anterior = $consulta->cargarPeriodo();
        //datos del programa
        $datos_programa = $consulta->listar($id);
        //todos los estudiantes que eztan en ese programa en esa jornada y en ese periodo
        $registros = $consulta->listarTotalRenovar($id, $jornada, $periodo_anterior);
        //arreglo vacio
        $data = array();
        //for por todos los estudiantes
        for ($i=0; $i < count($registros) ; $i++) {
            //si el semestre del programa es el mismo que el del estudiante 
            if($datos_programa["semestres"] == $registros[$i]["semestre_estudiante"]) {
                $ciclo = $registros[$i]["ciclo"];
                $tabla = "materias" . $ciclo;
                $id_estudiante = $registros[$i]["id_estudiante"];
                $promedio_estudiante = $por_renovar->cargarDatosCalificaciones($tabla, $id_estudiante, $registros[$i]["semestre_estudiante"]);
                for ($j = 0; $j < count($promedio_estudiante); $j++) {
                    if ($promedio_estudiante[$j]['promedio'] < 3) {
                        $datos_credencial = $consulta->cargarDatosCredencial($registros[$i]["id_credencial"]);
                        $nombre = $datos_credencial['credencial_nombre'] . ' ' . $datos_credencial['credencial_nombre_2'] . ' ' . $datos_credencial['credencial_apellido'] . ' ' . $datos_credencial['credencial_apellido_2'];
                        $nombre = strtoupper($nombre);
                        $data[] = array(
                            "0" => $datos_credencial['credencial_identificacion'],
                            "1" => $nombre,
                            "2" => $datos_credencial['celular'],
                            "3" => $datos_credencial['credencial_login'],
                        );
                        break;
                    }
                }
            }else{
                $datos = $consulta->datosEstudiante($registros[$i]['id_credencial']);
                $data[] = array(
                    "0" => $datos['credencial_identificacion'],
                    "1" => $datos['credencial_nombre'] . ' ' . $datos['credencial_nombre_2'] . ' ' . $datos['credencial_apellido'] . ' ' . $datos['credencial_apellido_2'],
                    "2" => $datos['celular'],
                    "3" => $datos['credencial_login']
                );
            }
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );

        echo json_encode($results);
    break;
}
?>
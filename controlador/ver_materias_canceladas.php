<?php
session_start();
require_once "../modelos/VerMateriasCanceladas.php";

$ver_materias_canceladas = new VerMateriasCanceladas();

switch($_GET["op"]){
    case 'listar':
        $cargar_informacion = $ver_materias_canceladas->listar();
        //Vamos a declarar un array
 		$data= Array();
        $i = 0;			
        while ($i < count($cargar_informacion)){
            $id_credencial = $cargar_informacion[$i]["id_credencial"];
            $datos_estudiante = $ver_materias_canceladas->datos_estudiante($id_credencial);
            $documento = $datos_estudiante["credencial_identificacion"];

            $id_programa = $cargar_informacion[$i]["id_programa"];
            $datos_programa = $ver_materias_canceladas->datos_programa($id_programa);
            $nombre_programa = $datos_programa["nombre"];

            $data[]=array(
            "0"=>$cargar_informacion[$i]["id_estudiante"],
            "1"=>$documento,
            "2"=>$nombre_programa,
            "3"=>$cargar_informacion[$i]["nombre_materia"],
            "4"=>$cargar_informacion[$i]["periodo"],
            "5"=>$cargar_informacion[$i]["usuario"],
            "6"=>$cargar_informacion[$i]["fecha"]	
            );
            $i++;
         }
     
      $results = array(
          "sEcho"=>1, //Información para el datatables
          "iTotalRecords"=>count($data), //enviamos el total registros al datatable
          "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
          "aaData"=>$data);
      echo json_encode($results);
    break;
}

?>
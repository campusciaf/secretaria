<?php 

require_once  '../modelos/Pendientesevaluaciondocente.php';
$pendiente = new Pendiente();

switch ($_GET['op']) {
    case 'listar':
        $id_escuela=$_GET["id_escuela"];

        $estudiantes = $pendiente->estudiantes($id_escuela);

        $data['conte'] = '';

        $data['conte'] .= '
        <table class="table col-12 table-sm compact" id="tbl_listar">
            <thead>
                <tr>
                <th scope="col">id_credencial</th>
                <th scope="col">id_estudiante</th>
                <th scope="col">Identificación</th>
                <th scope="col">Nombre Estudiante</th>
                <th scope="col">Programa Ac</th>
                <th scope="col">Matrículadas</th>
                <th scope="col">Evaluadas</th>
                <th scope="col">Por responder</th>
                </tr>
            </thead>
            <tbody>';
        

        for ($i=0; $i < count($estudiantes); $i++) { 
            
            $cant_materias = $pendiente->cant_materias($estudiantes[$i]['id_estudiante'],$estudiantes[$i]['ciclo']);
            $cantidad_materias=$cant_materias["cantidad_matriculadas"];

            $cant_respondidas = $pendiente->cant_respondidas($estudiantes[$i]['id_estudiante']);
            $cantidad_respuesta=$cant_respondidas["cantidad_respuesta"];
            
            $resultado = $cantidad_materias - $cantidad_respuesta;
            

                $data['conte'] .= '
                <tr>
                    <th>'.$estudiantes[$i]['id_credencial'].'</th>
                    <th>'.$estudiantes[$i]['id_estudiante'].'</th>
                    <td>'.$estudiantes[$i]["credencial_identificacion"].'</td>
                    <td>'.$estudiantes[$i]["credencial_apellido"].' ' . $estudiantes[$i]["credencial_apellido_2"] .' ' . $estudiantes[$i]["credencial_nombre"] .' ' . $estudiantes[$i]["credencial_nombre_2"].'</td>
                    <td>'.$estudiantes[$i]['fo_programa'].'</td>
                    <td>'.$cantidad_materias.'</td>
                    <td>'.$cantidad_respuesta.'</td>
                    <td>'.$resultado.'</td>
                </tr>';
            
        }

        $data['conte'] .= '</tbody></table>';

        echo json_encode($data);

    break;
    case 'listarescuelas':
		$data= Array();//Vamos a declarar un array
		$data["mostrar"] ="";//iniciamos el arreglo
        $data["mostrar"] .= '<div class="row">';
            $traerescuelas = $pendiente->listarescuelas();
            for($a=0;$a<count($traerescuelas);$a++){
                $escuela=$traerescuelas[$a]["escuelas"];
                $clase=$traerescuelas[$a]["clase"];
                $color=$traerescuelas[$a]["color"];
                $bg_color=$traerescuelas[$a]["bg_color"];
                
                $id_escuelas=$traerescuelas[$a]["id_escuelas"];
                $data["mostrar"] .= '


                <div class="" role="group" aria-label="Basic example">
                    <button onclick="listar('.$id_escuelas.','.$a.')"  class="btn btn-light" title="ver cifras" id="boton'.$a.'">
                    
                        <b style="color:'.$color.' !important">'.$escuela.'</b>
                       
                    </button>
                    
                </div>';

            }
         $data["mostrar"] .= '</div>';   

		
            echo json_encode($data);
	break;
}


?>
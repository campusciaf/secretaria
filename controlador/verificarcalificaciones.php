<?php
require '../modelos/Verificarcalificaciones.php';
$verificarcalficaciones = new VerificarCalificaciones();

$programa=isset($_POST["programa"])? limpiarCadena($_POST["programa"]):"";
$corte=isset($_POST["corte"])? limpiarCadena($_POST["corte"]):"";


switch ($_GET['op']) {

    case 'listarProgramas':
        $verificarcalficaciones->listarProgramas();
    break;

    case 'consulta2':
        $programa = $_POST['programa'];
        $corte = $_POST['corte'];
        //echo $programa." ".$corte;
        $datos = $verificarcalficaciones->consulta($programa);
        $data['conte'] = '';

        $data['conte'] .= '<table class="table table-compact table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombre Docente</th>
                                    <th scope="col">Materia</th>
                                    <th scope="col">Jornada</th>
                                    <th scope="col">Semestre</th>
                                    <th scope="col">Programa</th>
                                    <th scope="col">Estado calificación</th>
                                </tr>
                            </thead>
                            <tbody>';

        for ($i=0; $i < count($datos); $i++) { 
            $id_materia=$datos[$i]['id_materia'];


            $datosmateria=$verificarcalficaciones->BuscarDatosAsignatura($id_materia);
			$nombre_materia=$datosmateria["nombre"];


            $docente = $verificarcalficaciones->datosDocente($datos[$i]['id_docente']);
            $pro = $verificarcalficaciones->datosPrograma($datos[$i]['id_programa']);
            $verinotas = $verificarcalficaciones->verificarcalificacion($corte,$programa,$nombre_materia,$datos[$i]['ciclo'],$datos[$i]['semestre'],$datos[$i]['jornada']);
            $a = ($verinotas == 0)? '<div class="text-center"><span class="btn-danger btn-sm"><i class="far fa-times-circle"></i> Pendiente</span></div>' : '<div class="text-center"><span class="btn-success btn-sm"><i class="far fa-check-circle"></i> Al dia</span></div>';
            $data['conte'] .= '<tr>
                                    <th scope="row">'.$docente['cc'].'</th>
                                    <td>'.$docente['nombre'].'</td>
                                    <td>'.$nombre_materia.'</td>
                                    <td>'.$datos[$i]['jornada'].'</td>
                                    <td>'.$datos[$i]['semestre'].'</td>
                                    <td>'.$pro['nombre'].'</td>
                                    <td>'.$a.'</td>
                                </tr>';
        }

        $data['conte'] .= '</tbody></table>';

        echo json_encode($data);
    break;


    case 'consulta':
        $programa=$_GET["programa"];
        $corte=$_GET["corte"];

        $datos = $verificarcalficaciones->consulta($programa);
        
    
        for ($i=0; $i < count($datos); $i++) { 

            $id_materia=$datos[$i]['id_materia'];

            $docente = $verificarcalficaciones->datosDocente($datos[$i]['id_docente']);

            $datosmateria=$verificarcalficaciones->BuscarDatosAsignatura($id_materia);
			$nombre_materia=$datosmateria["nombre"];

            $programadatos = $verificarcalficaciones->datosPrograma($datos[$i]['id_programa']);
            $nombre_programa=$programadatos["nombre"];

            $verinotas = $verificarcalficaciones->verificarcalificacion($corte,$programa,$nombre_materia,$datos[$i]['ciclo'],$datos[$i]['semestre'],$datos[$i]['jornada']);
            $a = ($verinotas == 0)? '<div class="text-center"><span class="btn-danger btn-sm"><i class="far fa-times-circle"></i> Pendiente</span></div>' : '<div class="text-center"><span class="btn-success btn-sm"><i class="far fa-check-circle"></i> Al dia</span></div>';

            $data[]=array(
                "0"=>$docente['cc'],
                "1"=>$docente['apellido'],
                "2"=>$docente['nombre'],
                "3"=>$nombre_materia,
                "4"=>$datos[$i]['jornada'],
                "5"=>$datos[$i]['semestre'],
                "6"=>$datos[$i]['corte'],
                "7"=>$nombre_programa,
                "8"=>$a

            );
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
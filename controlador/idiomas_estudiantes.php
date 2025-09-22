<?php 

session_start(); 
require_once "../modelos/Idiomas_estudiantes.php";
$consulta = new Consulta();

switch ($_GET['op']) {
    case 'listar':
        
        
        $data['conte'] = '';
        $datos = $consulta->listar();

        $data['conte'] .= '
                    <table id="tbllistado" class="table table-hover">
                            <thead>
                                <th> CC </th>
                                <th> Nombre </th>
                                <th> Programa </th>
                                <th> Niveles </th>
                                <th> Tipo </th>
                                <th> Estado</th>
                            </thead>
                            <tbody>  
        ';

        for ($i=0; $i < count($datos); $i++) { 

            if ($datos[$i]['tipo'] == 1) {
                $tipo = '<small class="badge badge-primary">Pagos</small>';
            }

            if ($datos[$i]['tipo'] == 2) {
                $tipo = '<a href="../files/estudiantes/1004681758.jpg" target="_blank" rel="noopener noreferrer" style="text-decoration: none;"><small class="badge badge-danger"><i class="fa fa-file-pdf"></i> Prueba</small></a>
                ';
            }

            $estudiante = $consulta->datos_estu($datos[$i]['id_credencial']);
            $programa = $consulta->programa($datos[$i]['id_programa']);
            $color = ($datos[$i]['estado'] == 1) ? 'success' : 'warning' ;
            $estado = ($datos[$i]['estado'] == 1) ? 'Aprobado' : 'Cursando' ;
            $data['conte'] .= '
            <tr>
                <td scope="row">'.$estudiante['credencial_identificacion'].'</td>
                <td>'.$estudiante['credencial_nombre'].' '.$estudiante['credencial_nombre_2'].' '.$estudiante['credencial_apellido'].' '.$estudiante['credencial_apellido_2'].'</td>
                <td>'.$programa['nombre'].'</td>
                <td>'.$datos[$i]['cantidad'].'/'.$programa['cant_asignaturas'].'</td>
                <td>'.$tipo.'</td>
                <td><small class="badge badge-'.$color.'">'.$estado.'</small></td>
            </tr>
            ';
        }

        $data['conte'] .= '
                </tbody>
            </table>
        ';

        echo json_encode($data);

    break;

    case 'consulta':
        $val = $_POST['val'];
        $restl = $consulta->consulta($val);

        echo json_encode($restl);
    break;

    case 'consulta_programa':
        $rstl = $consulta->consulta_programa();
        $data['conte'] = '';

        $data['conte'] .= '<option selected disabled>-Selecciona-</option>';

        for ($i=0; $i < count($rstl); $i++) { 
            $data['conte'] .= '<option value="'.$rstl[$i]['id_programa'].'">'.$rstl[$i]['nombre'].'</option>';
        }

        echo json_encode($data);

    break;
}

?>
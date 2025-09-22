<?php
require_once "../modelos/Gestionparciales.php";
$gestion = new Gestion();
switch ($_GET['op']) {
    case 'consulta':
        $programa = $_POST['programa'];
        $jornada = $_POST['jornada'];
        $semestre = $_POST['semestre'];
        $periodo=$_POST["periodo"];

        $data['conte'] = '<table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombre Docente</th>
                                    <th scope="col">Asignatura</th>
                                    <th scope="col">Programa</th>
                                    <th scope="col">Jornada</th>
                                    <th scope="col">C1</th>
                                    <th scope="col">C2</th>
                                    <th scope="col">C3</th>
                                    <th scope="col">C4</th>
                                    <th scope="col">C5</th>
                                </tr>
                            </thead>
                            <tbody>';

        $datos = $gestion->consulta($programa,$jornada,$semestre,$periodo);

        for ($i=0; $i < count($datos); $i++) { 
            $id_materia=$datos[$i]['id_materia'];
            $datosmateria=$gestion->BuscarDatosAsignatura($id_materia);

            $docente = $gestion->datosDocente($datos[$i]['id_docente']);
            $programa = $gestion->programa($datos[$i]['id_programa']);
            $si = '<button onclick=cambiarestado('.$datos[$i]['id_docente_grupo'].',"1","'; $si2 ='") class="btn btn-danger"><i class="fas fa-lock"></i></button>';
            $no = '<button onclick=cambiarestado('.$datos[$i]['id_docente_grupo'].',"0","'; $no2 ='") class="btn btn-success"><i class="fas fa-lock-open"></i></button>';
            $c1 = ($datos[$i]['c1'] == "0") ? $si.'c1'.$si2 : $no.'c1'.$no2;
            $c2 = ($datos[$i]['c2'] == "0") ? $si.'c2'.$si2 : $no.'c2'.$no2;
            $c3 = ($datos[$i]['c3'] == "0") ? $si.'c3'.$si2 : $no.'c3'.$no2;
            $c4 = ($datos[$i]['c4'] == "0") ? $si.'c4'.$si2 : $no.'c4'.$no2;
            $c5 = ($datos[$i]['c5'] == "0") ? $si.'c5'.$si2 : $no.'c5'.$no2;
            $data['conte'] .= '<tr>
                                <th scope="row">'.$docente['cc'].'</th>
                                <td>'.$docente['nombre'].'</td>
                                <td>'.$datosmateria["nombre"].'</td>
                                <td>'.$programa['nombre'].'</td>
                                <td>'.$datos[$i]['jornada'].'</td>
                                <td>'.$c1.'</td>
                                <td>'.$c2.'</td>
                                <td>'.$c3.'</td>
                                <td>'.$c4.'</td>
                                <td>'.$c5.'</td>
                            </tr>';
        }

        $data['conte'] .= '</tbody></table>';

        $data['button'] ="";

        echo json_encode($data);
        

        break;
    case 'cambiarestado':
        $docente = $_POST['docente'];    
        $medio = $_POST['medio'];
        $columna = $_POST['columna'];
        $gestion->cambiarestado($docente,$medio,$columna);
        break;
    case 'cambiartodo':
        $val = $_POST['val'];
        $programa = $_POST['programa'];
        $jornada = $_POST['jornada'];
        $semestre = $_POST['semestre'];
        $corte = $_POST['corte'];

        $gestion->cambiartodo($val,$programa,$jornada,$semestre,$corte);
        
        break;


        case "selectPeriodo":	
            $rspta = $gestion->selectPeriodo();
            echo "<option value=''>Seleccionar</option>";
            for ($i=0;$i<count($rspta);$i++)
                {
                    echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
                }
        break;

}

?>
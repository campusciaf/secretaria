<?php
require_once "../modelos/Actualidad.php";
$consulta = new Consulta();
switch ($_GET['op']) {
    case 'mostrarPeriodo':
       $consulta->mostrarPeriodo();
    break;
    case 'consulta':
        $medio = $_POST['guia'];
        $jornada = $_POST['jornada'];
        $programa = $_POST['programa'];
        if($jornada=="Todas las Jornadas"){
            $jornada="Ninguno";
        }
        $data['conte'] = "";
        $estudiantes = $consulta->consultaestudiante($medio,$jornada,$programa);
        //print_r($estudiantes);
        $data['conte'] .= '
        <table class="table table-sm table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Identificación</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Celular</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Correo P</th>
                    <th scope="col">Genero</th>
                    <th scope="col">Programa</th>
                    <th scope="col">Jornada</th>
                    <th scope="col">Semestre</th>
                    <th scope="col">Periodo ingreso</th>
                    <th scope="col">Departamento</th>
                    <th scope="col">Municipio</th>
                    <th scope="col">Direccion</th>
                    <th scope="col">Barrio</th>
                    <th scope="col">Latitud</th>
                    <th scope="col">Longitud</th>
                    <th scope="col">Caracterizado</th>
                    <th scope="col">Fecha Nacimiento</th>
                </tr>
            </thead>
            <tbody>';
                    for ($i=0; $i < count($estudiantes); $i++) {
                        $datos = $consulta->consultaDatos($estudiantes[$i]['id_credencial']);
                        $caract = $consulta->est_carac_habeas($estudiantes[$i]['id_credencial']);
                        if($caract==true){
                            $estado_caracteriazdo="si";
                        }else{
                            $estado_caracteriazdo="no";
                        }

                        $data['conte'] .= '<tr>';
                        $data['conte'] .= '<th>'.$datos['id_credencial'].'</th>';
                        $data['conte'] .= '<th>'.$datos['credencial_identificacion'].'</th>';
                        $data['conte'] .= '<td>'.$datos['credencial_nombre'].' '.$datos['credencial_nombre_2'].' '.$datos['credencial_apellido'].' '.$datos['credencial_apellido_2'].'</td>';
                        $data['conte'] .= '<td>'.$datos['celular'].'</td>';
                        $data['conte'] .= '<td>'.$datos['email'].'</td>';
                        $data['conte'] .= '<td>'.$datos['credencial_login'].'</td>';
                        $data['conte'] .= '<td>'.$datos['genero'].'</td>';
                        $data['conte'] .= '<td>'.$estudiantes[$i]['fo_programa'].'</td>';
                        $data['conte'] .= '<td>'.$estudiantes[$i]['jornada_e'].'</td>';
                        $data['conte'] .= '<td>'.$estudiantes[$i]['semestre_estudiante'].'</td>';
                        $data['conte'] .= '<td>'.$estudiantes[$i]['periodo'].'</td>';
                        $data['conte'] .= '<td>'.$datos['departamento_residencia'].'</td>';
                        $data['conte'] .= '<td>'.$datos['municipio'].'</td>';
                        $data['conte'] .= '<td>'.$datos['direccion'].'</td>';
                        $data['conte'] .= '<td>'.$datos['barrio'].'</td>';
                        $data['conte'] .= '<td>'.$datos['latitud'].'</td>';
                        $data['conte'] .= '<td>'.$datos['longitud'].'</td>';
                        $data['conte'] .= '<td>'.$estado_caracteriazdo.'</td>';
                        $data['conte'] .= '<td>'. $datos['fecha_nacimiento'].'</td>';
                        $data['conte'] .= '</tr>';
                    }
                    $data['conte'] .= '
                </tbody>

            </table>';
        echo json_encode($data);
    break;
    case 'consultaNuevos':
        $medio = $_POST['guia'];
        $jornada = $_POST['jornada'];
        $programa = $_POST['programa'];
        $periodo = $_POST['periodo'];
        $data['conte'] = "";
        if($jornada=="Todas las Jornadas"){
            $jornada="Ninguno";
        }
        $estudiantestotal = $consulta->consultaestudiantenuevostotal($medio,$jornada,$programa,$periodo);
        $estudiantes = $consulta->consultaestudiantenuevos($medio,$jornada,$programa,$periodo);
        //print_r($estudiantes);

        $data['conte'] .= '
         <div class="titulo-2"> Total Estudiantes: '.count($estudiantestotal).'</div>
        <table class="table table-nowarp table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Celular</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Programa</th>
                    <th scope="col">Jornada</th>
                    <th scope="col">Semestre</th>
                    <th scope="col">Periodo Ingreso</th>
                    <th scope="col">Periodo activo</th>
                    <th scope="col">Estado</th>
                    <th scope="col">admisiones</th>
                    <th scope="col">Caracterizado</th>
                </tr>
            </thead>
            <tbody>';
        for ($i=0; $i < count($estudiantes); $i++) {
            $datos = $consulta->consultaDatos($estudiantes[$i]['id_credencial']);
            $caract = $consulta->est_carac_habeas($estudiantes[$i]['id_credencial']);
            if($caract==true){
                $estado_caracteriazdo="si";
            }else{
                $estado_caracteriazdo="no";
            }

            $periodos=$consulta->periodoactual();
            $periodo_actual=$periodos["periodo_actual"];
            $periodo_anterior=$periodos["periodo_anterior"];
            $periodo_siguiente=$periodos["periodo_siguiente"];
            $temporada_actual=$periodos["temporada"];

            $temporada_estudiante=$estudiantes[$i]['temporada'];
            $estado="sin estado";

            if($estudiantes[$i]['periodo_activo']==$periodo_actual or $estudiantes[$i]['periodo_activo']== $periodo_siguiente){
                $estado="Activo";
            }
            else if($estudiantes[$i]['periodo_activo']==$periodo_anterior){
                $estado="Por renovar";
            }else{
                $estado="Deserción";
            }

            $data['conte'] .= '<tr>';
            $data['conte'] .= '<th>'.$datos['credencial_identificacion'].'</th>';
            $data['conte'] .= '<td>'.$datos['credencial_nombre'].' '.$datos['credencial_nombre_2'].' '.$datos['credencial_apellido'].' '.$datos['credencial_apellido_2'].'</td>';
            $data['conte'] .= '<td>'.$datos['celular'].'</td>';
            $data['conte'] .= '<td>'.$datos['email'].'</td>';
            $data['conte'] .= '<td>'.$estudiantes[$i]['fo_programa'].'</td>';
			$data['conte'] .= '<td>'.$estudiantes[$i]['jornada_e'].'</td>';
            $data['conte'] .= '<td>'.$estudiantes[$i]['semestre_estudiante'].'</td>';
            $data['conte'] .= '<td>'.$estudiantes[$i]['periodo'].'</td>';
            $data['conte'] .= '<td>'.$estudiantes[$i]['periodo_activo'].'</td>';
            $data['conte'] .= '<td>'.$estado.'</td>';
		    $data['conte'] .= '<td>'.$estudiantes[$i]['admisiones'].'</td>';
            $data['conte'] .= '<td>'.$estado_caracteriazdo.'</td>';
            $data['conte'] .= '</tr>';
        }
        echo json_encode($data);
    break;
    case 'mostrarJornada':
        $consulta->mostrarJornada();
    break;
    case 'listarProgra':
        $consulta->listarPrograma();
    break;
}
?>
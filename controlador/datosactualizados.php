<?php 
require_once "../modelos/Datosactualizados.php";
$consulta = new Consulta();
switch ($_GET['op']) {
    case 'consulta':
        $estado = $_POST['estado'];
        $datos = $consulta->datos($estado);
        $data['conte'] = '';

        $data['conte'] .= '<table class="table compact" id="dtl_consulta">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Programa</th>
                                <th scope="col">Jornada</th>
                                <th scope="col">Telefono</th>
                                <th scope="col">Correo CIAF</th>
                                <th scope="col">Correo personal</th>
                                <th scope="col">Caracterizado</th>
								<th scope="col">Edad</th>
								<th scope="col">Genero</th>
                            </tr>
                        </thead>
                        <tbody>';

        for ($i=0; $i < count($datos); $i++) {
            $estudiante = $consulta->consultaDatos($datos[$i]['id_credencial']);
            $caracterizado = $consulta->est_carac_habeas($datos[$i]['id_credencial']);
            if(empty($caracterizado)){
                $caracterizado = "No";
            }else{
                $caracterizado = "Si";
            }
            if ($estado == $estudiante['status_update']) {

				
                $data['conte'] .= '<tr>
                                    <th>'.$estudiante['credencial_identificacion'].'</th>
                                    <td>'.$estudiante['credencial_nombre'].' '.$estudiante['credencial_nombre_2'].' '.$estudiante['credencial_apellido'].' '.$estudiante['credencial_apellido_2'].'</td>
                                    <td>'.$estudiante['fo_programa'].'</td>
                                    <td>'.$estudiante['jornada_e'].'</td>
                                    <td>'.$estudiante['celular'].'</td>
                                    <td>'.$estudiante['credencial_login'].'</td>
                                    <td>'.$estudiante['email'].'</td>
                                    <td>'.$caracterizado.'</td>
									<td>'.$consulta->calculaedad($estudiante['fecha_nacimiento']).'</td>
                                    <td>'.$estudiante['genero'].'</td>
                                </tr>';
            }
            
        }
        $data['conte'] .= '</tbody></table>';

        echo json_encode($data);

        break;
}

?>
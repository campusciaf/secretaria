<?php
session_start();
require_once "../modelos/NoContinuaron.php";

date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('H:i:S');

$nocontinuaron = new NoContinuaron();

$rsptaperiodo = $nocontinuaron->periodoactual();
$periodo_actual = $rsptaperiodo['periodo_actual'];
$periodo_anterior = $rsptaperiodo['periodo_anterior'];
$temporada=$rsptaperiodo['temporada']-2;
switch ($_GET["op"]) {

    case 'listarescuelas':
        $data = array(); //Vamos a declarar un array
        $data["mostrar"] = ""; //iniciamos el arreglo
        $data["mostrar"] .= '<div class="row">';
        $traerescuelas = $nocontinuaron->listarescuelas();
        for ($a = 0; $a < count($traerescuelas); $a++) {
            $escuela = $traerescuelas[$a]["escuelas"];
            $color = $traerescuelas[$a]["color"];
            $color_ingles = $traerescuelas[$a]["color_ingles"];
            $nombre_corto = $traerescuelas[$a]["nombre_corto"];
            $id_escuelas = $traerescuelas[$a]["id_escuelas"];
            $data["mostrar"] .= '
            
            <div style="width:170px">
                <a onclick="listar(' . $id_escuelas . ')" title="ver cifras" class="row pointer m-2">
                    <div class="col-3 rounded bg-light-'.$color_ingles.'">
                        <div class="text-red text-center pt-1">
                            <i class="fa-regular fa-calendar-check fa-2x  text-'.$color_ingles.'" ></i>
                        </div>
                        
                    </div>
                    <div class="col-9 borde">
                        <span>Escuela de</span><br>
                        <span class="titulo-2 fs-12 line-height-16"> ' . $nombre_corto . '</span>
                    </div>
                </a>
            </div>';
        }
        $data["mostrar"] .= '</div>';
        echo json_encode($data);
    break;
    case 'listar':
        $data = array(); //Vamos a declarar un array
        $data["mostrar"] = ""; //iniciamos el arreglo
        $id_escuela = $_POST["id_escuela"];
        $nombreescuela = $nocontinuaron->nombreescuela($id_escuela);
        // consulta para traer los activos de la tabla estudiantes
        $traerestudiantes = $nocontinuaron->traerestudiantes($id_escuela,$temporada);

        $data["mostrar"] .= ' 
        <div class="col-12 tono-3 mt-2 px-4 py-2 ">
            <p class="titulo-3 m-0">Escuela de ' . $nombreescuela["escuelas"] . '</p>
        </div>
        <div class="tono-3 m-0 p-1" style="border-bottom: 1px solid ' . $nombreescuela["color"] . '"></div>
            <div class="col-12 p-4 table-responsive">
                <table class="table table-hover" style="width:100%">
                    <thead>
                        <th>ID est. act</th>
                        <th>identificación</th>
                        <th>Nombre estudiante</th>
                        <th>Programa</th>
                        <th>Jornada</th>
                        <th>Ingreso</th>
                        <th>Activo</th>
                        <th>Celular</th>
                        <th>Correo</th>
                    </thead>
                    <tbody>';
                    for ($a = 0; $a < count($traerestudiantes); $a++) {
                        $id_credencial = $traerestudiantes[$a]["id_credencial"];
                        $id_estudiante = $traerestudiantes[$a]["id_estudiante"];
                        $mirarsicontinuo=$nocontinuaron->mirarsicontinuo($id_credencial);
                        if(!$mirarsicontinuo){// si no continuaron en el ciclo 2
                            $dato_credencial = $nocontinuaron->dato_estudiante_credencial($id_credencial);
                            $credencial_identificacion = $dato_credencial["credencial_identificacion"];
                            $credencial_nombre = $dato_credencial["credencial_apellido"] . " " . $dato_credencial["credencial_apellido_2"] . " " . $dato_credencial["credencial_nombre"] . " " . $dato_credencial["credencial_nombre_2"];
                            $dato_estudiante = $nocontinuaron->dato_estudiante($id_estudiante);
                            $celular = $dato_estudiante["celular"];
                            $email = $dato_estudiante["email"];

                            $data["mostrar"] .= '
                                <tr>
                                    <td>'.$id_estudiante.'</td>
                                    <td>'.$credencial_identificacion.'</td>
                                    <td>'.$credencial_nombre.'</td>
                                    <td>'.$traerestudiantes[$a]["fo_programa"].'</td>
                                    <td>'.$traerestudiantes[$a]["jornada_e"].'</td>
                                    <td>'.$traerestudiantes[$a]["periodo"].'</td>
                                    <td>'.$traerestudiantes[$a]["periodo_activo"].'</td>
                                    <td>'.$celular.'</td>
                                    <td>'.$email.'</td>
                                </tr>';
        
                        }
                    }
        $data["mostrar"] .= '</tbody>';
        $data["mostrar"] .= '</table>';
        $data["mostrar"] .= '</div></div>';
        echo json_encode($data);
    break;
}
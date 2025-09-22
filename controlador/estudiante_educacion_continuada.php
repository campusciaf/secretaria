<?php
require_once "../modelos/EstudianteEducacionContinuada.php";
//modelo en el cual estan las funciones a base de datos 
$consulta = new EstudianteEducacionContinuada();
//dependiendo de la opcion que envien por el GET, el switch determinara donde entrar
switch ($_GET['op']) {
    case 'listarCursosEducacionContinuada':
        $cursos = $consulta->listarCursosEducacionContinuada();
        $array["exito"] = 0;
        $array["html"] = "";
        //dependiendo de la cantidad de registros, el for hara un bucle almacenandolos en el array
        for ($i = 0; $i < count($cursos); $i++) {
            $imagen_curso = $cursos[$i]["imagen_curso"];
            $nombre_curso = $cursos[$i]["nombre_curso"];
            $descripcion_curso = $cursos[$i]["descripcion_curso"];
            $modalidad_curso = $cursos[$i]["modalidad_curso"];
            $fecha_inicio = $cursos[$i]["fecha_inicio"];
            $precio_curso = $cursos[$i]["precio_curso"];
            $duracion_educacion = $cursos[$i]["duracion_educacion"];
            $categoria = $cursos[$i]["categoria"];

            $array["exito"] = 1;
            $precio_curso = $consulta->formatoDinero($precio_curso);
            $fecha_inicio = $consulta->fechaesp($fecha_inicio);
            $array["html"] .= '
                <div class="col-4 mb-4 p-3">
                    <div class="card mb-3" style="max-width: 540px;">
                        <div class="row no-gutters">
                            <img class="card-img-top" src="https://ciaf.digital/public/img_educacion/'.$imagen_curso.'" alt="...">
                            <div class="card-body">
                                <h5 class="text-center mb-4">' .$nombre_curso. '</h5>
                                <div class="card-text limitar-texto">
                                '. $descripcion_curso.'
                                </div>
                                <table class="table border-0 text-center mt-3">
                                    <tr>
                                        <td>Inicio <br> <b> '.$fecha_inicio.'</b></td>
                                        <td>Modalidad <br> <b> '.$modalidad_curso.'</b> </td>
                                        <td>Duración <br> <b> '.$duracion_educacion.'</b></td>
                                        <td>Inversion <br> <b> $'.$precio_curso.'</b></td>
                                    </tr>
                                </table>
                                <div class="text-center mt-3">
                                    <a href="" class="btn bg-morado btn-block text-white font-weight-bolder" target="_blank">Inscribirme</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        }
        echo json_encode($array);
        break;


}

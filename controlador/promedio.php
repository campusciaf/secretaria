<?php
require  '../modelos/Promedio.php';
$promedio = new Promedio();
switch ($_GET['op']) {
    case 'consulta':
        $cedula = $_POST['cedula'];
        $datos = $promedio->consulta($cedula);
        $data['table'] = "";
        if ($datos) {
            $imagen = (file_exists('../files/estudiantes/'.$datos['credencial_identificacion'])) ? $datos['credencial_identificacion'].'jpg' : 'null.jpg' ;
            $programa = $promedio->consultaProgramas($datos['id_credencial']);
            $data['datos'] = '<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center">
                    <img src="../files/'.$imagen.'" class="img-thumbnail">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <table class="table table-hover table-nowarp">
                        <tbody>
                            <tr>
                                <td><i class="fas fa-user fa-2x"></i> '.$datos['credencial_nombre'].' '.$datos['credencial_nombre_2'].' '.$datos['credencial_apellido'].' '.$datos['credencial_apellido_2'].'</td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-portrait fa-2x"></i> '.$programa[0]['fo_programa'].'</td>
                            </tr>
                            <tr>
                                <td><i class="far fa-clock fa-2x"></i> '.$programa[0]['jornada_e'].'</td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-envelope-open-text fa-2x"></i> '.$datos['credencial_login'].'</td>
                            </tr>
                        </tbody>
                    </table>
                </div>';
            $data['table'] = '<table class="table table-hover table-nowarp">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Programa</th>
                    <th scope="col">Jornada</th>
                    <th scope="col">Periodo Activo</th>
                    </tr>
                </thead>
            <tbody>';
            for ($i=0; $i < count($programa); $i++) { 
                $data['table'].='<tr>
                    <td><button class="btn btn-success btn-flat" onclick=promedios("'.$programa[$i]['id_estudiante'].'","'.$programa[$i]['id_programa_ac'].'","'.$programa[$i]['ciclo'].'") ><i class="fas fa-plus-square"></i></button></td>
                    <td>'.$programa[$i]['fo_programa'].'</td>
                    <td>'.$programa[$i]['jornada_e'].'</td>
                    <td>'.$programa[$i]['periodo_activo'].'</td>
                </tr>';
            } 
            $data['table'] .='</tbody>
                    </table>';
        }else{
            $data['datos'] = '<div class="toast bg-danger fade show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="mr-auto"><i class="fas fa-exclamation-triangle"></i> Error</strong>
            </div>
                <div class="toast-body">La cedula no se encuentra registrada, verifica e intenta nuevamente.</div>
            </div>';
        }
        echo json_encode($data);
    break;
    case 'consultaMaterias':
        $id_usuario = $_POST['id_usuario'];
        $id_programa = $_POST['id_programa'];
        $ciclo = $_POST['ciclo'];
        $creditos = 0;
        $suma = 0;
        $sumafinal = 0;
        $semestres = $promedio->cantidadSemestre($id_programa);
        $data['notas'] = "";
        $data['notas'] .= "
                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                    <button class='btn btn-primary btn-block btn-flat' onclick=volver()><i class='fas fa-arrow-left'></i> Volver</button>
                </div>";
        for ($i=0; $i < $semestres['semestres']; $i++) {
            $creditos = 0;
            $suma = 0;
            $data['notas'] .= '<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2 mt-2">
                <div class="card">
                    <div class="card-header border-1">
                        <h3 class="card-title">Semestre '.($i+1).'</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-info" data-card-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">';
            $datos = $promedio->consultaMaterias($id_usuario,$id_programa,$ciclo,$i+1);
            for ($p=0; $p < count($datos); $p++) { 
                $creditos = $creditos+$datos[$p]['creditos'];
            }
            for ($a=0; $a < count($datos); $a++) {
                $formula = 0;
                $nota = ($datos[$a]['promedio'] >= 3.0) ? $datos[$a]['promedio']." <span class='text-green'><i class='fas fa-check-circle'></i> Aprobado</span>" : $datos[$a]['promedio']." <span class='text-warning'><i class='fas fa-times'></i> No Aprobado</span>";
                $style = ($datos[$a]['promedio'] >= 3.0) ? "success": "danger" ;
                $data['notas'] .= '<div class="alert bg-'.$style.'">
                    <small class="label text-white">['.$datos[$a]['creditos'].']</small>'.$datos[$a]['nombre_materia'].'<br>
                    Promedio: '.$nota.' <i class="fa fa-calendar-alt"></i>'.$datos[$a]['jornada'].'<i class="fa fa-hourglass-start"></i>'.$datos[$a]['periodo'].'
                </div>';
                $formula = ($datos[$a]['creditos'] / $creditos) * $datos[$a]['promedio'];
                $suma = round($suma + $formula,2);
            }
            $style2 = ($suma > 3.0) ? "success": "danger" ;
            $data['notas'] .= "<div class='alert bg-".$style2."'>
                Créditos [".$creditos."] Promedio: ".round($suma,2)."
            </div>";
            $data['notas'] .= "</div>
            </div></div>";
            $sumafinal = $sumafinal + $suma;
        }
        $data['notas'] .= "<div class='row col-xs-12 col-sm-12 col-md-12 col-lg-12' style='margin:0px'>
            <b>Promedio acumulado por los ".$semestres['semestres']." semestres  <u>".  round(($sumafinal/$semestres['semestres']),2) . " </u></b>
        </div>";
        echo json_encode($data);
    break;
}
?>
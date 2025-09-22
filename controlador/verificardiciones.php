<?php
require '../modelos/Verificardiciones.php';

$verifica = new Verifica();

switch ($_GET['op']) {
    case 'consultaCedula':
        $cedula = $_POST['cc'];
        $titulo = $_POST['titulo'];
        $verifica->consultaCedula($cedula,$titulo);
        break;
    case 'guardarEstado':
        $titulo = ($_POST['titulo'] == "")? "" : $_POST['titulo'];
        $verificar_estudiante = ($_POST['verificar_estudiante'] == "") ? "" : $_POST['verificar_estudiante'];
        $estado_est = ($_POST['estado_est'] == "")? "": $_POST['estado_est'];
        $numero_acta = ($_POST['numero_acta'] == "")? "": $_POST['numero_acta'];
        $folio = ($_POST['folio'] == "")? "": $_POST['folio'];
        $ano_graduacion = ($_POST['ano_graduacion'] == "")? "":$_POST['ano_graduacion'];
        $periodo = ($_POST['periodo'] == "")? "":$_POST['periodo'];

        $consulta = $verifica->guardarEstado($titulo,$verificar_estudiante,$estado_est,$numero_acta,$folio,$ano_graduacion,$periodo);
        //echo json_encode($consulta);
        if ($consulta['result'] == "ok") {
            $data['status'] = "ok";

            $datos = $verifica->consultaDatos($verificar_estudiante);

            $data['conte'] = $datos['conte'];
        } else {
           $data['status'] = "error";
        }

        echo json_encode($data);

        break;
    case 'listarMaterias':
        $cedula = $_POST['cc'];
        $tipo = $_POST['tipo'];
        $data['conte'] = "";
        $semestres = $verifica->consultaSemestres($cedula,$tipo);
        for ($i=0; $i < count($semestres); $i++) { 
            
            
            
            $materias = $verifica->consultaMateria($cedula,$tipo,$semestres[$i]['semestre']);
                $data['conte'] .= '<div class="alert col-xs-12 col-sm-6 col-md-4 col-lg-2">';
                $data['conte'] .= '<div class="alert bg-primary col-xs-12 col-sm-12 col-md-12 col-lg-12"> Semestre '.$semestres[$i]['semestre'].'</div>';
                
                for ($a=0; $a < count($materias); $a++) {

                    $nota = ($materias[$a]['nota'] >= 3) ? "<span class='text-success'> <i class='far fa-sticky-note'></i> ".$materias[$a]['nota']."</span>" : " <span class='text-danger'> <i class='far fa-sticky-note'></i> ".$materias[$a]['nota']."</span>";

                    $data['conte'] .= '<div class="panel panel-warning col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <button type="button" class="close" onClick="eliminarMateria('.$materias[$a]['id_materia'].')" data-dismiss="modal">&times;</button>
                    
                                    <p class="small">'.$materias[$a]['nombre_materia'].' ['.$materias[$a]['creditos'].']</p> 
                                    '.$nota.' <i class="fas fa-calendar-alt"></i> '.$materias[$a]['periodo'].' <i class="far fa-clock"></i> '.$materias[$a]['jornada'].' <button type="button" style="padding: 0 2px 0 2px !important;" class="btn btn-warning btn-xs" onClick="consultaMateria('.$materias[$a]['id_materia'].')"><i class="fas fa-pencil-alt fa-1x"></i></button>
                                </div>';
                }
                $data['conte'] .= '</div>';
        }

        echo json_encode($data);
        break;
    case 'aggMaterias':
       $cc = $_POST['cc'];
       $tipo = $_POST['tipo'];
       $escuela = $_POST['escuela'];
       $programa = $_POST['programa'];
       $materia = $_POST['materia'];
       $creditos = $_POST['creditos'];
       $semestre = $_POST['semestre'];
       $nota = $_POST['nota'];
       $periodo = $_POST['periodo'];
       $jornada = $_POST['jornada'];

       $verifica->aggMaterias($cc,$tipo,$escuela,$programa,$materia,$creditos,$semestre,$nota,$periodo,$jornada);

        break;
    case 'mostrarJornada':
        $verifica->mostrarJornada();
        break;
    case 'eliminarMateria':
        $id = $_POST['id'];
        $verifica->eliminarMateria($id);
        break;
    case 'consultaMateria':
        $id = $_POST['id'];
        $verifica->consultaMateriaDatos($id);
        break;
    case 'editarMateria':
        $id = $_POST['id'];
        $asignatura = $_POST['asignatura'];
        $creditos = $_POST['creditos'];
        $semestre = $_POST['semestre'];
        $nota = $_POST['nota'];
        $periodo = $_POST['periodo'];
        $jornada = $_POST['jornada'];
        $verifica->editarMateria($id,$asignatura,$creditos,$semestre,$nota,$periodo,$jornada);
        break;
}

?>
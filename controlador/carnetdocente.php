<?php
require_once "../modelos/CarnetDocente.php";


$carnetdocente = new CarnetDocente();
switch ($_GET['op']) {

    case 'buscar':
        
        $cc = $_SESSION['usuario_imagen'];

        $sizeqr = "600";
        $datos = $carnetdocente->datosdocente();

        // traer el periodo actual.
        $perido_carnet = $carnetdocente->PeriodoActualCarnet();
        $anio_carnet =   explode("-", $perido_carnet["periodo_actual"]);
        $periodo_actual_carnet = $anio_carnet[0];
        


        $nombre = $datos['usuario_apellido'].' '.$datos['usuario_apellido_2'].'<div class="pl-4 ">Apellidos</div><br> '.$datos['usuario_nombre'].' '.$datos['usuario_nombre_2'].'<br><small>Nombres</small>';
        $cedula = $datos['usuario_identificacion'];

        


        if (file_exists("../files/docentes/".$datos['usuario_identificacion'].".jpg")) {
            $url = "../files/docentes/".$datos['usuario_identificacion'].".jpg";
        }
        else {
            $url = "../files/null.jpg";
        }


        $data['conte'] = '';
        $data['conte2'] = '';


        

        if ($datos != false) {
            $data['status'] = "ok";
            $data['conte'] .= ' 
                                     
                <div class="col-xl-12" >
                    <table class="m-0 p-0 bg-white" width="480px">
                        <tr>
                            <td>
                            </td>
                            <td rowspan="3" valign="bottom" width="140px" align="center">
                                <img src="../public/img/logo_ciaf_carnet.svg" width="150px">
                                <img src="'.$url.'" width="90px">
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <span class="pl-4"><b>'.$cedula. '</b> RH. '.$datos['usuario_tipo_sangre'].'</span>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" style="line-height:16px"> 
                                <div class="pl-4"><span style="font-weight:700; font-size:18px">'.strtoupper($datos['usuario_apellido']).' ' .strtoupper($datos['usuario_apellido_2']) . '</span><br><span>Apellidos</span></div>
                                <div class="pl-4"><span style="font-weight:700; font-size:18px">'.strtoupper($datos['usuario_nombre']).' ' .strtoupper($datos['usuario_nombre_2']) . '</span><br><span>Nombres</span></div>
                            </td> 
                        </tr>
                        

                        <tr>
                            <td align="right" colspan="2">
                                <span class="small">VENCE: 31/12/'.$periodo_actual_carnet.'</span>
                                <span class="small pr-4">VIGILADA MINEDUCACIÓN</span>
                                
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <div class="row m-0 p-0">
                                    <div class="col-3 bg-primary" style="height:10px"></div>
                                    <div class="col-3 bg-danger" style="height:10px"></div>
                                    <div class="col-3 bg-warning" style="height:10px"></div>
                                    <div class="col-3 bg-success" style="height:10px"></div>
                                    <div class="col-12 text-white" style="height:40px; background-color: #132252; text-align:center; font-size:28px"> Docente CIAF</div>
                                </div>
                            </td>
                        </tr>
                    </table>                
                </div>
               
                
                
        <div class="col-12">
            <table style="border: solid #c4c4c4 1px" class="m-0 p-0" width="480px">
                <tr>
                </tr>
            </table>
            <div class="moverconvenioslider">';
                $eventosacademicos = $carnetdocente->mostrarconvenios();
                for ($i = 0; $i < count($eventosacademicos); $i++) {
                    $nombre_convenio = $eventosacademicos[$i]["nombre_convenio"];
                    $descripcion_convenio = $eventosacademicos[$i]["descripcion_convenio"];
                    $id_web_convenio = $eventosacademicos[$i]["id_web_convenio"];
                    $url_convenio  = $eventosacademicos[$i]["url_convenio"];
                    $imagen_convenio  = $eventosacademicos[$i]["imagen_convenio"];
                    $imagen_convenio_2  = $eventosacademicos[$i]["imagen_convenio"];
                    $ruta_img = '../public/web_convenios/';
                    $url_imagen = '' . $ruta_img . $imagen_convenio . '';
                    $data['conte'] .= '
                        <div class="container mt-5">
                            <div class="row">
                            <div class="card card-deck col-11" >
                                        <div class="row no-gutters">
                                            <div class="col-md-3">
                                                <div class="p-2 justify-content-center align-items-center">
                                                    <div class="bg-white justify-content-center align-items-center">
                                                        <img src="' . $url_imagen . '" class="card-img" width="100" height="100">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <h5 class="titulo-2 fs-20 text-semibold">' . $nombre_convenio . '</h5>
                                                <p class="fs-15 line-height-18">' . $descripcion_convenio . '</p>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>';

    }
        $data['conte'] .= '
                </div>
                </div>';


            
        }else {
            $data['status'] = "error";
        }

        echo json_encode($data);

    break;

    


}

?>
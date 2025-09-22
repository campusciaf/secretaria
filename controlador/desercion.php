<?php
session_start();
require_once "../modelos/Desercion.php";
$desercion = new Desercion();

date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('H:i:s');

$rsptaperiodo = $desercion->periodoactual();
$periodo_actual = $rsptaperiodo["periodo_actual"];
$periodo_anterior = $rsptaperiodo["periodo_anterior"];
$temporadaactual = $rsptaperiodo["temporada"];
$id_credencial = isset($_POST["id_credencial"]) ? limpiarCadena($_POST["id_credencial"]) : "";
$temporadainactivos = $temporadaactual - 2;
$id_usuario = $_SESSION['id_usuario'];

switch ($_GET['op']) {

    case 'listargeneral':
        $data = array();
        $data["total"] = "";
        $listar_estudiantes_porrenovar = $desercion->listargeneralporrenovar($periodo_anterior);
        $listar_estudiantes = $desercion->listargeneralrenovaron($periodo_actual);

        $total_estudiantes_porrenovar = count($listar_estudiantes_porrenovar);
        $totalgeneralrenovaron = count($listar_estudiantes);

        $totalsuma = $total_estudiantes_porrenovar + $totalgeneralrenovaron;

        $avancegeneral = ($totalgeneralrenovaron / $totalsuma) * 100;
        $faltageneral = (100 - $avancegeneral);

        $data["total"] .= '<div class="row">';
        $data["total"] .= '<div class="col-xl-3">';
        $data["total"] .= '
                    <div class="col-12">
                        <div class="info-box bg-olive">
                            <div class="info-box-content">

                                <div class="progress-group">
                                    General
                                    <span class="float-right"><b>' . $totalsuma . '</b></span>
                                </div>

                                <div class="progress-group">
                                    Renovaron
                                    <span class="float-right">
                                        <b><a onclick=listarestudiantes("' . $periodo_actual . '","1") class="text-white" title="Estudiantes que renovaron" style="cursor:pointer">' . $totalgeneralrenovaron . '</a></b>/
                                        ' . round($avancegeneral) . '% </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width: ' . round($avancegeneral) . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group">
                                    Pendiente
                                    <span class="float-right"><b>
                                        <a onclick=listarestudiantes("' . $periodo_anterior . '","2") class="text-white" title="Estudiantes por renovar" style="cursor:pointer">' . $total_estudiantes_porrenovar . '</a></b>/
                                        ' . round($faltageneral, 0) . '% </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width: ' . round($faltageneral) . '%"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>';

        $data["total"] .= '</div>';

        $data["total"] .= '<div class="col-xl-9">';
        $data["total"] .= '<div class="row">';

        $listar_estudiantes_porrenovar_nivel1 = $desercion->listargeneralporrenovarnivel($periodo_anterior, 1);
        $listar_estudiantes_nivel1 = $desercion->listargeneralrenovaronnivel($periodo_actual, 1);

        $total_estudiantes_porrenovar_nivel1 = count($listar_estudiantes_porrenovar_nivel1);
        $totalgeneralrenovaronnivel1 = count($listar_estudiantes_nivel1);

        $totalsuma1 = $total_estudiantes_porrenovar_nivel1 + $totalgeneralrenovaronnivel1;

        $avancegeneral1 = ($totalgeneralrenovaronnivel1 / $totalsuma1) * 100;
        $faltageneral1 = (100 - $avancegeneral1);

        $data["total"] .= '
                        <div class="col-xl-3">
                            <div class="info-box bg-primary">
                                <div class="info-box-content">
                                    <div class="progress-group">
                                        Técnico
                                        <span class="float-right"><b>' . $totalsuma1 . '</b></span>
                                    </div>
                                
                                    <div class="progress-group">
                                        Renovaron
                                        <span class="float-right"><b>
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","1","1") class="text-white" title="Estudiantes que renovaron" style="cursor:pointer">' . $totalgeneralrenovaronnivel1 . '</a></b>/
                                        ' . round($avancegeneral1) . '%</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar"  style="width: ' . round($avancegeneral1) . '%"></div>
                                        </div>
                                    </div>

                                    <div class="progress-group">
                                        Pendiente
                                        <span class="float-right"><b>
                                            <a onclick=listarestudiantesnivel("' . $periodo_anterior . '","1","2") class="text-white" title="Estudiantes por renovar" style="cursor:pointer">' . $total_estudiantes_porrenovar_nivel1 . '</a></b>/
                                            ' . round($faltageneral1, 0) . '%</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar"  style="width: ' . round($faltageneral1) . '%"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>';

        $listar_estudiantes_porrenovar_nivel2 = $desercion->listargeneralporrenovarnivel($periodo_anterior, 2);
        $listar_estudiantes_nivel2 = $desercion->listargeneralrenovaronnivel($periodo_actual, 2);

        $total_estudiantes_porrenovar_nivel2 = count($listar_estudiantes_porrenovar_nivel2);
        $totalgeneralrenovaronnivel2 = count($listar_estudiantes_nivel2);

        $totalsuma2 = $total_estudiantes_porrenovar_nivel2 + $totalgeneralrenovaronnivel2;

        $avancegeneral2 = ($totalgeneralrenovaronnivel2 / $totalsuma2) * 100;
        $faltageneral2 = (100 - $avancegeneral2);

        $data["total"] .= '
                        <div class="col-xl-3">
                            <div class="info-box bg-purple">
                            
                                <div class="info-box-content">
                                    <div class="progress-group">
                                        Tecnologico
                                        <span class="float-right"><b>' . $totalsuma2 . '</b></span>
                                    </div>
                                
                                    <div class="progress-group">
                                        Renovaron
                                        <span class="float-right"><b>
                                            <a onclick=listarestudiantesnivel("' . $periodo_actual . '","2","1") class="text-white" title="Estudiantes que renovaron" style="cursor:pointer">' . $totalgeneralrenovaronnivel2 . '</a>
                                            </b>/' . round($avancegeneral2) . '%</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar"  style="width: ' . round($avancegeneral1) . '%"></div>
                                        </div>
                                    </div>

                                    <div class="progress-group">
                                        Pendiente
                                        <span class="float-right"><b>
                                            <a onclick=listarestudiantesnivel("' . $periodo_anterior . '","2","2") class="text-white" title="Estudiantes por renovar" style="cursor:pointer">' . $total_estudiantes_porrenovar_nivel2 . '</a>
                                            </b>/' . round($faltageneral2, 0) . '%</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar"  style="width: ' . round($faltageneral2) . '%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';

        $listar_estudiantes_porrenovar_nivel3 = $desercion->listargeneralporrenovarnivel($periodo_anterior, 3);
        $listar_estudiantes_nivel3 = $desercion->listargeneralrenovaronnivel($periodo_actual, 3);

        $total_estudiantes_porrenovar_nivel3 = count($listar_estudiantes_porrenovar_nivel3);
        $totalgeneralrenovaronnivel3 = count($listar_estudiantes_nivel3);

        $totalsuma3 = $total_estudiantes_porrenovar_nivel3 + $totalgeneralrenovaronnivel3;

        $avancegeneral3 = ($totalgeneralrenovaronnivel3 / $totalsuma3) * 100;
        $faltageneral3 = (100 - $avancegeneral3);

        $data["total"] .= '
                        <div class="col-xl-3">
                            <div class="info-box bg-maroon">
                            
                                    <div class="info-box-content">
                                        <div class="progress-group">
                                        Profesional
                                        <span class="float-right"><b>' . $totalsuma3 . '</b></span>
                                    </div>
                                
                                    <div class="progress-group">
                                        Renovaron
                                        <span class="float-right"><b>
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","3","1") class="text-white" title="Estudiantes que renovaron" style="cursor:pointer">' . $totalgeneralrenovaronnivel3 . '</a>
                                        </b>/' . round($avancegeneral3) . '%</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar"  style="width: ' . round($avancegeneral3) . '%"></div>
                                        </div>
                                    </div>

                                    <div class="progress-group">
                                        Pendiente
                                        <span class="float-right"><b>
                                            <a onclick=listarestudiantesnivel("' . $periodo_anterior . '","3","2") class="text-white" title="Estudiantes por renovar" style="cursor:pointer">' . $total_estudiantes_porrenovar_nivel3 . '</a>
                                        </b>/' . round($faltageneral3, 0) . '%</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar"  style="width: ' . round($faltageneral3) . '%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';

        $listar_estudiantes_porrenovar_nivel4 = $desercion->listargeneralporrenovarnivel($periodo_anterior, 4);
        $listar_estudiantes_nivel4 = $desercion->listargeneralrenovaronnivel($periodo_actual, 4);

        $total_estudiantes_porrenovar_nivel4 = count($listar_estudiantes_porrenovar_nivel4);
        $totalgeneralrenovaronnivel4 = count($listar_estudiantes_nivel4);

        $totalsuma4 = $total_estudiantes_porrenovar_nivel4 + $totalgeneralrenovaronnivel4;
        @$avancegeneral4 = 0;
        $faltageneral4 = 0;
        if ($totalsuma4 > 0) {
            @$avancegeneral4 = ($totalgeneralrenovaronnivel4 / $totalsuma4) * 100;
            $faltageneral4 = (100 - $avancegeneral4);
        }

        $data["total"] .= '
                        <div class="col-xl-3">
                            <div class="info-box bg-Lightblue">
                            
                                <div class="info-box-content">
                                        <div class="progress-group">
                                        Seminarios
                                        <span class="float-right"><b>' . $totalsuma4 . '</b></span>
                                    </div>
                                
                                    <div class="progress-group">
                                        Renovaron
                                        <span class="float-right"><b>
                                            <a onclick=listarestudiantesnivel("' . $periodo_actual . '","4","1") class="text-white" title="Estudiantes que renovaron" style="cursor:pointer">' . $totalgeneralrenovaronnivel4 . '</a>
                                        </b>/' . round($avancegeneral4) . '%</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar"  style="width: ' . round($avancegeneral4) . '%"></div>
                                        </div>
                                    </div>

                                    <div class="progress-group">
                                        Pendiente
                                        <span class="float-right"><b>
                                            <a onclick=listarestudiantesnivel("' . $periodo_anterior . '","4","2") class="text-white" title="Estudiantes por renovar" style="cursor:pointer">' . $total_estudiantes_porrenovar_nivel4 . '</a>
                                        </b>/' . round($faltageneral4, 0) . '%</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar"  style="width: ' . round($faltageneral4) . '%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';

        $listar_estudiantes_porrenovar_nivel5 = $desercion->listargeneralporrenovarnivel($periodo_anterior, 5);
        $listar_estudiantes_nivel5 = $desercion->listargeneralrenovaronnivel($periodo_actual, 5);

        $total_estudiantes_porrenovar_nivel5 = count($listar_estudiantes_porrenovar_nivel5);
        $totalgeneralrenovaronnivel5 = count($listar_estudiantes_nivel5);

        $totalsuma5 = $total_estudiantes_porrenovar_nivel5 + $totalgeneralrenovaronnivel5;

        $avancegeneral5 = ($totalgeneralrenovaronnivel5 / $totalsuma5) * 100;
        $faltageneral5 = (100 - $avancegeneral5);

        $data["total"] .= '
                        <div class="col-xl-3">
                            <div class="info-box bg-pink">
                            
                                <div class="info-box-content">
                                    <div class="progress-group">
                                        Nivelatorios
                                        <span class="float-right"><b>' . $totalsuma5 . '</b></span>
                                    </div>
                                
                                    <div class="progress-group">
                                        Renovaron
                                        <span class="float-right"><b>
                                            <a onclick=listarestudiantesnivel("' . $periodo_actual . '","5","1") class="text-white" title="Estudiantes que renovaron" style="cursor:pointer">' . $totalgeneralrenovaronnivel5 . '</a>
                                        </b>/' . round($avancegeneral5) . '%</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar"  style="width: ' . round($avancegeneral5) . '%"></div>
                                        </div>
                                    </div>

                                    <div class="progress-group">
                                        Pendiente
                                        <span class="float-right"><b>
                                            <a onclick=listarestudiantesnivel("' . $periodo_anterior . '","5","2") class="text-white" title="Estudiantes que renovaron" style="cursor:pointer">' . $total_estudiantes_porrenovar_nivel5 . '</a>
                                        </b>/' . round($faltageneral5, 0) . '%</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar"  style="width: ' . round($faltageneral5) . '%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';

        // $listar_estudiantes_porrenovar_nivel6 = $desercion->listargeneralporrenovarnivel($periodo_anterior,6);
        // $listar_estudiantes_nivel6 = $desercion->listargeneralrenovaronnivel($periodo_actual,6);

        // $total_estudiantes_porrenovar_nivel6=count($listar_estudiantes_porrenovar_nivel6);
        // $totalgeneralrenovaronnivel6=count($listar_estudiantes_nivel6);

        // $totalsuma6=$total_estudiantes_porrenovar_nivel6+$totalgeneralrenovaronnivel6;

        // $avancegeneral6=($totalgeneralrenovaronnivel6/$totalsuma6)*100;
        // $faltageneral6=(100-$avancegeneral6);

        // $data["total"].='
        //     <div class="col-xl-2">
        //         <div class="info-box bg-pink">

        //             <div class="info-box-content">
        //                 <span class="info-box-text">Idiomas</span>
        //                 <span class="info-box-number"><span title="Por renovar"> '. $total_estudiantes_porrenovar_nivel6.'</span>/<span title="Renovaron">'.$totalgeneralrenovaronnivel6.'</span> = '.$totalsuma6.'</span>
        //                 <div class="progress">
        //                     <div class="progress-bar" style="width: '.round($avancegeneral6).'%"></div>
        //                 </div>
        //                 <span class="progress-description">
        //                     '.round($avancegeneral6).'% Ok. '.round($faltageneral6,0).'% Falta
        //                 </span>
        //             </div>
        //         </div>
        //     </div>';

        $listar_estudiantes_porrenovar_nivel7 = $desercion->listargeneralporrenovarnivel($periodo_anterior, 7);
        $listar_estudiantes_nivel7 = $desercion->listargeneralrenovaronnivel($periodo_actual, 7);

        $total_estudiantes_porrenovar_nivel7 = count($listar_estudiantes_porrenovar_nivel7);
        $totalgeneralrenovaronnivel7 = count($listar_estudiantes_nivel7);

        $totalsuma7 = $total_estudiantes_porrenovar_nivel7 + $totalgeneralrenovaronnivel7;

        $avancegeneral7 = ($totalgeneralrenovaronnivel7 / $totalsuma7) * 100;
        $faltageneral7 = (100 - $avancegeneral7);

        $data["total"] .= '
                        <div class="col-xl-3">
                            <div class="info-box bg-warning">
                            
                                    <div class="info-box-content">
                                        <div class="progress-group">
                                        Programas Laborales
                                        <span class="float-right"><b>' . $totalsuma7 . '</b></span>
                                    </div>
                                
                                    <div class="progress-group">
                                        Renovaron
                                        <span class="float-right"><b>
                                            <a onclick=listarestudiantesnivel("' . $periodo_actual . '","7","1") class="text-white" title="Estudiantes que renovaron" style="cursor:pointer">' . $totalgeneralrenovaronnivel7 . '</a>
                                        </b>/' . round($avancegeneral7) . '%</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar"  style="width: ' . round($avancegeneral7) . '%"></div>
                                        </div>
                                    </div>

                                    <div class="progress-group">
                                        Pendiente
                                        <span class="float-right"><b>
                                        <a onclick=listarestudiantesnivel("' . $periodo_anterior . '","7","2") class="text-white" title="Estudiantes por renovar" style="cursor:pointer">' . $total_estudiantes_porrenovar_nivel7 . '</a>
                                        </b>/' . round($faltageneral7, 0) . '%</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar"  style="width: ' . round($faltageneral7) . '%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';

        $data["total"] .= '</div>';
        $data["total"] .= '</div>';
        $data["total"] .= '</div>';
        $data["total"] .= '<hr>';
        $data["total"] .= '<div class="col-xl-12">';
        $data["total"] .= '<a onclick="volver()" class="btn btn-danger btn-sm d-flex float-right" style="color:#F4F3F2!important" > Volver</a>';
        $data["total"] .= '</div>';

        $data["total"] .= '<div class="row">';
        $data["total"] .= '<div class="col-xl-12">';
        $data["total"] .= 'Jornadas: ';
        $traerjornadastotal = $desercion->jornadastodas();
        for ($a = 0; $a < count($traerjornadastotal); $a++) {
            $id_jornada = $traerjornadastotal[$a]["id_jornada"];
            $jornadanombre = $traerjornadastotal[$a]["nombre"];
            $jornadacodigo = $traerjornadastotal[$a]["codigo"];
            $porrenovar = $traerjornadastotal[$a]["porrenovar"];
            if ($jornadacodigo == "Ninguno") {
            } else {
                if ($porrenovar == 1) {
                    $data["total"] .= '<a onclick="activarjornada(' . $id_jornada . ',0)" class="btn text-success btn-xs" title="Desactivar"><b>' . $jornadacodigo . '</b></a>';
                } else {
                    $data["total"] .= '<a onclick="activarjornada(' . $id_jornada . ',1)" class="btn text-gray btn-xs" title="Activar">' . $jornadacodigo . '</a>';
                }
            }
        }
        $data["total"] .= '</div>';

        $data["total"] .= '<div class="col-xl-2">';
        $data["total"] .= ' <a onclick="profesional(1)" class="btn btn-block btn-outline-danger btn-xs">Administración de empresas</a>';
        $data["total"] .= '</div>';

        $data["total"] .= '<div class="col-xl-2">';
        $data["total"] .= ' <a onclick="profesional(2)" class="btn btn-block btn-outline-danger btn-xs">Contaduría pública</a>';
        $data["total"] .= '</div>';

        $data["total"] .= '<div class="col-xl-2">';
        $data["total"] .= ' <a onclick="profesional(3)" class="btn btn-block btn-outline-primary btn-xs">Ingeniería de software</a>';
        $data["total"] .= '</div>';

        $data["total"] .= '<div class="col-xl-2">';
        $data["total"] .= ' <a onclick="profesional(4)" class="btn btn-block btn-outline-success btn-xs">Seguridad y salud en el trabajo</a>';
        $data["total"] .= '</div>';

        $data["total"] .= '<div class="col-xl-2">';
        $data["total"] .= ' <a onclick="profesional(5)" class="btn btn-block btn-outline-warning btn-xs">Ingeniería Industrial</a>';
        $data["total"] .= '</div>';

        $data["total"] .= '</div>';

        $data["total"] .= '<hr>';
        $data["total"] .= '<div class="row">';

        $data["total"] .= '<div class="col-xl-3">';

        $buscarjornadameta = $desercion->jornadas();
        $totalrenovarmeta = 0;
        $totalrenovaronmeta = 0;
        for ($b = 0; $b < count($buscarjornadameta); $b++) {
            $jornadameta = $buscarjornadameta[$b]["nombre"];

            $porrenovarmeta = $desercion->porrenovarmeta($jornadameta, $periodo_anterior);
            $totalrenovarmeta = $totalrenovarmeta + count($porrenovarmeta);

            $renovaronmeta = $desercion->renovaronmeta($jornadameta, $periodo_actual);
            $totalrenovaronmeta = $totalrenovaronmeta + count($renovaronmeta);
        }

        $metarenovar = $totalrenovarmeta + $totalrenovaronmeta;
        $avancefaltan = 0;
        $avancerenovaron = 0;
        if ($metarenovar > 0) {
            $avancefaltan = ($totalrenovarmeta * 100) / $metarenovar;

            $avancerenovaron = ($totalrenovaronmeta * 100) / $metarenovar;
        }
        $data["total"] .= '   
            <div class="col-12">
                <div class="info-box bg-success">
                    <div class="info-box-content">

                        <div class="progress-group">
                            Meta
                            <span class="float-right"><b>' . $metarenovar . '</b></span>
                        </div>

                        <div class="progress-group">
                            Renovaron
                            <span class="float-right"><b>
                                <a onclick=listarestudiantesmeta("' . $periodo_actual . '","1") class="text-white" title="Estudiantes que renovaron" style="cursor:pointer">' . $totalrenovaronmeta . '
                                </a></b>/' . round($avancerenovaron) . '% </span>
                            <div class="progress progress-sm">
                                <div class="progress-bar"  style="width: ' . round($avancerenovaron) . '%"></div>
                            </div>
                        </div>
                        <div class="progress-group">
                            Pendiente
                            <span class="float-right"><b>
                            <a onclick=listarestudiantesmeta("' . $periodo_anterior . '","2") class="text-white" title="Estudiantes que renovaron" style="cursor:pointer">' . $totalrenovarmeta . '</a>
                            </b>/' . round($avancefaltan, 0) . '% </span>
                            <div class="progress progress-sm">
                                <div class="progress-bar"  style="width: ' . round($avancefaltan) . '%"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>';
        $data["total"] .= '</div">';

        $data["total"] .= '<div class="col-xl-9">';
        $data["total"] .= '</div>';

        $data["total"] .= '</div>';
        echo json_encode($data);
        break;


    case 'consulta_desercion':
        $cedula = $_POST['dato'];
        // $tipo = $_POST['tipo'];
        $data['conte'] = '';
        $data['conte2'] = '';

        $datos = $desercion->consulta_desercion($cedula);

        $identificacion =  $datos["identificacion"];
        // $nombre =  $datos["nombre"] ." ".$datos["nombre_2"]." ".$datos["apellidos"]." ".$datos["apellidos_2"];
        // $correo =  $datos["email"];
        // $celular =  $datos["celular"];

        //     $data['conte'] .= '
        //     <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        //         <div class="card card-primary" style="padding: 2% 1%">
        //             <div class="row">

        //                 <div class="col-xl-4 col-lg-8 col-md-12 col-12 text-center">
        //                     <div class="direct-chat-msg">
        //                     <div class="direct-chat-text text-left">
        //                     <span class="direct-chat-name">'.$nombre.'</span><br>
        //                     Correo: <span>'.$correo.'</span><br>
        //                     Celular: <span>'.$celular.'</span>
        //                 </div>
        //                     </div>
        //                 </div>
        //     ';

        $rspta = $desercion->consulta_id_credencial($identificacion);

        $data['conte2'] .=
            '		

                
        <div class="row">
            <div class="col-12 m-2 p-2">
            <table id="tabla_desertados" class="table table-bordered table-responsive-sm compact table-sm table-hover" style="width:100%">
                <thead>
                    <th>Acciones</th>
                    <th>Identificación</th>
                    <th>Nombre estudiante</th>
                    <th>Correo CIAF</th>
                    <th>Correo personal</th>
                    <th>Celular</th>
                    <th>Periodo Ingreso</th>
                    <th>Periodo Activo</th>
                
        </div> 

            </thead><tbody>';

        $credencial_identificacion =  $rspta["credencial_identificacion"];
        $credencial_nombre =  $rspta["credencial_nombre"] . " " . $rspta["credencial_nombre_2"] . " " . $rspta["credencial_apellido"] . " " . $rspta["credencial_apellido_2"];
        $credencil_correo =  $rspta["credencial_login"];
        $id_credencial =  $rspta["id_credencial"];

        $celular =  $rspta["celular"];
        $email =  $rspta["email"];
        $periodo =  $rspta["periodo"];
        $periodo_activo =  $rspta["periodo_activo"];

        $data['conte2'] .= '
                                            
                    <tr>
                        <td class="text-center">' . '<button onclick="agregar_mostrar_seguimiento(' . $id_credencial . ')" class="btn btn-primary btn-xs" title="Agregar seguimiento"><i class="fa fa-plus"></i> Seguimiento</button> <button onclick="seguimientoverHistorial(' . $id_credencial . ')" class="btn btn-primary btn-xs" title="historial"><i class="fa fa-eye" style="color:#fff"></i> Ver</button>' . '</td>

                        <td class="text-center">' . $credencial_identificacion . '</td>

                        <td class="text-center">' . $credencial_nombre . '</td>
                        <td >' . $credencil_correo . '</td>
                        <td >' . $email . '</td>

                        <td >' . $celular . '</td>
                        <td >' . $periodo . '</td>
                        <td >' . $periodo_activo . '</td>
                    </tr>
                ';

        $data['conte2'] .= '</tbody></table>';

        echo json_encode($data);
        break;

    case 'profesional':
        $profesional = $_POST["valor"];
        $data = array();
        $data["total"] = "";



        $datosprograma = $desercion->programaAc($profesional);
        for ($a = 0; $a < count($datosprograma); $a++) {
            $id_programa = $datosprograma[$a]["id_programa"];
            $programa = $datosprograma[$a]["nombre"];
            $semestres = $datosprograma[$a]["semestres"];


            $data["total"] .= '<div class="col-12 titulo-4">' . $programa . '</div>';
            $data["total"] .= '<div class="row table-responsive p-0 m-0">';
            $data["total"] .= '<table class="table table-bordered table-sm">';
            $data["total"] .= '<thead>';
            $data["total"] .= '<tr>';
            $data["total"] .= '<th style="width: 10px">#</th>';
            $traerjornadas = $desercion->jornadas();
            for ($b = 0; $b < count($traerjornadas); $b++) {
                $jornada = $traerjornadas[$b]["nombre"];
                $jornadanombre = $traerjornadas[$b]["codigo"];
                $data["total"] .= '<th>' . $jornadanombre . '</th>';
            }

            $data["total"] .= '</tr>';
            $data["total"] .= '</thead>';
            $data["total"] .= '<tbody>';
            $elsemestre = 1;
            while ($elsemestre <= $semestres) {

                $data["total"] .= '<tr>';
                $data["total"] .= '<td>' . $elsemestre . '</td>';

                $traerjornadasfila = $desercion->jornadas();
                for ($c = 0; $c < count($traerjornadasfila); $c++) {
                    $jornadafila = $traerjornadas[$c]["nombre"];
                    $jornadanombrefila = $traerjornadas[$c]["codigo"];

                    list($año, $numero) = explode('-', $periodo_actual);

                    $resta_año = $año - 2;
                    $inactivos_año_anterior_pendientes = $resta_año . '-' . $numero;

                    $traerpendienteperiodos = $desercion->traernumeropendientes($id_programa, $elsemestre, $jornadafila, $temporadainactivos, $inactivos_año_anterior_pendientes); // trae los estudiantes que deben renovar
                    $traernumeropendiente = $desercion->traernumero($id_programa, $elsemestre, $jornadafila, $periodo_anterior); // trae los estudiantes que deben renovar
                    $traernumerorenovaron = $desercion->traernumero($id_programa, $elsemestre, $jornadafila, $periodo_actual); // trae los estudiantes que deben renovar

                    $traerporrenovarprograma = $desercion->traerporrenovar($id_programa, $elsemestre, $jornadafila, $periodo_anterior);
                    $data["total"] .= '
                                            <td>
                                                <div style="width:180px">
                                                    <div class="campo-tabla"><a onclick=verestudiantesinactivos("' . $id_programa . '","' . $jornadafila . '","' . $elsemestre . '","' . $temporadainactivos . '") class="text-danger" title="Inactivos" >' . count($traerpendienteperiodos) . '</a></div>

                                                    <div class="campo-tabla"><a onclick=verestudiantesporrenovar("' . $id_programa . '","' . $jornadafila . '","' . $elsemestre . '","' . $periodo_anterior . '") class="text-purple" title="Por renovar">' . count($traerporrenovarprograma) . '</a></div> 
                                                    
                                                </div>
                                            </td>';
                }


                $data["total"] .= '</tr>';

                $elsemestre++;
            }
            $data["total"] .= '<td>Total</td>';
            $traerjornadastotal = $desercion->jornadas();
            for ($d = 0; $d < count($traerjornadastotal); $d++) {
                $jornadatotal = $traerjornadastotal[$d]["nombre"];
                $jornadanombretotal = $traerjornadastotal[$d]["codigo"];

                list($año, $numero) = explode('-', $periodo_actual);

                $resta_año = $año - 2;
                $inactivos_año_anterior = $resta_año . '-' . $numero;

                $sumanumeroinactivos = $desercion->sumanumeroinactivos($id_programa, $jornadatotal, $temporadainactivos, $inactivos_año_anterior); // consulta para traer el total de nuevos

                $sumaporrenovar = $desercion->sumaporrenovar($id_programa, $jornadatotal, $periodo_anterior); // consulta para traer el total de nuevos
                $array_resultante = array_merge($sumanumeroinactivos, $sumaporrenovar);
                $sumatotal = count($array_resultante);


                $data["total"] .= '
                                    <td>
                                        <div class="campo-tabla"><a onclick=verestudiantesinactivostotal("' . $id_programa . '","' . $jornadatotal . '","' . $temporadainactivos . '") class="text-danger" title="Total inactivos" > <b>' . count($sumanumeroinactivos) . '</a></div>

                                        <div class="campo-tabla"><a onclick=verestudiantesporrenovartotal("' . $id_programa . '","' . $jornadatotal . '","0","' . $periodo_anterior . '","6.1") class="text-purple" title="Total por renovar" > <b>' . count($sumaporrenovar) . '</a></div>
                
                                    </td>';
            }

            $data["total"] .= '<tr>';

            $data["total"] .= '</tbody>';
            $data["total"] .= '</table>';
            $data["total"] .= '</div>';



            $data["total"] .= '<div class="row">';
            $data["total"] .= '<div class="col-xl-2 mt-1">';
            $data["total"] .= '  <button class="btn btn-primary" onclick=vertotalestudiantes("' . $id_programa . '","' . $temporadainactivos . '","' . $profesional . '") class="text-primary" title="Total General">Total General</button> ';
            $data["total"] .= '</div>';
            $data["total"] .= '<div class="col-xl-2 mt-1">';
            $data["total"] .= ' <button class="btn btn-danger" onclick=vertotalestudiantesinactivos("' . $id_programa . '","' . $temporadainactivos . '","' . $profesional . '") class="text-primary" title="Total Inactivos">Total Inactivos</button> ';
            $data["total"] .= '</div>';

            $data["total"] .= '<div class="col-xl-2 mt-1">';
            $data["total"] .= ' <button class="btn bg-purple" onclick=vertotalestudiantesporrenovar("' . $id_programa . '","' . $temporadainactivos . '","' . $profesional . '") class="text-primary" title="Total Por renovar">Total Por renovar</button>';
            $data["total"] .= '</div>';
            $data["total"] .= '</div>';
        }

        echo json_encode($data);
        break;


        // consultamos en una tabla los estudiantes que faltan por renovar 
    case 'verestudiantesporrenovar':

        $id_programa = $_GET["id_programa"];
        $jornada = $_GET["jornada"];
        $semestre = $_GET["semestre"];
        $periodo = $_GET["periodo"];
        $porrenovar = $_GET["porrenovar"];

        $porrenovar = $desercion->porrenovarestudiante($id_programa, $jornada, $periodo, $semestre); // consulta para traer el total de nuevos

        $data = array();
        $reg = $porrenovar;


        for ($i = 0; $i < count($reg); $i++) {

            $data[] = array(
                "0" => '<button onclick="agregar_mostrar_seguimiento(' . $reg[$i]['id_credencial'] . ')" class="btn btn-primary btn-xs" title="Agregar seguimiento"><i class="fa fa-plus"></i> Seguimiento</button> <button onclick="seguimientoverHistorial(' . $reg[$i]['id_credencial'] . ')" class="btn btn-primary btn-xs" title="historial"><i class="fa fa-eye" style="color:#fff"></i> Ver</button>',

                "1" => $reg[$i]["credencial_identificacion"],
                "2" => $reg[$i]["credencial_apellido"] . ' ' . $reg[$i]["credencial_apellido_2"] . ' ' . $reg[$i]["credencial_nombre"] . ' ' . $reg[$i]["credencial_nombre_2"],
                "3" => $reg[$i]["credencial_login"],
                "4" => $reg[$i]["email"],
                "5" => $reg[$i]["celular"],
                "6" => $reg[$i]["periodo"],
                "7" => $reg[$i]["periodo_activo"]
            );
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);

        break;

        //mostramos la suma total de los estudiantes por renovar 
    case 'verestudiantesporrenovartotal':
        $id_programa = $_GET["id_programa"];
        $jornadatotal = $_GET["jornada"];

        $rspta = $desercion->porrenovarestudiantetotal($id_programa, $jornadatotal, $periodo_anterior); // consulta para traer el total de nuevos

        //Vamos a declarar un array
        $data = array();
        $reg = $rspta;


        for ($i = 0; $i < count($reg); $i++) {

            $data[] = array(
                "0" => '<button onclick="agregar_mostrar_seguimiento(' . $reg[$i]['id_credencial'] . ')" class="btn btn-primary btn-xs" title="Agregar seguimiento"><i class="fa fa-plus"></i> Seguimiento</button> <button onclick="seguimientoverHistorial(' . $reg[$i]['id_credencial'] . ')" class="btn btn-primary btn-xs" title="historial"><i class="fa fa-eye" style="color:#fff"></i> Ver</button> ',

                "1" => $reg[$i]["credencial_identificacion"],
                "2" => $reg[$i]["credencial_apellido"] . ' ' . $reg[$i]["credencial_apellido_2"] . ' ' . $reg[$i]["credencial_nombre"] . ' ' . $reg[$i]["credencial_nombre_2"],
                "3" => $reg[$i]["credencial_login"],
                "4" => $reg[$i]["email"],
                "5" => $reg[$i]["celular"],
                "6" => $reg[$i]["periodo"],
                "7" => $reg[$i]["periodo_activo"]

            );
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);

        break;

    case 'activarjornada':
        $id_jornada = $_POST["id_jornada"];
        $valor = $_POST["valor"];


        $activarjornada = $desercion->activarjornada($id_jornada, $valor);

        echo json_encode($activarjornada);
        break;

    case 'listarestudiantes':

        $periodo = $_GET["periodo"];
        $valor = $_GET["valor"];
        $id_credencial = $_GET["id_credencial"];

        // print_r($id_credencial);

        if ($valor == "1") {
            $rspta = $desercion->listarestudaintesrenovaron($periodo);
        }
        if ($valor == "2") {
            $rspta = $desercion->listarestudaintesporrenovar($periodo);
        }



        //Vamos a declarar un array
        $data = array();
        $reg = $rspta;


        for ($i = 0; $i < count($reg); $i++) {

            $data[] = array(
                "0" => '<button onclick="seguimientoverHistorial(' . $reg[0]['id_credencial'] . ')" class="btn btn-primary btn-xs" title="historial"><i class="fa fa-eye" style="color:#fff"></i> Ver</button>',
                "1" => $reg[$i]["credencial_identificacion"],
                "2" => $reg[$i]["credencial_apellido"] . ' ' . $reg[$i]["credencial_apellido_2"] . ' ' . $reg[$i]["credencial_nombre"] . ' ' . $reg[$i]["credencial_nombre_2"],
                "3" => $reg[$i]["credencial_login"],
                "4" => $reg[$i]["email"],
                "5" => $reg[$i]["celular"],
                "6" => $reg[$i]["periodo"],
                "7" => $reg[$i]["periodo_activo"]

            );
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);

        break;

    case 'listarestudiantesnivel':

        $periodo = $_GET["periodo"];
        $nivel = $_GET["nivel"];
        $valor = $_GET["valor"];

        if ($valor == "1") {
            $rspta = $desercion->listarestudaintesrenovaronnivel($periodo, $nivel);
        }
        if ($valor == "2") {
            $rspta = $desercion->listarestudaintesporrenovarnivel($periodo, $nivel);
        }




        //Vamos a declarar un array
        $data = array();
        $reg = $rspta;


        for ($i = 0; $i < count($reg); $i++) {

            $data[] = array(
                "0" => '<button onclick="seguimientoverHistorial(' . $reg[$i]['id_credencial'] . ')" class="btn btn-primary btn-xs" title="historial"><i class="fa fa-eye" style="color:#fff"></i> Ver</button>',
                "1" => $reg[$i]["credencial_identificacion"],
                "2" => $reg[$i]["credencial_apellido"] . ' ' . $reg[$i]["credencial_apellido_2"] . ' ' . $reg[$i]["credencial_nombre"] . ' ' . $reg[$i]["credencial_nombre_2"],
                "3" => $reg[$i]["credencial_login"],
                "4" => $reg[$i]["email"],
                "5" => $reg[$i]["celular"],
                "6" => $reg[$i]["periodo"],
                "7" => $reg[$i]["periodo_activo"]

            );
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);

        break;

    case 'verestudiantes':
        $id_programa = $_GET["id_programa"];
        $jornada = $_GET["jornada"];
        $semestre = $_GET["semestre"];
        $periodo = $_GET["periodo"];
        $porrenovar = $_GET["porrenovar"];

        if ($porrenovar == 1) {
            $rspta = $desercion->verestudiantes($id_programa, $jornada, $semestre, $periodo, $porrenovar);
        } else {
            $rspta = $desercion->verestudiantesok($id_programa, $jornada, $semestre, $periodo);
        }

        //Vamos a declarar un array
        $data = array();
        $reg = $rspta;


        for ($i = 0; $i < count($reg); $i++) {

            $data[] = array(
                "0" => '<button onclick="seguimientoverHistorial(' . $reg[$i]['id_credencial'] . ')" class="btn btn-primary btn-xs" title="historial"><i class="fa fa-eye" style="color:#fff"></i> Ver</button>',
                "1" => $reg[$i]["credencial_identificacion"],
                "2" => $reg[$i]["credencial_apellido"] . ' ' . $reg[$i]["credencial_apellido_2"] . ' ' . $reg[$i]["credencial_nombre"] . ' ' . $reg[$i]["credencial_nombre_2"],
                "3" => $reg[$i]["credencial_login"],
                "4" => $reg[$i]["email"],
                "5" => $reg[$i]["celular"],
                "6" => $reg[$i]["periodo"],
                "7" => $reg[$i]["periodo_activo"]

            );
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);

        break;

    case 'verestudiantesinactivos':
        $id_programa = $_GET["id_programa"];
        $jornada = $_GET["jornada"];
        $semestre = $_GET["semestre"];
        $temporadainactivos = $_GET["temporadainactivos"];
        $id_credencial = $_GET["id_credencial"];


        list($año, $numero) = explode('-', $periodo_actual);

        $resta_año = $año - 2;
        $inactivos_año_anterior_pendientes = $resta_año . '-' . $numero;

        $rspta = $desercion->verestudiantesinactivos($id_programa, $jornada, $semestre, $temporadainactivos, $inactivos_año_anterior_pendientes);
        // print_r($rspta);

        //Vamos a declarar un array
        $data = array();
        $reg = $rspta;


        for ($i = 0; $i < count($reg); $i++) {

            $data[] = array(
                "0" => '<button onclick="agregar_mostrar_seguimiento(' . $reg[$i]['id_credencial'] . ')" class="btn btn-primary btn-xs" title="Agregar seguimiento"><i class="fa fa-plus"></i> Seguimiento</button> <button onclick="seguimientoverHistorial(' . $reg[$i]['id_credencial'] . ')" class="btn btn-primary btn-xs" title="historial"><i class="fa fa-eye" style="color:#fff"></i> Ver</button> ',

                "1" => $reg[$i]["credencial_identificacion"],
                "2" => $reg[$i]["credencial_apellido"] . ' ' . $reg[$i]["credencial_apellido_2"] . ' ' . $reg[$i]["credencial_nombre"] . ' ' . $reg[$i]["credencial_nombre_2"],
                "3" => $reg[$i]["credencial_login"],
                "4" => $reg[$i]["email"],
                "5" => $reg[$i]["celular"],
                "6" => $reg[$i]["periodo"],
                "7" => $reg[$i]["periodo_activo"]

            );
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);

        break;

    case 'seguimientoverHistorial':
        $data = array(); //Vamos a declarar un array
        $data["0"] = ""; //iniciamos el arreglo

        $rspta = $desercion->vernombreestudiantesinactivos($id_credencial);

        // print_r($rspta);
        for ($a = 0; $a < count($rspta); $a++) {

            $credencial_identificacion = $rspta[$a]["credencial_identificacion"];


            $nombre = $rspta[$a]["credencial_apellido"] . ' ' . $rspta[$a]["credencial_apellido_2"] . ' ' . $rspta[$a]["credencial_nombre"] . ' ' . $rspta[$a]["credencial_nombre_2"];

            // $credencial_login = $rspta["credencial_login"];
            // $email = $rspta["email"];
            // $celular = $rspta["celular"];
            // $periodo = $rspta["periodo"];
            // $periodo_activo = $rspta["periodo_activo"]; 


            $correo_institucional =  $rspta[$a]["credencial_login"];
            $email = $rspta[$a]["email"];
            $celular = $rspta[$a]["celular"];
            $periodo = $rspta[$a]["periodo"];
            $periodo_activo = $rspta[$a]["periodo_activo"];
        }
        $data["0"] .= '
        
        <div class="col-md-12">
                <div id="accordion">
                    <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
                    <div class="card ">
                    <div class="card-header">
                        <h4 class="card-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                            <div class="spinner-grow text-muted spinner-grow-sm"></div> Datos de contacto
                        </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="card-body">
                        
                        
                            <div class="row">
                                <div class="col-xl-6">

                                <dt>Nombre</dt>
                                <dd>' . $nombre . '</dd>
                                <dt>Correo</dt>
                                <dd>' . $email . '</dd>
                                <dt>Celular</dt>
                                <dd>' . $celular . '</dd>
                                
                                
                                </div>
                                <div class="col-xl-6">							
                                <dt>Cédula</dt>
                                <dd>' . $credencial_identificacion . '</dd>
                                <dt>Correo Institucional</dt>
                                <dd>' . $correo_institucional . '</dd>
                                <dt>Periodo Activo</dt>
                                <dd>' . $periodo_activo . '</dd>
                                
                                
                                </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    
            </div>
            </div>';
        $results = array($data);
        echo json_encode($results);
        break;

    case 'agregarSeguimiento':

        $id_usuario = $_SESSION['id_usuario'];
        $id_estudiante_agregar = isset($_POST["id_estudiante_agregar"]) ? limpiarCadena($_POST["id_estudiante_agregar"]) : "";
        $motivo_seguimiento = isset($_POST["motivo_seguimiento"]) ? limpiarCadena($_POST["motivo_seguimiento"]) : "";
        $mensaje_seguimiento = isset($_POST["mensaje_seguimiento"]) ? limpiarCadena($_POST["mensaje_seguimiento"]) : "";
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');
        $rspta = $desercion->vernombreestudiantesinactivos($id_estudiante_agregar);
        $id_estudiante_programa = 0;
        for ($a = 0; $a < count($rspta); $a++) {
            $id_estudiante_programa = $rspta[$a]["id_estudiante"];
        }
        $rspta = $desercion->insertarSeguimiento($id_usuario, $id_estudiante_agregar, $motivo_seguimiento, $mensaje_seguimiento, $fecha, $hora, $id_estudiante_programa);
        echo $rspta ? "Seguimiento registrado" : "Seguimiento no se pudo registrar";
        if ($rspta) {
            $actualizarcamposegui = $desercion->actualizarSegui($id_estudiante_agregar);
        }

        break;

    case 'agregarTarea':
        $fecha_realizo = NULL;
        $hora_realizo = NULL;
        $fecha = date('Y-m-d');
        $periodo_actual = $_SESSION['periodo_actual'];
        $hora = date('H:i:s');
        $id_usuario = $_SESSION['id_usuario'];
        $id_estudiante_tarea = isset($_POST["id_estudiante_tarea"]) ? limpiarCadena($_POST["id_estudiante_tarea"]) : "";
        $motivo_tarea = isset($_POST["motivo_tarea"]) ? limpiarCadena($_POST["motivo_tarea"]) : "";
        $mensaje_tarea = isset($_POST["mensaje_tarea"]) ? limpiarCadena($_POST["mensaje_tarea"]) : "";
        $fecha_programada = isset($_POST["fecha_programada"]) ? limpiarCadena($_POST["fecha_programada"]) : "";
        $hora_programada = isset($_POST["hora_programada"]) ? limpiarCadena($_POST["hora_programada"]) : "";

        $rspta = $desercion->vernombreestudiantesinactivos($id_estudiante_tarea);
        $id_estudiante_programa = 0;
        for ($a = 0; $a < count($rspta); $a++) {
            $id_estudiante_programa = $rspta[$a]["id_credencial"];
        }
        $rspta = $desercion->insertarTarea($id_usuario, $id_estudiante_tarea, $motivo_tarea, $mensaje_tarea, $fecha, $hora, $fecha_programada, $hora_programada, $fecha_realizo, $hora_realizo, $periodo_actual, $id_estudiante_programa);
        echo $rspta ? "Tarea Programada" : "Tarea no se pudo Programar";
        break;

    case 'agregar_mostrar_seguimiento':




        $data = array(); //Vamos a declarar un array
        $data["0"] = ""; //iniciamos el arreglo

        $rspta = $desercion->vernombreestudiantesinactivos($id_credencial);

        // print_r($rspta);
        for ($a = 0; $a < count($rspta); $a++) {

            $credencial_identificacion = $rspta[$a]["credencial_identificacion"];


            $nombre = $rspta[$a]["credencial_apellido"] . ' ' . $rspta[$a]["credencial_apellido_2"] . ' ' . $rspta[$a]["credencial_nombre"] . ' ' . $rspta[$a]["credencial_nombre_2"];


            $correo_institucional =  $rspta[$a]["credencial_login"];
            $email = $rspta[$a]["email"];
            $celular = $rspta[$a]["celular"];
            $periodo = $rspta[$a]["periodo"];
            $periodo_activo = $rspta[$a]["periodo_activo"];
        }
        $data["0"] .= '
        
        <div class="col-md-12">
                <div id="accordion">
                    <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
                    <div class="card ">
                    <div class="card-header">
                        <h4 class="card-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                            <div class="spinner-grow text-muted spinner-grow-sm"></div> Datos de contacto
                        </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="card-body">
                        
                        
                            <div class="row">
                                <div class="col-xl-6">

                                <dt>Nombre</dt>
                                <dd>' . $nombre . '</dd>
                                <dt>Correo</dt>
                                <dd>' . $email . '</dd>
                                <dt>Celular</dt>
                                <dd>' . $celular . '</dd>
                                </div>
                                <div class="col-xl-6">							
                                <dt>Cédula</dt>
                                <dd>' . $credencial_identificacion . '</dd>
                                <dt>Correo Institucional</dt>
                                <dd>' . $correo_institucional . '</dd>
                                <dt>Periodo Activo</dt>
                                <dd>' . $periodo_activo . '</dd>
                                
                                </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    
            </div>
            </div>';
        $results = array($data);
        echo json_encode($results);
        break;

    case 'verHistorialTabla':
        $id_credencial = $_GET["id_credencial"];

        $rspta = $desercion->verHistorialTabla($id_credencial);
        //Vamos a declarar un array
        $data = array();
        $reg = $rspta;


        for ($i = 0; $i < count($reg); $i++) {
            $datoasesor = $desercion->datosAsesor($reg[$i]["id_usuario"]);
            $nombre_usuario = $datoasesor["usuario_nombre"] . " " . $datoasesor["usuario_apellido"];
            $data[] = array(
                "0" => $reg[$i]["id_credencial"],
                "1" => $reg[$i]["motivo_seguimiento"],
                "2" => $reg[$i]["mensaje_seguimiento"],
                "3" => $desercion->fechaesp($reg[$i]["fecha_seguimiento"]) . ' a las ' . $reg[$i]["hora_seguimiento"],
                "4" => $nombre_usuario

            );
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);

        break;
    case 'verHistorialTablaTareas':
        $id_credencial = $_GET["id_credencial"];

        $rspta = $desercion->verHistorialTablaTareas($id_credencial);
        //Vamos a declarar un array
        $data = array();
        $reg = $rspta;


        for ($i = 0; $i < count($reg); $i++) {
            $datoasesor = $desercion->datosAsesor($reg[$i]["id_usuario"]);
            $nombre_usuario = $datoasesor["usuario_nombre"] . " " . $datoasesor["usuario_apellido"];

            $data[] = array(
                "0" => ($reg[$i]["estado"] == 1) ? 'Pendiente' : 'Realizada',
                "1" => $reg[$i]["motivo_tarea"],
                "2" => $reg[$i]["mensaje_tarea"],
                "3" => $desercion->fechaesp($reg[$i]["fecha_programada"]) . ' a las ' . $reg[$i]["hora_programada"],
                "4" => $nombre_usuario

            );
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);

        break;

    case 'verestudiantesinactivostotal':
        $id_programa = $_GET["id_programa"];
        $jornada = $_GET["jornada"];
        $temporadainactivos = $_GET["temporadainactivos"];
        $periodo_actual;
        // $cadena = 'Hola Mundo';

        list($año, $numero) = explode('-', $periodo_actual);

        $resta_año = $año - 2;
        $inactivos_año_anterior = $resta_año . '-' . $numero;

        $rspta = $desercion->verestudiantesinactivostotal($id_programa, $jornada, $temporadainactivos, $inactivos_año_anterior);


        //Vamos a declarar un array
        $data = array();
        $reg = $rspta;


        for ($i = 0; $i < count($reg); $i++) {

            $data[] = array(
                "0" => '<button onclick="agregar_mostrar_seguimiento(' . $reg[$i]['id_credencial'] . ')" class="btn btn-primary btn-xs" title="Agregar seguimiento"><i class="fa fa-plus"></i> Seguimiento</button> <button onclick="seguimientoverHistorial(' . $reg[$i]['id_credencial'] . ')" class="btn btn-primary btn-xs" title="historial"><i class="fa fa-eye" style="color:#fff"></i> Ver</button> ',

                "1" => $reg[$i]["credencial_identificacion"],
                "2" => $reg[$i]["credencial_apellido"] . ' ' . $reg[$i]["credencial_apellido_2"] . ' ' . $reg[$i]["credencial_nombre"] . ' ' . $reg[$i]["credencial_nombre_2"],
                "3" => $reg[$i]["credencial_login"],
                "4" => $reg[$i]["email"],
                "5" => $reg[$i]["celular"],
                "6" => $reg[$i]["periodo"],
                "7" => $reg[$i]["periodo_activo"]

            );
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);

        break;

    case 'verestudiantestotal':
        $id_programa = $_GET["id_programa"];
        $jornada = $_GET["jornada"];
        $periodo = $_GET["periodo"];
        $porrenovar = $_GET["porrenovar"];

        if ($porrenovar == 1) {
            $rspta = $desercion->verestudiantestotal($id_programa, $jornada, $periodo, $porrenovar);
        } else {
            $rspta = $desercion->verestudiantesoktotal($id_programa, $jornada, $periodo);
        }

        //Vamos a declarar un array
        $data = array();
        $reg = $rspta;


        for ($i = 0; $i < count($reg); $i++) {

            $data[] = array(
                "0" => '<button onclick="seguimientoverHistorial(' . $reg[$i]['id_credencial'] . ')" class="btn btn-primary btn-xs" title="historial"><i class="fa fa-eye" style="color:#fff"></i> Ver</button>',

                "1" => ' <button onclick="agregar_mostrar_seguimiento(' . $reg[$i]['id_credencial'] . ')" class="btn btn-primary btn-xs" title="Agregar seguimiento"><i class="fa fa-plus"></i> Seguimiento</button>',

                "2" => $reg[$i]["credencial_identificacion"],
                "3" => $reg[$i]["credencial_apellido"] . ' ' . $reg[$i]["credencial_apellido_2"] . ' ' . $reg[$i]["credencial_nombre"] . ' ' . $reg[$i]["credencial_nombre_2"],
                "4" => $reg[$i]["credencial_login"],
                "5" => $reg[$i]["email"],
                "6" => $reg[$i]["celular"],
                "7" => $reg[$i]["periodo"],
                "8" => $reg[$i]["periodo_activo"]

            );
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);

        break;

    case 'listarestudiantesmeta':
        $periodo = $_GET["periodo"];
        $valor = $_GET["valor"];
        //Vamos a declarar un array
        $data = array();


        $buscarjornadameta = $desercion->jornadas();
        $totalrenovarmeta = 0;
        $totalrenovaronmeta = 0;
        for ($b = 0; $b < count($buscarjornadameta); $b++) {
            $jornadameta = $buscarjornadameta[$b]["nombre"];

            // $porrenovarmeta=$desercion->porrenovarmeta($jornadameta,$periodo_anterior);
            // $totalrenovarmeta=$totalrenovarmeta+count($porrenovarmeta);

            if ($valor == 1) {
                $renovaronmeta = $desercion->listarrenovaronmeta($jornadameta, $periodo);
            }
            if ($valor == 2) {
                $renovaronmeta = $desercion->listarporrenovarmeta($jornadameta, $periodo);
            }

            for ($i = 0; $i < count($renovaronmeta); $i++) {

                $data[] = array(
                    "0" => $renovaronmeta[$i]["credencial_identificacion"],
                    "1" => $renovaronmeta[$i]["credencial_apellido"] . ' ' . $renovaronmeta[$i]["credencial_apellido_2"] . ' ' . $renovaronmeta[$i]["credencial_nombre"] . ' ' . $renovaronmeta[$i]["credencial_nombre_2"],
                    "2" => $renovaronmeta[$i]["credencial_login"],
                    "3" => $renovaronmeta[$i]["email"],
                    "4" => $renovaronmeta[$i]["celular"],
                    "5" => $renovaronmeta[$i]["periodo"],
                    "6" => $renovaronmeta[$i]["periodo_activo"]

                );
            }
        }



        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);

        break;

    case 'vertotalestudiantes':
        $id_programa = $_GET["id_programa"];
        $profesional = 1;
        $temporadainactivos = $_GET["temporadainactivos"];

        $nombre_array = array();
        $activarjornadatotalestudiantes = $desercion->activarjornadatotalestudiantes($profesional);
        for ($o = 0; $o < count($activarjornadatotalestudiantes); $o++) {
            $nombre = $activarjornadatotalestudiantes[$o]["nombre"];
            array_push($nombre_array, $nombre);
        }
        // $array_en_string = implode(' ', $nombre_array);

        // var_dump($nombre_array);

        list($año, $numero) = explode('-', $periodo_actual);
        $resta_año = $año - 2;
        $inactivos_año_anterior = $resta_año . '-' . $numero;
        $sumanumeroinactivos = $desercion->sumanumeroinactivostotal($id_programa, $temporadainactivos, $nombre_array, $inactivos_año_anterior);
        $sumaporrenovar = $desercion->sumaporrenovartotal($id_programa, $nombre_array, $periodo_anterior); // consulta para traer el total de nuevos
        $total_renovareinactivos = array_merge($sumanumeroinactivos, $sumaporrenovar);
        $data = array();
        $reg = $total_renovareinactivos;

        for ($i = 0; $i < count($reg); $i++) {

            $rspta = $desercion->vernombreestudiantesinactivos($reg[$i]['id_credencial']);

            for ($a = 0; $a < count($rspta); $a++) {

                $credencial_identificacion = $rspta[$a]["credencial_identificacion"];

                $nombre = $rspta[$a]["credencial_apellido"] . ' ' . $rspta[$a]["credencial_apellido_2"] . ' ' . $rspta[$a]["credencial_nombre"] . ' ' . $rspta[$a]["credencial_nombre_2"];
            }

            $data[] = array(
                "0" => '<button onclick="agregar_mostrar_seguimiento(' . $reg[$i]['id_credencial'] . ')" class="btn btn-primary btn-xs" title="Agregar seguimiento"><i class="fa fa-plus"></i> Seguimiento</button> <button onclick="seguimientoverHistorial(' . $reg[$i]['id_credencial'] . ')" class="btn btn-primary btn-xs" title="historial"><i class="fa fa-eye" style="color:#fff"></i> Ver</button> ',

                "1" => $credencial_identificacion,
                "2" => $nombre
            );
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );

        echo json_encode($results);



        break;


    case 'vertotalestudiantesinactivos':
        $id_programa = $_GET["id_programa"];
        $profesional = 1;
        $temporadainactivos = $_GET["temporadainactivos"];

        $nombre_array = array();
        $activarjornadatotalestudiantes = $desercion->activarjornadatotalestudiantes($profesional);
        for ($o = 0; $o < count($activarjornadatotalestudiantes); $o++) {
            $nombre = $activarjornadatotalestudiantes[$o]["nombre"];
            array_push($nombre_array, $nombre);
        }

        list($año, $numero) = explode('-', $periodo_actual);
        $resta_año = $año - 2;
        $inactivos_año_anterior = $resta_año . '-' . $numero;
        $sumanumeroinactivos = $desercion->sumanumeroinactivostotal($id_programa, $temporadainactivos, $nombre_array, $inactivos_año_anterior);
        $data = array();
        $reg = $sumanumeroinactivos;

        for ($i = 0; $i < count($reg); $i++) {

            $rspta = $desercion->vernombreestudiantesinactivos($reg[$i]['id_credencial']);

            for ($a = 0; $a < count($rspta); $a++) {

                $credencial_identificacion = $rspta[$a]["credencial_identificacion"];

                $nombre = $rspta[$a]["credencial_apellido"] . ' ' . $rspta[$a]["credencial_apellido_2"] . ' ' . $rspta[$a]["credencial_nombre"] . ' ' . $rspta[$a]["credencial_nombre_2"];
            }

            $data[] = array(
                "0" => '<button onclick="agregar_mostrar_seguimiento(' . $reg[$i]['id_credencial'] . ')" class="btn btn-primary btn-xs" title="Agregar seguimiento"><i class="fa fa-plus"></i> Seguimiento</button> <button onclick="seguimientoverHistorial(' . $reg[$i]['id_credencial'] . ')" class="btn btn-primary btn-xs" title="historial"><i class="fa fa-eye" style="color:#fff"></i> Ver</button> ',

                "1" => $credencial_identificacion,
                "2" => $nombre
            );
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );

        echo json_encode($results);

        break;

    case 'vertotalestudiantesporrenovar':
        $id_programa = $_GET["id_programa"];
        $profesional = 1;
        $temporadainactivos = $_GET["temporadainactivos"];

        $nombre_array = array();
        $activarjornadatotalestudiantes = $desercion->activarjornadatotalestudiantes($profesional);
        for ($o = 0; $o < count($activarjornadatotalestudiantes); $o++) {
            $nombre = $activarjornadatotalestudiantes[$o]["nombre"];
            array_push($nombre_array, $nombre);
        }
        // $array_en_string = implode(' ', $nombre_array);

        // var_dump($nombre_array);

        // list($año, $numero) = explode('-', $periodo_actual);
        // $resta_año = $año - 2;
        // $inactivos_año_anterior = $resta_año . '-' . $numero;
        // $sumanumeroinactivos = $desercion->($id_programa, $temporadainactivos, $nombre_array ,$inactivos_año_anterior);
        $sumaporrenovar = $desercion->sumaporrenovartotal($id_programa, $nombre_array, $periodo_anterior); // consulta para traer el total de nuevos
        $data = array();
        $reg = $sumaporrenovar;

        for ($i = 0; $i < count($reg); $i++) {

            $rspta = $desercion->vernombreestudiantesinactivos($reg[$i]['id_credencial']);

            for ($a = 0; $a < count($rspta); $a++) {

                $credencial_identificacion = $rspta[$a]["credencial_identificacion"];

                $nombre = $rspta[$a]["credencial_apellido"] . ' ' . $rspta[$a]["credencial_apellido_2"] . ' ' . $rspta[$a]["credencial_nombre"] . ' ' . $rspta[$a]["credencial_nombre_2"];
            }

            $data[] = array(
                "0" => '<button onclick="agregar_mostrar_seguimiento(' . $reg[$i]['id_credencial'] . ')" class="btn btn-primary btn-xs" title="Agregar seguimiento"><i class="fa fa-plus"></i> Seguimiento</button> <button onclick="seguimientoverHistorial(' . $reg[$i]['id_credencial'] . ')" class="btn btn-primary btn-xs" title="historial"><i class="fa fa-eye" style="color:#fff"></i> Ver</button> ',

                "1" => $credencial_identificacion,
                "2" => $nombre
            );
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );

        echo json_encode($results);



        break;
}

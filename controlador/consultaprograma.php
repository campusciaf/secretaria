<?php
session_start();
require_once "../modelos/Consultaprograma.php";
$consultaprograma = new Consultaprograma();
date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$rsptaperiodo = $consultaprograma->periodoactual();
$periodo_actual = $rsptaperiodo["periodo_actual"];
$periodo_anterior = $rsptaperiodo["periodo_anterior"];
$temporadaactual = $rsptaperiodo["temporada"];
$temporadainactivos = $temporadaactual - 2;
$id_usuario = $_SESSION['id_usuario'];
switch ($_GET['op']) {
    case 'listargeneral':
        $data = array();
        $data["total"] = "";
        $listartotalactivos = $consultaprograma->listartotalactivos($periodo_actual);
        $totalactivos = count($listartotalactivos); // contiene el total de estudaintes activos matriculados
        $listarnuevos = $consultaprograma->listarnuevos($periodo_actual);
        $totalnuevos = count($listarnuevos);
        $porcentajetotalnuevos = ($totalnuevos * 100) / $totalactivos;
        $listarnuevoshomologados = $consultaprograma->listarnuevoshomologados($periodo_actual);
        $totalnuevoshomologados = count($listarnuevoshomologados);
        $porcentajetotalnuevoshomologados = ($totalnuevoshomologados * 100) / $totalactivos;
        $listarinternos = $consultaprograma->listarinternos($periodo_actual);
        $totalinternos = count($listarinternos);
        $porcentajetotalinternos = ($totalinternos * 100) / $totalactivos;
        $listarrematricula = $consultaprograma->listarrematricula($periodo_actual);
        $totalrematricula = count($listarrematricula);
        $porcentajetotalrematricula = ($totalrematricula * 100) / $totalactivos;
        $listaraplazos = $consultaprograma->listaraplazos($periodo_actual);
        $totalaplazos = count($listaraplazos);
        $porcentajetotalaplazos = ($totalaplazos * 100) / $totalactivos;
        $listarinactivos = $consultaprograma->listarinactivos($periodo_anterior);
        $totalinactivos = count($listarinactivos);
        $porcentajetotalinactivos = ($totalinactivos * 100) / $totalactivos;
        $total_renovacion = $totalrematricula + $totalinactivos;
        $porcentajeporrenovar = ($totalinactivos * 100) / $total_renovacion;
        $data["total"] .= '<div class="row">';
        $data["total"] .= '<div class="col-xl-3 d-none">';
        $data["total"] .= '
                    <div class="col-12">
                        <div class="info-box bg-success">
                            <div class="info-box-content">
                            <h3 class="titulo-4 text-white">Vista General</h3>
                                <div class="progress-group">
                                    Activos
                                    <span class="float-right" title="Total activos">
                                        <a onclick=listarestudiantes("' . $periodo_actual . '","1") class="text-white" title="Estudiantes activos" style="cursor:pointer">
                                            <b>' . $totalactivos . '</b>
                                        </a>
                                    </span>
                                </div>
                                <div class="progress-group">
                                    Nuevos
                                    <span class="float-right">
                                        <a onclick=listarestudiantes("' . $periodo_actual . '","2") class="text-white" title="Estudiantes nuevos" style="cursor:pointer">
                                            <b>' . $totalnuevos . '</b>/' . round($porcentajetotalnuevos, 0) . '% 
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $porcentajetotalnuevos . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group">
                                    Homologados
                                    <span class="float-right">
                                        <a onclick=listarestudiantes("' . $periodo_actual . '","3") class="text-white" title="Estudiantes homologados" style="cursor:pointer">
                                            <b>' . $totalnuevoshomologados . '</b>/' . round($porcentajetotalnuevoshomologados, 0) . '% 
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                         <div class="progress-bar"  style="width:' . $porcentajetotalnuevoshomologados . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group">
                                    Internos
                                    <span class="float-right">
                                        <a onclick=listarestudiantes("' . $periodo_actual . '","4") class="text-white" title="Estudiantes que cambiaron de nivel" style="cursor:pointer">
                                            <b>' . $totalinternos . '</b>/' . round($porcentajetotalinternos, 0) . '% 
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                         <div class="progress-bar"  style="width:' . $porcentajetotalinternos . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group">
                                    Renovaron
                                    <span class="float-right">
                                        <a onclick=listarestudiantes("' . $periodo_actual . '","5") class="text-white" title="Estudiantes que renovaron" style="cursor:pointer">
                                            <b>' . $totalrematricula . '</b>/' . round($porcentajetotalrematricula, 0) . '% 
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                         <div class="progress-bar"  style="width:' . $porcentajetotalrematricula . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group">
                                    Aplazados
                                    <span class="float-right">
                                        <a onclick=listarestudiantes("' . $periodo_actual . '","6") class="text-white" title="Estudiantes   que aplazaron" style="cursor:pointer">
                                            <b>' . $totalaplazos . '</b>/' . round($porcentajetotalaplazos, 0) . '% 
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                         <div class="progress-bar"  style="width:' . $porcentajetotalaplazos . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group">
                                    Por renovar
                                    <span class="float-right">
                                        <a onclick=listarestudiantes("' . $periodo_anterior . '","7") class="text-white" title="Estudiantes por renovar, incluye aplazados" style="cursor:pointer">
                                            <b>' . $totalinactivos . '</b>/' . round($porcentajeporrenovar, 0) . '% 
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                         <div class="progress-bar"  style="width:' . $porcentajetotalinactivos . '%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
        $data["total"] .= '</div>';
        $data["total"] .= '<div class="col-xl-9 d-none">';
        $data["total"] .= '<div class="row">';
        $listarnuevosnivel1 = $consultaprograma->listarnivelnuevos($periodo_actual, 1);
        $listarrenovaronnivel1 = $consultaprograma->listarnivelrenovaron($periodo_actual, 1);
        $porrenovarnivel1 = $consultaprograma->inactivosnivel($periodo_anterior, 1);
        $aplazadosnivel1 = $consultaprograma->aplazadosnivel($periodo_actual, 1);
        $homologadosnivel1 = $consultaprograma->homologadosnivel($periodo_actual, 1);
        $internosnivel1 = $consultaprograma->internosnivel($periodo_actual, 1);
        $totalnuevosnivel1 = count($listarnuevosnivel1);
        $totalrenovaronnivel1 = count($listarrenovaronnivel1);
        $totalporrenovarnivel1 = count($porrenovarnivel1);
        $totalaplazadosnivel1 = count($aplazadosnivel1);
        $totalahomologadosnivel1 = count($homologadosnivel1);
        $totalinternosnivel1 = count($internosnivel1);
        $totalactivos1 = $totalnuevosnivel1 + $totalrenovaronnivel1 + $totalahomologadosnivel1 + $totalinternosnivel1;
        $totalrenovar1 = $totalrenovaronnivel1 + $totalporrenovarnivel1;
        $por_activos1 = ($totalactivos1 * 100) / $totalactivos;
        $por_nuevos1 = ($totalnuevosnivel1 * 100) / $totalactivos1;
        $por_renovaron1 = ($totalrenovaronnivel1 * 100) / $totalactivos1;
        $por_homologadosn1 = ($totalahomologadosnivel1 * 100) / $totalactivos1;
        $por_internosn1 = ($totalinternosnivel1 * 100) / $totalactivos1;
        $por_porrenovarn1 = ($totalporrenovarnivel1 * 100) / $totalrenovar1;
        $data["total"] .= '
                    <div class="col-xl-3">
                        <div class="info-box bg-primary">
                            <div class="info-box-content">
                            <h3 class="titulo-4 text-white" title="representación del nivel">Técnico <span class="float-right badge bg-white text-sm">' . round($por_activos1) . '%</span></h3>
                                <div class="progress-group" title="Estudiantes activos">
                                    Activos
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","1","1") class="text-white" title="Estudiantes Activos" style="cursor:pointer">
                                            <b>' . $totalactivos1 . '</b>
                                        </a>
                                    </span>
                                </div>
                                <div class="progress-group" title="Nuevos">
                                    Nuevos
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","1","2") class="text-white" title="Estudiantes nuevos" style="cursor:pointer">
                                            <b>' . $totalnuevosnivel1 . '</b>/' . round($por_nuevos1) . '%
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $por_nuevos1 . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group" title="Nuevos">
                                    Homologados
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","1","3") class="text-white" title="Estudiantes homologados" style="cursor:pointer">
                                            <b>' . $totalahomologadosnivel1 . '</b>/' . round($por_homologadosn1) . '%
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $por_homologadosn1 . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group" title="Nuevos">
                                    Internos
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","1","4") class="text-white" title="Estudiantes que cambiaron de nivel o programa" style="cursor:pointer">
                                            <b>' . $totalinternosnivel1 . '</b>/' . round($por_internosn1) . '%
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $por_internosn1 . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group" title="Renovaron">
                                    Renovaron
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","1","5") class="text-white" title="Estudiantes que renovaron" style="cursor:pointer">
                                            <b>' . $totalrenovaronnivel1 . '</b>/' . round($por_renovaron1) . '%
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $por_renovaron1 . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group" title="Por renovar">
                                    Por renovar
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_anterior . '","1","7") class="text-white" title="Estudiantes por renovar" style="cursor:pointer">
                                            <b>' . $totalporrenovarnivel1 . '</b>/' . round($por_porrenovarn1) . '%
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $por_porrenovarn1 . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group" title="Aplazaron semestre">
                                    Aplazaron
                                    <span class="float-right"><b>' . $totalaplazadosnivel1 . '</b></span>
                                </div>
                            </div>
                        </div>
                    </div>';
        $listarnuevosnivel2 = $consultaprograma->listarnivelnuevos($periodo_actual, 2);
        $listarrenovaronnivel2 = $consultaprograma->listarnivelrenovaron($periodo_actual, 2);
        $porrenovarnivel2 = $consultaprograma->inactivosnivel($periodo_anterior, 2);
        $aplazadosnivel2 = $consultaprograma->aplazadosnivel($periodo_actual, 2);
        $homologadosnivel2 = $consultaprograma->homologadosnivel($periodo_actual, 2);
        $internosnivel2 = $consultaprograma->internosnivel($periodo_actual, 2);
        $totalnuevosnivel2 = count($listarnuevosnivel2);
        $totalrenovaronnivel2 = count($listarrenovaronnivel2);
        $totalporrenovarnivel2 = count($porrenovarnivel2);
        $totalaplazadosnivel2 = count($aplazadosnivel2);
        $totalahomologadosnivel2 = count($homologadosnivel2);
        $totalinternosnivel2 = count($internosnivel2);
        $totalactivos2 = $totalnuevosnivel2 + $totalrenovaronnivel2 + $totalahomologadosnivel2 + $totalinternosnivel2;
        $totalrenovar2 = $totalrenovaronnivel2 + $totalporrenovarnivel2;
        $por_activos2 = $totalactivos > 0 ? ($totalactivos2 * 100) / $totalactivos : 0;
        $por_nuevos2 = $totalactivos2 > 0 ? ($totalnuevosnivel2 * 100) / $totalactivos2 : 0;
        $por_renovaron2 = $totalactivos2 > 0 ? ($totalrenovaronnivel2 * 100) / $totalactivos2 : 0;
        $por_homologadosn2 = $totalactivos2 > 0 ? ($totalahomologadosnivel2 * 100) / $totalactivos2 : 0;
        $por_internosn2 = $totalactivos2 > 0 ? ($totalinternosnivel2 * 100) / $totalactivos2 : 0;
        $por_porrenovarn2 = $totalrenovar2 > 0 ? ($totalporrenovarnivel2 * 100) / $totalrenovar2 : 0;
        $data["total"] .= '
                    <div class="col-xl-3">
                        <div class="info-box bg-purple">
                            <div class="info-box-content">
                            <h3 class="titulo-4 text-white" title="representación del nivel">Tecnológico <span class="float-right badge bg-white text-sm">' . round($por_activos2) . '%</span></h3>
                                <div class="progress-group" title="Estudiantes activos">
                                    Activos
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","2","1") class="text-white" title="Estudiantes Activos" style="cursor:pointer">
                                            <b>' . $totalactivos2 . '</b>
                                        </a>
                                    </span>
                                </div>
                                <div class="progress-group" title="Nuevos">
                                    Nuevos
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","2","2") class="text-white" title="Estudiantes nuevos" style="cursor:pointer">
                                            <b>' . $totalnuevosnivel2 . '</b>/' . round($por_nuevos2) . '%
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $por_nuevos2 . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group" title="Nuevos">
                                    Homologados
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","2","3") class="text-white" title="Estudiantes homologados" style="cursor:pointer">
                                            <b>' . $totalahomologadosnivel2 . '</b>/' . round($por_homologadosn2) . '%
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $por_homologadosn2 . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group" title="Nuevos">
                                    Internos
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","2","4") class="text-white" title="Estudiantes que cambiaron de nivel o programa" style="cursor:pointer">
                                            <b>' . $totalinternosnivel2 . '</b>/' . round($por_internosn2) . '%
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $por_internosn2 . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group" title="Renovaron">
                                    Renovaron
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","2","5") class="text-white" title="Estudiantes que renovaron" style="cursor:pointer">
                                            <b>' . $totalrenovaronnivel2 . '</b>/' . round($por_renovaron2) . '%
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $por_renovaron2 . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group" title="Por renovar">
                                    Por renovar
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_anterior . '","2","7") class="text-white" title="Estudiantes por renovar" style="cursor:pointer">
                                            <b>' . $totalporrenovarnivel2 . '</b>/' . round($por_porrenovarn2) . '%
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $por_porrenovarn2 . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group" title="Aplazaron semestre">
                                    Aplazaron
                                    <span class="float-right"><b>' . $totalaplazadosnivel2 . '</b></span>
                                </div>
                            </div>
                        </div>
                    </div>';
        // $listarnuevosnivel3 = $consultaprograma->listarnivelnuevos($periodo_actual,3);
        // $listarrenovaronnivel3 = $consultaprograma->listarnivelrenovaron($periodo_actual,3);
        // $porrenovarnivel3=$consultaprograma->inactivosnivel($periodo_anterior,3);
        // $aplazadosnivel3=$consultaprograma->aplazadosnivel($periodo_actual,3);
        // $homologadosnivel3=$consultaprograma->homologadosnivel($periodo_actual,3);
        // $internosnivel3=$consultaprograma->internosnivel($periodo_actual,3);
        // $totalnuevosnivel3=count($listarnuevosnivel3);
        // $totalrenovaronnivel3=count($listarrenovaronnivel3);
        // $totalporrenovarnivel3=count($porrenovarnivel3);
        // $totalaplazadosnivel3=count($aplazadosnivel3);
        // $totalahomologadosnivel3=count($homologadosnivel3);
        // $totalinternosnivel3=count($internosnivel3);
        // $totalactivos3=$totalnuevosnivel3+$totalrenovaronnivel3+$totalahomologadosnivel3+$totalinternosnivel3;
        // $totalrenovar3=$totalrenovaronnivel3+$totalporrenovarnivel3;
        // $por_activos3=($totalactivos3*100)/$totalactivos;
        // $por_nuevos3=($totalnuevosnivel3*100)/$totalactivos3;
        // $por_renovaron3=($totalrenovaronnivel3*100)/$totalactivos3;
        // $por_homologadosn3=($totalahomologadosnivel3*100)/$totalactivos3;
        // $por_internosn3=($totalinternosnivel3*100)/$totalactivos3;
        // $por_porrenovarn3=($totalporrenovarnivel3*100)/ $totalrenovar3;
        $listarnuevosnivel3 = $consultaprograma->listarnivelnuevos($periodo_actual, 3);
        $listarrenovaronnivel3 = $consultaprograma->listarnivelrenovaron($periodo_actual, 3);
        $porrenovarnivel3 = $consultaprograma->inactivosnivel($periodo_anterior, 3);
        $aplazadosnivel3 = $consultaprograma->aplazadosnivel($periodo_actual, 3);
        $homologadosnivel3 = $consultaprograma->homologadosnivel($periodo_actual, 3);
        $internosnivel3 = $consultaprograma->internosnivel($periodo_actual, 3);
        $totalnuevosnivel3 = count($listarnuevosnivel3);
        $totalrenovaronnivel3 = count($listarrenovaronnivel3);
        $totalporrenovarnivel3 = count($porrenovarnivel3);
        $totalaplazadosnivel3 = count($aplazadosnivel3);
        $totalahomologadosnivel3 = count($homologadosnivel3);
        $totalinternosnivel3 = count($internosnivel3);
        $totalactivos3 = $totalnuevosnivel3 + $totalrenovaronnivel3 + $totalahomologadosnivel3 + $totalinternosnivel3;
        $totalrenovar3 = $totalrenovaronnivel3 + $totalporrenovarnivel3;
        $por_activos3 = $totalactivos > 0 ? ($totalactivos3 * 100) / $totalactivos : 0;
        $por_nuevos3 = $totalactivos3 > 0 ? ($totalnuevosnivel3 * 100) / $totalactivos3 : 0;
        $por_renovaron3 = $totalactivos3 > 0 ? ($totalrenovaronnivel3 * 100) / $totalactivos3 : 0;
        $por_homologadosn3 = $totalactivos3 > 0 ? ($totalahomologadosnivel3 * 100) / $totalactivos3 : 0;
        $por_internosn3 = $totalactivos3 > 0 ? ($totalinternosnivel3 * 100) / $totalactivos3 : 0;
        $por_porrenovarn3 = $totalrenovar3 > 0 ? ($totalporrenovarnivel3 * 100) / $totalrenovar3 : 0;
        $data["total"] .= '
                    <div class="col-xl-3">
                        <div class="info-box bg-maroon">
                            <div class="info-box-content">
                            <h3 class="titulo-4 text-white" title="representación del nivel">Profesional <span class="float-right badge bg-white text-sm">' . round($por_activos3) . '%</span></h3>
                                <div class="progress-group" title="Estudiantes activos">
                                    Activos
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","3","1") class="text-white" title="Estudiantes Activos" style="cursor:pointer">
                                            <b>' . $totalactivos3 . '</b>
                                        </a>
                                    </span>
                                </div>
                                <div class="progress-group" title="Nuevos">
                                    Nuevos
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","3","2") class="text-white" title="Estudiantes nuevos" style="cursor:pointer">
                                            <b>' . $totalnuevosnivel3 . '</b>/' . round($por_nuevos3) . '%
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $por_nuevos3 . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group" title="Nuevos">
                                    Homologados
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","3","3") class="text-white" title="Estudiantes homologados" style="cursor:pointer">
                                            <b>' . $totalahomologadosnivel3 . '</b>/' . round($por_homologadosn3) . '%
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $por_homologadosn3 . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group" title="Nuevos">
                                    Internos
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","3","4") class="text-white" title="Estudiantes que cambiaron de nivel o programa" style="cursor:pointer">
                                            <b>' . $totalinternosnivel3 . '</b>/' . round($por_internosn3) . '%
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $por_internosn3 . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group" title="Renovaron">
                                    Renovaron
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","3","5") class="text-white" title="Estudiantes que renovaron" style="cursor:pointer">
                                            <b>' . $totalrenovaronnivel3 . '</b>/' . round($por_renovaron3) . '%
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $por_renovaron3 . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group" title="Por renovar">
                                    Por renovar
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_anterior . '","3","7") class="text-white" title="Estudiantes por renovar" style="cursor:pointer">
                                            <b>' . $totalporrenovarnivel3 . '</b>/' . round($por_porrenovarn3) . '%
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $por_porrenovarn3 . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group" title="Aplazaron semestre">
                                    Aplazaron
                                    <span class="float-right"><b>' . $totalaplazadosnivel3 . '</b></span>
                                </div>
                            </div>
                        </div>
                    </div>';
        // $listarnuevosnivel4 = $consultaprograma->listarnivelnuevos($periodo_actual,4);
        // $listarrenovaronnivel4 = $consultaprograma->listarnivelrenovaron($periodo_actual,4);
        // $porrenovarnivel4=$consultaprograma->inactivosnivel($periodo_anterior,4);
        // $aplazadosnivel4=$consultaprograma->aplazadosnivel($periodo_actual,4);
        // $homologadosnivel4=$consultaprograma->homologadosnivel($periodo_actual,4);
        // $internosnivel4=$consultaprograma->internosnivel($periodo_actual,4);
        // $totalnuevosnivel4=count($listarnuevosnivel4);
        // $totalrenovaronnivel4=count($listarrenovaronnivel4);
        // $totalporrenovarnivel4=count($porrenovarnivel4);
        // $totalaplazadosnivel4=count($aplazadosnivel4);
        // $totalahomologadosnivel4=count($homologadosnivel4);
        // $totalinternosnivel4=count($internosnivel4);
        // $totalactivos4=$totalnuevosnivel4+$totalrenovaronnivel4+$totalahomologadosnivel4+$totalinternosnivel4;
        // $totalrenovar4=$totalrenovaronnivel4+$totalporrenovarnivel4;
        // @$por_activos4=($totalactivos4*100)/$totalactivos;
        // @$por_nuevos4=($totalnuevosnivel4*100)/$totalactivos4;
        // @$por_renovaron4=($totalrenovaronnivel4*100)/$totalactivos4;
        // @$por_homologadosn4=($totalahomologadosnivel4*100)/$totalactivos4;
        // @$por_internosn4=($totalinternosnivel4*100)/$totalactivos4;
        // @$por_porrenovarn4=($totalporrenovarnivel4*100)/ $totalrenovar4;
        $listarnuevosnivel4 = $consultaprograma->listarnivelnuevos($periodo_actual, 4);
        $listarrenovaronnivel4 = $consultaprograma->listarnivelrenovaron($periodo_actual, 4);
        $porrenovarnivel4 = $consultaprograma->inactivosnivel($periodo_anterior, 4);
        $aplazadosnivel4 = $consultaprograma->aplazadosnivel($periodo_actual, 4);
        $homologadosnivel4 = $consultaprograma->homologadosnivel($periodo_actual, 4);
        $internosnivel4 = $consultaprograma->internosnivel($periodo_actual, 4);
        $totalnuevosnivel4 = count($listarnuevosnivel4);
        $totalrenovaronnivel4 = count($listarrenovaronnivel4);
        $totalporrenovarnivel4 = count($porrenovarnivel4);
        $totalaplazadosnivel4 = count($aplazadosnivel4);
        $totalahomologadosnivel4 = count($homologadosnivel4);
        $totalinternosnivel4 = count($internosnivel4);
        $totalactivos4 = $totalnuevosnivel4 + $totalrenovaronnivel4 + $totalahomologadosnivel4 + $totalinternosnivel4;
        $totalrenovar4 = $totalrenovaronnivel4 + $totalporrenovarnivel4;
        @$por_activos4 = $totalactivos > 0 ? ($totalactivos4 * 100) / $totalactivos : 0;
        @$por_nuevos4 = $totalactivos4 > 0 ? ($totalnuevosnivel4 * 100) / $totalactivos4 : 0;
        @$por_renovaron4 = $totalactivos4 > 0 ? ($totalrenovaronnivel4 * 100) / $totalactivos4 : 0;
        @$por_homologadosn4 = $totalactivos4 > 0 ? ($totalahomologadosnivel4 * 100) / $totalactivos4 : 0;
        @$por_internosn4 = $totalactivos4 > 0 ? ($totalinternosnivel4 * 100) / $totalactivos4 : 0;
        @$por_porrenovarn4 = $totalrenovar4 > 0 ? ($totalporrenovarnivel4 * 100) / $totalrenovar4 : 0;
        $data["total"] .= '
                    <div class="col-xl-3">
                        <div class="info-box bg-lightblue">
                            <div class="info-box-content">
                            <h3 class="titulo-4 text-white" title="representación del nivel">Seminarios <span class="float-right badge bg-white text-sm">' . round($por_activos4) . '%</span></h3>
                                <div class="progress-group" title="Estudiantes activos">
                                    Activos
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","4","1") class="text-white" title="Estudiantes Activos" style="cursor:pointer">
                                            <b>' . $totalactivos4 . '</b>
                                        </a>
                                    </span>
                                </div>
                                <div class="progress-group" title="Nuevos">
                                    Nuevos
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","4","2") class="text-white" title="Estudiantes nuevos" style="cursor:pointer">
                                            <b>' . $totalnuevosnivel4 . '</b>/' . round($por_nuevos4) . '%
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $por_nuevos4 . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group" title="Nuevos">
                                    Homologados
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","4","3") class="text-white" title="Estudiantes homologados" style="cursor:pointer">
                                            <b>' . $totalahomologadosnivel4 . '</b>/' . round($por_homologadosn4) . '%
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $por_homologadosn4 . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group" title="Nuevos">
                                    Internos
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","4","4") class="text-white" title="Estudiantes que cambiaron de nivel o programa" style="cursor:pointer">
                                            <b>' . $totalinternosnivel4 . '</b>/' . round($por_internosn4) . '%
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $por_internosn4 . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group" title="Renovaron">
                                    Renovaron
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","4","5") class="text-white" title="Estudiantes que renovaron" style="cursor:pointer">
                                            <b>' . $totalrenovaronnivel4 . '</b>/' . round($por_renovaron4) . '%
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $por_renovaron4 . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group" title="Por renovar">
                                    Por renovar
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_anterior . '","4","7") class="text-white" title="Estudiantes por renovar" style="cursor:pointer">
                                            <b>' . $totalporrenovarnivel4 . '</b>/' . round($por_porrenovarn4) . '%
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $por_porrenovarn4 . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group" title="Aplazaron semestre">
                                    Aplazaron
                                    <span class="float-right"><b>' . $totalaplazadosnivel4 . '</b></span>
                                </div>
                            </div>
                        </div>
                    </div>';
        // $listarnuevosnivel5 = $consultaprograma->listarnivelnuevos($periodo_actual,5);
        // $listarrenovaronnivel5 = $consultaprograma->listarnivelrenovaron($periodo_actual,5);
        // $porrenovarnivel5=$consultaprograma->inactivosnivel($periodo_anterior,5);
        // $aplazadosnivel5=$consultaprograma->aplazadosnivel($periodo_actual,5);
        // $homologadosnivel5=$consultaprograma->homologadosnivel($periodo_actual,5);
        // $internosnivel5=$consultaprograma->internosnivel($periodo_actual,5);
        // $totalnuevosnivel5=count($listarnuevosnivel5);
        // $totalrenovaronnivel5=count($listarrenovaronnivel5);
        // $totalporrenovarnivel5=count($porrenovarnivel5);
        // $totalaplazadosnivel5=count($aplazadosnivel5);
        // $totalahomologadosnivel5=count($homologadosnivel5);
        // $totalinternosnivel5=count($internosnivel5);
        // $totalactivos5=$totalnuevosnivel5+$totalrenovaronnivel5+$totalahomologadosnivel5+$totalinternosnivel5;
        // $totalrenovar5=$totalrenovaronnivel5+$totalporrenovarnivel5;
        // @$por_activos5=($totalactivos5*100)/$totalactivos;
        // @$por_nuevos5=($totalnuevosnivel5*100)/$totalactivos5;
        // @$por_renovaron5=($totalrenovaronnivel5*100)/$totalactivos5;
        // @$por_homologadosn5=($totalahomologadosnivel5*100)/$totalactivos5;
        // @$por_internosn5=($totalinternosnivel5*100)/$totalactivos5;
        // $por_porrenovarn5=($totalporrenovarnivel5*100)/ $totalrenovar5;
        $listarnuevosnivel5 = $consultaprograma->listarnivelnuevos($periodo_actual, 5);
        $listarrenovaronnivel5 = $consultaprograma->listarnivelrenovaron($periodo_actual, 5);
        $porrenovarnivel5 = $consultaprograma->inactivosnivel($periodo_anterior, 5);
        $aplazadosnivel5 = $consultaprograma->aplazadosnivel($periodo_actual, 5);
        $homologadosnivel5 = $consultaprograma->homologadosnivel($periodo_actual, 5);
        $internosnivel5 = $consultaprograma->internosnivel($periodo_actual, 5);
        $totalnuevosnivel5 = count($listarnuevosnivel5);
        $totalrenovaronnivel5 = count($listarrenovaronnivel5);
        $totalporrenovarnivel5 = count($porrenovarnivel5);
        $totalaplazadosnivel5 = count($aplazadosnivel5);
        $totalahomologadosnivel5 = count($homologadosnivel5);
        $totalinternosnivel5 = count($internosnivel5);
        $totalactivos5 = $totalnuevosnivel5 + $totalrenovaronnivel5 + $totalahomologadosnivel5 + $totalinternosnivel5;
        $totalrenovar5 = $totalrenovaronnivel5 + $totalporrenovarnivel5;
        @$por_activos5 = $totalactivos > 0 ? ($totalactivos5 * 100) / $totalactivos : 0;
        @$por_nuevos5 = $totalactivos5 > 0 ? ($totalnuevosnivel5 * 100) / $totalactivos5 : 0;
        @$por_renovaron5 = $totalactivos5 > 0 ? ($totalrenovaronnivel5 * 100) / $totalactivos5 : 0;
        @$por_homologadosn5 = $totalactivos5 > 0 ? ($totalahomologadosnivel5 * 100) / $totalactivos5 : 0;
        @$por_internosn5 = $totalactivos5 > 0 ? ($totalinternosnivel5 * 100) / $totalactivos5 : 0;
        $por_porrenovarn5 = $totalrenovar5 > 0 ? ($totalporrenovarnivel5 * 100) / $totalrenovar5 : 0;
        $data["total"] .= '
                    <div class="col-xl-3">
                        <div class="info-box bg-pink">
                            <div class="info-box-content">
                            <h3 class="titulo-4 text-white" title="representación del nivel">Nivelatorios <span class="float-right badge bg-white text-sm">' . round($por_activos5) . '%</span></h3>
                                <div class="progress-group" title="Estudiantes activos">
                                    Activos
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","5","1") class="text-white" title="Estudiantes Activos" style="cursor:pointer">
                                            <b>' . $totalactivos5 . '</b>
                                        </a>
                                    </span>
                                </div>
                                <div class="progress-group" title="Nuevos">
                                    Nuevos
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","5","2") class="text-white" title="Estudiantes nuevos" style="cursor:pointer">
                                            <b>' . $totalnuevosnivel5 . '</b>/' . round($por_nuevos5) . '%
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $por_nuevos5 . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group" title="Nuevos">
                                    Homologados
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","5","3") class="text-white" title="Estudiantes homologados" style="cursor:pointer">
                                            <b>' . $totalahomologadosnivel5 . '</b>/' . round($por_homologadosn5) . '%
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $por_homologadosn5 . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group" title="Nuevos">
                                    Internos
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","5","4") class="text-white" title="Estudiantes que cambiaron de nivel o programa" style="cursor:pointer">
                                            <b>' . $totalinternosnivel5 . '</b>/' . round($por_internosn5) . '%
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $por_internosn5 . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group" title="Renovaron">
                                    Renovaron
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","5","5") class="text-white" title="Estudiantes que renovaron" style="cursor:pointer">
                                            <b>' . $totalrenovaronnivel5 . '</b>/' . round($por_renovaron5) . '%
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $por_renovaron5 . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group" title="Por renovar">
                                    Por renovar
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_anterior . '","5","7") class="text-white" title="Estudiantes por renovar" style="cursor:pointer">
                                            <b>' . $totalporrenovarnivel5 . '</b>/' . round($por_porrenovarn5) . '%
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $por_porrenovarn5 . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group" title="Aplazaron semestre">
                                    Aplazaron
                                    <span class="float-right"><b>' . $totalaplazadosnivel5 . '</b></span>
                                </div>
                            </div>
                        </div>
                    </div>';
        // $listarnuevosnivel6 = $consultaprograma->listarnivelnuevos($periodo_actual,6);
        // $listarrenovaronnivel6 = $consultaprograma->listarnivelrenovaron($periodo_actual,6);
        // $porrenovarnivel6=$consultaprograma->inactivosnivel($periodo_anterior,6);
        // $aplazadosnivel6=$consultaprograma->aplazadosnivel($periodo_actual,6);
        // $homologadosnivel6=$consultaprograma->homologadosnivel($periodo_actual,6);
        // $internosnivel6=$consultaprograma->internosnivel($periodo_actual,6);
        // $totalnuevosnivel6=count($listarnuevosnivel6);
        // $totalrenovaronnivel6=count($listarrenovaronnivel6);
        // $totalporrenovarnivel6=count($porrenovarnivel6);
        // $totalaplazadosnivel6=count($aplazadosnivel6);
        // $totalahomologadosnivel6=count($homologadosnivel6);
        // $totalinternosnivel6=count($internosnivel6);
        // $totalactivos6=$totalnuevosnivel6+$totalrenovaronnivel6+$totalahomologadosnivel6+$totalinternosnivel6;
        // $totalrenovar6=$totalrenovaronnivel6+$totalporrenovarnivel6;
        // @$por_activos6=($totalactivos6*100)/$totalactivos;
        // @$por_nuevos6=($totalnuevosnivel6*100)/$totalactivos6;
        // @$por_renovaron6=($totalrenovaronnivel6*100)/$totalactivos6;
        // @$por_homologadosn6=($totalahomologadosnivel6*100)/$totalactivos6;
        // @$por_internosn6=($totalinternosnivel6*100)/$totalactivos6;
        // @$por_porrenovarn6=($totalporrenovarnivel6*100)/ $totalrenovar6;
        $listarnuevosnivel6 = $consultaprograma->listarnivelnuevos($periodo_actual, 6);
        $listarrenovaronnivel6 = $consultaprograma->listarnivelrenovaron($periodo_actual, 6);
        $porrenovarnivel6 = $consultaprograma->inactivosnivel($periodo_anterior, 6);
        $aplazadosnivel6 = $consultaprograma->aplazadosnivel($periodo_actual, 6);
        $homologadosnivel6 = $consultaprograma->homologadosnivel($periodo_actual, 6);
        $internosnivel6 = $consultaprograma->internosnivel($periodo_actual, 6);
        $totalnuevosnivel6 = count($listarnuevosnivel6);
        $totalrenovaronnivel6 = count($listarrenovaronnivel6);
        $totalporrenovarnivel6 = count($porrenovarnivel6);
        $totalaplazadosnivel6 = count($aplazadosnivel6);
        $totalahomologadosnivel6 = count($homologadosnivel6);
        $totalinternosnivel6 = count($internosnivel6);
        $totalactivos6 = $totalnuevosnivel6 + $totalrenovaronnivel6 + $totalahomologadosnivel6 + $totalinternosnivel6;
        $totalrenovar6 = $totalrenovaronnivel6 + $totalporrenovarnivel6;
        @$por_activos6 = $totalactivos > 0 ? ($totalactivos6 * 100) / $totalactivos : 0;
        @$por_nuevos6 = $totalactivos6 > 0 ? ($totalnuevosnivel6 * 100) / $totalactivos6 : 0;
        @$por_renovaron6 = $totalactivos6 > 0 ? ($totalrenovaronnivel6 * 100) / $totalactivos6 : 0;
        @$por_homologadosn6 = $totalactivos6 > 0 ? ($totalahomologadosnivel6 * 100) / $totalactivos6 : 0;
        @$por_internosn6 = $totalactivos6 > 0 ? ($totalinternosnivel6 * 100) / $totalactivos6 : 0;
        @$por_porrenovarn6 = $totalrenovar6 > 0 ? ($totalporrenovarnivel6 * 100) / $totalrenovar6 : 0;
        $data["total"] .= '
                    <div class="col-xl-3">
                        <div class="info-box bg-teal">
                            <div class="info-box-content">
                            <h3 class="titulo-4 text-white" title="representación del nivel">Idiomas <span class="float-right badge bg-white text-sm">' . round($por_activos6) . '%</span></h3>
                                <div class="progress-group" title="Estudiantes activos">
                                    Activos
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","6","1") class="text-white" title="Estudiantes Activos" style="cursor:pointer">
                                            <b>' . $totalactivos6 . '</b>
                                        </a>
                                    </span>
                                </div>
                                <div class="progress-group" title="Nuevos">
                                    Nuevos
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","6","2") class="text-white" title="Estudiantes nuevos" style="cursor:pointer">
                                            <b>' . $totalnuevosnivel6 . '</b>/' . round($por_nuevos6) . '%
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $por_nuevos6 . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group" title="Nuevos">
                                    Homologados
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","6","3") class="text-white" title="Estudiantes homologados" style="cursor:pointer">
                                            <b>' . $totalahomologadosnivel6 . '</b>/' . round($por_homologadosn6) . '%
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $por_homologadosn6 . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group" title="Nuevos">
                                    Internos
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","6","4") class="text-white" title="Estudiantes que cambiaron de nivel o programa" style="cursor:pointer">
                                            <b>' . $totalinternosnivel6 . '</b>/' . round($por_internosn6) . '%
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $por_internosn6 . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group" title="Renovaron">
                                    Renovaron
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","6","5") class="text-white" title="Estudiantes que renovaron" style="cursor:pointer">
                                            <b>' . $totalrenovaronnivel6 . '</b>/' . round($por_renovaron6) . '%
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $por_renovaron6 . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group" title="Por renovar">
                                    Por renovar
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_anterior . '","6","7") class="text-white" title="Estudiantes por renovar" style="cursor:pointer">
                                            <b>' . $totalporrenovarnivel6 . '</b>/' . round($por_porrenovarn6) . '%
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $por_porrenovarn6 . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group" title="Aplazaron semestre">
                                    Aplazaron
                                    <span class="float-right"><b>' . $totalaplazadosnivel6 . '</b></span>
                                </div>
                            </div>
                        </div>
                    </div>';
        // $listarnuevosnivel7 = $consultaprograma->listarnivelnuevos($periodo_actual,7);
        // $listarrenovaronnivel7 = $consultaprograma->listarnivelrenovaron($periodo_actual,7);
        // $porrenovarnivel7=$consultaprograma->inactivosnivel($periodo_anterior,7);
        // $aplazadosnivel7=$consultaprograma->aplazadosnivel($periodo_actual,7);
        // $homologadosnivel7=$consultaprograma->homologadosnivel($periodo_actual,7);
        // $internosnivel7=$consultaprograma->internosnivel($periodo_actual,7);
        // $totalnuevosnivel7=count($listarnuevosnivel7);
        // $totalrenovaronnivel7=count($listarrenovaronnivel7);
        // $totalporrenovarnivel7=count($porrenovarnivel7);
        // $totalaplazadosnivel7=count($aplazadosnivel7);
        // $totalahomologadosnivel7=count($homologadosnivel7);
        // $totalinternosnivel7=count($internosnivel7);
        // $totalactivos7=$totalnuevosnivel7+$totalrenovaronnivel7+$totalahomologadosnivel7+$totalinternosnivel7;
        // $totalrenovar7=$totalrenovaronnivel7+$totalporrenovarnivel7;
        // @$por_activos7=($totalactivos7*100)/$totalactivos;
        // @$por_nuevos7=($totalnuevosnivel7*100)/$totalactivos7;
        // @$por_renovaron7=($totalrenovaronnivel7*100)/$totalactivos7;
        // @$por_homologadosn7=($totalahomologadosnivel7*100)/$totalactivos7;
        // @$por_internosn7=($totalinternosnivel7*100)/$totalactivos7;
        // @$por_porrenovarn7=($totalporrenovarnivel7*100)/ $totalrenovar7;
        $listarnuevosnivel7 = $consultaprograma->listarnivelnuevos($periodo_actual, 7);
        $listarrenovaronnivel7 = $consultaprograma->listarnivelrenovaron($periodo_actual, 7);
        $porrenovarnivel7 = $consultaprograma->inactivosnivel($periodo_anterior, 7);
        $aplazadosnivel7 = $consultaprograma->aplazadosnivel($periodo_actual, 7);
        $homologadosnivel7 = $consultaprograma->homologadosnivel($periodo_actual, 7);
        $internosnivel7 = $consultaprograma->internosnivel($periodo_actual, 7);
        $totalnuevosnivel7 = count($listarnuevosnivel7);
        $totalrenovaronnivel7 = count($listarrenovaronnivel7);
        $totalporrenovarnivel7 = count($porrenovarnivel7);
        $totalaplazadosnivel7 = count($aplazadosnivel7);
        $totalahomologadosnivel7 = count($homologadosnivel7);
        $totalinternosnivel7 = count($internosnivel7);
        $totalactivos7 = $totalnuevosnivel7 + $totalrenovaronnivel7 + $totalahomologadosnivel7 + $totalinternosnivel7;
        $totalrenovar7 = $totalrenovaronnivel7 + $totalporrenovarnivel7;
        @$por_activos7 = $totalactivos > 0 ? ($totalactivos7 * 100) / $totalactivos : 0;
        @$por_nuevos7 = $totalactivos7 > 0 ? ($totalnuevosnivel7 * 100) / $totalactivos7 : 0;
        @$por_renovaron7 = $totalactivos7 > 0 ? ($totalrenovaronnivel7 * 100) / $totalactivos7 : 0;
        @$por_homologadosn7 = $totalactivos7 > 0 ? ($totalahomologadosnivel7 * 100) / $totalactivos7 : 0;
        @$por_internosn7 = $totalactivos7 > 0 ? ($totalinternosnivel7 * 100) / $totalactivos7 : 0;
        @$por_porrenovarn7 = $totalrenovar7 > 0 ? ($totalporrenovarnivel7 * 100) / $totalrenovar7 : 0;
        $data["total"] .= '
                    <div class="col-xl-3">
                        <div class="info-box bg-warning">
                            <div class="info-box-content">
                            <h3 class="titulo-4 text-white" title="representación del nivel">Pro. laborales <span class="float-right badge bg-white text-sm">' . round($por_activos7) . '%</span></h3>
                                <div class="progress-group" title="Estudiantes activos">
                                    Activos
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","7","1") class="text-white" title="Estudiantes Activos" style="cursor:pointer">
                                            <b>' . $totalactivos7 . '</b>
                                        </a>
                                    </span>
                                </div>
                                <div class="progress-group" title="Nuevos">
                                    Nuevos
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","7","2") class="text-white" title="Estudiantes nuevos" style="cursor:pointer">
                                            <b>' . $totalnuevosnivel7 . '</b>/' . round($por_nuevos7) . '%
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $por_nuevos7 . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group" title="Nuevos">
                                    Homologados
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","7","3") class="text-white" title="Estudiantes homologados" style="cursor:pointer">
                                            <b>' . $totalahomologadosnivel7 . '</b>/' . round($por_homologadosn7) . '%
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $por_homologadosn7 . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group" title="Nuevos">
                                    Internos
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","7","4") class="text-white" title="Estudiantes que cambiaron de nivel o programa" style="cursor:pointer">
                                            <b>' . $totalinternosnivel7 . '</b>/' . round($por_internosn7) . '%
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $por_internosn7 . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group" title="Renovaron">
                                    Renovaron
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_actual . '","7","5") class="text-white" title="Estudiantes que renovaron" style="cursor:pointer">
                                            <b>' . $totalrenovaronnivel7 . '</b>/' . round($por_renovaron7) . '%
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $por_renovaron7 . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group" title="Por renovar">
                                    Por renovar
                                    <span class="float-right">
                                        <a onclick=listarestudiantesnivel("' . $periodo_anterior . '","7","7") class="text-white" title="Estudiantes por renovar" style="cursor:pointer">
                                            <b>' . $totalporrenovarnivel7 . '</b>/' . round($por_porrenovarn7) . '%
                                        </a>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar"  style="width:' . $por_porrenovarn7 . '%"></div>
                                    </div>
                                </div>
                                <div class="progress-group" title="Aplazaron semestre">
                                    Aplazaron
                                    <span class="float-right"><b>' . $totalaplazadosnivel7 . '</b></span>
                                </div>
                            </div>
                        </div>
                    </div>';
        $data["total"] .= '</div>';
        $data["total"] .= '</div>';

        $data["total"] .= ' 
                <div style="width:170px">
                    <a onclick="profesional(1)" title="ver cifras" class="row pointer m-2">
                        <div class="col-3 rounded bg-light-red">
                            <div class="text-red text-center pt-1">
                                <i class="fa-regular fa-calendar-check fa-2x  text-red" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="col-9 borde">
                            <span>Programa de</span><br>
                            <span class="titulo-2 fs-12 line-height-16"> Administración</span>
                        </div>
                    </a>
                </div>
            ';
        $data["total"] .= ' 
                <div style="width:170px">
                    <a onclick="profesional(2)" title="ver cifras" class="row pointer m-2">
                        <div class="col-3 rounded bg-light-purple">
                            <div class="text-red text-center pt-1">
                                <i class="fa-regular fa-calendar-check fa-2x  text-purple" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="col-9 borde">
                            <span>Programa de</span><br>
                            <span class="titulo-2 fs-12 line-height-16">Contaduría</span>
                        </div>
                    </a>
                </div>
            ';
        $data["total"] .= ' 
                <div style="width:170px">
                    <a onclick="profesional(3)" title="ver cifras" class="row pointer m-2">
                        <div class="col-3 rounded bg-light-blue">
                            <div class="text-red text-center pt-1">
                                <i class="fa-regular fa-calendar-check fa-2x  text-primary" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="col-9 borde">
                            <span>Programa de</span><br>
                            <span class="titulo-2 fs-12 line-height-16">Ingeniería</span>
                        </div>
                    </a>
                </div>
            ';
        $data["total"] .= ' 
                <div style="width:170px">
                    <a onclick="profesional(4)" title="ver cifras" class="row pointer m-2">
                        <div class="col-3 rounded bg-light-green">
                            <div class="text-red text-center pt-1">
                                <i class="fa-regular fa-calendar-check fa-2x  text-success" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="col-9 borde">
                            <span>Programa de</span><br>
                            <span class="titulo-2 fs-12 line-height-16"> SST</span>
                        </div>
                    </a>
                </div>
            ';
        $data["total"] .= ' 
                <div style="width:170px">
                    <a onclick="profesional(5)" title="ver cifras" class="row pointer m-2">
                        <div class="col-3 rounded bg-light-orange">
                            <div class="text-red text-center pt-1">
                                <i class="fa-regular fa-calendar-check fa-2x  text-orange" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="col-9 borde">
                            <span>Programa de</span><br>
                            <span class="titulo-2 fs-12 line-height-16"> Industrial</span>
                        </div>
                    </a>
                </div>
            ';
        $data["total"] .= ' 
                <div style="width:170px">
                    <a onclick="profesional(7)" title="ver cifras" class="row pointer m-2">
                        <div class="col-3 rounded bg-light-yellow">
                            <div class="text-red text-center pt-1">
                                <i class="fa-regular fa-calendar-check fa-2x  text-warning" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="col-9 borde">
                            <span>Programa de</span><br>
                            <span class="titulo-2 fs-12 line-height-16"> Laborales</span>
                        </div>
                    </a>
                </div>
            ';
        $data["total"] .= '<div class="col-xl-12 m-2 p-2"></div>';
        echo json_encode($data);
        break;
    case 'profesional':
        $profesional = $_POST["valor"];
        $data = array();
        $data["total"] = "";
        $datosprograma = $consultaprograma->programaAc($profesional);
        for ($a = 0; $a < count($datosprograma); $a++) {
            $id_programa = $datosprograma[$a]["id_programa"];
            $programa = $datosprograma[$a]["nombre"];
            $semestres = $datosprograma[$a]["semestres"];
            $totalprograma = $consultaprograma->totalprograma($id_programa, $periodo_actual);
            $totalprogramaporrenovar = $consultaprograma->totalprogramaporrenovar($id_programa, $periodo_anterior);
            $data["total"] .= '
                    <div class="col-12">
                        <span class="titulo-2 fs-18">' . $programa . '</span> 
                        <a onclick=ver() class="btn"> Activos = ' . count($totalprograma) . ' </a>
                        <a onclick=ver() class="btn"> Deben renovar = ' . count($totalprogramaporrenovar) . ' </a>
                    </div>';
            $data["total"] .= '<div class="row table-responsive p-0 m-0">';
            $data["total"] .= '<table class="table table-hover table-sm" >';
            $data["total"] .= '<thead>';
            $data["total"] .= '<tr>';
            $data["total"] .= '<th>Sem.</th>';
            $traerjornadas = $consultaprograma->jornadas();
            for ($b = 0; $b < count($traerjornadas); $b++) {
                $jornada = $traerjornadas[$b]["nombre"];
                $jornadanombre = $traerjornadas[$b]["codigo"];
                $data["total"] .= '<th class="text-center">' . $jornadanombre . '</th>';
            }
            $data["total"] .= '</tr>';
            $data["total"] .= '</thead>';
            $data["total"] .= '<tbody>';
            $elsemestre = 1;
            while ($elsemestre <= $semestres) {
                $data["total"] .= '<tr>';
                $data["total"] .= '<td>' . $elsemestre . '</td>';
                $traerjornadasfila = $consultaprograma->jornadas();
                for ($c = 0; $c < count($traerjornadasfila); $c++) {
                    $jornadafila = $traerjornadas[$c]["nombre"];
                    $jornadanombrefila = $traerjornadas[$c]["codigo"];
                    $traerporrenovarprograma = $consultaprograma->traerporrenovar($id_programa, $elsemestre, $jornadafila, $periodo_anterior);
                    $traernuevoprograma = $consultaprograma->traernuevoprograma($id_programa, $elsemestre, $jornadafila, $periodo_actual);
                    $traerprogramahomologado = $consultaprograma->traerprogramahomologado($id_programa, $elsemestre, $jornadafila, $periodo_actual);
                    $traerprogramainterno = $consultaprograma->traerprogramainterno($id_programa, $elsemestre, $jornadafila, $periodo_actual);
                    $traerprogramainterno = $consultaprograma->traerprogramainterno($id_programa, $elsemestre, $jornadafila, $periodo_actual);
                    $traerprogramarenovacion = $consultaprograma->traerprogramarenovacion($id_programa, $elsemestre, $jornadafila, $periodo_actual);
                    $traerprogramatotaljornadasemestre = $consultaprograma->traerprogramatotaljornadasemestre($id_programa, $elsemestre, $jornadafila, $periodo_actual);
                    $data["total"] .= '
                                        <td>
                                            <div style="width:250px">
                                                <div class="campo-tabla"><a onclick=verestudiantes("' . $id_programa . '","' . $jornadafila . '","' . $elsemestre . '","' . $periodo_anterior . '","1.1") class="text-danger" title="Por renovar">' . count($traerporrenovarprograma) . '</a></div> 
                                                <div class="campo-tabla"><a onclick=verestudiantes("' . $id_programa . '","' . $jornadafila . '","' . $elsemestre . '","' . $periodo_actual . '","1") class="text-purple" title="Nuevos">' . count($traernuevoprograma) . '</a></div> 
                                                <div class="campo-tabla"><a onclick=verestudiantes("' . $id_programa . '","' . $jornadafila . '","' . $elsemestre . '","' . $periodo_anterior . '","2") class="text-primary" title="Nuevos Homologados" >' . count($traerprogramahomologado) . '</a></div> 
                                                <div class="campo-tabla"><a onclick=verestudiantes("' . $id_programa . '","' . $jornadafila . '","' . $elsemestre . '","' . $periodo_actual . '","3") class="text-info" title="Internos" >' . count($traerprogramainterno) . ' </a></div> 
                                                <div class="campo-tabla"><a onclick=verestudiantes("' . $id_programa . '","' . $jornadafila . '","' . $elsemestre . '","' . $periodo_actual . '","4") class="text-success" title="renovación" >' . count($traerprogramarenovacion) . '</a></div> 
                                                <div class="campo-tabla"><a onclick=verestudiantes("' . $id_programa . '","' . $jornadafila . '","' . $elsemestre . '","' . $periodo_actual . '","5") class="text-black " title="Total" > = <b>' . count($traerprogramatotaljornadasemestre) . '</b></a></div>
                                            </div>
                                        </td>';
                }
                $data["total"] .= '</tr>';
                $elsemestre++;
            }
            $data["total"] .= '<tr>';
            $data["total"] .= '<td>Total</td>';
            $traerjornadastotal = $consultaprograma->jornadas();
            for ($c = 0; $c < count($traerjornadastotal); $c++) {
                $jornadatotal = $traerjornadastotal[$c]["nombre"];
                $jornadanombretotal = $traerjornadastotal[$c]["codigo"];
                $sumaporrenovar = $consultaprograma->sumaporrenovar($id_programa, $jornadatotal, $periodo_anterior); // consulta para traer el total de nuevos
                $sumanuevos = $consultaprograma->sumanuevos($id_programa, $jornadatotal, $periodo_actual); // consulta para traer el total de nuevos
                $sumahomologado = $consultaprograma->sumahomologado($id_programa, $jornadatotal, $periodo_actual); // consulta para traer el total de nuevos homologados
                $sumainternos = $consultaprograma->sumainternos($id_programa, $jornadatotal, $periodo_actual); // consulta para traer el total de internos
                $sumarenovacion = $consultaprograma->sumarenovacion($id_programa, $jornadatotal, $periodo_actual); // consulta para traer el total de renovaciones
                $sumajornada = $consultaprograma->sumajornada($id_programa, $jornadatotal, $periodo_actual); // consulta para traer el total de renovaciones
                $data["total"] .= '
                                <td>
                                    <div class="campo-tabla"><a onclick=verestudiantes("' . $id_programa . '","' . $jornadatotal . '","0","' . $periodo_anterior . '","6.1") class="text-danger" title="Total por renovar" > <b>' . count($sumaporrenovar) . '</a></div>
                                    <div class="campo-tabla"><a onclick=verestudiantes("' . $id_programa . '","' . $jornadatotal . '","0","' . $periodo_actual . '","6") class="text-purple" title="Total nuevos" > <b>' . count($sumanuevos) . '</a></div>
                                    <div class="campo-tabla"><a onclick=verestudiantes("' . $id_programa . '","' . $jornadatotal . '","0","' . $periodo_actual . '","7") class="text-primary " title="Total homologados" > <b>' . count($sumahomologado) . '</a></div>
                                    <div class="campo-tabla"><a onclick=verestudiantes("' . $id_programa . '","' . $jornadatotal . '","0","' . $periodo_actual . '","8") class="text-info " title="Total Internos" > <b>' . count($sumainternos) . '</a></div>
                                    <div class="campo-tabla"><a onclick=verestudiantes("' . $id_programa . '","' . $jornadatotal . '","0","' . $periodo_actual . '","9") class="text-success" title="Total Renovaciones" > <b>' . count($sumarenovacion) . '</a></div>
                                    <div class="campo-tabla"><a onclick=verestudiantes("' . $id_programa . '","' . $jornadatotal . '","0","' . $periodo_actual . '","10") class="text-black " title="Total de la jornada" > =<b>' . count($sumajornada) . '</a></div>
                                </td>';
            }
            $data["total"] .= '</tr>';
            $data["total"] .= '<tr>';
            $nuevosmestre = $elsemestre - 1;
            $data["total"] .= '<td>Cambio</td>';
            $traerjornadastotalcambio = $consultaprograma->jornadas();
            for ($d = 0; $d < count($traerjornadastotalcambio); $d++) {
                $jornadafilacambio = $traerjornadastotalcambio[$d]["nombre"];
                $traerporrenovarprograma = $consultaprograma->traerporrenovarcambio($id_programa, $nuevosmestre, $jornadafilacambio, $periodo_anterior);
                $totalporcambiodenivel = 0;
                $totalrenenovocambionivel = 0;
                for ($dd = 0; $dd < count($traerporrenovarprograma); $dd++) {
                    $id_credencial_cambio_nivel = $traerporrenovarprograma[$dd]["id_credencial"];
                    $mirarsirenovo = $consultaprograma->mirarsirenovocambiodenivel($id_credencial_cambio_nivel, $periodo_actual);
                    if ($mirarsirenovo) {
                        $totalrenenovocambionivel = $totalrenenovocambionivel + 1;
                    } else {
                        $totalporcambiodenivel = $totalporcambiodenivel + 1;
                    }
                }
                $data["total"] .= '
                                <td>
                                    <div class="campo-tabla">
                                        <a onclick=verestudiantes("' . $id_programa . '","' . $jornadafilacambio . '","' . $nuevosmestre . '","' . $periodo_anterior . '","4.1") class="text-danger"  title="Total cambio de nivel"> 
                                            <b>' . $totalporcambiodenivel . '</b>
                                        </a>
                                    </div>';
                $data["total"] .= '
                                    <div class="campo-tabla">
                                        <a onclick=verestudiantes("' . $id_programa . '","' . $jornadafilacambio . '","' . $nuevosmestre . '","' . $periodo_anterior . '","4.2") class="text-success"  title="Cambiaron de nivel"> 
                                             <b>' . $totalrenenovocambionivel . '</b>
                                        </a>
                                    </div>
                                </td>';
            }
            $data["total"] .= '</tr>';
            $data["total"] .= '</tbody>';
            $data["total"] .= '</table>';
            $data["total"] .= '</div>';
        }
        echo json_encode($data);
        break;
    case 'activarjornada':
        $id_jornada = $_POST["id_jornada"];
        $valor = $_POST["valor"];
        $activarjornada = $consultaprograma->activarjornada($id_jornada, $valor);
        echo json_encode($activarjornada);
        break;
    case 'listarestudiantes':
        $periodo = $_GET["periodo"];
        $valor = $_GET["valor"];
        if ($valor == "1") {
            $rspta = $consultaprograma->listarestudaintesactivos($periodo);
        }
        if ($valor == "2") {
            $rspta = $consultaprograma->listarestudaintesnuevos($periodo);
        }
        if ($valor == "3") {
            $rspta = $consultaprograma->listarestudaintesnuevoshomologados($periodo);
        }
        if ($valor == "4") {
            $rspta = $consultaprograma->listarestudaintesinternos($periodo);
        }
        if ($valor == "5") {
            $rspta = $consultaprograma->listarestudaintesrematricula($periodo);
        }
        if ($valor == "6") {
            $rspta = $consultaprograma->listarestudaintesaplazados($periodo);
        }
        if ($valor == "7") {
            $rspta = $consultaprograma->listarestudaintesporrenovar($periodo);
        }
        //Vamos a declarar un array
        $data = array();
        $reg = $rspta;
        for ($i = 0; $i < count($reg); $i++) {
            $mensajes_no_vistos = 0;
            if (isset($reg[$i]["celular"])) {
                $estilo_whatsapp = 'btn-success';
                $numero_celular = $reg[$i]["celular"];
                $registro_whatsapp = $consultaprograma->obtenerRegistroWhastapp($numero_celular);
                $mensajes_no_vistos = isset($registro_whatsapp["mensajes_no_vistos"]) ? $registro_whatsapp["mensajes_no_vistos"] : $mensajes_no_vistos;
            } else {
                $estilo_whatsapp = 'btn-danger disabled';
                $numero_celular = '';
            }
            $boton_whatsapp =
                '<button type="button" class="btn ' . $estilo_whatsapp . ' btn-sm position-relative" data-target="#modal_whatsapp" data-toggle="modal" onclick="listarDatos(57' . $numero_celular . ')"> 
                        <i class="fab fa-whatsapp"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            ' . $mensajes_no_vistos . '
                        </span>
                    </button>';
            $data[] = array(
                "0" => $reg[$i]["credencial_identificacion"],
                "1" => $reg[$i]["credencial_apellido"] . ' ' . $reg[$i]["credencial_apellido_2"] . ' ' . $reg[$i]["credencial_nombre"] . ' ' . $reg[$i]["credencial_nombre_2"],
                "2" => $reg[$i]["fo_programa"],
                "3" => $reg[$i]["credencial_login"],
                "4" => $reg[$i]["email"],
                "5" => '<div class="text-center">' . $reg[$i]["celular"] . "<br>" . $boton_whatsapp . '</div>',
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
            $rspta = $consultaprograma->listarestudaintesactivosnivel($periodo, $nivel);
        }
        if ($valor == "2") {
            $rspta = $consultaprograma->listarestudaintesnuevosnivel($periodo, $nivel);
        }
        if ($valor == "3") {
            $rspta = $consultaprograma->listarestudaintesnuevoshomologadosnivel($periodo, $nivel);
        }
        if ($valor == "4") {
            $rspta = $consultaprograma->listarestudaintesinternosnivel($periodo, $nivel);
        }
        if ($valor == "5") {
            $rspta = $consultaprograma->listarestudaintesrematriculanivel($periodo, $nivel);
        }
        if ($valor == "6") {
            $rspta = $consultaprograma->listarestudaintesaplazados($periodo);
        }
        if ($valor == "7") {
            $rspta = $consultaprograma->listarestudaintesporrenovarnivel($periodo, $nivel);
        }
        //Vamos a declarar un array
        $data = array();
        $reg = $rspta;
        for ($i = 0; $i < count($reg); $i++) {
            $mensajes_no_vistos = 0;
            if (isset($reg[$i]["celular"])) {
                $estilo_whatsapp = 'btn-success';
                $numero_celular = $reg[$i]["celular"];
                $registro_whatsapp = $consultaprograma->obtenerRegistroWhastapp($numero_celular);
                $mensajes_no_vistos = isset($registro_whatsapp["mensajes_no_vistos"]) ? $registro_whatsapp["mensajes_no_vistos"] : $mensajes_no_vistos;
            } else {
                $estilo_whatsapp = 'btn-danger disabled';
                $numero_celular = '';
            }
            $boton_whatsapp =
                '<button type="button" class="btn ' . $estilo_whatsapp . ' btn-sm position-relative" data-target="#modal_whatsapp" data-toggle="modal" onclick="listarDatos(57' . $numero_celular . ')"> 
                        <i class="fab fa-whatsapp"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            ' . $mensajes_no_vistos . '
                        </span>
                    </button>';
            $data[] = array(
                "0" => $reg[$i]["credencial_identificacion"],
                "1" => $reg[$i]["credencial_apellido"] . ' ' . $reg[$i]["credencial_apellido_2"] . ' ' . $reg[$i]["credencial_nombre"] . ' ' . $reg[$i]["credencial_nombre_2"],
                "2" => $reg[$i]["fo_programa"],
                "3" => $reg[$i]["credencial_login"],
                "4" => $reg[$i]["email"],
                "5" =>'<div class="text-center">' . $reg[$i]["celular"] . "<br>" . $boton_whatsapp . '</div>',
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

        //Vamos a declarar un array
        $data = array();
        $id_programa = $_GET["id_programa"];
        $jornada = $_GET["jornada"];
        $semestre = $_GET["semestre"];
        $periodo = $_GET["periodo"];
        $valor = $_GET["valor"];
        if ($valor == "4.1") {
            $rspta = $consultaprograma->verestudiantes($id_programa, $jornada, $semestre, $periodo, $valor);
            $reg = $rspta;
            for ($i = 0; $i < count($reg); $i++) {
                $id_credencial = $reg[$i]["id_credencial"];
                // whatsapp
                    $mensajes_no_vistos = 0;
                    if (isset($reg[$i]["celular"])) {
                        $estilo_whatsapp = 'btn-success';
                        $numero_celular = $reg[$i]["celular"];
                        $registro_whatsapp = $consultaprograma->obtenerRegistroWhastapp($numero_celular);
                        $mensajes_no_vistos = isset($registro_whatsapp["mensajes_no_vistos"]) ? $registro_whatsapp["mensajes_no_vistos"] : $mensajes_no_vistos;
                    } else {
                        $estilo_whatsapp = 'btn-danger disabled';
                        $numero_celular = '';
                    }
                    $boton_whatsapp = 
                        '<button type="button" class="btn ' . $estilo_whatsapp . ' btn-sm position-relative" data-target="#modal_whatsapp" data-toggle="modal" onclick="listarDatos(57' . $numero_celular . ')"> 
                            <i class="fab fa-whatsapp"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                ' . $mensajes_no_vistos . '
                            </span>
                        </button>';
                // hasta aqui whatsapp 

                $mirarsirenovo = $consultaprograma->mirarsirenovocambiodenivel($id_credencial, $periodo_actual);
                if ($mirarsirenovo) {
                } else {
                    $data[] = array(
                        "0" => $reg[$i]["miidestudiante"],
                        "1" => $reg[$i]["credencial_identificacion"],
                        "2" => $reg[$i]["credencial_apellido"] . ' ' . $reg[$i]["credencial_apellido_2"] . ' ' . $reg[$i]["credencial_nombre"] . ' ' . $reg[$i]["credencial_nombre_2"],
                        "3" => $reg[$i]["fo_programa"],
                        "4" => $reg[$i]["credencial_login"],
                        "5" => $reg[$i]["email"],
                        "6" => '<div class="text-center">' . $reg[$i]["celular"] . "<br>" . $boton_whatsapp.'</div>',
                        "7" => $reg[$i]["periodo"],
                        "8" => $reg[$i]["periodo_activo"]
                    );
                }
            }
        } else if ($valor == "4.2") {
            $rspta = $consultaprograma->verestudiantes($id_programa, $jornada, $semestre, $periodo, $valor);
            $reg = $rspta;
            for ($i = 0; $i < count($reg); $i++) {
                $mensajes_no_vistos = 0;
                if (isset($reg[$i]["celular"])) {
                    $estilo_whatsapp = 'btn-success';
                    $numero_celular = $reg[$i]["celular"];
                    $registro_whatsapp = $consultaprograma->obtenerRegistroWhastapp($numero_celular);
                    $mensajes_no_vistos = isset($registro_whatsapp["mensajes_no_vistos"]) ? $registro_whatsapp["mensajes_no_vistos"] : $mensajes_no_vistos;
                } else {
                    $estilo_whatsapp = 'btn-danger disabled';
                    $numero_celular = '';
                }
                $boton_whatsapp =
                    '<button type="button" class="btn ' . $estilo_whatsapp . ' btn-sm position-relative" data-target="#modal_whatsapp" data-toggle="modal" onclick="listarDatos(57' . $numero_celular . ')"> 
                        <i class="fab fa-whatsapp"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            ' . $mensajes_no_vistos . '
                        </span>
                    </button>';
                $id_credencial = $reg[$i]["id_credencial"];
                $mirarsirenovo = $consultaprograma->mirarsirenovocambiodenivel($id_credencial, $periodo_actual);
                if ($mirarsirenovo) {
                    $data[] = array(
                        "0" => $reg[$i]["miidestudiante"],
                        "1" => $reg[$i]["credencial_identificacion"],
                        "2" => $reg[$i]["credencial_apellido"] . ' ' . $reg[$i]["credencial_apellido_2"] . ' ' . $reg[$i]["credencial_nombre"] . ' ' . $reg[$i]["credencial_nombre_2"],
                        "3" => $reg[$i]["fo_programa"],
                        "4" => $reg[$i]["credencial_login"],
                        "5" => $reg[$i]["email"],
                        "6" => '<div class="text-center">' . $reg[$i]["celular"] . "<br>" . $boton_whatsapp . '</div>',
                        "7" => $reg[$i]["periodo"],
                        "8" => $reg[$i]["periodo_activo"]
                    );
                } else {
                }
            }
        } else if ($valor <= 5) {
            $rspta = $consultaprograma->verestudiantes($id_programa, $jornada, $semestre, $periodo, $valor);
            $reg = $rspta;
            for ($i = 0; $i < count($reg); $i++) {
                $mensajes_no_vistos = 0;
                if (isset($reg[$i]["celular"])) {
                    $estilo_whatsapp = 'btn-success';
                    $numero_celular = $reg[$i]["celular"];
                    $registro_whatsapp = $consultaprograma->obtenerRegistroWhastapp($numero_celular);
                    $mensajes_no_vistos = isset($registro_whatsapp["mensajes_no_vistos"]) ? $registro_whatsapp["mensajes_no_vistos"] : $mensajes_no_vistos;
                } else {
                    $estilo_whatsapp = 'btn-danger disabled';
                    $numero_celular = '';
                }
                $boton_whatsapp =
                    '<button type="button" class="btn ' . $estilo_whatsapp . ' btn-sm position-relative" data-target="#modal_whatsapp" data-toggle="modal" onclick="listarDatos(57' . $numero_celular . ')"> 
                        <i class="fab fa-whatsapp"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            ' . $mensajes_no_vistos . '
                        </span>
                    </button>';
                $data[] = array(
                    "0" => $reg[$i]["miidestudiante"],
                    "1" => $reg[$i]["credencial_identificacion"],
                    "2" => $reg[$i]["credencial_apellido"] . ' ' . $reg[$i]["credencial_apellido_2"] . ' ' . $reg[$i]["credencial_nombre"] . ' ' . $reg[$i]["credencial_nombre_2"],
                    "3" => $reg[$i]["fo_programa"],
                    "4" => $reg[$i]["credencial_login"],
                    "5" => $reg[$i]["email"],
                    "6" => '<div class="text-center">' . $reg[$i]["celular"] . "<br>" . $boton_whatsapp . '</div>',
                    "7" => $reg[$i]["periodo"],
                    "8" => $reg[$i]["periodo_activo"]
                );
            }
        } else {
            $rspta = $consultaprograma->verestudiantestotal($id_programa, $jornada, $periodo, $valor);
            $reg = $rspta;
            for ($i = 0; $i < count($reg); $i++) {
                $mensajes_no_vistos = 0;
                if (isset($reg[$i]["celular"])) {
                    $estilo_whatsapp = 'btn-success';
                    $numero_celular = $reg[$i]["celular"];
                    $registro_whatsapp = $consultaprograma->obtenerRegistroWhastapp($numero_celular);
                    $mensajes_no_vistos = isset($registro_whatsapp["mensajes_no_vistos"]) ? $registro_whatsapp["mensajes_no_vistos"] : $mensajes_no_vistos;
                } else {
                    $estilo_whatsapp = 'btn-danger disabled';
                    $numero_celular = '';
                }
                $boton_whatsapp =
                    '<button type="button" class="btn ' . $estilo_whatsapp . ' btn-sm position-relative" data-target="#modal_whatsapp" data-toggle="modal" onclick="listarDatos(57' . $numero_celular . ')"> 
                        <i class="fab fa-whatsapp"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            ' . $mensajes_no_vistos . '
                        </span>
                    </button>';
                $data[] = array(
                    "0" => $reg[$i]["miidestudiante"],
                    "1" => $reg[$i]["credencial_identificacion"],
                    "2" => $reg[$i]["credencial_apellido"] . ' ' . $reg[$i]["credencial_apellido_2"] . ' ' . $reg[$i]["credencial_nombre"] . ' ' . $reg[$i]["credencial_nombre_2"],
                    "3" => $reg[$i]["fo_programa"],
                    "4" => $reg[$i]["credencial_login"],
                    "5" => $reg[$i]["email"],
                    "6" => '<div class="text-center">' . $reg[$i]["celular"] . "<br>" . $boton_whatsapp . '</div>',
                    "7" => $reg[$i]["periodo"],
                    "8" => $reg[$i]["periodo_activo"]
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
    case 'verestudiantesinactivos':
        $id_programa = $_GET["id_programa"];
        $jornada = $_GET["jornada"];
        $semestre = $_GET["semestre"];
        $temporadainactivos = $_GET["temporadainactivos"];
        //$rspta=$consultaprograma->verestudiantesinactivos($id_programa,$jornada,$semestre,$temporadainactivos);
        //Vamos a declarar un array
        $data = array();
        $reg = $rspta;
        for ($i = 0; $i < count($reg); $i++) {
            $mensajes_no_vistos = 0;
            if (isset($reg[$i]["celular"])) {
                $estilo_whatsapp = 'btn-success';
                $numero_celular = $reg[$i]["celular"];
                $registro_whatsapp = $consultaprograma->obtenerRegistroWhastapp($numero_celular);
                $mensajes_no_vistos = isset($registro_whatsapp["mensajes_no_vistos"]) ? $registro_whatsapp["mensajes_no_vistos"] : $mensajes_no_vistos;
            } else {
                $estilo_whatsapp = 'btn-danger disabled';
                $numero_celular = '';
            }
            $boton_whatsapp =
                '<button type="button" class="btn ' . $estilo_whatsapp . ' btn-sm position-relative" data-target="#modal_whatsapp" data-toggle="modal" onclick="listarDatos(57' . $numero_celular . ')"> 
                        <i class="fab fa-whatsapp"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            ' . $mensajes_no_vistos . '
                        </span>
                    </button>';
            $data[] = array(
                "0" => $reg[$i]["id_estudiante"],
                "1" => $reg[$i]["credencial_identificacion"],
                "2" => $reg[$i]["credencial_apellido"] . ' ' . $reg[$i]["credencial_apellido_2"] . ' ' . $reg[$i]["credencial_nombre"] . ' ' . $reg[$i]["credencial_nombre_2"],
                "3" => $reg[$i]["credencial_login"],
                "4" => $reg[$i]["email"],
                "5" => '<div class="text-center">' . $reg[$i]["celular"] . "<br>" . $boton_whatsapp . '</div>',
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
}

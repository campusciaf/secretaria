<?php
require_once "../modelos/ReporteQuincenal.php";
$reporte = new reporteQuincenal();
switch ($_GET['op']) {
    case 'estudiante_x_mes':
        $fecha_inicial = isset($_POST['fecha_inicial']) ? $_POST['fecha_inicial'] : '';
        $fecha_final = isset($_POST['fecha_final']) ? $_POST['fecha_final'] : '';
        $periodo = isset($_POST['periodo']) ? $_POST['periodo'] : '';
        $motivo_financiacion = isset($_POST['motivo_financiacion']) ? $_POST['motivo_financiacion'] : '';
        $arreglo_datos = $reporte->estudiante_x_mes($fecha_inicial, $fecha_final, $periodo, $motivo_financiacion);
        $data = array();
        /*print_r($arreglo_datos);*/
        for ($i = 0; $i < count($arreglo_datos); $i++) {
            $fecha_separada = explode(" ", $arreglo_datos[$i]["fecha_inicial"]);
            $fecha = $fecha_separada[0];
            //id_persona, nombres, apellidos, id, numero_documento, celular, email, programa, semestre, jornada, labora, en_cobro, periodo
            $labora_btn = '<button class="btn bg-purple btn-sm color-palette btn-flat val_' . $arreglo_datos[$i]["id_persona"] . '" data-nombre_' . $arreglo_datos[$i]["id_persona"] . '="' . $arreglo_datos[$i]["nombres"] . ' ' . $arreglo_datos[$i]["apellidos"] . '" data-toggle="modal" onclick="verInfoSolicitante(' . $arreglo_datos[$i]["id_persona"] . ')" data-target="#verInfoSolicitante"><i data-toggle="tooltip" title="Referencias personales" class="fa fa-eye"></i></button>';
            $data[] = array(
                "0" => $labora_btn . '<button class="btn bg-info btn-flat btn-sm seg_idpersona" onclick="mostrarseg(' . $arreglo_datos[$i]["id_persona"] . ')" data-toggle="modal" data-idpersona="' . $arreglo_datos[$i]["id_persona"] . '" data-target="#seguimientos"><i data-toggle="tooltip" title="Ver y Añadir Seguimientos" class="fas fa-search-plus"></i></i></button><button class="btn btn-sm bg-yellow color-palette btn-flat Show_name" data-toggle="modal" onclick="mostrarcuotas(this,' . $arreglo_datos[$i]["id"] . ')" data-name_user="' . $arreglo_datos[$i]["nombres"] . " " . $arreglo_datos[$i]["apellidos"] . '" data-target="#modal_cuotas"><i data-toggle="tooltip" data-original-title="Información Cuotas" class="fas fa-calendar-alt"></i></button>',
                "1" => $arreglo_datos[$i]["numero_documento"],
                "2" => $arreglo_datos[$i]["nombres"] . " " . $arreglo_datos[$i]["apellidos"],
                "3" => $arreglo_datos[$i]["celular"],
                "4" => $arreglo_datos[$i]["email"],
                "5" => $reporte->cantidad_atrasos($arreglo_datos[$i]["id"])['total'],
                "6" => $arreglo_datos[$i]["programa"],
                "7" => $arreglo_datos[$i]["semestre"],
                "8" => $arreglo_datos[$i]["jornada"],
                "9" => $arreglo_datos[$i]["labora"],
                "10" => ($arreglo_datos[$i]["en_cobro"] == 1) ? "SI" : "NO",
                "11" => $arreglo_datos[$i]["periodo"],
                "12" => $fecha,
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
    case 'estudiante_x_mes_pagados':
        $fecha_inicial = isset($_POST['fecha_inicial']) ? $_POST['fecha_inicial'] : '';
        $fecha_final = isset($_POST['fecha_final']) ? $_POST['fecha_final'] : '';
        $periodo = isset($_POST['periodo']) ? $_POST['periodo'] : '';
        $motivo_financiacion = isset($_POST['motivo_financiacion']) ? $_POST['motivo_financiacion'] : '';
        $arreglo_datos = $reporte->estudiante_x_mes_pagados($fecha_inicial, $fecha_final, $periodo, $motivo_financiacion);
        $data = array();
        for ($i = 0; $i < count($arreglo_datos); $i++) {
            $fecha_separada = explode(" ", $arreglo_datos[$i]["fecha_inicial"]);
            $fecha = $fecha_separada[0];
            //id_persona, nombres, apellidos, id, numero_documento, celular, email, programa, semestre, jornada, labora, en_cobro, periodo
            $labora_btn = '<button class="btn bg-purple btn-sm color-palette btn-flat val_' . $arreglo_datos[$i]["id_persona"] . '" data-nombre_' . $arreglo_datos[$i]["id_persona"] . '="' . $arreglo_datos[$i]["nombres"] . ' ' . $arreglo_datos[$i]["apellidos"] . '" data-toggle="modal" onclick="verInfoSolicitante(' . $arreglo_datos[$i]["id_persona"] . ')" data-target="#verInfoSolicitante"><i data-toggle="tooltip" title="Referencias personales" class="fa fa-eye"></i></button>';
            $data[] = array(
                "0" => $labora_btn . '<button class="btn bg-info btn-flat btn-sm seg_idpersona" onclick="mostrarseg(' . $arreglo_datos[$i]["id_persona"] . ')" data-toggle="modal" data-idpersona="' . $arreglo_datos[$i]["id_persona"] . '" data-target="#seguimientos"><i data-toggle="tooltip" title="Ver y Añadir Seguimientos" class="fas fa-search-plus"></i></i></button><button class="btn btn-sm bg-yellow color-palette btn-flat Show_name" data-toggle="modal" onclick="mostrarcuotas(this,' . $arreglo_datos[$i]["id"] . ')" data-name_user="' . $arreglo_datos[$i]["nombres"] . " " . $arreglo_datos[$i]["apellidos"] . '" data-target="#modal_cuotas"><i data-toggle="tooltip" data-original-title="Información Cuotas" class="fas fa-calendar-alt"></i></button>',
                "1" => $arreglo_datos[$i]["numero_documento"],
                "2" => $arreglo_datos[$i]["nombres"] . " " . $arreglo_datos[$i]["apellidos"],
                "3" => $arreglo_datos[$i]["celular"],
                "4" => $arreglo_datos[$i]["email"],
                "5" => $reporte->cantidad_atrasos($arreglo_datos[$i]["id"])['total'],
                "6" => $arreglo_datos[$i]["programa"],
                "7" => $arreglo_datos[$i]["semestre"],
                "8" => $arreglo_datos[$i]["jornada"],
                "9" => $arreglo_datos[$i]["labora"],
                "10" => ($arreglo_datos[$i]["en_cobro"] == 1) ? "SI" : "NO",
                "11" => $arreglo_datos[$i]["periodo"],
                "12" => $fecha,
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
    case 'listarperiodos':
        $rspta = $reporte->listarperiodos();
        for ($i = 0; $i < count($rspta); $i++) {
            $data[] = array(
                "periodo" => $rspta[$i]["periodo"],
            );
        }
        echo json_encode($data); //Codificar el resultado utilizando json
        break;
    case 'reporte_quincenal':
        //modena local para la lista de valores 
        setlocale(LC_MONETARY, 'en_US');
        //traemos el periodo desde la vista, si no hay un periodo por defecto se toma el actual
        $periodo = isset($_POST["periodo_buscar"]) ? $_POST["periodo_buscar"] : $reporte->traerPeriodo();
        $motivo_financiacion = isset($_POST["motivo_financiacion"]) ? $_POST["motivo_financiacion"] : "";
        //echo $periodo;
        //array de meses 
        $mes = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        //generar array de lapsos
        $rango_fecha = ['1 al 15', '16 al 30'];
        //de base de datos busca la primer y ultima fecha de ese periodo  
        $fechas = $reporte->traerFechas($periodo, $motivo_financiacion);
        $fecha_inicial = $fechas["inicio"];
        $fecha_final =  $fechas["fin"];
        //toma el mes de la fecha inicial
        $mes_actual = date("m", strtotime($fecha_inicial));
        //crear un formato de fecha para la inicial y la final
        $datetime1 = date_create($fecha_inicial);
        $datetime2 = date_create($fecha_final);
        //toma el intevalo de tiempo para saber cuantos meses o años hay que  
        $interval = date_diff($datetime1, $datetime2);
        //los años se multiplican por 12 para calcular los meses 
        $meses =  $interval->format('%m');
        $anios =  $interval->format('%y');
        $cantidad_meses = ($anios * 12) + $meses;
        //se toma el año de la fecha inicial 
        $ano_actual = date("Y", strtotime($fecha_inicial));
        $dia = 1;
        //ciclo que ira por la cantidad de meses que hay entre las fechas
        for ($i = 0; $i <= $cantidad_meses; $i++) {
            //ciclo que determina desde el 1ro al 15 y el 16 al 30
            for ($j = 0; $j <= 1; $j++) {
                //se crea la fecha a partir de las variables que hacen que cambien 
                $fecha_inicial = $ano_actual . "-" . (($mes_actual < 10) ? "0" . $mes_actual : $mes_actual) . "-" . (($dia < 10) ? "0" . $dia : $dia);
                //si el mes es febrero y el segundo ciclo ya ha dado la primer vuelta, la fecha debe tener el numero 28
                if ($mes_actual == 2 && $j == 1) {
                    $fecha_final = $ano_actual . "-" . (($mes_actual < 10) ? "0" . $mes_actual : $mes_actual) . "-28";
                } else {
                    $fecha_final = date('Y-m-d', strtotime($fecha_inicial . ' +14 days'));
                }
                //
                $cuotas_total = $reporte->reporte_quincenal($fecha_inicial, $fecha_final, $periodo, $motivo_financiacion);
                //print_r($cuotas_total);
                $cuotas_pagadas = $reporte->reporte_quincenal_pagados($fecha_inicial, $fecha_final, $periodo, $motivo_financiacion);
                //print_r($cuotas_pagadas);
                $valor_cartera = $reporte->reporte_valor_cartera($fecha_inicial, $fecha_final, $periodo, $motivo_financiacion);
                if ($dia == 1) {
                    $dia = 16;
                    $rango = 0;
                } else {
                    $dia = 1;
                    $rango = 1;
                }
                $total = $valor_cartera["valor_total"];
                $cartera = $valor_cartera["valor_total"] - $valor_cartera["valor_pagado"];
                $porcentaje = ($total != 0)?number_format(100 - (($cartera * 100) / $total), 2):0;
                if ($porcentaje >= 95) {
                    $color = 'green';
                } elseif ($porcentaje >= 80 and $porcentaje <= 94.99) {
                    $color = '#DFCC12';
                } else {
                    $color = 'red';
                }
                $pagado = intval($total - $cartera);
                $total = $reporte->moneyFormat($total);
                $cartera = $reporte->moneyFormat($cartera);
                $pagado = $reporte->moneyFormat($pagado);
                $data[] = array(
                    "0" => $mes[$mes_actual - 1] . " " . $ano_actual,
                    "1" => $rango_fecha[$rango]/*" --- ".$fecha_inicial." al ".$fecha_final*/,
                    "2" => $cuotas_total["total"],
                    "3" => $cuotas_pagadas["total"],
                    "4" => $cuotas_total["total"] - $cuotas_pagadas["total"],
                    "5" => $total,
                    "6" => $pagado,
                    "7" => $cartera . '<button class="btn btn-xs btn-info btn-flat" data-toggle="tooltip" data-placement="left" title="Ver atrasados" onclick="verporfecha(`' . $fecha_inicial . '`, `' . $fecha_final . '`, `' . $periodo . '`)" data-toggle="modal" data-target="#modal-default"><i class="fas fa-search" style="font-size:10px"></i></button><button class="btn btn-xs btn-success btn-flat" data-toggle="tooltip" data-placement="top" title="Ver Pagados" onclick="verporfechaPagados(`' . $fecha_inicial . '`, `' . $fecha_final . '`, `' . $periodo . '`)" data-toggle="modal" data-target="#modal-default"><i class="fas fa-search" style="font-size:10px"></i></button>',
                    "8" => '<div style="color: ' . $color . '">' . $porcentaje . '%</div>',
                );
            }
            $mes_actual++;
            if ($mes_actual == 13) {
                $ano_actual++;
                $mes_actual = 1;
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
    case 'search':
        $valor_cuota_pagar = "";
        $dato_busqueda = isset($_POST['dato_busqueda']) ? $_POST['dato_busqueda'] : "";
        $tipo_busqueda = isset($_POST['tipo_busqueda']) ? $_POST['tipo_busqueda'] : "";
        $rspta = $reporte->search($dato_busqueda, $tipo_busqueda);
        $data = array();
        $aprobacion = "";
        $flag = true;
        for ($i = 0; $i < count($rspta); $i++) {
            if ($rspta[$i]["estado_financiacion"] == 0) {
                $aprobacion = '<button class="btn btn-sm bg-orange-active btn-flat disabled" disabled data-toggle="modal" data-idfinanciamiento="' . $rspta[$i]["id_financiamiento"] . '" data-target="#modal_pagos"><i class="fas fa-user-slash"></i><i> Anulado</i></button>';
            } else {
                if ($rspta[$i]["estado"] == "A Pagar" && $reporte->dias_atrazo($rspta[$i]["plazo_pago"]) <= 0) {
                    $estado = '<span class="label bg-yellow">
                            <i class="fas fa-spinner"></i> A pagar</span>';
                    if ($flag === true) {
                        $valor_cuota_abonada = intval($rspta[$i]["valor_cuota"]) - intval($rspta[$i]["valor_pagado"]);
                        $aprobacion = '<button class="btn btn-sm bg-navy btn-flat btn_abonar " data-valorcuotapagar="' . $valor_cuota_abonada . '" data-plazo="' . $rspta[$i]["plazo_pago"] . '" data-toggle="modal" data-idfinanciamiento="' . $rspta[$i]["id_financiamiento"] . '" data-target="#modal_abonos"><i data-toggle="tooltip" title="Opciones de Cuota Seleccionada"><i class="fas fa-hand-holding-usd"></i> <i>Pagar</i> </button>';
                        $flag = false;
                    } else {
                        $valor_cuota_pagar = intval($rspta[$i]["valor_cuota"]) - intval($rspta[$i]["valor_pagado"]);
                        $aprobacion = '<button class="btn btn-sm bg-yellow btn-flat btn_pagar disabled" disabled data-valorcuotapagar="' . $valor_cuota_pagar . '" data-toggle="modal" data-idfinanciamiento="' . $rspta[$i]["id_financiamiento"] . '" data-target="#modal_pagos"><i class="fas fa-spinner"></i><i> En proceso</i></button>';
                    }
                } else if ($rspta[$i]["estado"] == "Pagado") {
                    $estado = "<span class='label bg-green'><i class='fas fa-check'></i>  Pagado</span>";
                    $aprobacion = '<button class="btn btn-sm bg-green btn-flat custom" disabled data-toggle="modal" data-target="#modal_historial_pagos"> <i ><i class="fas fa-check"></i><i> Pagado</i></i></button>';
                } else if ($rspta[$i]["estado"] == "A Pagar" && $reporte->dias_atrazo($rspta[$i]["plazo_pago"]) > 0) {
                    if ($flag === true) {
                        $valor_cuota_pagar = intval($rspta[$i]["valor_cuota"]) - intval($rspta[$i]["valor_pagado"]);
                        $aprobacion = '<button class="btn btn-sm btn-danger btn-flat btn_atrazado" data-valorcuotapagar="' . $valor_cuota_pagar . '" data-toggle="modal" data-idfinanciamiento="' . $rspta[$i]["id_financiamiento"] . '" data-plazo="' . $rspta[$i]["plazo_pago"] . '" data-target="#modal_atrazos"><i  data-toggle="tooltip" title="Opciones de Cuota Seleccionada" ><i class="fas fa-calendar-times"></i><i>  Atrazado</i> </i></button>';
                        $flag = false;
                    } else {
                        if ($reporte->dias_atrazo($rspta[$i]["plazo_pago"]) > 0) {
                            $aprobacion = '<button class="btn btn-sm btn-danger btn-flat btn_pagar disabled" disabled data-valorcuotapagar="' . $valor_cuota_pagar . '" data-toggle="modal" data-idfinanciamiento="' . $rspta[$i]["id_financiamiento"] . '" data-target="#modal_pagos"><i class="fas fa-spinner"></i><i> Atrazado</i></button>';
                        }
                    }
                } else if ($rspta[$i]["estado"] == "Abonado" && $reporte->dias_atrazo($rspta[$i]["plazo_pago"]) > 0) {
                    if ($flag === true) {
                        $valor_cuota_pagar = intval($rspta[$i]["valor_cuota"]) - intval($rspta[$i]["valor_pagado"]);
                        $aprobacion = '<button class="btn btn-sm btn-danger btn-flat btn_atrazado" data-valorcuotapagar="' . $valor_cuota_pagar . '" data-toggle="modal" data-idfinanciamiento="' . $rspta[$i]["id_financiamiento"] . '" data-plazo="' . $rspta[$i]["plazo_pago"] . '" data-target="#modal_atrazos"><i  data-toggle="tooltip" title="Opciones de Cuota Seleccionada" ><i class="fas fa-calendar-times"></i><i>  Atrazado</i> </i></button>';
                        $flag = false;
                    } else {
                        $valor_cuota_pagar = intval($rspta[$i]["valor_cuota"]) - intval($rspta[$i]["valor_pagado"]);
                        $aprobacion = '<button class="btn btn-sm bg-yellow btn-flat btn_pagar disabled" disabled data-valorcuotapagar="' . $valor_cuota_pagar . '" data-toggle="modal" data-idfinanciamiento="' . $rspta[$i]["id_financiamiento"] . '" data-target="#modal_pagos"><i class="fas fa-spinner"></i><i> En proceso</i></button>';
                    }
                } else if ($rspta[$i]["estado"] == "Abonado") {
                    if ($flag === true) {
                        $valor_cuota_pagar = intval($rspta[$i]["valor_cuota"]) - intval($rspta[$i]["valor_pagado"]);
                        $aprobacion = '<button class="btn btn-sm bg-teal btn-flat btn_abonar " data-valorcuotapagar="' . $valor_cuota_pagar . '" data-toggle="modal" data-plazo="' . $rspta[$i]["plazo_pago"] . '" data-idfinanciamiento="' . $rspta[$i]["id_financiamiento"] . '" data-target="#modal_abonos"><i  data-toggle="tooltip" title="Opciones de Cuota Seleccionada" ><i class="fas fa-handshake"></i>	<i> Abonando</i> </i></button>';
                        $flag = false;
                    } else {
                        $valor_cuota_pagar = intval($rspta[$i]["valor_cuota"]) - intval($rspta[$i]["valor_pagado"]);
                        $aprobacion = '<button class="btn btn-sm bg-yellow btn-flat btn_pagar disabled" disabled data-valorcuotapagar="' . $valor_cuota_pagar . '" data-toggle="modal" data-idfinanciamiento="' . $rspta[$i]["id_financiamiento"] . '" data-target="#modal_pagos"><i class="fas fa-spinner"></i><i> En proceso</i></button>';
                    }
                }
            }
            $data[] = array(
                "0" => '<div class="btn-group col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" style="padding:0px  !important; margin:0px !important;">
					 	<div>' . $aprobacion . '
						</div>
					</div>',
                "1" => '<span id="no_cuota_' . $rspta[$i]["id_financiamiento"] . '">' . $rspta[$i]["numero_cuota"] . '</span>',
                "2" => '<span class="money_value">' . $rspta[$i]["valor_cuota"] . '</span>',
                "3" => $rspta[$i]["valor_pagado"],
                "4" => $rspta[$i]["fecha_pago"],
                "5" => $rspta[$i]["plazo_pago"],
                "6" => $reporte->dias_atrazo($rspta[$i]["plazo_pago"]),
                "7" => '<button class="btn bg-yale btn-flat btn-sm text-left" data-toggle="modal" data-target=".bs-example-modal-sm" onclick="editar_cuota(' . $rspta[$i]["id_financiamiento"] . ')"><i class="fas fa-pen-fancy"></i></button>',
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
        //Muestra la informacion especifica del solicitante
}
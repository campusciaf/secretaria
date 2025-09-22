<?php
require_once "../modelos/Financiacion.php";
require_once("../YeminusApi/modelos/Yeminus.php");
$yeminus_obj = new Yeminus();
//modelo en el cual estan las funciones a base de datos 
$consulta = new Financiacion();
//dependiendo de la opcion que envien por el GET, el switch determinara donde entrar
switch ($_GET['op']) {
    case 'listarCuotaActual':
        $numero_documento = $_SESSION['credencial_identificacion'];
        $creditos_activos = $consulta->creditosActivos($numero_documento);
        $valor_acumulado_cuotas = 0;
        $array["exito"] = 0;
        $array["html"] = "";
        $fecha_limite = "";
        //dependiendo de la cantidad de registros, el for hara un bucle almacenandolos en el array
        if (count($creditos_activos) > 0) {
            for ($i = 0; $i < count($creditos_activos); $i++) {
                $array["exito"] = 1;
                $consecutivo = $creditos_activos[$i]["id"];
                $motivo_financiacion = $creditos_activos[$i]["motivo_financiacion"];
                $cuotas = $consulta->traerCuotas($consecutivo);
                $valor_acumulado = 0;
                $pago_inmediato = false;
                foreach ($cuotas as $cuota) {
                    $fecha_pago = $cuota["fecha_pago"];
                    $valor_cuota = $cuota["valor_cuota"];
                    $valor_pagado = $cuota["valor_pagado"];
                    $valor_cuota = $valor_cuota - $valor_pagado;
                    $valor_acumulado += $valor_cuota;
                    if (date("Y-m-d") < $fecha_pago && !$pago_inmediato) { //aun esta en el plazo limite
                        $fecha_limite = $consulta->fechaesp($cuota["fecha_pago"]);
                    } else {
                        $fecha_limite = "<small class='text-danger fs-24'>Inmediato</small>";
                        $pago_inmediato = true;
                    }
                }
                $formato_cuota = $consulta->formatoDinero($valor_acumulado);
                $array["html"] .= '
                    <div class="col-12 col-sm-12 col-md-6 col-lg-8 ">
                        <form action="#" method="POST" id="formularioCuota">
                            <div class="rounded mb-3 bg-gris">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                       
                                        <div class="card-body pt-1 pb-1">
                                            <span class="font-weight-normal  m-0 text-dark fs-18"> ' . $motivo_financiacion . ' #' . $consecutivo . ' </span><br>
                                            <span class="f-montserrat-bold fs-48"> $ ' . $formato_cuota . '</span><br>
                                            <span class="font-weight-normal fs-16">  Fecha limite de Pago: ' . $fecha_limite . ' </span>
                                        </div>
                                    </div>

                                    <div class="col-12 mb-3 px-3">
                                        <button type="button" onclick="datosPago(' . $consecutivo . ')" data-toggle="modal" data-target="#modal_pagar_cuotas" class="btn bg-purple" style="font-size:48px !important"> Pagar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                ';
            }
        } else {
            $array["exito"] = 1;
            $array["html"] .= '
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 ">
                        <form>
                            <div class="rounded mb-3 bg-gris">
                                <div class="row no-gutters">
                                    <div class="col-md-7">
                                        <h6 class="font-weight-normal p-3 mb-0"> <span class="badge bg-success pl-3 pr-3">Finalizado</span> </h6>  
                                        <div class="card-body pt-1 pb-1">
                                            <h6 class="font-weight-normal mb-3 text-dark"> No Hay Crédito Activo </h6>
                                            <h4 class="text-dark"> $ 0.00</h4>
                                            <h5 class="font-weight-normal mb-3 text-secondary"> <small> Estado: <span class="text-success"> Finalizado </span> </small></h5>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <h5 class="font-weight-normal mb-3 text-dark mt-2"> <span class="badge bg-navy pl-3 pr-3">Recuerda que puedes realizar:</span> </h5>
                                        <div class="card-body pt-1 ">
                                            <label class="text-dark">
                                                <span> - Pago Mínimo(Cuota)</span>
                                            </label>
                                            <br>
                                            <label class="text-dark">
                                                <span> - Pago Total</span>
                                            </label>
                                            <br>
                                            <label class="text-dark">
                                                <span> - Otro Valor</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3 px-3">
                                        <button type="button" disabled class="btn bg-morado btn-block text-white"> Pagar Cuota </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                ';
        }
        echo json_encode($array);
        break;
    case "cargarFinanciacion": // listar los datos de la persona que va a ver la financiación
        $cc = $_SESSION['credencial_identificacion'];
        $data = array();
        $data["0"] = '1';
        $data["1"] = $cc;
        $data["2"] = 'tabla_info';
        $results = array($data);
        echo json_encode($results);
        break;
    case 'listarCuotas': //Listar todos los financiados que esten a 3 dias de cumplir su cuota
        /*print_r($_POST);*/
        $tipo_busqueda = isset($_POST["tipo_busqueda"]) ? $_POST["tipo_busqueda"] : die();
        $dato_busqueda = isset($_POST["dato_busqueda"]) ? $_POST["dato_busqueda"] : die();
        $hoy = date("Y-m-d");
        //hacemos peticion al modelo
        $rsta = $consulta->listarCuotas($tipo_busqueda, $dato_busqueda);
        //creamos un array
        $array = array();
        //2 = consecutivo; 1 y 3 = nombre o cedula  
        if ($tipo_busqueda == 2) {
            //creamos las variables de los botones
            $btn_pagado = '<span class="badge bg-success"><i class="fas fa-check"></i><i> Pagado</i></span>';
            $btn_progreso_normal = '<button class="btn btn-xs bg-yellow" disabled><i class="fas fa-spinner"></i><i> En proceso</i></button>';
            $btn_proceso_atrasado = '<button class="btn btn-xs btn-danger" disabled> <i class="fas fa-calendar-times"></i> <i> Atrasado </i> </button>';
            $btn_anulado = '<button class="btn btn-xs bg-orange" disabled><i class="fas fa-handshake-alt-slash"></i> <i> Anulado</i></button>';
            $flag = false;
            //Dependiendo de la cantidad de registros, el for hara un bucle almacenandolos en el array
            for ($i = 0; $i < count($rsta); $i++) {
                if (strtotime($hoy) >= strtotime($rsta[$i]["fecha_pago"]) and $flag) {
                    $btn_progreso = $btn_proceso_atrasado;
                } else {
                    $btn_progreso = $btn_progreso_normal;
                }
                //calculamos los dias de atraso
                $dias_atraso = $consulta->diferenciaFechas(date("Y-m-d"), $rsta[$i]["plazo_pago"]);
                //creamos las variables de los botones que tienen accion
                $e = $rsta[$i]["estado"];
                //id del financiamiento
                $id_cuota = $rsta[$i]["id_financiamiento"];
                //el valor de la cuota actual
                $valor_a_pagar = intval($rsta[$i]["valor_cuota"] - $rsta[$i]["valor_pagado"]);
                $btn_pagar = '<button class="btn btn-xs bg-navy scroll_btn_pagar" data-toggle="modal" data-target="#modal_pagar_cuotas" onclick="datosPago(' . $rsta[$i]["id_matricula"] . ')">
                                <i data-toggle="tooltip" data-original-title="Pagar Cuota"><i class="fas fa-hand-holding-usd"></i> Pagar
                            </button>';
                $btn_abonar = '<button class="btn btn-xs btn-info" disabled> <i data-toggle="tooltip" data-original-title="Abonar Cuota"><i class="fas fa-coins"></i></i> </button>';
                $btn_adelantar = '<button class="btn btn-xs btn-warning" disabled> <i data-toggle="tooltip" data-original-title="Adelantar Cuota"><i class="fas fa-angle-double-right"></i></i></button>';
                $btn_atraso = '<button class="btn btn-xs btn-danger" disabled>
                            <i data-toggle="tooltip" data-original-title="Pagar Atrasado">
                                <i class="fas fa-calendar-times"></i> 
                                <i> Atrasado</i>
                            </i>
                        </button>';
                $btn_abonado = '<button class="btn btn-xs bg-teal" disabled>
                            <i data-toggle="tooltip" data-original-title="Pagar total abonado"><i class="fas fa-handshake"></i></i>
                        </button>';
                //array con info
                $final = '<div class="text-center" style="padding:0px  !important; margin:0px !important;">
                            ' . (($rsta[$i]["estado_credito"] == "Anulado") ? $btn_anulado : (($e == "Pagado") ? $btn_pagado : (($flag) ? $btn_progreso : $btn_pagar))) . '
                        </div>';
                $array[] = array(
                    "0" => $rsta[$i]["numero_cuota"],
                    "1" => $consulta->formatoDinero($rsta[$i]["valor_cuota"]),
                    "2" => $consulta->formatoDinero($rsta[$i]["valor_pagado"]),
                    "3" => $rsta[$i]["fecha_pago"],
                    "4" => $rsta[$i]["plazo_pago"],
                    "5" => ($rsta[$i]["estado"] == "A Pagar" && strtotime($hoy) >= strtotime($rsta[$i]["fecha_pago"])) ? $dias_atraso : (($rsta[$i]["estado"] == "A Pagar" && strtotime($hoy) < strtotime($rsta[$i]["fecha_pago"])) ? "-" . $dias_atraso : 0),
                    "6" => $final,
                );
                $flag = ($e == "Pagado") ? false : true;
            }
        } else {
            //dependiendo de la cantidad de registros, el for hara un bucle almacenandolos en el array
            for ($i = 0; $i < count($rsta); $i++) {
                $totales = $consulta->cuotasTotales($rsta[$i]["id"])["total"];
                $pagadas = $consulta->cuotasPagadas($rsta[$i]["id"])["total"];
                if ($totales == $pagadas) {
                    $color_boton = "btn-success";
                    $tooltip = "Finalizado";
                    $consulta->FinalizarFinanciacion($rsta[$i]["id"]);
                } else {
                    $color_boton = "btn-warning";
                    $tooltip = "En Proceso";
                }
                $array[] = array(
                    "0" => '<button class="btn ' . $color_boton . ' tooltip-button" onclick="listar_cuotas(2,' . $rsta[$i]["id"] . ',`' . "tabla_cuotas" . '`)" data-toggle="tooltip" data-html="true" title="' . $tooltip . '"> <i class="fas fa-calendar-alt"></i> </button>',
                    "1" => $rsta[$i]["periodo"],
                    "2" => $rsta[$i]["id"],
                    "3" => $rsta[$i]["programa"],
                    "4" => $consulta->formatoDinero($rsta[$i]["valor_total"]),
                    "5" => $consulta->formatoDinero($rsta[$i]["valor_financiacion"]),
                    "6" => $rsta[$i]["descuento"],
                    "7" => date("Y-m-d", strtotime($rsta[$i]["fecha_inicial"])),
                );
            }
        }
        //se crea otro array para almacenar toda la informacion que analizara el datatable
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($array), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($array), //enviamos el total registros a visualizar
            "aaData" => $array
        );
        echo json_encode($results);
        break;
    case 'listarCuotasFinalizadas': //Listar todos los financiados que esten a 3 dias de cumplir su cuota
        /*print_r($_POST);*/
        $tipo_busqueda = isset($_POST["tipo_busqueda"]) ? $_POST["tipo_busqueda"] : die();
        $dato_busqueda = isset($_POST["dato_busqueda"]) ? $_POST["dato_busqueda"] : die();
        $hoy = date("Y-m-d");
        //hacemos peticion al modelo
        $rsta = $consulta->listarCuotasFinalizadas($tipo_busqueda, $dato_busqueda);
        //creamos un array
        $array = array();
        //creamos las variables de los botones
        $btn_pagado = '<span class="badge bg-success"><i class="fas fa-check"></i><i> Pagado</i></span>';
        //Dependiendo de la cantidad de registros, el for hara un bucle almacenandolos en el array
        for ($i = 0; $i < count($rsta); $i++) {
            //array con info
            $final = '<div class="text-center" style="padding:0px !important; margin:0px !important;">  '. $btn_pagado.' </div>';
            $array[] = array(
                "0" => $rsta[$i]["numero_cuota"],
                "1" => $consulta->formatoDinero($rsta[$i]["valor_cuota"]),
                "2" => $consulta->formatoDinero($rsta[$i]["valor_pagado"]),
                "3" => $rsta[$i]["fecha_pago"],
                "4" => $rsta[$i]["plazo_pago"],
                "5" => 0,
                "6" => $final,
            );
        }
        //se crea otro array para almacenar toda la informacion que analizara el datatable
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($array), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($array), //enviamos el total registros a visualizar
            "aaData" => $array
        );
        echo json_encode($results);
        break;
    case 'listarCreditosFinalizados':
        $numero_documento = $_SESSION['credencial_identificacion'];
        $creditos_finalizados = $consulta->creditosFinalizados($numero_documento);
        $array = array();
        if (count($creditos_finalizados) > 0) {
            for ($i = 0; $i < count($creditos_finalizados); $i++) {
                $array[] = array(
                    "0" => '<button class="btn btn-success tooltip-button" onclick="listar_cuotas_finalizadas(2,' . $creditos_finalizados[$i]["id"] . ',`' . "tabla_cuotas" . '`)" data-toggle="tooltip" data-html="true" title="Finalizado"> <i class="fas fa-calendar-alt"></i> </button>',
                    "1" => $creditos_finalizados[$i]["periodo"],
                    "2" => $creditos_finalizados[$i]["id"],
                    "3" => $creditos_finalizados[$i]["programa"],
                    "4" => $consulta->formatoDinero($creditos_finalizados[$i]["valor_total"]),
                    "5" => $consulta->formatoDinero($creditos_finalizados[$i]["valor_financiacion"]),
                    "6" => $creditos_finalizados[$i]["descuento"],
                    "7" => date("Y-m-d", strtotime($creditos_finalizados[$i]["fecha_inicial"])),
                );
            }
        }
        //se crea otro array para almacenar toda la informacion que analizara el datatable
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($array), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($array), //enviamos el total registros a visualizar
            "aaData" => $array
        );
        echo json_encode($results);
        break;
    case "PagarCuota":
        $tipo_pago = isset($_POST["optionsRadios"]) ? $_POST["optionsRadios"] : "";
        $otro_valor = isset($_POST["otro_valor"]) ? $_POST["otro_valor"] : "";
        $input_pagar_minimo = isset($_POST["input_pagar_minimo"]) ? $_POST["input_pagar_minimo"] : "";
        $input_pagar_total = isset($_POST["input_pagar_total"]) ? $_POST["input_pagar_total"] : "";
        $input_mora = isset($_POST["input_mora"]) ? $_POST["input_mora"] : "";
        $consecutivo =  isset($_POST["consecutivo_pago"]) ? $_POST["consecutivo_pago"] : die(json_encode(array("exito" => 0, "info" => "Solicitante obligatorio")));
        $documento_yeminus = isset($_POST["documento_yeminus"]) ? $_POST["documento_yeminus"] : die(json_encode(array("exito" => 0, "info" => "Documento vacío")));
        $prefijo = isset($_POST["prefijo"]) ? $_POST["prefijo"] : "";
        $tipoDocumento = isset($_POST["tipoDocumento"]) ? $_POST["tipoDocumento"] : "";
        if ($tipo_pago == "pago_minimo") {
            $total_enviar = $input_pagar_minimo;
        } else if ($tipo_pago == "pago_total") {
            $total_enviar = $input_pagar_total;
        } else if ($tipo_pago == "pago_parcial") {
            $total_enviar = $otro_valor;
        } else {
            die(json_encode(array("exito" => 0, "info" => "Tipo de pago obligatorio")));
        }
        $rsta = $consulta->verInfoSolicitante($consecutivo);
        if ($rsta >= 1) {
            //extrae el array y lo convierte en variables individuales
            extract($rsta);
            $array = array(
                'exito' => 1,
                "info" => '
                   
                    <!-- =====================================================================
                    ///////////   Este es su botón de Botón de pago ePayco AGREGADOR   ///////////
                    ===================================================================== -->
                    <form class="col-6">
                        <script src="https://checkout.epayco.co/checkout.js" 
                            data-epayco-key="8b4e82b040c208b31bc5be3f33830392" 
                            class="epayco-button" 
                            data-epayco-amount="' . $total_enviar . '" 
                            data-epayco-tax="0"
                            data-epayco-tax-base="' . $total_enviar . '"
                            data-epayco-name="Pago crédito ' . $motivo_financiacion . '" 
                            data-epayco-description="Pago crédito # ' . $consecutivo . ' CC. ' . $numero_documento . '" 
                            data-epayco-extra1="' . $id_persona . '"
                            data-epayco-extra2="' . $consecutivo . '"
                            data-epayco-extra3="' . $tipo_pago . '"
                            data-epayco-extra4="' . $consecutivo . '"
                            data-epayco-extra5="21"
                            data-epayco-extra6="11100611"
                            data-epayco-extra7="' . $prefijo . '"
                            data-epayco-extra8="' . $tipoDocumento . '"
                            data-epayco-extra9="' . $documento_yeminus . '"
                            data-epayco-extra10="' . $input_mora . '"
                            data-epayco-currency="cop"    
                            data-epayco-country="CO" 
                            data-epayco-test="false" 
                            data-epayco-external="true"
                            data-epayco-response="https://ciaf.digital/vistas/gracias.php"  
                            data-epayco-confirmation="https://ciaf.digital/vistas/pagosagregadorsofi.php" 
                            data-epayco-button="https://ciaf.digital/public/img/pago-efectivo.webp"> 
                        </script> 
                    </form>

                     <!-- =====================================================================
                    ///////////   Este es su botón de Botón de pago ePayco GATEWAY   ///////////
                    ===================================================================== -->
                    <form class="col-6">
                        <script src="https://checkout.epayco.co/checkout.js"
                            data-epayco-key="d4b482f39f386634f5c50ba7076eecff" 
                            class="epayco-button" 
                            data-epayco-amount="' . $total_enviar . '" 
                            data-epayco-tax="0"
                            data-epayco-tax-base="' . $total_enviar . '"
                            data-epayco-name="Pago crédito ' . $motivo_financiacion . '" 
                            data-epayco-description="Pago crédito # ' . $consecutivo . ' CC. ' . $numero_documento . '" 
                            data-epayco-extra1="' . $id_persona . '"
                            data-epayco-extra2="' . $consecutivo . '"
                            data-epayco-extra3="' . $tipo_pago . '"
                            data-epayco-extra4="' . $consecutivo . '"
                            data-epayco-extra5="16"
                            data-epayco-extra6="11100506"
                            data-epayco-extra7="' . $prefijo . '"
                            data-epayco-extra8="' . $tipoDocumento . '"
                            data-epayco-extra9="' . $documento_yeminus . '"
                            data-epayco-extra10="' . $input_mora . '"
                            data-epayco-currency="cop"    
                            data-epayco-country="CO" 
                            data-epayco-test="false" 
                            data-epayco-external="true" 
                            data-epayco-response="https://ciaf.digital/vistas/gracias.php"  
                            data-epayco-confirmation="https://ciaf.digital/vistas/pagosagregadorsofi.php" 
                            data-epayco-button="https://ciaf.digital/public/img/pagos-pse.webp"> 
                        </script> 
                    </form>
                    
                    
                    
                    '
            );
        } else {
            $array = array("exito" => 0);
        }
        echo json_encode($array);
        break;
    //Muestra la informacion especifica del solicitante
    case 'verInfoSolicitante':
        $consecutivo = isset($_POST["consecutivo"]) ? $_POST["consecutivo"] : die(json_encode(array("exito" => 0, "info" => "Solicitante obligatorio")));
        $rsta = $consulta->verInfoSolicitante($consecutivo);
        if ($rsta >= 1) {
            // estado_ciafi 0 = bloqueado, 1 = desbloqueado 
            $estado_ciafi = ($rsta["estado_ciafi"] == 0) ? "Bloqueado" : "No Bloqueado";
            // estado_financiacion 0 = inactivo, 1 = activo 
            $estado_financiacion = ($rsta["estado"] == "Anulado") ? "Anulado" : "Activo";
            $estado_credito = ($rsta["estado"] == "Anulado") ? 0 : 1;
            // en_cobro 0 = no, 1 = si 
            $en_cobro = ($rsta["en_cobro"] == 0) ? "NO" : "SI";
            $array = array(
                "exito" => 1,
                "id_persona" => $rsta["id_persona"],
                "tipo_documento" => $rsta["tipo_documento"],
                "numero_documento" => $rsta["numero_documento"],
                "nombres" => $rsta["nombres"],
                "apellidos" => $rsta["apellidos"],
                "direccion" => $rsta["direccion"],
                "telefono" => $rsta["telefono"],
                "celular" => $rsta["celular"],
                "email" => $rsta["email"],
                "periodo" => $rsta["periodo"],
                "id" => $rsta["id"],
                "programa" => $rsta["programa"],
                "jornada" => $rsta["jornada"],
                "semestre" => $rsta["semestre"],
                "dia_pago" => $rsta["dia_pago"],
                "valor_financiacion" => $rsta["valor_financiacion"],
                "cantidad_tiempo" => $rsta["cantidad_tiempo"],
                "estado_financiacion" => $estado_financiacion,
                "estado_ciafi" => $estado_ciafi,
                "en_cobro" => $en_cobro
            );
        } else {
            $array = array("exito" => 0);
        }
        echo json_encode($array);
        break;
    //Muestra la informacion especifica del solicitante
    case 'saldoDebito':
        $pago_minimo = 0;
        // Obtener el id del financiamiento
        $consecutivo = isset($_POST["consecutivo"]) ? $_POST["consecutivo"] : die(json_encode(array("exito" => 0, "info" => "Cuota obligatoria")));
        $data = array();
        // Definimos en cero todas las variables que se van a usar 
        $valor_deuda_total = 0;
        // El calculo de la suma de la cuot a + interes y ese mismo se suma sobre los mismos intereses 
        $valor_mas_interes = 0;
        // La suma del interes neto
        $interes_total = 0;
        // Consultamos en la base de datos las cuotas que no se han pagado hasta la fecha actual
        $rspta = $consulta->consultarCuotasNoPagadas($consecutivo);
        if (count($rspta) >= 1) {
            // Realizamos un for a través de las cuotas 
            for ($i = 0; $i < count($rspta); $i++) {
                /*me ayuda a guardar solo el plazo de la primer cuota atrasada, esto para cuando el estudiante esta atrasado el mismo mes de la cuota, ya que de eso depende el calculo de mes actual */
                $plazo_primer_cuota = ($i == 0) ? $rspta[$i]["plazo_pago"] : $plazo_primer_cuota;
                // Tomamos el plazo de la cuota 
                $plazo_pago = $rspta[$i]["plazo_pago"];
                // Obtenemos el valor real de la cuota
                $valor_cuota = $rspta[$i]["valor_cuota"];
                // Obtenemos el valor abonado a la cuota
                $valor_pagado = $rspta[$i]["valor_pagado"];
                // Calculamos el valor restante a pagar (es por si se ha realizado abonos)
                $valor_cuota =  $valor_cuota - $valor_pagado;
                //almacenamos el pago minimo de la cuota
                $pago_minimo = ($i == 0) ? $valor_cuota : $pago_minimo;
                // Almacenamos el valor total de la deuda indica lo que lleva atrasado sin mora
                $valor_deuda_total += $valor_cuota;
                // Almacenamos el valor de la deuda pero ahora teniendo en cuenta el valor del interés
                $valor_mas_interes += $valor_cuota;
                // Tomamos el año de la cuota
                $anio_cuota = date("Y", strtotime($plazo_pago));
                // Tomamos el mes de la cuota
                $mes_cuota = date("m", strtotime($plazo_pago));
                // Tomamos el día de la cuota
                $dia_cuota = date("d", strtotime($plazo_pago));
                // Obtenemos los datos del interés mora del mes y el año de la cuota
                $interes = $consulta->TraerInteresMora("$anio_cuota-$mes_cuota");
                // Obtenemos el interés
                $porcentaje_interes = $interes["porcentaje"];
                // Obtenemos el nombre del mes de interés
                $nombre_mes = $interes['nombre_mes'];
                // Obtenemos la fecha límite de interés
                $fecha_interes = $interes["fecha_mes"];
                // Obtenemos solo el día límite de interés
                $dia_final_interes = date("d", strtotime($fecha_interes));
                //si la cuota esta en el mes actual, nos devolvemos un mes atras, para calcularlo en con la formula de actual
                if ($anio_cuota == date("Y") && $mes_cuota == date("m")) {
                    //si es enero, debemos devolver a diciembre
                    $mes_cuota = ($mes_cuota == 01) ? 12 : $mes_cuota - 1;
                    //si es enero, debemos devolver un año atras
                    $anio_cuota = ($mes_cuota == 01) ? $anio_cuota-- : $anio_cuota;
                } else {
                    // Calculamos los días transcurridos
                    $dias_transcurridos =  $dia_final_interes - $dia_cuota;
                    // Si es el primer ciclo, el valor debe ser la resta de los días, sino, sería el total del mes 
                    $dias_transcurridos = ($i == 0) ? $dias_transcurridos : $dia_final_interes;
                    // pow es potenciación, es decir calculamos el porcentaje por medio de un cálculo que incluye potenciación
                    $porcentaje = pow((1 + ($porcentaje_interes / 100)), (1 / 12)) - 1;
                    // Se calcula el valor del interés
                    $valor_interes = $valor_deuda_total * ($porcentaje / $dia_final_interes * $dias_transcurridos);
                    // Se suma al total de los intereses
                    $interes_total += $valor_interes;
                    // Este valor es simplemente datos de ayuda a la tabla
                    $valor_mas_interes += $valor_interes;
                    // Mostrar el valor final en la tabla
                    $data[] = array(
                        '0' => $nombre_mes,
                        '1' => $dias_transcurridos,
                        '2' => round($valor_deuda_total),
                        '3' => round($valor_interes),  // Días hasta hoy en el mes actual
                        '4' => round($valor_mas_interes),
                        '5' => number_format(($porcentaje * 100), 2)
                    );
                }
            }
            /* Calcular los intereses desde la última cuota hasta la fecha actual  */
            //bandera que me indica que los meses restantes aparte de las cuotas ya finalizaron
            $finalizo = true;
            //este do-while se ejecuta hasta que llegue el mes actual y la bandera $finalizo sea false
            do {
                //sumamos uno a uno los meses teniendo en cuenta que puede haber cuotas de un año para otro
                $anio_cuota = ($mes_cuota == 12) ? $anio_cuota + 1 : $anio_cuota;
                //si el mes es igual a 12 quiere decir que el procimo mes es enero por ende 1, sino sumamos uno mas
                $mes_cuota = ($mes_cuota == 12) ? 1 : $mes_cuota + 1;
                //agregamos el cero del 1 al 9 para temas de evitar errores al momento de consultar interes
                $mes_cuota = ($mes_cuota <= 9) ? "0" . $mes_cuota : $mes_cuota;
                // Obtenemos los datos del interés mora del mes y el año de la cuota
                $interes = $consulta->TraerInteresMora("$anio_cuota-$mes_cuota");
                // Obtenemos el interés
                $porcentaje_interes = $interes["porcentaje"];
                // Obtenemos el nombre del mes de interés
                $nombre_mes = $interes['nombre_mes'];
                // Obtenemos la fecha límite de interés
                $fecha_interes = $interes["fecha_mes"];
                // Obtenemos solo el día límite de interés
                $dia_final_interes = date("d", strtotime($fecha_interes));
                if (date("m") == $mes_cuota && $anio_cuota == date("Y")) {
                    $mes_primer_cuota_atrasada = date("m", strtotime($plazo_primer_cuota));
                    if ($mes_primer_cuota_atrasada == $mes_cuota) {
                        $dia_primer_cuota_atrasada = date("d", strtotime($plazo_primer_cuota));
                        $dia_actual = date("d");
                        $dias_transcurridos = $dia_actual - $dia_primer_cuota_atrasada;
                    } else {
                        $dias_transcurridos = date("d");
                    }
                    $finalizo = false;
                } else {
                    $dias_transcurridos = $dia_final_interes;
                }
                // pow es potenciación, es decir calculamos el porcentaje por medio de un cálculo que incluye potenciación
                $porcentaje = pow((1 + ($porcentaje_interes / 100)), (1 / 12)) - 1;
                // Se calcula el valor del interés
                $valor_interes = $valor_deuda_total * ($porcentaje / $dia_final_interes * $dias_transcurridos);
                // Se suma al total de los intereses
                $interes_total += $valor_interes;
                // Este valor es simplemente datos de ayuda a la tabla
                $valor_mas_interes += $valor_interes;
                $data[] = array(
                    '0' => $nombre_mes,
                    '1' => $dias_transcurridos,
                    '2' => round($valor_deuda_total),
                    '3' => round($valor_interes),  // Días hasta hoy en el mes actual
                    '4' => round($valor_mas_interes),
                    '5' => number_format(($porcentaje * 100), 2)
                );
            } while ($finalizo);
        }
        // Preparar los resultados para el datatables
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data,
            "pago_minimo" => round($pago_minimo + $interes_total),
            "valor_total" => round($valor_mas_interes),
            "total_interes" => round($interes_total),
            "atraso" => (count($data) == 0) ? 0 : 1,
        );
        if ($results["atraso"] == 0) {
            $rsta = $consulta->saldoDebito($consecutivo);
            $results["valor_total"] = $rsta["saldo_debito"];
            $rsta2 = $consulta->pagoMinimoCuota($consecutivo);
            $results["pago_minimo"] = isset($rsta2["valor_pagar"])? $rsta2["valor_pagar"] : 0;
            $results["total_interes"] = 0;
        }
        echo json_encode($results);
        break;
    case 'validarDatosFactura':
        //datos del post enviado desde js
        $dato_busqueda = isset($_POST["dato_busqueda"]) ? $_POST["dato_busqueda"] : die(json_encode(array("exito" => 0, "info" => "Documento vacío")));
        $document_filter = array(
            "filtrar" => true,
            "tiposDocumentos" => array("FV"),
            "prefijos" => array("ELEC", "API"),
            "numero" => $dato_busqueda
        );
        $rspta = $yeminus_obj->ConsultarFacturaVenta($document_filter);
        if (is_null($rspta)) {
            die(json_encode(array("exito" => 0, "info" => "No se encontró Documento")));
        } else {
            $data = array(
                "exito" => 1,
                "prefijo" => $rspta["documentos"][0]["prefijo"],
                "tipoDocumento" => $rspta["documentos"][0]["tipoDocumento"],
                "referencia" => $rspta["documentos"][0]["referencia"],
                "observaciones" => $rspta["documentos"][0]["observaciones"],
                "codigoTercero" => $rspta["documentos"][0]["codigoTercero"],
                "descripcionTercero1" => $rspta["documentos"][0]["descripcionTercero1"],
                "correoFacturacionElectronica" => $rspta["documentos"][0]["correoFacturacionElectronica"],
                "precioTotalCantPendiente" => $rspta["documentos"][0]["precioTotalCantPendiente"],
            );
            die(json_encode(array("exito" => 1, "info" => $data)));
        }
        break;
}

<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 8;
    $seccion = "Crédito Educativo";
    require 'header_estudiante.php';
    if (!empty($_SESSION['id_usuario'])) {
?>
        <link rel="stylesheet" href="../public/css/pure-tabs.css">
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <!-- Main content -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-8">
                            <h2 class="m-0 line-height-16">
                                <span class="fs-16 f-montserrat-regular ">Medios pagos</span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                    </div>
                    <div class="row mb-3 ">
                        <div class="col-12 imagen_marque">
                            <img src="../public/img/medios_pago/pse.png" width="100px" height="50px" alt="PSE">
                            <img src="../public/img/medios_pago/davivienda.png" width="100px" height="50px" alt="davivienda">
                            <img src="../public/img/medios_pago/davipuntos.png" width="100px" height="50px" alt="davipuntos">
                            <img src="../public/img/medios_pago/efecty.png" width="100px" height="50px" alt="efecty">
                            <img src="../public/img/medios_pago/mastercard.png" width="100px" height="50px" alt="Mastercard">
                            <img src="../public/img/medios_pago/puntored.png" width="100px" height="50px" alt="Puntored">
                            <img src="../public/img/medios_pago/visa.png" width="100px" height="50px" alt="Visa">
                            <img src="../public/img/medios_pago/safetypay.png" width="100px" height="50px" alt="Safety Pay">
                            <img src="../public/img/medios_pago/suchance.png" width="100px" height="50px" alt="Suchance">
                            <img src="../public/img/medios_pago/sured.png" width="100px" height="50px" alt="Sured">
                            <img src="../public/img/medios_pago/baloto.png" width="100px" height="50px" alt="baloto">
                            <img src="../public/img/medios_pago/acertemos.png" width="100px" height="50px" alt="Acertemos">
                            <img src="../public/img/medios_pago/amex.png" width="100px" height="50px" alt="Amex">
                            <img src="../public/img/medios_pago/apuestas-cucuta.png" width="100px" height="50px" alt="Apuestas Cucuta">
                            <img src="../public/img/medios_pago/condesa.png" width="100px" height="50px" alt="condesa">
                            <img src="../public/img/medios_pago/fondo-medios-de-pago.png" width="100px" height="50px" alt="fondos medios de pago">
                            <img src="../public/img/medios_pago/gana.png" width="100px" height="50px" alt="gana">
                            <img src="../public/img/medios_pago/gana-gana.png" width="100px" height="50px" alt="gana gana">
                            <img src="../public/img/medios_pago/Jer.png" width="100px" height="50px" alt="Jer">
                            <img src="../public/img/medios_pago/la-perla.png" width="100px" height="50px" alt="La Perla">
                            <img src="../public/img/medios_pago/paga-todo.png" width="100px" height="50px" alt="Paga Todo">
                            <img src="../public/img/medios_pago/paypal.png" width="100px" height="50px" alt="Paypal">
                            <img src="../public/img/medios_pago/red-de-servicios-del-cesar.png" width="100px" height="50px" alt="Red de Servicios del Cesar">
                            <img src="../public/img/medios_pago/red-servi.png" width="100px" height="50px" alt="Red Servi">
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="row">
                    <div class="col-md-12 p-3">
                        <!-- tabs -->
                        <div class="pcss3t pcss3t-effect-slide-scale  pcss3t-theme-1">
                            <input type="radio" name="pcss3t" id="tab1" class="tab-content-first" checked>
                            <label for="tab1"> <i class=" fas fa-money-check-dollar"></i> Cuota Actual</label>
                            <input type="radio" name="pcss3t" id="tab2" class="tab-content-2">
                            <label for="tab2"><i class="fas fa-file-invoice-dollar"></i> Créditos Activos</label>
                            <input type="radio" name="pcss3t" id="tab3" class="tab-content-3">
                            <label for="tab3"><i class="fas fa-check-to-slot"></i> Créditos Finalizados</label>
                            <ul>
                                <li class="tab-content tab-content-first typography">
                                    <div class="col-12">
                                        <div class="row" id="listadoCuotasActuales">
                                        </div>
                                    </div>
                                </li>
                                <li class="tab-content tab-content-2 typography">
                                    <div class="table-responsive">
                                        <table id="tabla_info" class="table table-hover ">
                                            <thead>
                                                <td>Cuotas</td>
                                                <td>Periodo</td>
                                                <td>Consecutivo</td>
                                                <td>Programa</td>
                                                <td>Matrícula</td>
                                                <td>Financiado</td>
                                                <td>Descuento</td>
                                                <td>Inicio</td>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="9" class="jumbotron text-center bg-navy rounded-0"> Aquí aparecen los estudiantes</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </li>
                                <li class="tab-content tab-content-3 typography">
                                    <div class="table-responsive">
                                        <table id="tabla_creditos_finalizados" class="table table-hover ">
                                            <thead>
                                                <td>Cuotas</td>
                                                <td>Periodo</td>
                                                <td>Consecutivo</td>
                                                <td>Programa</td>
                                                <td>Matrícula</td>
                                                <td>Financiado</td>
                                                <td>Descuento</td>
                                                <td>Inicio</td>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="9" class="jumbotron text-center bg-navy rounded-0"> Aquí aparecen los estudiantes</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="tabla_cuotas table-responsive">
                            <p class="list-group-item text-dark">
                                <b> Saldo Débito:</b>
                                <a class="box-profiledates saldo_debito"> -------------- </a>
                            </p>
                            <table id="tabla_cuotas" class="table table-hover ">
                                <thead>
                                    <td>Cuota</td>
                                    <td>Valor</td>
                                    <td>Pagado</td>
                                    <td>Fecha</td>
                                    <td>Plazo</td>
                                    <td>Atraso</td>
                                    <td>Pagar</td>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="7" class="jumbotron text-center bg-navy rounded-0"> Aquí aparecen las cuotas</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!----------------------------------------------------------------------- MODAL HISTORIAL PAGOS  --------------------------------------------------------------------------->
        <div class="modal fade" id="modal_pagar_cuotas" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-md">
                <div class="modal-content modal">
                    <div class="modal-header bg-purple">
                        <h4 class="text-white">Monto A Pagar</h4>
                        <button type="button" class="close " data-dismiss="modal" aria-label="Close"> <span aria-hidden="true" class="text-white">×</span></button>
                    </div>
                    <div class="modal-body">
                        <form id="formularioPagarCuotas" method="POST" action="#" class="container-fluid">
                            <div class="row">
                                <div class="col-6 col-sm-6 col-md-6 col-lg-3 col-xl-6 ">

                                    <div class="card-body pt-1 ">
                                        Seleccionar: <br>
                                        <label class="label-pilled">
                                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="pago_minimo"/>
                                            <span>Pago Mínimo</span>
                                        </label>
                                        <br>
                                        <label class="label-pilled">
                                            <input type="radio" name="optionsRadios" id="optionsRadios2" value="pago_total" />
                                            <span>Pago Total</span>
                                        </label>
                                        <br>
                                        <label class="label-pilled">
                                            <input type="radio" name="optionsRadios" id="optionsRadios3" value="pago_parcial" />
                                            <span>Otro Valor</span>
                                        </label>
                                    </div>
                                    <div class="col-12 opciones_pagar_cuotas">
                                        <br>
                                        <div class="col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3 ">
                                            <div class="col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3 ">
                                                <div class="col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3 ">
                                                    <div class="col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3 ">
                                                        <div class="col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3 ">
                                                            <div class="col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3 ">
                                                                <div class="col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3 ">
                                                                    <div class="col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3 ">
                                                                        <div class="col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3 ">
                                                                            <input type="hidden" name="consecutivo_pago" id="consecutivo_pago">
                                                                            <input type="hidden" name="documento_yeminus" id="documento_yeminus">
                                                                            <input type="hidden" name="prefijo" id="prefijo">
                                                                            <input type="hidden" name="tipoDocumento" id="tipoDocumento">
                                                                            <input type="hidden" name="input_pagar_minimo" id="input_pagar_minimo">
                                                                            <input type="hidden" name="input_pagar_total" id="input_pagar_total">
                                                                            <input type="hidden" name="input_mora" id="input_mora">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-default btn-xs d-none" data-dismiss="modal">Salir</button>
                                        <button type="submit" class="btn btn-success btn-xs btn_pagar_cuotas" disabled style="font-size:36px !important"> Continuar </button>
                                    </div>
                                    <div class="pagos row">
                                    </div>
                                </div>
                                <div class="col-6 col-sm-6 col-md-6 col-lg-3 col-xl-6 pt-4">
                                    <div class="mt-2">
                                        <label class="pagar_minimo text-gray"> 0 </label>
                                    </div>
                                    <div class="mt-2">
                                        <label class="pagar_total text-gray"> 0 </label>
                                    </div>
                                    <div class="mt-2">
                                        <input type="number" name="otro_valor" id="otro_valor" class="form-control" placeholder="Ingresa el valor" disabled>
                                    </div>
                                </div>
                                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-lg-6 col-xl-12 box_intereses">
                                    <div class="col-12 d-none">
                                        <br>
                                        <div class="box_tabla_intereses_mora table-responsive text-center" id="box_tabla_intereses_mora">
                                            <span class="badge bg-danger">* Cuando se ingrese el valor que se va a pagar. <br>primero se aplica el interés mora y el restante se aplicará a la cuota. </span>
                                            <table id="tabla_intereses_mora" class="table table-hover" style="margin: 0px; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Mes</th>
                                                        <th>Dias</th>
                                                        <th>Acumulado</th>
                                                        <th>Interés</th>
                                                        <th>Total + Interés</th>
                                                        <th>%</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<?php
    } else {
        require 'noacceso.php';
    }
    require 'footer_estudiante.php';
}
ob_end_flush();
?>
<script src="../public/datatables/dataTables.bootstrap4.min.js"></script>
<script src="../public/datatables/responsive.bootstrap4.min.js"></script>
<script type="text/javascript" src="scripts/financiacion.js"></script>
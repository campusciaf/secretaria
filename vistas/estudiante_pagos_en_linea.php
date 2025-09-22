<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 13;
    $seccion = "Otros Pagos";
    require 'header_estudiante.php';
?>
    <link rel="stylesheet" href="../public/css/pure-tabs.css">
    <div id="precarga" class="precarga"></div>
    <div class="content-wrapper ">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="m-0 line-height-16">
                            <span class="fs-16 f-montserrat-regular pl-2">Recibimos todos los medios pagos</span>
                        </h2>
                    </div>
                    <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
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
        <section class="container-fluid">
            <div class="row">
                <div class="col-3">
                    <div class="redondeado bg-morado text-white m-3 p-4 renovacion_sticky">
                        <h2 class="mt-3 mb-3"> Financiación Matrícula</h2>
                        <h5 class="text-right font-weight-normal"> <span class="btn-sm mb-3 bg-morado-oscuro rounded-pill pl-3 pr-3">Activa</span> </h5>
                        <h3 class="font-weight-normal mb-3"> $ 672.000,00</h3>
                        <h6 class="font-weight-normal mb-4">Fecha limite de Pago: sábado, 3 de mayo de 2025</h6>
                        <h6 class="font-weight-normal"> Opciones de pago </h6>
                        <form action="#" method="POST" id="formularioCuota">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <div class="card-body pt-1 ">
                                        <label class="label-pilled">
                                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="pago_minimo" checked="">
                                            <span class="text-white">Pago Mínimo(cuota)</span>
                                        </label>
                                        <br>
                                        <label class="label-pilled">
                                            <input type="radio" name="optionsRadios" id="optionsRadios2" value="pago_total">
                                            <span class="text-white">Pago Total</span>
                                        </label>
                                        <br>
                                        <label class="label-pilled">
                                            <input type="radio" name="optionsRadios" id="optionsRadios3" value="pago_parcial">
                                            <span class="text-white">Otro Valor</span>
                                        </label>
                                        <div class="form-group mb-3 position-relative check-valid div_otro_valor" style="display: none;">
                                            <div class="form-floating">
                                                <input type="text" name="otro_valor" id="otro_valor" value="" class="form-control" disabled="">
                                                <label>Ingresa el valor</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 px-3">
                                    <button class="btn btn-lg btn-block btn-success rounded-pill font-weight-bold mb-4" type="submit"> Pagar Cuota </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-9">
                    <div id="listadoCuotasActuales" class="mt-3">

                    </div>
                    <div class="row" id="tipos_pagos_en_linea">

                    </div>
                    <div class="row" id="factura_de_pago">
                        <div class="mx-auto col-7 mt-3">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="fw-bold h5 text-center mb-0"> Detalle de la transacción </h3>
                                </div>
                                <div class="card-body p-1" style="display: block;">
                                    <div class="row">
                                        <div class="products-list product-list-in-card pl-2 pr-2 col-xl-12" style="padding-left:24px !important">
                                            <div class="item">
                                                <span class="product-title">Descripción Compra</span>
                                                <br>
                                                <span class="nombre_pago_en_linea"> --------- </span>
                                            </div>
                                        </div>
                                        <div class="css-1a5jqy3" style="width: 96%; border-top: 1px dashed rgb(172, 172, 172); margin:auto"></div>
                                        <div class="products-list product-list-in-card pl-2 pr-2 col-12" style="padding-left:24px !important">
                                            <div class="item">
                                                <span class="product-title">Cantidad</span>
                                                <br>
                                                <span class="cantidad_semestres">
                                                    <select class="form-control" name="cantidad_semestres" id="cantidad_semestres" onchange="calcularNuevaCantidad(this.value)">
                                                        <option selected value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option value="10">10</option>
                                                    </select>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="css-1a5jqy3" style="width: 96%; border-top: 1px dashed rgb(172, 172, 172); margin:auto"></div>
                                        <div class="products-list product-list-in-card pl-2 pr-2 col-12" style="padding-left:24px !important">
                                            <div class="item">
                                                <span class="product-title">Número de Documento</span>
                                                <br>
                                                <span class="numero_documento">
                                                    ---------
                                                </span>
                                            </div>
                                        </div>
                                        <div class="css-1a5jqy3" style="width: 96%; border-top: 1px dashed rgb(172, 172, 172); margin:auto"></div>
                                        <div class="products-list product-list-in-card pl-2 pr-2 col-12" style="padding-left:24px !important">
                                            <div class="item">
                                                <span class="product-title">Nombre Completo</span>
                                                <br>
                                                <span class="nombre_completo">
                                                    ------------
                                                </span>
                                            </div>
                                        </div>
                                        <div class="css-1a5jqy3" style="width: 96%; border-top: 1px dashed rgb(172, 172, 172); margin:auto"></div>
                                        <div class="products-list product-list-in-card pl-2 pr-2 col-12" style="padding-left:24px !important">
                                            <div class="item">
                                                <span class="product-title">Celular</span>
                                                <br>
                                                <span class="celular_estudiante">
                                                    ------------
                                                </span>
                                            </div>
                                        </div>
                                        <div class="css-1a5jqy3" style="width: 96%; border-top: 1px dashed rgb(172, 172, 172); margin:auto"></div>
                                        <div class="products-list product-list-in-card pl-2 pr-2 col-12" style="padding-left:24px !important">
                                            <div class="item">
                                                <span class="product-title">Valor a Pagar</span>
                                                <br>
                                                <span class="valor_transaccion">
                                                    ----------
                                                </span>
                                            </div>
                                        </div>
                                        <div class="css-1a5jqy3" style="width: 96%; border-top: 1px dashed rgb(172, 172, 172); margin:auto"></div>
                                        <div class="products-list product-list-in-card pl-2 pr-2 col-12" style="padding-left:24px !important">
                                            <span class="product-title mt-2">Formas de pago:</span>
                                            <div class="item botones_pago">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-danger col-12 my-3" onclick="volverTiposPagosEnLinea()"> <i class="fas fa-hand-point-left"></i> Volver </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php
    require 'footer_estudiante.php';
}
ob_end_flush();
?>
<script src="scripts/estudiante_pagos_en_linea.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 11;
    require 'header_estudiante.php';
?>

    <div id="precarga" class="precarga"></div>
    <div class="content-wrapper ">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-xl-10 col-9">
                        <h2 class="m-0 line-height-16">
                            <span class="titulo-2 fs-18 text-semibold">Pagos</span><br>
                            <span class="fs-14 f-montserrat-regular">Hacer tus pagos desde la comodidad de su casa nunca fue tan facil</span>
                        </h2>
                    </div>
                    <div class="col-xl-2 col-3 pt-4 pr-4 text-right">
                        <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'> <i class="fa-solid fa-play"></i> Tour </button>
                    </div>
                </div>
                <div class="col-12 migas">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="panel_estudiante.php">Inicio</a></li>
                      <li class="breadcrumb-item active">Pagos</li>
                    </ol>
              </div>
            </div>
        </div>
        <section class="container-fluid px-4">
            <div class="row">
                <div class="col-12 text-center py-4">
                    <h3 class="titulo-3 text-bold fs-24">Realiza <span class="text-gradient">Tus pagos</span> de manera <span class="text-gradient">Segura </span> desde tu plataforma institucional </h3>
                    <span class="fs-14 f-montserrat-regular">¡Estamos comprometidos a hacer que el proceso de compra sea lo más sencillo y seguro posible para ti!</span>
                </div>

                <div class="col-12">
                    <div class="row listadoConceptos">

                    </div>
                </div>
            </div>
        </section>
        <div class="modal fade" id="gestionPago" tabindex="-1" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title ">Detalle de la transacción</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="precarga" id="precarga"></div>
                        <div class="container-fluid">
                            <form class="row" id="datos_boton_epayco" action="#">
                                <div class="products-list product-list-in-card px-3 col-12">
                                    <div class="py-2">
                                        <span class="product-title">Ref. Pago</span>
                                        <input name="id_conceptos_pago" class="id_conceptos_pago form-control form-control-sm" readonly style="border:none !important">
                                    </div>
                                </div>
                                <div class="products-list product-list-in-card px-3 col-12">
                                    <div class="py-2">
                                        <span class="product-title">Descripción</span><br>
                                        <input name="conceptos_pago_nombre" class="conceptos_pago_nombre form-control form-control-sm" readonly style="border:none !important">
                                    </div>
                                </div>
                                <div class="products-list product-list-in-card px-3 col-12">
                                    <div class="py-2">
                                        <span class="product-title">Valor Total</span>
                                        <input name="conceptos_pago_valor" class="conceptos_pago_valor form-control form-control-sm" readonly style="border:none !important">
                                    </div>
                                </div>
                                <div class="products-list product-list-in-card px-3 col-12">
                                    <div class="py-2">
                                        <span class="product-title">Cantidad</span>
                                        <span class="product-description">
                                            <select name="cantidad_productos" id="cantidad_productos" class="form-control form-control-sm cantidad_productos">
                                                <option value='1' selected> 1 </option>
                                                <option value='2'> 2 </option>
                                                <option value='3'> 3 </option>
                                                <option value='4'> 4 </option>
                                                <option value='5'> 5 </option>
                                                <option value='6'> 6 </option>
                                                <option value='7'> 7 </option>
                                                <option value='8'> 8 </option>
                                                <option value='9'> 9 </option>
                                                <option value='10'> 10 </option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                                <div class="products-list product-list-in-card px-3 col-12">
                                    <div class="py-2">
                                        <span class="product-title">Medio de pago</span>
                                        <span class="product-description">
                                            <select name="medio_pago" id="medio_pago" class="form-control form-control-sm medio_pago" onchange="mostrarBotonesEpayco()">
                                                <option value="" disabled selected>- elige un medio de pago -</option>
                                                <option value="efectivo"> Efectivo </option>
                                                <option value="pse"> PSE y Tarjeta </option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                                <div class="products-list product-list-in-card px-3 col-12">
                                    <div class="boton_epayco py-2">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
    require 'footer_estudiante.php';
}
ob_end_flush();
?>
<script src="scripts/pagogeneral.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
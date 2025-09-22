<?php
session_start();
ob_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header('Location: ../');
    exit();
} else {
    $menu = 2;
    $submenu = 221;
    require 'header.php';
    if ($_SESSION['metodologia_poa_general'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-8 col-lg-7 col-md-8 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">CRONOGRAMA POA</span><br>
                                <span class="fs-16 f-montserrat-regular">Establezca, ejecute y vigile el cumplimiento de nuestro propósito superior</span>
                            </h2>
                        </div>
                        <div class="col-xl-4 col-lg-5 col-md-4 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" data-bs-toggle="tooltip" data-bs-placement="top" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">CRONOGRAMA</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-xl-5 col-lg-4 col-md-4 col-6 ">
                <div class="form-group mb-3 position-relative check-valid">
                    <div class="form-floating">
                        <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="usuario" id="usuario" onchange="listar(this.value)"></select>
                        <label>Usuario</label>
                    </div>
                </div>
            </div>



            <div class="col-xl-12 col-lg-12 col-md-12 col-12" id="contenido"></div>

            <!-- <section class="content" style="padding-top: 0px;" id="ver_proyectos">
                <div class="row card" style="padding: 2% 1%">
                    <div class="row" id="contenido">
                    </div>
                </div>
            </section> -->
        </div>


        <!-- Modal Crear accion -->
        <div class="modal" id="ModalAccion">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">GESTIÓN POA</h6>
                        <button type="button" class="close" data-dismiss="modal" >&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="panel-body p-3">
                            <form name="formularioaccion" id="formularioaccion" method="POST">
                            
                                <div class="col-xl-12 col-lg-6 col-md-12 col-sm-12">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <textarea rows="3" type="text" placeholder="" value="" class="form-control border-start-0" name="nombre_accion" id="nombre_accion" required></textarea>
                                            <label>¿Cómo?</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                <div class="row">

                                    
                                    <div class="col-sm">
                                        <div class="col-xl-12 col-lg-6 col-md-12 col-sm-12">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="form-floating">
                                                    <input type="date" required class="form-control border-start-0" name="fecha_fin" id="fecha_fin">
                                                    <label for="fecha_fin">Cuando:</label>
                                                    </input>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback">Please enter valid input</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-6 col-md-12 col-sm-12">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <input type="time" class="form-control border-start-0" name="hora_accion" id="hora_accion" required>
                                            <label for="hora_accion">Hora</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Por favor, ingrese una hora válida</div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <input type="hidden" name="id_usuario" id="id_usuario">
                                    <input type="number" class="d-none id_meta" id="id_meta" name="id_meta">
                                    <input type="number" class="d-none id_accion" id="id_accion" name="id_accion">
                                    <button class="btn btn-success btn-block" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>





        </div>
        </div>
    <?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
    ?>
    <script type="text/javascript" src="scripts/metodologia_poa_general.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
ob_end_flush();
?>
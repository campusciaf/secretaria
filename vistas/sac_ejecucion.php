<?php
    session_start();
    ob_start();
    if (!isset($_SESSION["usuario_nombre"])) {
        header('Location: ../');
        exit();
    } else {
        $menu = 2;
        $submenu = 214;
        require 'header.php';
        if ($_SESSION['sac_ejecucion'] == 1) {
?>
            <div id="precarga" class="precarga"></div>
                <div class="content-wrapper">
                    <div class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-xl-8 col-lg-7 col-md-8 col-9">
                                    <h2 class="m-0 line-height-16">
                                        <span class="titulo-2 fs-18 text-semibold">Plan operativo 2023</span><br>
                                        <span class="fs-16 f-montserrat-regular">Establezca, ejecute y vigile el cumplimiento de nuestro propósito superior</span>
                                    </h2>
                                </div>
                                <div class="col-xl-4 col-lg-5 col-md-4 col-3 pt-4 pr-4 text-right">
                                    <button class="btn btn-sm btn-outline-warning px-2 py-0" data-bs-toggle="tooltip" data-bs-placement="top" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                                </div>
                                <div class="col-12 migas">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                        <li class="breadcrumb-item active">Plan operativo 2023</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <section class="content" style="padding-top: 0px;" id="ver_proyectos">
                        <div class="row card" style="padding: 2% 1%" >
                            <div class="row" id="contenido">
                            </div>
                        </div>
                    </div>
                    <!-- Modal Crear Proyecto -->
                    <div class="modal" id="ModalAccion">
                        <div class="modal-dialog modal-md modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title">Crear Acción</h6>
                                    <button type="button" class="close" data-dismiss="modal" onclick="cancelarform()">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="panel-body p-3">
                                        <form name="formularioaccion" id="formularioaccion" method="POST">
                                            <div class="col-xl-12 col-lg-6 col-md-12 col-sm-12">
                                                <div class="form-group mb-3 position-relative check-valid">
                                                    <div class="form-floating">
                                                        <input type="text" placeholder="" value="" class="form-control border-start-0" name="nombre_accion" id="nombre_accion" required>
                                                        <label>Nombre</label>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">Please enter valid input</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm">
                                                    <div class="col-xl-12 col-lg-6 col-md-12 col-sm-12">
                                                        <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                                <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="fecha_accion" id="fecha_accion">
                                                                    <label>Desde:</label>
                                                                    <?php
                                        
                                                                    $meses = array( "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre","Noviembre","Diciembre");

                                                                    for ($a = 0; $a <= 11; $a++) {     
                                                                            
                                                                    ?>
                                                                    <option value="<?php echo $a+1; ?>" name="<?php echo $meses[$a]; ?>"><?php echo $meses[$a]; ?></option>
                                                                    
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="invalid-feedback">Please enter valid input</div>
                                                    </div>
                                                </div>
                                                <div class="col-sm">

                                                    <div class="col-xl-12 col-lg-6 col-md-12 col-sm-12">
                                                        <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                                <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="fecha_fin" id="fecha_fin">
                                                                    <label>Hasta:</label>
                                                                    <?php
                                                                    for ($a = 0; $a <= 11; $a++) {
                                                                        ?>
                                                                        <option value="<?php echo $a+1; ?>" name="<?php echo $meses[$a]; ?>"><?php echo $meses[$a]; ?></option>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="invalid-feedback">Please enter valid input</div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
        <script type="text/javascript" src="scripts/sacejecucion.js"></script>
       
    
    <?php
    }
    ob_end_flush();
    ?>
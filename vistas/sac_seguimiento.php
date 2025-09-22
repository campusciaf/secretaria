    <?php
    //Activamos el almacenamiento en el buffer
    ob_start();
    session_start();
    if (!isset($_SESSION["usuario_nombre"])) {
        header("Location: ../");
    } else {
        $menu = 2;
        $submenu = 215;
        require 'header.php';
        if ($_SESSION['sac_listar_dependencia'] == 1) {
            /* require_once "../modelos/SacObjectivosGenerales.php";
                $sacobjetivosgenerales = new SacObjectivosGenerales();
                date_default_timezone_set("America/Bogota");	
                $fecha = date('Y-m-d');
                $hora = date('H:i:s'); */
    ?>
        <div id="precarga" class="precarga"></div>
            <div class="content-wrapper">
                <!-- Main content -->
                <div class="content-header col-xl-12">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">
                                Ejecución por usuario
                                <input type="hidden" id="id_usuario" value="<?php echo $_GET["id_usuario"];?>">
                                <input type="hidden" id="usuario_cargo" value="<?php echo $_GET["usuario_cargo"];?>">
                                <input type="hidden" id="id_cargo" value="<?php echo $_GET["id_cargo"];?>">

                                </h1>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                    <li class="breadcrumb-item active">Gestión compromisos</li>
                                </ol>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->
                </div>

                <section class="content" style="padding-top: 0px;">
                    <div class="row">
                        <div class="contenido col-12">
                                <a href="sac_listar_dependencia.php" class="btn btn-danger col-2 float-sm-right"><i class="fas fa-arrow-left"> </i>  Volver</a>
                            <div class="accordion" id="volverbtncondicion">
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </section>

                <section class="content" style="padding-top: 0px;">
                    <div class="row">
                        <div class="contenido col-12">
                        
                                <span id="" class="tllistadoejecucion panel-body table-responsive">
                                    <div class="accordion" id="listarejecucion">
                                    </div>

                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <!--Fin-Contenido-->
            <!-- The Modal -->
            <!-- Modal Crear Ejecucion -->
            <div class="modal fade" id="ModalEjecucion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Crear Ejecución</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="formularioejecucion" id="formularioejecucion" method="POST" enctype="multipart/form-data">
                                <div class="form-group col-xl-12 col-lg-6 col-md-12 col-sm-12">
                                    <label for="exampleInputtext">Nombre</label>
                                    <input type="text" class="form-control" id="nombre_accion" name="nombre_accion" placeholder="Nombre Acción">
                                </div>
                            
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm">
                                            <label>Desde:</label>
                                            <select class="form-control" name="fecha_accion" id="fecha_accion" required='fecha_accion'>
                                                <option value=""  selected disabled> -- Selecciona un mes -- </option>
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
                                        <div class="col-sm">
                                                <label>Hasta:</label>
                                            <select class="form-control" name="fecha_fin" id="fecha_fin" required='fecha_fin'>
                                                <option value=""  selected disabled> -- Selecciona un mes -- </option>
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
                                </div>
                    
                                <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                    <input type="number" class="d-none id_meta" id="id_meta" name="id_meta">
                                    <input type="number" class="d-none id_accion" id="id_accion" name="id_accion">
                                    <button type="submit" class="btn btn-primary mt-4" id="btnGuardarEjecucion"> <i class="fa fa-save"></i> Guardar </button>
                                </div>    
                            </form>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                </div>
            </div>  

            <!-- MODAL DE EVIDENCIAS-->
            <div class="modal" id="modal_evidencia" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Evidencia</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="formularievidencia" id="formularievidencia" method="POST" enctype="multipart/form-data">
                            <div class="form-group col-xl-12 col-lg-6 col-md-12 col-sm-12">
                                <label for="exampleInputtext">Subir Evidencia</label>
                                <input type="file" class="form-control" id="foto" name="foto" placeholder="Evidencia" required>
                            </div>
                            
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                            <input type="hidden" class="d-none id_meta" id="id_meta" name="id_meta">
                            <button type="submit" class="btn btn-primary" id="btnGuardarEvidencia" ><i class="fa fa-save"></i> Guardar</button>
                        </div>

                        </form>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger float-right" data-dismiss="modal">Close</button>
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
        <script type="text/javascript" src="scripts/sacseguimiento.js"></script>
        <script>
    $(document).ready(function () {
        $('#reco').on('input change', function () {
            if ($(this).val() != '') {
                $('#submit').prop('disabled', false);
            }
            else {
                $('#submit').prop('disabled', true);
            }
        });
    });
</script>
        <style>
            .style-3::-webkit-scrollbar-track {
                -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
                background-color: #F5F5F5;
            }

            .style-3::-webkit-scrollbar {
                width: 6px;
                background-color: #F5F5F5;
            }

            .style-3::-webkit-scrollbar-thumb {
                background-color: #000000;
            }
        </style>
    <?php
    }
    ob_end_flush();
    ?>
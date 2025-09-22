    <?php
    //Activamos el almacenamiento en el buffer
    ob_start();
    session_start();
    if (!isset($_SESSION["usuario_nombre"])) {
        header("Location: ../");
    } else {
        $menu = 2;
        $submenu = 212;
        require 'header.php';
        if ($_SESSION['sac_planeacion'] == 1) {
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
                                    Proyecto
                                    <button class="btn btn-success btn-flat btn-sm" data-toggle="modal" data-target="#ModalCrearObjetivosGenerales"> Agregar Proyecto</button>
                                </h1>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                    <li class="breadcrumb-item active">Gestión compromisos</li>
                                    <li class="breadcrumb-item"><a href="sac_ejes_estrategicos.php">Atras</a></li>
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
                            <div class="card card-primary" style="padding: 2% 1%">
                                <a href="sac_ejes_estrategicos.php" class="btn btn-danger col-xs-4 col-sm-4 col-md-4"><i class="fas fa-arrow-left"> </i> Volver</a>
                                <span id="" class="tllistado mt-2">
                                    <div class="accordion" id="listadoregistrosobjetivosgenerales">
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
            <!-- Modal Crear Objetivos GENERALES -->
            <div class="modal fade" id="ModalCrearObjetivosGenerales" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Crear Proyecto</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="formularioobjetivosgenerales" id="formularioobjetivosgenerales" method="POST">
                                <div class="form-group">
                                    <label for="exampleInputtext">Nombre</label>
                                    <input type="text" class="form-control" id="nombre_objetivo" name="nombre_objetivo" placeholder="Nombre Proyecto">
                                </div>
                                <div>
                                    <input type="number" class="d-none" id="id_ejes" name="id_ejes" value="<?php echo $_GET["id_ejes"] ?>">
                                    <input type="number" class="d-none id_objetivo_general" id="id_objetivo_general" name="id_objetivo">
                                </div>
                                <button type="submit" class="btn btn-primary" id="btnGuardarObjetivoGeneral"><i class="fa fa-save"></i> Guardar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Crear Objetivos ESPECIFICOS -->
            <div class="modal fade" id="ModalCrearObjetivosEspecifico" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel1">Crear Obejtivo Especifico</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="#" name="formularioobjetivosespecifico" id="formularioobjetivosespecifico" method="POST">
                                <div class="form-group">
                                    <label for="exampleInputtext">Nombre</label>
                                    <input type="text" class="form-control" id="nombre_objetivo_especifico" name="nombre_objetivo_especifico" placeholder="Nombre Objetivo">
                                </div>
                                <div>
                                    <input type="number" class="d-none" id="id_objetivo" name="id_objetivo">
                                    <input type="number" class="d-none" id="id_objetivo_especifico" name="id_objetivo_especifico">
                                </div>
                                <button type="submit" class="btn btn-primary" id="btnGuardarObjetivoEspecifico"><i class="fa fa-save"></i> Guardar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal Meta -->
            <div class="modal" id="myModalMeta">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Crear Meta</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <form name="formularioguardometa" id="formularioguardometa" method="POST">
                                <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                    <label>Nombre de la meta</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="meta_nombre" id="meta_nombre" maxlength="255" placeholder="Nombre de la meta" onchange="javascript:this.value=this.value.toUpperCase();" required>
                                    </div>
                                </div>

                                <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                    <label>Condiciones Institucionales:</label>
                                    <div class="box_condiciones_institucionales form-check">

                                    </div>
                                    <label>Condiciones De programa:</label>
                                    <div class="condiciones_programa form-check" id="condiciones_programa">

                                    </div>

                                    <label>Corresponsable:</label>
                                    <div class="form-check" id="dependencias">

                                    </div>
                                    <div class="form-group col-xl-12 col-lg-6 col-md-12 col-sm-12">
                                        <label>Fecha:</label>
                                        <input type="date" class="form-control" name="meta_fecha" id="meta_fecha">
                                    </div>

                                    <div class="form-group col-xl-12 col-lg-6 col-md-12 col-sm-12">
                                        <label>Año:</label>
                                        <select class="form-control" name="anio_eje" id="anio_eje" required>
                                            <option value=""  selected disabled> -- Selecciona un año -- </option>
                                            <?php
                                                for ($i = 2021; $i <= 2030; $i++) {
                                            ?>
                                            <option value="<?php echo $i ?>" name="<?php echo $i ?>"><?php echo $i ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                        <label>Responsable:</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user-check"></i></span>
                                            </div>
                                            <select id="meta_responsable" name="meta_responsable" class="form-control selectpicker" data-live-search="true" data-style="border" required></select>
                                        </div>
                                    </div>

                                    <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                        <input type="text" class="d-none id_objetivo_especifico" name="id_objetivo_especifico">
                                        <input type="number" class="d-none id_meta" id="id_meta" name="id_meta">
                                        <button class="btn btn-primary" type="submit" id="btnGuardometa"><i class="fa fa-save"></i> Guardar</button>
                                    </div>
                            </form>
                            <!-- <div class="modal-body" id="resultadometas">resultado metas</div> -->
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="cancelarformmeta()">Cerrar</button>
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
        <script type="text/javascript" src="scripts/sacproyectocopia.js"></script>
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
        <script>
            mostrarIdEjes(<?php echo $_GET["id_ejes"] ?>);
        </script>
    <?php
    }
    ob_end_flush();
    ?>
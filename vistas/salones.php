<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();


if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 1;
    $submenu = 7;
    require 'header.php';
    if ($_SESSION['pea'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <!-- Main content -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Formatos</span><br>
                                <span class="fs-16 f-montserrat-regular">Gestione los formatos institucionales</span>
                            </h2>

                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0 primer_tour" onclick='iniciarTour()'><i
                                    class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Gestión de Formatos</li>
                            </ol>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <section class="content">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-4">
                        <div class="row">
                            <div class="col-12 card">
                                <div class="row">
                                    <div class="col-6 p-2 tono-3">
                                        <div class="row align-items-center">
                                            <div class="pl-3">
                                                <span class="rounded bg-light-blue p-3 text-primary ">
                                                    <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                            <div class="col-10">
                                                <div class="col-5 fs-14 line-height-18">
                                                    <span class="">Gestión de salones</span> <br>
                                                    <span class="text-semibold fs-20">Campus virtual</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 tono-3 text-right py-4 pr-4">
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal" onclick="nuevoSalon()">
                                            <i class="fas fa-plus-circle"></i> Agregar salon
                                        </button>
                                        </h1>
                                    </div>
                                    <div class="col-12 table-responsive p-2" id="listadoregistros">
                                        <table id="tbllistado" class="table" style="width: 100%;">
                                            <thead>
                                                <th>Opciones</th>
                                                <th>Salón</th>
                                                <th>Capacidad</th>
                                                <th>Tv</th>
                                                <th>Video Beam</th>
                                                <th>Piso</th>
                                                <th>Estado</th>
                                                <th>Formulario CRAILAB</th>
                                                <th>Accion</th>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- <div class="modal fade" id="ModalEditarSalones" tabindex="-1" aria-labelledby="exampleModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Editar Salón </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form name="formularioeditarsalones" id="formularioeditarsalones" method="POST"
                                                        enctype="multipart/form-data">

                                                        <div class="form-group col-12">
                                                            <label>Nombre Salón:</label><br>
                                                            <input type="text" class="form-control" name="nombre_salon_m"
                                                                id="nombre_salon_m" maxlength="100" placeholder="Nombre Salón" required>
                                                        </div>

                                                        <div class="form-group col-12">
                                                            <label>Capacidad:</label><br>
                                                            <input type="text" class="form-control" name="capacidad_salon"
                                                                id="capacidad_salon" maxlength="100" placeholder="Capacidad Salón" required>
                                                        </div>

                                                        <div class="form-group col-12">
                                                            <label>Piso:</label><br>
                                                            <input type="text" class="form-control" name="piso_salon_m" id="piso_salon_m"
                                                                maxlength="100" placeholder="Capacidad Salón" required>
                                                        </div>

                                                        <div class="form-group col-12">
                                                            <label>sede:</label><br>
                                                            <input type="text" class="form-control" name="sede" id="sede"
                                                                maxlength="100" placeholder="sede" required>
                                                        </div>
                                                        <div class="form-group col-12">
                                                            <label>Permiso Formulario </label>
                                                            <select class="form-control" id="estado_formulario" name="estado_formulario">
                                                                <option value="" selected disabled>Selecciona una opción</option>
                                                                <option value="0">No</option>
                                                                <option value="1">Si</option>
                                                            </select><br>
                                                        </div>
                                                        <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                                            <input type="text" class="d-noned id_oculto_salon" id="id_oculto_salon"
                                                                name="id_oculto_salon">
                                                            <button type="submit" class="btn btn-primary mt-4"> <i class="fa fa-save"></i>
                                                                Guardar </button>
                                                        </div>
                                                    </form>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->

                                    <!-- Modal agregarSalon-->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modal salón</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="guardarDatos" id="formguardaryeditarsalon" method="POST">
                                                        <div class="row">
                                                            <div class="form-group col-xl-12">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control" id="codigo_s" name="codigo_s" required>
                                                                        <label for="codigo_s">Salón</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-xl-12">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <input type="number" class="form-control" id="capacidad" name="capacidad" required>
                                                                        <label for="capacidad">Capacidad</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-xl-12">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <select class="form-control" id="piso" name="piso" required>
                                                                            <option value="" selected disabled></option>
                                                                            <option value="0">0</option>
                                                                            <option value="1">1</option>
                                                                            <option value="2">2</option>
                                                                            <option value="3">3</option>
                                                                            <option value="4">4</option>
                                                                            <option value="5">5</option>
                                                                        </select>
                                                                        <label for="piso">Piso</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-xl-12">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <select class="form-control" id="sede" name="sede">
                                                                            <option value="" selected disabled>Seleccione...</option>
                                                                            <option value="CIAF">CIAF</option>
                                                                            <option value="CRAI">CRAI</option>
                                                                            <option value="otro">Otro</option>
                                                                        </select>
                                                                        <label>Sede</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 d-none" id="sede_otro_wrap">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control" id="sede_otro" name="sede_otro">
                                                                        <label>Otro (especifique)</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-xl-12">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <select class="form-control" id="tv" name="tv" required>
                                                                            <option value="" selected disabled></option>
                                                                            <option value="1">Sí</option>
                                                                            <option value="0">No</option>
                                                                        </select>
                                                                        <label for="tv">Tiene TV</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-xl-12">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <select class="form-control" id="video_beam" name="video_beam" required>
                                                                            <option value="" selected disabled></option>
                                                                            <option value="1">Sí</option>
                                                                            <option value="0">No</option>
                                                                        </select>
                                                                        <label for="video_beam">Tiene Video Beam</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-xl-12">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <select class="form-control" id="estado_formulario" name="estado_formulario" required>
                                                                            <option value="" selected disabled>Selecciona una opción</option>
                                                                            <option value="0">No</option>
                                                                            <option value="1">Sí</option>
                                                                        </select>
                                                                        <label for="estado_formulario">Permiso Formulario</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <br>
                                                        <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                                            <input type="text" class="d-none id_oculto_salon" id="id_oculto_salon"
                                                                name="id_oculto_salon">
                                                            <button type="submit" class="btn btn-primary mt-4"> <i class="fa fa-save"></i>
                                                                Guardar </button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.content-wrapper -->
                                <!--Fin-Contenido-->



                            <?php
                        } else {
                            require 'noacceso.php';
                        }

                        require 'footer.php';
                            ?>

                            <script type="text/javascript" src="scripts/salones.js"></script>
                        <?php
                    }
                    ob_end_flush();
                        ?>
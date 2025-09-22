<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: login");
} else {
    $menu = 43;
    $submenu = 4302;
    require 'header.php';
    if ($_SESSION['puntos_asignar_billetera'] == 1) {
?>
        <div id="precarga" class="precarga" style="display: none;"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><small id="nombre_programa"></small>Puntos Billetera Docente</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Puntos Billetera Docente</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="container-fluid">
                <div class="row mx-0">
                    <div class="col-md-12">
                        <div class="card card-primary" style="padding: 2% 1%">
                            <div class="panel-body" id="listadoregistros">
                                <table id="tbllistado" class="table-responsive table table-hover table-nowarp">
                                    <thead>
                                        <th>Opciones</th>
                                        <th>Apellido</th>
                                        <th>Nombre</th>
                                        <th>Documento</th>
                                        <th>Celular</th>
                                        <th>Email CIAF</th>
                                        <th>Contrato</th>
                                        <th>Puntos</th>
                                        <th>Foto</th>
                                        <th>Estado</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="panel-body" id="formularioregistros">
                                <form name="formulario" class="row" id="formulario" method="POST">
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-6">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="punto_nombre" id="punto_nombre" maxlength="100">
                                                <label for="punto_nombre">Nombre Del Punto</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-6">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="number" placeholder="" value="" required="" class="form-control border-start-0" name="puntos_cantidad" id="puntos_cantidad" maxlength="100">
                                                <label for="puntos_cantidad">Cantidad Asignada</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-6">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="number" placeholder="" value="" required="" class="form-control border-start-0" name="punto_maximo" id="punto_maximo" maxlength="100">
                                                <label for="punto_maximo">Puntos Maximos por Estudiante</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-6">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="date" placeholder="" value="" required="" class="form-control border-start-0" name="punto_fecha_limite" id="punto_fecha_limite" maxlength="100" min="<?= date("Y-m-d") ?>">
                                                <label for="punto_fecha_limite">Fecha Limite Para Entregar</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <input type="hidden" name="id_docente" id="id_docente_puntos">
                                        <button class="btn btn-primary" type="submit" id="btnGuardar">
                                            <i class="fa fa-save"></i>
                                            Guardar
                                        </button>
                                        <button class="btn btn-danger" onclick="cancelarform()" type="button">
                                            <i class="fa fa-arrow-circle-left"></i>
                                            Cancelar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modalBilleterasDocente" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Billeteras Activas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-nowarp col-12">
                                <thead>
                                    <th> Nombre </th>
                                    <th> Cantidad </th>
                                    <th> Maximo </th>
                                    <th> Periodo </th>
                                    <th> Fecha Limite </th>
                                    <th> Creado </th>
                                </thead>
                                <tbody id="billeterasActivas">
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
<?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/puntos_asignar_billetera.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
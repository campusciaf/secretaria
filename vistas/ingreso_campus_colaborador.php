<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 22;
    $submenu = 2205;
    require 'header.php';
    if ($_SESSION['ingresocampuscolaborador']) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper ">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-6 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Ingresos campus</span><br>
                                <span class="fs-14 f-montserrat-regular">Control de ingresos usuarios en plataforma</span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Ingresos</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content" style="padding-top: 0px;">
                <div class="row">

                    <div class="col-xl-5 col-lg-4 col-md-4 col-12">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <select value="" required="" class="form-control border-start-0 selectpicker" data-live-search="true" name="colaboradores" id="colaboradores" onchange="listar()"></select>
                                <label>Colaboradores</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-4 col-12">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <input type="date" placeholder="" value="" required="" class="form-control border-start-0" id="fecha_ingreso" name="fecha_ingreso" onchange="listar()" value="<?php echo date("Y-m-d") ?>">
                                <label>Seleccionar Día</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>

                    <div class="col-xl-3">
                        <a class="btn btn-danger text-white py-3" onClick="sinIngresos()">Ver los que no ingresaron</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary" style="padding: 2%">
                            <table id="tbllistado" class="table table-striped table-compact table-sm table-hover ">
                                <thead>
                                    <tr>
                                        <th>#Ref</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>IP</th>
                                    </tr>
                                </thead>        
                            </table>
                        </div>
                    </div>
                </div>

            </section>

        </div>


        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <div id="resutados"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
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

    <script type="text/javascript" src="scripts/ingreso_campus_colaborador.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
ob_end_flush();
?>
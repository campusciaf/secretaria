<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 33;
    $submenu = 3310;
    require 'header.php';

    if ($_SESSION['web_funcionarios'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-6">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Web Funcionarios</span><br>
                                <span class="fs-16 f-montserrat-regular">Administra los funcionarios de la pagina web.</span>
                            </h2>
                        </div>
                        <div class="col-6 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" data-bs-toggle="tooltip" data-bs-placement="top" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Web Funcionarios</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="container-fluid px-4">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-4">
                        <div class="row">
                            <div class="card col-12">
                                <div class="row">
                                    <div class="col-6 p-4 tono-3" id="ocultargestionproyecto">
                                        <div class="row align-items-center">
                                            <div class="pl-4">
                                                <span class="rounded bg-light-blue p-3 text-primary ">
                                                    <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                            <div class="col-10">
                                                <div class="col-12 fs-14 line-height-18">
                                                    <span class="">Resultados</span> <br>
                                                    <span class="text-semibold fs-20">Web Funcionarios</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 text-right py-4 pr-4 tono-3">
                                        <!-- <button class="btn btn-success pull-right" id="tour_agregar_programas_descripcion" onclick="mostraragregarprogramas(true)"><i class="fa fa-plus-circle"></i> Agregar Descripción</button> -->
                                    </div>

                                    <div class="col-12" id="mostrar_funcionarios"></div>
            
                                    <div class="modal fade" id="ModalEditarFuncionario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-md modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Editar Funcionario</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form name="formularioeditarfuncionario" id="formularioeditarfuncionario" method="POST" enctype="multipart/form-data">
                                                        <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                                            <div class="mb-3 position-relative check-valid">
                                                                <div class="form-floating">
                                                                    <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="selec_funcionarios" id="selec_funcionarios">
                                                                        <label>Funcionarios</label>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter valid input</div>
                                                        </div>
                                                        <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                                            <input type="number" class="d-none id_web_cargos" id="id_web_cargos" name="id_web_cargos">
                                                            <button class="btn btn-success btn-block" type="submit" id="btnGuardar"><i class="fa fa-save" aria-hidden="true"></i> Guardar</button>
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

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


        </div>
    <?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/web_funcionarios.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
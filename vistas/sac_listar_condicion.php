<?php
session_start();
//Activamos el almacenamiento en el buffer
ob_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header('Location: ../');  // Redirige al usuario a la página de login
    exit();
} else {
    $menu = 2;
    $submenu = 216;
    require 'header.php';
    if ($_SESSION['sac_listar_condicion'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-8 col-lg-7 col-md-8 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Condiciones Institucionales y de programa</span><br>
                                <span class="fs-16 f-montserrat-regular"> Visualice las metas y acciones en función de las condiciones institucionales y de programa.</span>
                            </h2>
                        </div>
                        <div class="col-xl-4 col-lg-5 col-md-4 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" data-bs-toggle="tooltip" data-bs-placement="top" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Condiciones Institucionales y de programa</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content" style="padding-top: 0px;">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-4">
                        <div class="card col-xl-12 col-lg-12 col-md-12 col-12 ">
                            <div class="row ">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                    <div class="btn-group" role="group" aria-label="Basic example" style="margin: 10px;">
                                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                            <li class="nav-item" id="tour_grafico">
                                                <a class="nav-link active" onclick="buscar(1)" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Condiciones de Programa</a>
                                            </li>
                                            <li class="nav-item" id="tour_condiciones_institucionales">
                                                <a class="nav-link" onclick="buscar(2)" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Condiciones Institucionales</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 text-right">
                                    <form name="formulario" id="formulario" method="POST" class="row justify-content-end">
                                        <div class="form-group col-md-2 col-sm-6">
                                            <div class="form-floating">
                                                <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="periodo_seleccionado" id="periodo_seleccionado" onchange="actualizarPeriodo(this.value)">
                                                    <option value="0">General</option>
                                                    <option value="2025">2025</option>
                                                    <option value="2024">2024</option>
                                                    <option value="2023">2023</option>
                                                    <option value="2022">2022</option>
                                                </select>
                                                <label>Buscar periodo</label>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div id="tour_muestra_tabla" class="col-12 pr-4 text-right">
                                    <h5>
                                        <p id="opciones"><i class="fas fa-chart-pie float-right p-2 text-primary" aria-hidden="true"></i> <a id="tour_muestra_tabla" onclick="programa(1)"><i class="fas fa-table float-right p-2" aria-hidden="true"></i></a></p>
                                    </h5>

                                    <h5>
                                        <p id="opciones2"><i class="fas fa-chart-pie float-right p-2 text-primary" aria-hidden="true"></i> <a onclick="condiciones(1)"><i class="fas fa-table float-right p-2" aria-hidden="true"></i></a></p>

                                    </h5>
                                </div>
                                <div class="col-12 listar_condiciones_programa px-4"></div>
                                <div class="col-12" id="grafico1">
                                    <div id="chartContainer1" style="height: 370px; max-width: 920px; margin: 0px auto;">
                                    </div>
                                </div>
                                <div class="col-12" id="grafico2">
                                    <div id="chartContainer2" style="height: 370px; max-width: 920px; margin: 0px auto;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal nombre meta condicion de programa -->
                <div class="modal fade" id="myModalMetaCondicion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title">Condición de Programa</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <label class="id_con_pro"> </label>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal accion condicion de programa -->
                <div class="modal fade" id="myModalAccion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title" id="exampleModalLabel">Condición de Programa</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <label class="id_con_pro"> Nombre Acción: </label>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="myModalTareas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title" id="exampleModalLabel">Tareas</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <label class="mostrar_tareas"> Nombre Tarea: </label>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- modal nombre meta condicion por institucion -->
                <div class="modal fade" id="myModalNombreMetaInstitucional" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Condición Por Institución</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <label class="id_con_ins"> Nombre Meta: </label>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal nombre accion condicion por institucion -->
                <div class="modal fade" id="myModalAccionInstitucion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title" id="exampleModalLabel">Condición Por Institución</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <label class="id_accion_institucional"> Nombre Meta: </label>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
    ?>
    <script type="text/javascript" src="scripts/saclistarcondicion.js"></script>
    <script>
        $(document).ready(function() {
            $('#reco').on('input change', function() {
                if ($(this).val() != '') {
                    $('#submit').prop('disabled', false);
                } else {
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
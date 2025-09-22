<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["curso_docente"])) {
    header("Location: ../");
} else {
    $menu = 6;
    $submenu = 612;
    require 'header.php';
    if ($_SESSION['curso_docente'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper ">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-6 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Curso Docente</span><br>
                                <span class="fs-14 f-montserrat-regular">Gestione las preguntas de nuestro curso docente</span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas mb-0">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Gestión curso docente</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content p-4">
                <div class="row">
                    <div class="col-6 p-4">
                        <div class="row align-items-center">
                            <div class="pl-3">
                                <span class="rounded bg-light-blue p-3 text-primary ">
                                    <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                </span>
                            </div>
                            <div class="col-10">
                                <div class="col-5 fs-14 line-height-18">
                                    <span class="" id="lugar_tabla"> Gestión</span> <br>
                                    <span class="text-semibold fs-20">inducción Docente</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card p-1  panel-body table-responsive px-4" id="listadoregistros">
                            <table id="tbllistado" class="table table-hover ">
                                <thead class="text-center">
                                    <th> Video </th>
                                    <th> Categorias </th>
                                    <th> <button class="btn btn-light btn-sm" data-toggle="modal" data-target="#ModalAgregaryEditarCategoria"> <i class="fas fa-plus"></i> Crear Categoria</button> </th>
                                </thead>
                                <tbody class="text-center">
                                </tbody>
                            </table>
                        </div>
                        <div class="card p-1 panel-body table-responsive p-4" id="listadoPreguntas">
                            <div class="button_volver">
                                <button class="btn btn-danger btn-sm" onclick="volverCategorias()"> <i class="fas fa-hand-point-left"></i> Volver a categorias</button>
                            </div>
                            <table id="tbllistadoPreguntas" class="table table-hover ">
                                <thead class="text-center">
                                    <th> Pregunta </th>
                                    <th> Correcta </th>
                                    <th> Tipo </th>
                                    <th> <button class="btn btn-success btn-xs" id="btnagregar" onclick="mostrarform(true)">
                                            <i class="fa fa-plus-circle"></i>
                                            Agregar Pregunta
                                        </button> </th>
                                </thead>
                                <tbody class="text-center">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card panel-body px-4" id="formularioregistros">
                            <form name="formulario" id="formulario" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-12">
                                        <h6 class="title">Registro de Preguntas</h6>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input placeholder="" value="" required=""
                                                    class="form-control border-start-0" name="texto_pregunta"
                                                    id="texto_pregunta" rows="4"
                                                    onchange="javascript:this.value=this.value.toUpperCase();"></input>
                                                <label for="texto_pregunta">Texto de la Pregunta</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Por favor, ingresa un texto válido</div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <select required class="form-control border-start-0 selectpicker"
                                                    data-live-search="true" name="tipo_pregunta" id="tipo_pregunta"
                                                    onchange="cambiarOpciones()">
                                                    <option value="" selected disabled>Selecciona un tipo de
                                                        pregunta</option>
                                                    <option value="multiple">Opción Múltiple</option>
                                                    <option value="falsoVerdadero">Falso/Verdadero</option>
                                                </select>
                                                <label for="tipo_pregunta">Tipo de Pregunta</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Por favor, selecciona un tipo de pregunta
                                            válido</div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 d-none">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="number" required class="form-control border-start-0" name="categoria" id="categoria">
                                                <label for="categoria">Categoría</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="opcionesMultiples" class="col-12"
                                        style="display: none;">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group mb-3 d-flex align-items-center">
                                                    <div class="form-floating flex-grow-1 me-2">
                                                        <input id="opcion1" name="opcion1" class="form-control border-start-0" rows="1" placeholder=""></input>
                                                        <label for="opcion1">Opción 1</label>
                                                    </div>
                                                    <button type="button" class="btn btn-primary btn-sm btnSeleccionar" data-opcion="opcion1">Elige como correcta</button>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group mb-3 d-flex align-items-center">
                                                    <div class="form-floating flex-grow-1 me-2">
                                                        <input id="opcion2" name="opcion2" class="form-control border-start-0" rows="1" placeholder=""></input>
                                                        <label for="opcion2">Opción 2</label>
                                                    </div>
                                                    <button type="button" class="btn btn-primary btn-sm btnSeleccionar"
                                                        data-opcion="opcion2">Elige como correcta</button>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group mb-3 d-flex align-items-center">
                                                    <div class="form-floating flex-grow-1 me-2">
                                                        <input id="opcion3" name="opcion3" class="form-control border-start-0" rows="1" placeholder=""></input>
                                                        <label for="opcion3">Opción 3</label>
                                                    </div>
                                                    <button type="button" class="btn btn-primary btn-sm btnSeleccionar" data-opcion="opcion3">Elige como correcta</button>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group mb-3 d-flex align-items-center">
                                                    <div class="form-floating flex-grow-1 me-2">
                                                        <input id="opcion4" name="opcion4" class="form-control border-start-0" rows="1" placeholder=""></input>
                                                        <label for="opcion4">Opción 4</label>
                                                    </div>
                                                    <button type="button" class="btn btn-primary btn-sm btnSeleccionar" data-opcion="opcion4">Elige como correcta</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="opcionesFalsoVerdadero" style="display: none;"
                                        class="col-xl-6 col-lg-6 col-md-6 col-6">
                                        <div class="form-group mb-2 position-relative check-valid">
                                            <div class="d-flex align-items-center mb-2">
                                                <label for="respuestaVerdadero" class="me-2"></label>
                                                <input type="text" id="respuestaVerdadero" name="respuestaVerdadero" class="form-control me-2" placeholder="Ingrese Verdadero">
                                                <button type="button" class="btn btn-primary btn-sm btnSeleccionar" data-opcion="verdadero">Elige como correcta</button>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <label for="respuestaFalso" class="me-2"></label>
                                                <input type="text" id="respuestaFalso" name="respuestaFalso" class="form-control me-2" placeholder="Ingrese Falso">
                                                <button type="button" class="btn btn-primary btn-sm btnSeleccionar" data-opcion="falso">Elige como correcta</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 text-right p-2">
                                        <button class="btn btn-danger" onclick="cancelarform()" type="button">
                                            <i class="fa fa-arrow-circle-left"></i> Atras
                                        </button>
                                        <button class="btn btn-success" type="button" id="btnGuardar">
                                            <i class="fa fa-save"></i> Guardar
                                        </button>
                                    </div>
                                    <input type="hidden" id="opcion_correcta" name="opcion_correcta">
                                    <input type="hidden" name="id_pregunta" id="id_pregunta">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="modal fade" id="ModalVerVideo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tutorial</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form name="formulariovervideo" id="formulariovervideo" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div id="mostar_video_modal"></div>
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
        <div class="modal fade" id="ModalAgregaryEditarCategoria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="labelAgregaryEditarCategoria">Agregar Categoria</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form name="formularioAgregaryEditarCategoria" id="formularioAgregaryEditarCategoria" method="POST" enctype="multipart/form-data">
                            <div class="col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="hidden" name="id_induccion_docente_categoria" id="id_induccion_docente_categoria" />
                                        <input placeholder="" required class="form-control border-start-0" name="nombre_categoria" id="nombre_categoria" onchange="javascript:this.value=this.value.toUpperCase();"></input>
                                        <label for="nombre_categoria">Nombre de la categoria</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input placeholder="" required class="form-control border-start-0" name="enlace_video_categoria" id="enlace_video_categoria" />
                                        <!-- <input type="hidden" name="enlace_video_categoria" id="enlace_video_categoria"></input> -->
                                        <label for="enlace_video_completo">Enlace Youtube</label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success" id="btnGuardarCategoria"> Guardar </button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </form>
                    </div>
                </div>
                <!-- Modal footer -->
            </div>
        </div>
        <style>
            .dataTables_filter {
                width: 100%;
                text-align: center !important;
            }

            .dataTables_filter input {
                display: block;
                margin: 0 auto;
                text-align: center;
            }
        </style>
<?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/curso_docente.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
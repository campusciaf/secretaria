<?php
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $submenu = 3704;
    $menu = 38;
    require 'header.php';
    if ($_SESSION['gestion_servicio'] == 1) {
?>
<div id="precarga" class="precarga"></div>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Listado de empresas</span><br>
                        <span class="fs-16 f-montserrat-regular">Gestione el listado de las empresas vinculadas</span>
                    </h2>
                </div>
                <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                    <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i
                            class="fa-solid fa-play"></i> Tour</button>
                </div>
                <div class="col-12 migas">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Gestión Listado de empresas</li>
                    </ol>
                </div>
            </div>
        </div>
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
                                            <span class="">Listado de empresas</span> <br>
                                            <span class="text-semibold fs-20">Campus virtual</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 tono-3 text-right py-4 pr-4">
                                <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i
                                        class="fa fa-plus-circle"></i> Agregar empresa</button>
                            </div>
                            <div class="col-12 table-responsive p-2" id="listadoregistros">
                                <table id="tblistaofertalaboral" class="table" style="width: 100%;">
                                    
                                    <thead>
                                        <th>Opciones</th>
                                        <th>NIT</th>
                                        <th>Nombre empresa</th>
                                        <th>Área en la que prestará ss</th>
                                        <th>Representante legal</th>
                                        <th>Contacto</th>
                                        <th>Horario pactado</th>
                                        <th>Personas a cargo</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-12 panel-body" id="formularioregistros">
                                <form name="formulario_crearyeditarofertaslaborales"
                                    id="formulario_crearyeditarofertaslaborales" method="POST">
                                    <input type="number" class="d-none" id="id_usuario"
                                        name="id_usuario">
                                    <div class="row">
                                        <div class="col-12">
                                            <h6 class="title">Perfil de la empresa</h6>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="form-floating">
                                                <input type="text" placeholder="" value="" required
                                                class="form-control border-start-0" name="usuario_nit"
                                                id="usuario_nit" required>
                                            <label>NIT</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="form-floating">
                                                <input type="text" placeholder="" value="" required
                                                class="form-control border-start-0" name="usuario_nombre"
                                                id="usuario_nombre" required>
                                            <label>Nombre Empresa</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="form-floating">
                                                <input type="text" placeholder="" value="" required
                                                class="form-control border-start-0" name="usuario_area_ss"
                                                id="usuario_area_ss" required>
                                            <label>Área en la que prestará servicio social</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="form-floating">
                                                <input type="text" placeholder="" value="" required
                                                class="form-control border-start-0" name="usuario_representante"
                                                id="usuario_representante" required>
                                            <label>Nombre del representante</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="form-floating">
                                                <input type="text" placeholder="" value="" required
                                                class="form-control border-start-0" name="usuario_celular"
                                                id="usuario_celular" required>
                                            <label>Contacto del representante</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="form-floating">
                                                <input type="text" placeholder="" value="" required
                                                class="form-control border-start-0" name="usuario_horario_pactado"
                                                id="usuario_horario_pactado" required>
                                            <label>Horario pactado</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                        <div class="col-12 text-right mt-3">
                                            <button class="btn btn-danger" onclick="cancelarform()" type="button">
                                                <i class="fa fa-arrow-circle-left"></i> Atrás
                                            </button>
                                            <button class="btn btn-success" type="submit" id="btnGuardar">
                                                <i class="fa fa-save"></i> Guardar
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                         
                            <div class="modal" id="ModalListarPostulados">
                                <div class="modal-dialog modal-xl modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">
                                                <h6 class="modal-title">Postulados
                                            </h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="usuarios_postulados"></div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger"
                                                data-dismiss="modal">Cancelar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="modal" id="ModalMotivoEliminarPostulacion">
                                <div class="modal-dialog modal-md modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Eliminar postulación</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <form name="motivo_eliminacion" id="motivo_eliminacion" method="POST">
                                                <input type="number" class="d-none"
                                                    id="id_bolsa_empleo_oferta_desactivar_oferta"
                                                    name="id_bolsa_empleo_oferta_desactivar_oferta">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group mb-3">
                                                            <label for="motivo_finalizacion">Motivo Eliminación</label>
                                                            <input type="text" class="form-control"
                                                                name="motivo_finalizacion" id="motivo_finalizacion"
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-danger" type="button" data-dismiss="modal">
                                                        <i class="fa fa-arrow-circle-left"></i> Atrás
                                                    </button>
                                                    <button class="btn btn-success" type="submit"
                                                        id="btnGuardarmotivoeliminacion">
                                                        <i class="fa fa-save"></i> Guardar
                                                    </button>
                                                </div>
                                            </form>
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
 <script src="scripts/listado_empresa.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
                            <?php
}
ob_end_flush();
<?php //Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: login.html");
} else {
    $menu = 39;
    $submenu = 3901;
    require 'header.php';
    if ($_SESSION['hojadevidaadminfuncionarios'] == 1) {
?>

        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper ">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-6 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Hojas de vida de administrativos</span><br>
                                <span class="fs-14 f-montserrat-regular">Elige los perfiles y estilos profesionales que más se adapten a las necesidades y requerimientos de nuestra institución.</span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0 primer_tour" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas mb-0">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Hojas de vida</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-primary col-12 mx-0 mt-4" style="padding: 2%">
                <div class="panel-body table-responsive" id="listadoregistros">
                    <table id="tbllistado" class="table table-condensed table-hover" style="width:100%">
                        <thead>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Documento</th>
                            <th>Celular</th>
                            <th>Email</th>
                            <th>Titulo Obtenido</th>
                            <th>Hoja de vida</th>
                            <th>Fecha Ingreso</th>
                            <th>Estado</th>
                            <th>cargo al que aspira</th>
                            <th>% Avance pasos</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <!--FORMULARIO EDITAR-->
            <div class="card card-primary col-12 m-0" style="padding: 2%" id="formularioregistros">
                <form name="formulario" class="row" id="formulario" method="POST" enctype="multipart/form-data">
                    <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="cvadministrativos_nombre" id="cvadministrativos_nombre" maxlength="100" placeholder="Nombre Completo" required onchange="javascript:this.value=this.value.toUpperCase();">
                                <label>Nombres(*)</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>
                    <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="cvadministrativos_identificacion" id="cvadministrativos_identificacion" maxlength="100" placeholder="Nombre Completo" required>
                                <label> Número Identificación(*)</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>
                    <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="cvadministrativos_celular" id="cvadministrativos_celular" maxlength="100" placeholder="Celular" required>
                                <label> Celular(*)</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>
                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="cvadministrativos_correo" id="cvadministrativos_correo" maxlength="100" placeholder="Email" required>
                                <label> Email(*)</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>

                    </div>
                    <div class="col-xl-5 col-lg-4 col-md-4 col-6">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="cvadministrativos_cargo" id="cvadministrativos_cargo"></select>
                                <label>Cargo CIAF</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <input type="hidden" name="id_cvadministrativos" id="id_cvadministrativos">

                        <button class="btn btn-primary" type="submit" id="btnGuardar">
                            <i class="fa fa-save"></i> Guardar
                        </button>
                        <button class="btn btn-danger" onclick="cancelarform()" type="button"><i
                                class="fa fa-arrow-circle-left"></i> Cancelar</button>
                    </div>
                </form>
            </div>
            <!--FORMULARIO ENTREVISTA-->
            <div class="modal fade in" id="modal-default">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Citar Entrevista</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form role="form" method="post" name="form_entrevista" id="form_entrevista">
                                <div class="box-body">
                                    <input type="hidden" class="d-none" id="id_cvadministrativos_cv"
                                        name="id_cvadministrativos_cv">
                                    <div class="form-group">
                                        <label for="cvadministrativos_correo_cv">Correo Electronico:</label>
                                        <input type="email" class="form-control" id="cvadministrativos_correo_cv" name="cvadministrativos_correo_cv" placeholder="Ingresa correo del destinatario" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="cvadministrativos_entrevista_direccion">Dirección de la entrevista:</label>
                                        <select class="form-control" id="cvadministrativos_entrevista_direccion" name="cvadministrativos_entrevista_direccion" required>
                                            <option value="">Seleccione una dirección</option>
                                            <option value="CIAF">Sede CIAF(Cra 6 #24-56)</option>
                                            <option value="CRAI">Sede CRAI(calle 20 #4-57)</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="cvadministrativos_entrevista_fecha">Fecha de la entrevista:</label>
                                        <input type="date" class="form-control" id="cvadministrativos_entrevista_fecha" name="cvadministrativos_entrevista_fecha" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="cvadministrativos_entrevista_hora">Hora de la entrevista:</label>
                                        <input type="time" class="form-control" id="cvadministrativos_entrevista_hora" name="cvadministrativos_entrevista_hora" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="cvadministrativos_entrevista_comentario">Comentarios adicionales:</label>
                                        <input type="text" class="form-control" id="cvadministrativos_entrevista_comentario" name="cvadministrativos_entrevista_comentario" placeholder="">
                                    </div>
                                </div>
                                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success">Citar</button>
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
}
ob_end_flush();
    ?>
    <script type="text/javascript" src="scripts/cvadmin.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
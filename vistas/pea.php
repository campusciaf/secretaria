<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: login.html");
} else {
    $menu = 1;
    $submenu = 5;
    require 'header.php';
    if ($_SESSION['pea'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper ">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-6 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Proyectos Educativos de Aula</span><br>
                                <span class="fs-14 f-montserrat-regular">Da un vistazo a todos los proyectos educativos de aula de cada programa y su respectivo nivel</span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0 primer_tour" onclick='iniciarTour()'><i
                                    class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas mb-0">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                                <li class="breadcrumb-item active">PEA</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="container-fluid" style="padding-top: 0px;">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card card-primary" style="padding: 2%">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="form-floating">
                                    <select required="" class="form-control border-start-0 selectpicker"
                                        data-live-search="true" name="programa_ac" id="programa_ac"
                                        onChange="listar(this.value)"></select>
                                    <label>Seleccionar un programa</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please enter valid input</div>
                            <div class="panel-body table-responsive" id="listadoregistros">
                                <table id="tbllistado" class="table table-condensed table-hover" style="width:100%">
                                    <thead>
                                        <th>Crear</th>
                                        <th>Editar</th>
                                        <th>Pea Activo</th>
                                        <th>Nombre</th>
                                        <th>Semestre</th>
                                        <th>Area</th>
                                        <th>Creditos</th>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="row ml-1 mr-1">
                            <div class="col-12 table-responsive p-3" id="gestion_pea">
                                <div class="row">
                                    <div class="col-12">
                                        <button class="btn btn-info float-right " id="btnvolver" onclick="volver()">
                                            <i class="fa fa-angle-double-left"></i> Volver
                                        </button>
                                    </div>
                                </div>
                                <div id="tbllistadopea"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Formulario para gestionar contenido del pea-->
                    <div class="panel-body" id="formularioregistros">
                    </div>
                    <!-- *******************************************-->
                    <!--Fin centro -->
                </div><!-- /.box -->
            </section><!-- /.content -->
            <!--Fin-Contenido-->
            <div class="modal" id="myModalTema">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modalTitulo"></h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <form name="formulario" id="formulario" method="POST">
                                <input type="hidden" name="id_tema" id="id_tema" value="">
                                <input type="hidden" name="id_pea" id="id_pea" value="">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label>Conceptuales</label>
                                    <div class="input-group">
                                        <textarea id="conceptuales" name="conceptuales" rows="5" class="form-control"
                                            required></textarea>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                                    <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>
                                        Guardar</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="myModalReferencia">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modalTitulo"></h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <form name="formularioreferencia" id="formularioreferencia" method="POST">
                                <input type="hidden" name="id_pea_referencia" id="id_pea_referencia" value="">
                                <input type="hidden" name="id_pea_2" id="id_pea_2" value="">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label>Rerefencia</label>
                                    <div class="input-group">
                                        <textarea id="referencia" name="referencia" rows="5" class="form-control"
                                            required></textarea>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                                    <button class="btn btn-primary" type="submit" id="btnGuardarReferencia"><i
                                            class="fa fa-save"></i> Guardar</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- The Modal -->
            <div class="modal" id="myModalCrearPea">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Crear PEA</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div id="resultadocrearpea"></div>
                            <div class="panel-body" id="formularioregistroscrearpea">
                                <form name="formulariocrearpea" id="formulariocrearpea" method="POST">
                                    Crear la versión:
                                    <input type="hidden" name="id_materia" id="id_materia" value="">
                                    <input type="text" name="version" id="version" value=""
                                        style="width: 45px"><br><br>
                                    <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                        <label>Fecha de Aprobación</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-city"></i></span>
                                            </div>
                                            <input type="date" name="fecha_aprobacion" id="fecha_aprobacion"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <button class="btn btn-primary" type="submit" id="btnGuardarPea"><i
                                                class="fa fa-save"></i> Guardar</button>
                                        <button class="btn btn-danger" onclick="cancelarform()" type="button"><i
                                                class="fa fa-arrow-circle-left"></i> Cancelar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- The Modal -->
            <div class="modal" id="myModalPea">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Gestión PEA</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div id="resultado"></div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.content-wrapper -->

        <?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
        ?>
        <script type="text/javascript" src="scripts/pea.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
    <?php
}
ob_end_flush();
    ?>
<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
require_once "../modelos/MateriasPrograma.php";
$materiasprograma = new MateriasPrograma();
$programa = isset($_POST["programa"]) ? limpiarCadena($_POST["programa"]) : "";
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 1;
    $submenu = 4;
    require 'header.php';
    if ($_SESSION['materiasprograma'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper ">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1><span class="titulo-4"> Materias </span></h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="panel_admin.php"> Inicio </a></li>
                                <li class="breadcrumb-item active"> Gestión materias </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content" style="padding-top: 0px;">
                <div class="card card-primary" style="padding: 2% 1%">
                    <div class="row">
                        <div class="campo-select col-xl-4 col-lg-4 pb-2">
                            <select id="programa_ac" name="programa_ac" class="form-control selectpicker" data-live-search="true" onChange="listar(this.value)"></select>
                            </select>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Programa académico</label>
                        </div>
                        <div class="col-xl-4" id="btnagregar">
                            <button class="btn btn-success" onclick="mostrarform(true)">
                                <i class="fa fa-plus-circle"></i> Agregar Materias
                            </button>
                        </div>
                        <div class="col-xl-12 col-lg-12">
                            <div class="panel-body table-responsive" id="listadoregistros">
                                <hr>
                                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover compact table-sm" style="width:99%">
                                    <thead>
                                        <th>Acciones</th>
                                        <th>Nombre</th>
                                        <th>Semestre</th>
                                        <th>Area</th>
                                        <th>Creditos</th>
                                        <th>Codigo</th>
                                        <th>Presenciales</th>
                                        <th>Independiente</th>
                                        <th>Escuela</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card panel-body" id="formularioregistros" style="padding: 2% 1%">
                            <form name="formulario" id="formulario" method="POST">
                                <div class="row">
                                    <input type="hidden" name="id" id="id">
                                    <div class="form-group col-xl-6 col-lg-12 col-md-12 col-12 d-none">
                                        <label>Programa Académico</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                            </div>
                                            <select id="programa" name="programa" class="form-control selectpicker" data-live-search="true" required></select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-6 col-md-12 col-12">
                                        <label>Nombre Materia</label>
                                        <input type="text" class="form-control" name="nombre" id="nombre" maxlength="150" required>
                                    </div>
                                    <div class="form-group col-xl-2 col-lg-6 col-md-4 col-12">
                                        <label>Semestre</label>
                                        <input type="number" class="form-control" name="semestre" id="semestre">
                                    </div>
                                    <div class="form-group col-xl-2 col-lg-6 col-md-4 col-12">
                                        <label>Créditos</label>
                                        <input type="number" class="form-control" name="creditos" id="creditos">
                                    </div>
                                    <div class="form-group col-xl-2 col-lg-6 col-md-4 col-12">
                                        <label>Código</label>
                                        <input type="number" name="codigo" id="codigo2" class="form-control">
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-6 col-md-12 col-12">
                                        <label>Área</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                            </div>
                                            <select id="area" name="area" class="form-control selectpicker" data-live-search="true"></select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-3 col-lg-6 col-md-6 col-12">
                                        <label>Presenciales</label>
                                        <input type="number" class="form-control" name="presenciales" value=2>
                                    </div>
                                    <div class="form-group col-xl-3 col-lg-6 col-md-6 col-12">
                                        <label>Independiente</label>
                                        <input type="number" class="form-control" name="independiente" value=4>
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-6 col-md-12 col-12">
                                        <label>Escuela</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                            </div>
                                            <select id="escuela" name="escuela" class="form-control selectpicker" data-live-search="true" required></select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-3 col-lg-3 col-md-6 col-6">
                                        <label for="modelo">Modelo PAT</label><br>
                                        <select name="modelo" id="modelo" class="form-control selectpicker" data-live-search="true">
                                            <option value="0">Si</option>
                                            <option value="1">No</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-xl-3 col-lg-3 col-md-6 col-6">
                                        <label for="modalidad_grado">Modalidad grado</label><br>
                                        <select name="modalidad_grado" id="modalidad_grado" class="form-control selectpicker" data-live-search="true">
                                            <option value="0">Si</option>
                                            <option value="1">No</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-6 col-md-12 col-12">
                                        <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                                        <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- Modal modalidad de grado -->
        <div class="modal fade" id="modal_modalidad_grado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modalidades de grado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form name="fomaddmodalidad" id="fomaddmodalidad" method="POST">
                            <input type="text" name="id_materias_ciafi_modalidad" id="id_materias_ciafi_modalidad" class="d-none">
                            <input type="text" name="id_materia_add" id="id_materia_add" class="d-none">
                            <div class="group col-xl-12">
                                <input type="text" name="modalidad_add" id="modalidad_add" required />
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Nueva modalidad</label>
                            </div>
                            <div class="col-12">
                                <input type="submit" value="Agregar modalidad" class="btn btn-success btn-block">
                            </div>
                        </form>
                        <h3>Modalidades</h3>
                        <div id="resultado_modalidad"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">cerrar</button>
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
<script type="text/javascript" src="scripts/materiasprograma.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
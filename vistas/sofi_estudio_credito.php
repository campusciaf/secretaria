<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
date_default_timezone_set("America/Bogota");
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 23;
    $submenu = 2309;
    require 'header.php';
    if ($_SESSION['sofi_estudio_credito'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Estudio de créditos </h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="panel.php">Panel </a></li>
                                <li class="breadcrumb-item active">Estudio de créditos </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary" style="padding: 2% 1%">
                            <div class="panel-body table-responsive" id="listadoregistros">
                                <div class="input-group mb-2">
                                    <select name="input_periodo" id="input_periodo" class="form-control" onChange="listar(this.value)">
                                    </select>
                                </div>
                                <table id="tbllistado" class="table text-center">
                                    <thead>
                                        <th> Yeminus </th>
                                        <th> Opciones </th>
                                        <th> Data crédito </th>
                                        <th> Identificacion </th>
                                        <th> Nombres </th>
                                        <th> Apellidos </th>
                                        <th> Incluir Ingles </th>
                                        <th> Correo </th>
                                        <th> Celular </th>
                                        <th> Estado </th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="modal" id="modalAprobarTicket">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"> Tickets </h4>
                        <button type="button" class="close" data-dismiss="modal"> × </button>
                    </div>
                    <div class="modal-body">
                        <table id="box_tickets" class="table ">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Valor</th>
                                    <th>Fecha Limite </th>
                                    <th>Tipo </th>
                                    <th>Semestre</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="modaldetalle">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Detalle </h4>
                        <button type="button" class="close" data-dismiss="modal"> × </button>
                    </div>
                    <div class="modal-body">
                        <div id="resultado"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="modalAprobarEstudio">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Aprobar Estudio</h4>
                        <button type="button" class="close" data-dismiss="modal"> × </button>
                    </div>
                    <form action="#" method="POST" id="formAprobarEstudio">
                        <div class="form-group col-12 mt-2">
                            <label> Programa Aprobado: </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                </div>
                                <select class="form-control" name="id_programa_estudio" id="id_programa_estudio" data-live-search="true" data-style="border" required>
                                </select>
                                <input type="hidden" name="id_persona_estudio" id="id_persona_estudio">
                                <input type="hidden" name="periodo_pecuniario_estudio" id="periodo_pecuniario_estudio">
                                <input type="hidden" name="numero_documento_estudio" id="numero_documento_estudio">
                            </div>
                        </div>
                        <div class="col-12 mt-2 mb-3">
                            <input type="submit" class="btn btn-outline-success btnEstudio" value="Aprobar Estudio">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal" id="modalTicket">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Generar Ticket</h4>
                        <button type="button" class="close" data-dismiss="modal"> × </button>
                    </div>
                    <div class="modal-body">
                        <form name="formularioticket" id="formularioticket" method="POST" class="row">
                            <div class="form-group col-12">
                                <input type="hidden" id="id_ticket" name="id_ticket">
                                <input type="hidden" id="id_estudiante_credito" name="id_estudiante_credito">
                                <input type="hidden" id="id_persona_credito" name="id_persona_credito">
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 aporte_y_pecuniario">
                                <label>Precio Pecuniario </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                    </div>
                                    <input type="number" value="0" id="valor_pecuniario" name="valor_pecuniario" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 aporte_y_pecuniario">
                                <label>Aporte social </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                    </div>
                                    <input type="number" value="0" id="aporte_social" name="aporte_social" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <label>Agregar ingles </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                    </div>
                                    <select id="agregar_ingles" name="agregar_ingles" class="form-control" required>
                                        <option value="" selected disabled>Selecciona una opción</option>
                                        <option value="1">Si</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <label>Valor ingles </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                    </div>
                                    <input type="number" value="0" id="valor_ingles" name="valor_ingles" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <label>Descuento </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                    </div>
                                    <input type="number" value="0" id="porcentaje_descuento" name="porcentaje_descuento" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <label>Valor Programa </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                    </div>
                                    <input type="number" value="0" id="valor_total" name="valor_total" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <label>Valor Ticket </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                    </div>
                                    <input type="number" value="0" id="valor_ticket" name="valor_ticket" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <label>Valor financiación </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                    </div>
                                    <input type="number" value="0" id="valor_financiacion" name="valor_financiacion" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <label>Tipo de matrícula </label>
                                <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo_pago" id="opcion1" value="1">
                                    <label class="form-check-label" for="opcion1">Completa</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo_pago" id="opcion2" value="2">
                                    <label class="form-check-label" for="opcion2">Media</label>
                                </div>
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <label>Tiempo de pago </label>
                                <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tiempo_pago" id="opcion_tiempo1" value="ordinaria-e">
                                    <label class="form-check-label" for="opcion_tiempo1">Ordinaria</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tiempo_pago" id="opcion_tiempo2" value="extra-e">
                                    <label class="form-check-label" for="opcion_tiempo2">Extraordinaria</label>
                                </div>
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <label> Fecha limite </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                    </div>
                                    <input type="date" name="fecha_limite" id="fecha_limite" class="form-control" required value="<?= date("Y-m-d") ?>">
                                    <input type="hidden" name="ticket_semestre" id="ticket_semestre">
                                </div>
                            </div>
                            <button type="submit" id="btnNovedad" class="btn btn-info btn-block">Generar ticket</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal_datacredito" tabindex="-1" role="dialog" aria-labelledby="modal_datacredito_label">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-navy">
                        <h6 class="modal-title" id="modal_datacredito_label"> Generar Score Datacredito </h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <form class="col-12" action="#" id="formularioDatacredito" method="post">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <input type="hidden" id="id_persona_score" name="id_persona_score">
                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="datacredito_documento" id="datacredito_documento" maxlength="100">
                                            <label> Número de documento </label>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <input type="text" placeholder="" value="" class="form-control border-start-0" id="primer_apellido_datacredito" name="primer_apellido_datacredito">
                                            <label> Primer Apellido </label>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <input class="btn btn-success" value="Generar Score" type="submit" name="btnDatacredito" id="btnDatacredito">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .btn-outline-purple {
                color: #605ca8;
                border-color: #605ca8;
            }

            .btn-outline-purple:hover {
                color: white;
                background-color: #605ca8;
                border-color: #605ca8;
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
<script type="text/javascript" src="scripts/sofi_estudio_credito.js?<?= date("Y-m-d H:i:s") ?>"></script>
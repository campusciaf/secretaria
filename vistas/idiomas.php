<?php
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 6;
    $submenu = 1001;
    require 'header_estudiante.php';
?>
    <div id="precarga" class="precarga"></div>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><small id="nombre_programa">Idiomas</small></h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="panel_estudiante.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Idiomas</li>
                        </ol>
                    </div>
                    <!-- /.col -->
                </div>
            </div>
        </div>
        <input type="number" class="d-none nivel_cantidad" id="nivel_cantidad" name="nivel_cantidad">
        <input type="text" class="d-none texto_materias" id="texto_materias" name="texto_materias">
        <section class="content" style="padding-top: 0px;">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card card-primary" style="padding: 2%">
                        <div class="card-body p-0">
                            <div class="col">
                                <div class="card card-success">
                                    <div class="card-header">
                                        <h3 class="card-title"></h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body" id="conte" style="display: block;">
                                        <butto></butto>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /. box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
    </div><!-- /.content-wrapper -->

    <div id="conte_modales">
        <div class="modal fade exampleModal_una" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h4 class="modal-title">Pago de nivel</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
                    </div>
                    <div class="box-body bg-white">
                        <div class="row">
                            <div class="col">
                                <table class="table">
                                    <tr>
                                        <th>Nivel </th>
                                        <th>Jornada</th>
                                        <th>Modulo</th>
                                        <th>Precio</th>
                                    </tr>
                                    <tr>
                                        <td id="checkbox_indices"> </td>
                                        <td><select id="jornada_e" name="jornada_e" class="form-control selectpicker" data-live-search="true" data-style="border" required onchange="cambiarJornadaEpayco(this.value)"></select></td>
                                        <td id="modulos_seleccionados"> </td>
                                        <td id="nivel_globalid"> </td>
                                        <!-- <td>0</td> -->
                                    </tr>
                                </table>
                                <div class="row botones_epayco" style="padding: 10px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
    require 'footer_estudiante.php';
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/idiomas.js"></script>
<style>
    .h6 {
        font-size: 0.8rem !important;
    }
    #precarga{
        z-index: 1111;
    }
</style>
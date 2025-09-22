<?php
ob_start();
require_once "../modelos/Reporte_Veedor.php";
$reporte_veedor = new Reporte_Veedor();

if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
    exit;
} else {
    $menu = 4;
    require 'header_estudiante.php';
    if (!empty($_SESSION['id_usuario'])) {
?>

        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper ">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-6 col-9">
                            <h3 class="m-0 line-height-16">
                                <span></span>
                            </h3>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas mb-0">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel_estudiante.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Reporte veedor</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="container-fluid px-4">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card card-primary">
                            <div class="card-body p-0">
                                <br>
                                <div id="tbllistado" class="p-2"></div>
                            </div>
                            <div id="listar_estudiantes" class="m-0 p-0"></div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- Modal reporte influencer -->
        <div class="modal fade" id="modalReporteInfluencer" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">Reporte influencer</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="reporteinfluencer" id="reporteinfluencer" method="POST">
                        <input type= 'hidden'  value="" id='id_estudiante_in' name='id_estudiante_in'>
                        <input type='hidden' value="" id='id_docente_in' name='id_docente_in'>
                        <input type='hidden' value="" id='id_programa_in' name='id_programa_in'>
                        <input type='hidden' value="" id='id_materia_in' name='id_materia_in'>
                        <input type='hidden' value="" id='id_credencial_in' name='id_credencial_in'>
                        <div class="form-group col-12">
                            <label>Describir la novedad:</label>
                            <textarea name="influencer_mensaje" id="influencer_mensaje" rows="5" class="form-control" required></textarea>
                        </div>
                        <button type="submit" id="btnInfluencer" class="btn bg-purple btn-block">Enviar Reporte</button>
                    </form>
                </div>
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
    require 'footer_estudiante.php';
    $estudiante = isset($_GET["id"]) ? $_GET["id"] : "";
}
ob_end_flush();
?>

<link href='../fullcalendar/css/main.css' rel='stylesheet' />
<script src='../fullcalendar/js/main.js'></script>
<script src='../fullcalendar/locales/es.js'></script>
<script type="text/javascript" src="scripts/reporte_veedor.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
if (!empty($estudiante)) {
    $ciclo = $_GET["ciclo"];
    $id_programa = $_GET["id_programa"];
    $grupo = $_GET["grupo"];
    $rspta2 = $estudiante_c->programaacademico($id_programa);
    echo "<script>listar('$estudiante','" . $ciclo . "','$id_programa','$grupo');</script>";
    echo "<script>$('#nombre_programa').html('<span class=fs-16>" . $rspta2["original"] . '</span><br><span class="fs-14 f-montserrat-regular">' . $rspta2["nombre"] . "</span>');</script>";
}
?>

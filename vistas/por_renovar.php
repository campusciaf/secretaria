<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])){
  header("Location: ../");
}else{
    $menu = 10;
    $submenu = 1007;
    require 'header.php';
	if ($_SESSION['porrenovar']==1){
?>
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    th .select2-container {
    width: 150px !important;
}
th .select2-selection--multiple {
  min-height: 34px;
  font-size: 12px;
}

</style>

<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
              <div class="col-xl-6 col-9">
                <h2 class="m-0 line-height-16">
                    <span class="titulo-2 fs-18 text-semibold">Por renovar</span><br>
                    <span class="fs-14 f-montserrat-regular">Universitarios CIAF en la era digital</span>
                </h2>
              </div>
              <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
              </div>
              <div class="col-12 migas">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                      <li class="breadcrumb-item active">Población estudiantil</li>
                    </ol>
              </div>
          </div>
        </div>
    </div>
    <section class="container-fluid px-4">
      <div class="col-12" id="escuelas"></div>
         <div class="col-12" id="resultado"></div>
    </section>


	<section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary" style="padding: 2% 1%">

                    <div class="box">
                        <h4 class="mb-2 text-center">Listado de Estudiantes por Renovar</h4>
                        <div class="box-body">
                            <div id="contenedor_tabla" class="col-12 table-responsive">
                                <table id="tblrenovar" class="table table-hover table-nowarp table-sm compact">
                                    <thead>
                                        <tr>
                                            <th> Acciones</th>
                                            <th> Identificación</th>
                                            <th> Nombre</th>
                                            <th> Programa</th>
                                            <th> Ciclo</th>
                                            <th> Estado</th>
                                            <th> Jornada</th>
                                            <th> Semestre</th>
                                            <th> Financiera</th>
                                            <th> Academicamente</th>
                                            <th> Semestre actual</th>
                                            <th> Correo personal</th>
                                            <th> Celular</th>
                                            <th> Periodo ingreso</th>
                                            <th> Periodo Activo</th>
                                            <th> Escuela</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div> 



  <!-- inicio modal historial -->
    <div class="modal" id="myModalHistorial">
        <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
                <h6 class="modal-title">Listado Consulta</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <?php require_once "segui_tareas.php" ?>
        </div>

        </div>
        </div>
    </div>

          <!-- inicio modal agregar seguimiento -->
    <div class="modal" id="myModalAgregar">
        <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h6 class="modal-title">Gestión seguimientos</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <?php require_once "agregar_segui_tareas.php" ?>
            </div>

        </div>
        </div>
    </div>
    <!-- fin modal agregar seguimiento -->



 <!---------------------------------------------------------------------  MODALES(Ver whatsapp)   ---------------------------------------------------------------------------->
 <div class="modal fade" id="modal_whatsapp" tabindex="-1" role="dialog" aria-labelledby="modal_whatsapp_label">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h6 class="modal-title" id="modal_whatsapp_label"> WhatsApp CIAF</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body p-0">
                <div class="container">
                    <div class="row">
                        <div class="col-12 m-0 seccion_conversacion">
                            <?php require_once 'whatsapp_module.php';?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
	}else{
	  require 'noacceso.php';
	}
    require 'footer.php';
}
	ob_end_flush();
?>
<script type="text/javascript" src="scripts/por_renovar.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<script type="text/javascript" src="scripts/segui_tareas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<script type="text/javascript" src="scripts/agregar_segui_tareas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<script src="scripts/whatsapp_module.js?<?= date(" Y-m-d H:i:s") ?>"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

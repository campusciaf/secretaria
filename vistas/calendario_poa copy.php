<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"]))
{
  header("Location: ../");
}
else
{
$menu=2;
$submenu=210;
require 'header.php';
	
	if ($_SESSION['calendariopoa']==1)
	{
?>
  <!-- fullCalendar -->
  <link rel="stylesheet" href="../public/css/fullcalendar.min.css">
  <link rel="stylesheet" href="../public/css/fullcalendar.print.min.css" media="print">

<div id="precarga" class="precarga"></div>
<!--Contenido-->
<!-- Content Wrapper. Contains page content -->
<!--Contenido-->
<div class="content-wrapper">
   <!-- Main content -->
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1 class="m-0"><small id="nombre_programa"></small>Calendario personal </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                  <li class="breadcrumb-item active">Gestión Calendario</li>
               </ol>
            </div>
            <!-- /.col -->
         </div>
         <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
   </div>
   <section class="content" style="padding-top: 0px;">
      <div class="row">
         <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card card-primary" style="padding: 2% 1%">
				
				
              <!-- THE CALENDAR -->
              <div id="calendar"></div>
          
			 </div>
            <!-- /.card -->
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!--Fin-Contenido-->
<?php
}
	else
	{
	  require 'noacceso.php';
	}	
	
require 'footer.php';
?>
<!-- fullCalendar -->
<script src="../bower_components/moment/moment.js"></script>
<script src="../bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<script src="../bower_components/fullcalendar/dist/locale/es.js"></script>
<!-- Page specific script -->
<?php
}
  ob_end_flush();
?>
<!-- Script para cargar los eventos js del calendario -->
<script src="scripts/calendariopoaindividual.js"></script>

<!-- Modal (Mostrar Información)-->
<div class="modal" id="modalcalendariopoa" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <b><h4 class="modal-title" id="calendariopoatitle"></h4></b>
        </button>
      </div>
      <div class="modal-body">
      	<div class="row">
             <div class="col-xs-12 col-sm-12 col-md-12 col-xl-12">
             	<b>COMPROMISO: </b> &nbsp;
        		<i class="fas fa-hands-helping"></i>&nbsp;<span id="nombre_compromiso"></span>
             </div>
             <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6">
             	<b>FECHA: </b> &nbsp;
        		<i class="far fa-calendar-alt"></i>&nbsp;<span id="fecha_meta"></span><br>
             </div>
             <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6">
             	<b>VERIFICA: </b> &nbsp;
        		<i class="fas fa-user-check"></i>&nbsp;<span id="quien_verifica"></span>
             </div>
      	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<style>
 .fc th{
  padding: 10px 0px;
  vertical-align: middle;
  background: #f2f2f2;
 }
 .fc-content{
  cursor: pointer;
 }
 .fc-day:hover{
  background-color: #b5d2da;
  cursor: pointer;
 }
</style>
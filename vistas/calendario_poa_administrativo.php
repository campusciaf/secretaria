<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"]))
{
  header("Location: login");
}
else
{
require 'header.php';
?>
  <!-- fullCalendar -->
  <link rel="stylesheet" href="../public/css/fullcalendar.min.css">
  <link rel="stylesheet" href="../public/css/fullcalendar.print.min.css" media="print">

  <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
	<h3>
		<a href="calendario_poa_administrativo.php" class="btn btn-info pull-right" id="boton_calendario_admin">Ver Calendario Área Administrativa</a>
		<a href="calendario_poa_academico.php" class="btn bg-maroon pull-right" id="boton_calendario_academ">Ver Calendario Área Académica</a>
       	<a href="calendario_poa_general.php" class="btn btn-default pull-right" id="boton_calendario">Ver Calendario General POA</a>
    </h3> <br><br> 
<section class="content">
      <div class="row">
		  
		<div class="col-md-3">
			<div class="callout callout-success">
                Meta Cumplida
            </div>
			<div class="callout callout-warning">
                Meta Por Validar
            </div>
			<div class="callout callout-info">
                Meta Por Vencer
            </div>
			<div class="callout callout-danger">
                Meta Vencida
            </div>
      <div class="callout callout bg-navy-active">
                Meta del Día
            </div>
      </div>
		  
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-body no-padding">
              <!-- THE CALENDAR -->
              <div id="calendar">
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

				  
				  </section>				  

              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
<?php
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
<script src="scripts/calendariopoaadministrativo.js"></script>

<!-- Modal (Mostrar Información)-->
<div class="modal" id="modalcalendariopoa" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <b><h4 class="modal-title" id="calendariopoatitle"></h4></b>
        </button>
      </div>
      <div class="modal-body">
      	<div class="row">
      		<div class="col-xs-4 col-sm-4 col-md-3 col-xl-3">
	      			<div class="media-left" id="imagen_dependencia">
	             	</div>
      		</div>
      		<div class="col-xs-8 col-sm-8 col-md-8 col-xl-8">
             	<b>COMPROMISO: </b> <br>
        		<i class="fas fa-hands-helping"></i>&nbsp;<span id="nombre_compromiso"></span>
             </div>
             <div class="col-xs-8 col-sm-8 col-md-8 col-xl-8">
             	<b>NOMBRE: </b> <br>	
        		<i class="fas fa-user"></i>&nbsp;<span id="nombre_encargado"></span>
             </div>
             <div class="col-xs-8 col-sm-8 col-md-8 col-xl-8">
             	<b>DEPENDENCIA: </b> <br>
        		<i class="fas fa-user-tag"></i>&nbsp;<span id="dependencia"></span>
             </div>
             <div class="col-xs-8 col-sm-8 col-md-6 col-xl-6">
             	<b>FECHA: </b> &nbsp;
        		<i class="far fa-calendar-alt"></i>&nbsp;<span id="fecha_meta"></span><br>
             </div>
             <div class="col-xs-8 col-sm-8 col-md-4 col-xl-4">
             	<b>TELÉFONO: </b> &nbsp;
        		<i class="fas fa-phone"></i>&nbsp;<span id="fijo"></span><br>
             </div>
             <div class="col-xs-8 col-sm-8 col-md-4 col-xl-4">
             	<b>CELULAR: </b> &nbsp;
        		<i class="fas fa-mobile"></i>&nbsp;<span id="celular"></span><br>
             </div>
             <div class="col-xs-8 col-sm-8 col-md-6 col-xl-6">
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
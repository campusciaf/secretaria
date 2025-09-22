<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])){
    header("Location: login");
}else{
	$menu=3;
	$submenu=301;
    require 'header.php';
	if ($_SESSION['admincalendario']==1){
?>
<!-- fullCalendar -->
<link rel="stylesheet" href="../public/css/fullcalendar.min.css">
<link rel="stylesheet" href="../public/css/fullcalendar.print.min.css" media="print"> 		  
<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
   <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-xl-6 col-9">
                <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Calendario académico</span><br>
                        <span class="fs-14 f-montserrat-regular">Esta es la ventana a lo increible.</span>
                </h2>
                </div>
                <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                </div>
                <div class="col-12 migas mb-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Administrador eventos</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content" style="padding-top: 0px;">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card card-primary" style="padding: 2% 1%">
                    <!-- THE CALENDAR -->
              		<div id="calendar"></div>
                </div>
            </div>
        </div>
    </section>                
</div>
<!-- Modal (Agregar, Modificar, Borrar Calendario)-->
<div class="modal fade" id="modalCalendario" tabindex="-1" role="dialog" aria-labelledby="modalCalendario" aria-hidden="true">
    <form method="POST">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <b><h3 class="modal-title" id="modalCalendarioLabel">Agregar Evento</h3></b>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="idActividad" name="idActividad"/><br>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Título: </label>
                            <input class="form-control" type="text" id="txtTitulo" name="txtTitulo" placeholder="Título del Evento" required/>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Fecha Inicio:</label>
                            <input class="form-control" type="date" id="txtFechaInicio" name="txtFechaInicio" disabled required/>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Fecha Fin:</label>
                            <input class="form-control" type="date" id="txtFechaFin" name="txtFechaFin" required/>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Color</label>
                            <select class="form-control" id="txtColor" name="txtColor" required>
                                <option value="#008000" style="background-color:#008000; color:white;">Verde</option>
                                <option value="#0080c0" style="background-color:#0080c0; color:white";>Azul Claro</option>
                                <option value="#000040" style="background-color:#000040; color:white;">Azul Oscuro</option>
                                <option value="#ff8000" style="background-color:#ff8000; color:white;">Naranja</option>
                                <option value="#800080" style="background-color:#800080; color:white;">Violeta</option>
                                <option value="#800000" style="background-color:#800000; color:white;">Rojo</option>
                                <option value="#400000" style="background-color:#400000; color:white;">Vinotinto</option>
                                <option value="#808080" style="background-color:#808080; color:white;">Gris</option>
                                <option value="#000000" style="background-color:#000000; color:white;">Negro</option>
                                <option value="#808000" style="background-color:#808000; color:white;">Dorado</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="botonAgregar" class="btn btn-success">Agregar</button>
                    <button type="button" id="botonModificar" class="btn btn-success" >Modificar</button>
                    <button type="button" id="botonEliminar" class="btn btn-danger"  >Eliminar</button>
                    <button type="button" onclick="LimpiarFormulario()" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </form>
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
<?php
	}else{
	  require 'noacceso.php';
	}
    require 'footer.php';
?>
<!-- fullCalendar -->
<script src="../bower_components/moment/moment.js"></script>
<script src="../bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<script src="../bower_components/fullcalendar/dist/locale/es.js"></script>
<!-- Script para cargar los eventos js del calendario -->
<script src="scripts/admincalendario.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<!-- Page specific script -->
<?php 
    }
    ob_end_flush();
?>
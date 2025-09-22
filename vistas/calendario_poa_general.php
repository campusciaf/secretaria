<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
	header("Location: ../");
} else {
	$menu = 2;
	$submenu = 209;
	require 'header.php';

	if ($_SESSION['calendariopoageneral'] == 1) {
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
							<h1 class="m-0"><small id="nombre_programa"></small>Calendario general </h1>
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
							<div class="btn-group col-xl-6 col-lg-6 col-mb-12 col-12 float-rigth">
								<a href="calendario_poa_administrativo.php" class="btn btn-info float-right " id="boton_calendario_admin">Ver Administrativos</a>
								<a href="calendario_poa_academico.php" class="btn bg-maroon float-right " id="boton_calendario_academ">Ver Académicos</a>
								<a href="calendario_poa_general.php" class="btn btn-default float-right " id="boton_calendario">Ver Todos</a>
							</div>
							<br>
							<div class="row">
								<div class="col-xl-3 col-lg-3 col-md-3 col-12">
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
								<div class="card col-xl-9 col-lg-9 col-md-9 col-12">
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
							</div>
						</div>
						<!-- /.card -->
					</div>
					<!-- /.col -->
				</div>
				<!-- /.row -->
			</section>
			<!-- /.content -->

			<div class="modal" id="modalcalendariopoa" tabindex="-1" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<b>
								<h4 class="modal-title" id="calendariopoatitle"></h4>
							</b>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-xs-4 col-sm-4 col-md-3 col-xl-3">
									<div class="media-left" id="imagen_dependencia">
									</div>
								</div>
								<div class="col-xs-8 col-sm-8 col-md-8 col-xl-8">
									<br><br><b>ACCION: </b> <br>
									<i class="fas fa-hands-helping"></i>&nbsp;<span id="nombre_accion"></span>
								</div>
								<div class="col-xs-8 col-sm-8 col-md-8 col-xl-8">
									<b>NOMBRE: </b> <br>
									<i class="fas fa-user"></i>&nbsp;<span id="usuario_cargo"></span>
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
									<i class="fas fa-user-check"></i>&nbsp;<span id="meta_responsable"></span>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /.content-wrapper -->
		<!--Fin-Contenido-->
	<?php
	} else {
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
<script src="scripts/calendariopoageneral.js"></script>



<style>
	.fc th {
		padding: 10px 0px;
		vertical-align: middle;
		background: #f2f2f2;
	}

	.fc-content {
		cursor: pointer;
	}

	.fc-day:hover {
		background-color: #b5d2da;
		cursor: pointer;
	}
</style>
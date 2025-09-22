<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
	header("Location: ../");
} else {
	$menu = 14;
	$submenu = 1424;
	require 'header.php';
	if ($_SESSION['oncentervaldocumentos'] == 1) {
?>
		<div id="precarga" class="precarga"></div>
		<div class="content-wrapper">
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-xl-6 col-9">
							<h2 class="m-0 line-height-16">
								<span class="titulo-2 fs-18 text-semibold">Documentación</span><br>
								<span class="fs-16 f-montserrat-regular">Aquí se da inicio a la transformación CIAF</span>
							</h2>
						</div>
						<div class="col-xl-6 col-3 pt-4 pr-4 text-right">
							<button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
						</div>
						<div class="col-12 migas">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
								<li class="breadcrumb-item active">Documentación</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
			<section class="container-fluid px-4">
				<div class="row">
					<div class="col-12 m-0 p-0">
						<div class="row" id="data1"></div>
					</div>
					<div class="card col-12">
						<div class="row">
							<div class="col-12 p-4 tono-3 ">
								<div class="row align-items-center">
									<div class="col-auto pl-3">
										<span class="rounded bg-light-blue p-3 text-primary ">
											<i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
										</span>
									</div>
									<div class="col-auto">
										<div class="col-12 fs-14 line-height-18">
											<span class="">Resultados</span> <br>
											<span class="text-semibold fs-20">Documentación</span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 table-responsive p-4" id="listadoregistros">
								<table id="tbllistado" class="table table-hover" style="width:100%">
									<thead>
										<th id="t-caso">Caso</th>
										<th id="t-identificacion">Identificación</th>
										<th id="t-nombre">Nombre</th>
										<th id="t-whatsapp">Seguimiento</th>
										<th id="t-programa">Programa</th>
										<th id="t-jornada">Jornada</th>
										<th id="t-soportes">Soportes</th>
										<th id="t-validar">Validar</th>
										<th id="t-matricula">Matrícula</th>
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
		<div id="myModalPerfilEstudiante" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<!-- Modal Header -->
					<div class="modal-header">
						<h4 class="modal-title">Perfil Estudiante</h4>
						<button type="button" class="close" data-dismiss="modal">×</button>
					</div>
					<!-- Modal body -->
					<div class="modal-body" id="resultado_cambiar_documento">
						<form name="formularioeditarperfil" id="formularioeditarperfil" method="POST">
							<input type="hidden" id="id_estudiante" value="" name="id_estudiante">
							<input type="hidden" id="fila" value="" name="fila">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<h5>Programa de Interes</h5>
									<select name="fo_programa" id="fo_programa" class="form-control selectpicker" data-live-search="true">
									</select>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<h5>Jornada de Interes</h5>
									<select name="jornada_e" id="jornada_e" class="form-control selectpicker" data-live-search="true">
									</select>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<h5>Tipo de Documento</h5>
									<select name="tipo_documento" id="tipo_documento" class="form-control selectpicker" data-live-search="true">
									</select>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<h5>Primer Nombre</h5>
									<input type="text" name="nombre" id="nombre" class="form-control" />
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<h5>Segundo Nombre</h5>
									<input type="text" name="nombre_2" id="nombre_2" class="form-control" />
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<h5>Primer Apellido</h5>
									<input type="text" name="apellidos" id="apellidos" class="form-control" />
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<h5>Segundo Apellido</h5>
									<input type="text" name="apellidos_2" id="apellidos_2" class="form-control" />
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<h5>Número de Contacto</h5>
									<input type="number" name="celular" id="celular" class="form-control" />
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<h5>Correo Personal</h5>
									<input type="email" name="email" id="email" class="form-control" />
								</div>
							</div><br><br>
							<div class="row well">
								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<h5>Nivel de Escolaridad</h5>
									<select name="nivel_escolaridad" id="nivel_escolaridad" class="form-control selectpicker" data-live-search="true">
									</select>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<h5>Nombre del colegio</h5>
									<input name="nombre_colegio" id="nombre_colegio" class="form-control" />
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<h5>Fecha de graduación *</h5>
									<input type="date" name="fecha_graduacion" id="fecha_graduacion" value="" class="form-control">
								</div>
							</div>
							<br><br>
							<input type="submit" value="Guardar Cambios" id="btnEditar" class="btn btn-success btn-block">
						</form>
						<div id="resultado_cedula"></div>
					</div>
					<!-- Modal footer -->
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
		<div id="myModaVerSoportesDigitales" class="modal fade" role="dialog">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<!-- Modal Header -->
					<div class="modal-header">
						<h6 class="modal-title">Soportes</h6>
						<button type="button" class="close" data-dismiss="modal">×</button>
					</div>
					<!-- Modal body -->
					<div class="modal-body" id="resultado_cambiar_documento">
						<div id="soporte_cedula"></div>
						<div id="soporte_diploma"></div>
						<div id="soporte_acta"></div>
						<div id="soporte_salud"></div>
						<div id="soporte_prueba"></div>
						<div id="soporte_compromiso"></div>
						<div id="soporte_proteccion_datos"></div>
						<div id="soporte_ingles"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="modal_whatsapp" tabindex="-1" role="dialog" aria-labelledby="modal_whatsapp_label">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header bg-success">
						<h6 class="modal-title" id="modal_whatsapp_label"> Whatapp </h6>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body p-0">
						<div class="container">
							<div class="row">
								<div class="col-12 m-0 seccion_conversacion">
									<?php require_once "whatsapp_module.php" ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- inicio modal agregar seguimiento -->
		<div class="modal" id="myModalAgregar">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h6 class="modal-title">Agregar seguimiento</h6>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">

                        <?php require_once "on_segui_tareas.php" ?>

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
<script type="text/javascript" src="scripts/oncentervaldocumentos.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<script type="text/javascript" src="scripts/on_segui_tareas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<script type="text/javascript" src="scripts/whatsapp_module.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
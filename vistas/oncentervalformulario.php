<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
	header("Location: ../");
} else {
	$menu = 14;
	$submenu = 1421;
	require 'header.php';
	if ($_SESSION['oncentervalformulario'] == 1) {
?>
		<div id="precarga" class="precarga"></div>
		<!-- <link href="../public/css/styletour.css" rel="stylesheet"> -->
		<div class="content-wrapper ">
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-xl-6 col-9">
							<h2 class="m-0 line-height-16">
								<span class="titulo-2 fs-18 text-semibold">Estudiantes Pre-inscritos</span><br>
								<span class="fs-16 f-montserrat-regular">Aquí se da inicio a la transformación CIAF</span>
							</h2>
						</div>
						<div class="col-xl-6 col-3 pt-4 pr-4 text-right">
							<button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
						</div>
						<div class="col-12 migas">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
								<li class="breadcrumb-item active">Formularios</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
			<section class="content px-xl-2 mx-xl-4 px-2 mx-2">
				<div class="row">
					<div class="col-12 m-0 p-0">
						<div class="row" id="data1"></div>
					</div>
					<div class="card col-12 table-responsive py-2" id="listadoregistros">
						<table id="tbllistado" class="table table-hover" style="width:100%">
							<thead>
								<th id="t-ca">Caso</th>
								<th id="t-id">Identificación</th>
								<th id="t-no">Nombre</th>
								<th id="t-whatsapp">Seguimiento</th>
								<th id="t-pro">Programa</th>
								<th id="t-jor">Jornada</th>
								<th id="t-form">Formulario</th>
								<th id="t-ri">Recibo Inscripción</th>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</section>
			<div class="cd-cover-layer"></div>
		</div>
		<div id="myModalPerfilEstudiante" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<!-- Modal Header -->
					<div class="modal-header">
						<hs class="modal-title">Formulario de validación</hs>
						<button type="button" class="close" data-dismiss="modal">×</button>
					</div>
					<!-- Modal body -->
					<div class="modal-body" id="resultado_cambiar_documento">
						<form name="formularioeditarperfil" id="formularioeditarperfil" method="POST">
							<input type="hidden" id="id_estudiante" value="" name="id_estudiante">
							<input type="hidden" id="fila" value="" name="fila">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="form-group mb-3 position-relative check-valid">
										<div class="form-floating">
											<select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="fo_programa" id="fo_programa"></select>
											<label>Programa de Interes</label>
										</div>
									</div>
									<div class="invalid-feedback">Please enter valid input</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-6">
									<div class="form-group mb-3 position-relative check-valid">
										<div class="form-floating">
											<select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="jornada_e" id="jornada_e"></select>
											<label>Jornada de Interes</label>
										</div>
									</div>
									<div class="invalid-feedback">Please enter valid input</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-6">
									<div class="form-group mb-3 position-relative check-valid">
										<div class="form-floating">
											<select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="tipo_documento" id="tipo_documento"></select>
											<label>Tipo de Documento</label>
										</div>
									</div>
									<div class="invalid-feedback">Please enter valid input</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-6">
									<div class="form-group mb-3 position-relative check-valid">
										<div class="form-floating">
											<input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="nombre" id="nombre" maxlength="100" onchange="javascript:this.value=this.value.toUpperCase();">
											<label>Primer Nombre</label>
										</div>
									</div>
									<div class="invalid-feedback">Please enter valid input</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-6">
									<div class="form-group mb-3 position-relative check-valid">
										<div class="form-floating">
											<input type="text" placeholder="" value="" class="form-control border-start-0" name="nombre_2" id="nombre_2" maxlength="100" onchange="javascript:this.value=this.value.toUpperCase();">
											<label>Segundo Nombre</label>
										</div>
									</div>
									<div class="invalid-feedback">Please enter valid input</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-6">
									<div class="form-group mb-3 position-relative check-valid">
										<div class="form-floating">
											<input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="apellidos" id="apellidos" maxlength="100" onchange="javascript:this.value=this.value.toUpperCase();">
											<label>Primer Apellido</label>
										</div>
									</div>
									<div class="invalid-feedback">Please enter valid input</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-6">
									<div class="form-group mb-3 position-relative check-valid">
										<div class="form-floating">
											<input type="text" placeholder="" value="" class="form-control border-start-0" name="apellidos_2" id="apellidos_2" maxlength="100" onchange="javascript:this.value=this.value.toUpperCase();">
											<label>Segundo Apellido</label>
										</div>
									</div>
									<div class="invalid-feedback">Please enter valid input</div>
								</div>
								<div class="col-12">
									<h6 class="title">Datos de contacto</h6>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-12">
									<div class="form-group mb-3 position-relative check-valid">
										<div class="form-floating">
											<input type="number" placeholder="" value="" required class="form-control border-start-0" name="celular" id="celular" maxlength="20">
											<label>Número Celular</label>
										</div>
									</div>
									<div class="invalid-feedback">Please enter valid input</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-12">
									<div class="form-group mb-3 position-relative check-valid">
										<div class="form-floating">
											<input type="email" placeholder="" value="" required class="form-control border-start-0" name="email" id="email" maxlength="50">
											<label>Correo Personal</label>
										</div>
									</div>
									<div class="invalid-feedback">Please enter valid input</div>
								</div>
								<div class="col-12">
									<h6 class="title">Datos de estudio</h6>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-12 col-12">
									<div class="form-group mb-3 position-relative check-valid">
										<div class="form-floating">
											<select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="nivel_escolaridad" id="nivel_escolaridad"></select>
											<label>Nivel de Escolaridad</label>
										</div>
									</div>
									<div class="invalid-feedback">Please enter valid input</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-12 col-12">
									<div class="form-group mb-3 position-relative check-valid">
										<div class="form-floating">
											<input type="text" placeholder="" value="" class="form-control border-start-0" name="nombre_colegio" id="nombre_colegio" maxlength="100" onchange="javascript:this.value=this.value.toUpperCase();">
											<label>Nombre del colegio</label>
										</div>
									</div>
									<div class="invalid-feedback">Please enter valid input</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-12 col-12">
									<div class="form-group mb-3 position-relative check-valid">
										<div class="form-floating">
											<input type="date" placeholder="" value="" required class="form-control border-start-0" name="fecha_graduacion" id="fecha_graduacion">
											<label>Fecha de graduación</label>
										</div>
									</div>
									<div class="invalid-feedback">Please enter valid input</div>
								</div>
								<div class="col-12 text-right">
									<input type="submit" value="Actualizar perfil" id="btnEditar" class="btn btn-success">
								</div>
							</div>
						</form>
						<div id="resultado_cedula"></div>
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
<script type="text/javascript" src="scripts/oncentervalformulario.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<script type="text/javascript" src="scripts/on_segui_tareas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<script type="text/javascript" src="scripts/whatsapp_module.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
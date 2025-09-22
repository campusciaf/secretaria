<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"]) && $_SESSION["usuario_cargo"] != "Funcionario") {
	header("Location: ../");
} else {
	$menu = 10;
	$submenu = 1018;
	require 'header.php';
	if ($_SESSION['consulta_atrasados_programa'] == 1) {
?>
		<div id="precarga" class="precarga"></div>

		<div class="content-wrapper ">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-8 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Consulta Atrasados por programa </span><br>
                                <span class="fs-14 f-montserrat-regular"> 
								Consulta Atrasados por programa 
                                </span>
                            </h2>
                        </div>
                        <div class="col-xl-4 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'>
                                <i class="fa-solid fa-play"></i> 
                                Tour 
                            </button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel_admin.php"> Inicio </a></li>
                                <li class="breadcrumb-item active"> Cuotas vencidas </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
			<section class="content">
				<div class="row">
					<div class="col-md-12">
						<div class="card card-primary" style="padding: 2% 1%">
							

							<div class="col-xl-6 col-lg-6 col-md-12 col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <select value="" required="" class="form-control border-start-0 selectpicker" data-live-search="true" name="programa" id="programa" onchange="listar_atrasados(this.value)"></select>
                                        <label>Programa</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>


						
							<table id="tabla_atrasados" class="table table-condensed table-hover table-responsive">
								<thead>
									<td>Opciones</td>
									<td>Documento</td>
									<td>Nombre</td>
									<td>Teléfono</td>
									<td>Correo</td>
									<td>Semestre</td>
									<td>Jornada</td>
									<td>Labora</td>
									<td>Cuotas</td>
									<td>Días</td>
									<td>Valor</td>
									<td>Periodo</td>
								</thead>
								<tbody>
									<th colspan="13">
										<div class='jumbotron text-center' style="margin:0px !important">
											<h3>Aquí aparecerán los datos de la persona que tienen crédito.</h3>
										</div>
									</th>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</section>
        </div>

		<!----------------------------------------------------------------------MODALES(Ver detalles)------------------------------------------------------------------------------>
		<div class="modal fade " id="verInfoSolicitante">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header bg-teal-active color-palette">
						<h6 class="modal-title title_name_sol">Nombre Estudiante</h6>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span></button>
					</div>
					<div class="nav-tabs-custom ">
						<ul class="nav nav-tabs navnolabora">
							<li class="active data_infosol p-2"><a href="#tab_no_1" data-toggle="tab" aria-expanded="true">Información Personal</a></li>
							<li class="data_refsol p-2"><a href="#tab_no_2" data-toggle="tab" aria-expanded="false">Referencias</a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tab_no_1">
								<table class="table table-hover table-condensed table-nowarp">
									<tbody>
										<tr>
											<td><strong>Tipo De Documento:</strong><span class="float-right info-tipo_documento"></span></td>
										</tr>
										<tr>
											<td><strong>N° Documento:</strong><span class="float-right info-numero_documento"></span></td>
										</tr>
										<tr>
											<td><strong>Nombre Completo:</strong> <span class="float-right info-nombres"></span></td>
										</tr>
										<tr>
											<td><strong>Apellido:</strong><span class="float-right info-apellidos"></span></td>
										</tr>
										<tr>
											<td><strong>Fecha Nacimiento: </strong><span class="float-right info-fecha_nacimiento"></span></td>
										</tr>
										<tr>
											<td><strong>Dirección De Residencia:</strong> <span class="float-right info-direccion"></span></td>
										</tr>
										<tr>
											<td><strong>Ciudad:</strong> <span class="float-right info-ciudad"></span></td>
										</tr>
										<tr>
											<td><strong>Teléfono:</strong> <span class="float-right info-telefono"></span></td>
										</tr>
										<tr>
											<td><strong>Celular:</strong> <span class="float-right info-celular"></span></td>
										</tr>
										<tr>
											<td><strong>Email:</strong> <span class="float-right info-email"></span></td>
										</tr>
										<tr>
											<td><strong>Ocupación:</strong> <span class="float-right info-ocupacion"></span></td>
										</tr>
										<tr>
											<td><strong>Periodo:</strong> <span class="float-right info-periodo"></span></td>
										</tr>
									</tbody>
								</table>
								<input class="info-idsolicitante" type="hidden">
							</div>
							<div class="tab-pane" id="tab_no_2">
								<table class="table table-striped table-condensed">
									<tbody class="table-references">
									</tbody>
								</table>
							</div>
						</div>
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

		<!---------------------------------------------------------------------  MODALES(Ver Cuotas)   ---------------------------------------------------------------------------->
		<div class="modal fade" id="modal_cuotas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h6 class="modal-title" id="myModalLabel">Mostrando Cuotas de: <b class="nombre_atrasado"></b> </h6>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<table id="tabla_cuotas" class="table  table-condensed table-hover">
							<thead>
								<th>Estado</th>
								<th># Cuota</th>
								<th>Cuota</th>
								<th>Pagado</th>
								<th>Pago <small>(A-M-D)</small></th>
								<th>Plazo <small>(A-M-D)</small></th>
								<th>Atraso</th>
							</thead>
							<tbody>
								<th colspan="11">
									<div class='jumbotron text-center' style="margin:0px !important">
										<h3>Aquí aparecerán los datos de la persona que tienen crédito.</h3>
									</div>
								</th>
							</tbody>
							<tfoot>
								<th>Estado</th>
								<th># Cuota</th>
								<th>Cuota</th>
								<th>Pagado</th>
								<th>Pago</th>
								<th>Plazo</th>
								<th>Atraso</th>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>

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
	} else {
		require 'noacceso.php';
	}
	require 'footer.php';
	?>
	<script src="scripts/sofi_atraso_programa.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
	<script type="text/javascript" src="scripts/segui_tareas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
	<script type="text/javascript" src="scripts/agregar_segui_tareas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
	<script src="scripts/whatsapp_module.js?<?= date(" Y-m-d H:i:s") ?>"></script>
<?php
}
ob_end_flush();
?>
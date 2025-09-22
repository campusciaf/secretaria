<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"]) or $_SESSION['usuario_cargo'] == "Docente" or $_SESSION['usuario_cargo'] == "Estudiante") {
	header("Location: ../");
} else {
	$menu = 8;
	$submenu = 802;
	require 'header.php';
	if ($_SESSION['certificados'] == 1) {
?>
		<div id="precarga" class="precarga"></div>
		<div class="content-wrapper">
			<!-- Main content -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0"><small id="nombre_programa"></small>Certificados </h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
								<li class="breadcrumb-item active">Gestión certificados</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
			<section class="container-fluid" style="padding-top: 0px;">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<div class="card card-primary" style="padding: 2% 1%">
							<!-- /.row -->
							<!-- CONTENEDOR PARA BUSCAR POR NUMERO DE IDENTIFICACIÓN-->
							<div class="row" id="contenedor_busqueda">
								<!-- INPUT PARA CAPTURAR LA CÉDULA A BUSCAR EN LA BASE DE DATOS -->
								<div class="form-group col-xl-4 col-lg-6 col-md-12 col-12">
									<label>Buscar documento:</label>
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fa fa-id-card"></i></span>
										</div>
										<input type="number" id="input_cedula" class="form-control" required="required"
											placeholder="Digite el número de documento">
										<span class="input-group-btn">
											<button title='Buscar Estudiante' id="buscar_estudiante"
												class="btn btn-success">&nbsp;<span class="fa fa-search"></span></button>
										</span>
									</div>
								</div>
								<!-- INFORMACIÓN DEL ESTUDIANTE CON LOS PROGRAMAS Y LA JORNADA -->
								<div class="col-xl-12 col-md-12 col-lg-12 col-12" id="informacion_estudiante" hidden="true">
									<!-- Widget: user widget style 1 -->
									<div class="row">
										<!-- Add the bg color to the header using any of the bg-* classes -->
										<div class="col-xl-4 bg-light py-2">
											<img class="img-circle" id="user-photograph"
												style="width:30px; height:30px; float:left; margin-right:10px"
												src="../files/null.jpg" alt="User Avatar">
											<span id="nombre_completo_estudiante"></span>
											<span id="correo_estudiante"></span>
										</div>
										<div class="col-xl-8 text-right">
											<button id="certificadosExpedidos" type="button" class="btn btn-warning btn-lg">
												<i class="fas fa-history"></i> Ver Certificados Expedidos
											</button>
										</div>
										<div class="box-footer no-padding">
											<input type="hidden" name="id_credencial" id="id_credencial" />
											<input type="hidden" name="id_estudiante" id="id_estudiante" />
											<input type="hidden" name="id_programa_ac" id="id_programa_ac" />
										</div>
									</div>
									<div class="panel-body table-responsive py-4 " id="listadoregistros" hidden="true">
										<table id="tbllistado"
											class="table table-striped  table-compact table-bordered table-condensed table-hover">
											<thead>
												<th>Acciones</th>
												<th>Id estudiante</th>
												<th>Programa</th>
												<th>Jornada</th>
												<th>Estado</th>
												<th>Periodo Activo</th>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
									<!-- BOTÓN PARA SELECCIONAR EL TIPO DE CERTIFICADO A GENERAR -->
									<div class="p-2" id="generador_certificados" hidden="true">
										<form method="post" id="ver_certificado" name="ver_certificado">
											<div class="input-group">
												<select id="consulta" name="consulta" class="form-control selectpicker"
													data-live-search="true""  required></select>
							  					<div class=" col-3 m-0 p-0 text-center bg-info">
													<button type="submit" class="btn btn-info btn-success btn-block">Previsualizar
													</button>
											</div>
									</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
		</div>
		</section>
		</div>
		<!-- Modal Certificados Expedidos -->
		<div class="modal fade" id="certificadosExpedidos_modal" tabindex="-1" role="dialog"
			aria-labelledby="certificadosexpedidos_modalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="modaletiqueta">Certificados Expedidos</h5>
					</div>
					<div class="modal-body">
						Tabla Certificados Expedidos
						<table id='expedidosTabla' class="display table-compact table-sm" cellspacing="0" width="100%">
							<thead>
								<tr class="titulo15">
									<th>Tipo de certificado</th>
									<th>Programa</th>
									<th>Fecha de Expedición</th>
									<th>Archivo</th>
								</tr>
							</thead>
							<tfoot>
								<tr class="titulo15">
									<th>Documento</th>
									<th>Certificado Expedido</th>
									<th>Fecha de solicitud</th>
									<th>Archivo</th>
								</tr>
							</tfoot>
							<tbody id="cuerpo_tabla">
								<tr class="titulo15">
									<td id="campo_cedula"></td>
									<td id="campo_tipo"></td>
									<td id="campo_fecha"></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
		<!-- Modal para cargar un diploma -->
		<div class="modal fade" id="cargar_diploma" tabindex="-1" role="dialog"
			aria-labelledby="certificadosexpedidos_modalLabel" aria-hidden="true">
			<div class="modal-dialog " role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="modaletiqueta">cargar Diploma</h5>
					</div>
					<div class="modal-body">
						<form name="formulario" id="formulario" method="POST">
							<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<label>Archivo PDF:</label>
								<input type="hidden" name="tipo_certificado" id="tipo_certificado" />
								<input type="hidden" name="id_credencial2" id="id_credencial2" />
								<input type="hidden" name="id_estudiante2" id="id_estudiante2" />
								<input type="hidden" name="id_programa_ac2" id="id_programa_ac2" />
								<input type="file" class="form-control" name="archivo_diploma" id="archivo_diploma">
								<input type="hidden" name="imagenactual" id="imagenactual">
							</div>
							<button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>
								Guardar</button>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
		<!-- Modal Para Previsualizar el Certificado -->
		<div class="modal fade" id="vistaprevia_modal" tabindex="-1" role="dialog" aria-labelledby="vistaprevia_modalLabel"
			aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="row p-2">
						<div class="col-xl-6 col-lg-6 col-md-6 col-6">
							<h5 class="modal-title" id="vistaprevia_modaletiqueta">Vista Previa del Certificado</h5>
						</div>
						<!-- Contenedor de los botones de impresión -->
						<div id="botones" class="col-xl-6 col-lg-6 col-md-6 col-6 text-right">
							<span id="imprimir" hidden="true">
								<a class="btn btn-warning" id="boton_imprimir">
									<i class="fas fa-print"></i>
									Imprimir Certificado
								</a>
							</span>
							<span id="descargarCertificado" hidden="true">
								<a class="btn btn-secondary text-white" id="boton_descargar">
									<i class="fas fa-download"></i>
									Descargar Certificado
								</a>
							</span>
							<span id="verificar">
								<a class="btn btn-success text-right" id="boton_verificar">
									<i class="fas fa-fingerprint"></i>
									Generar Certificado
								</a>
							</span>
						</div>
						<div class="col-xl-12 col-lg-12 col-md-12 col-12 border-bottom p-2">
						</div>
					</div>
					<!-- Este es el contenedor que da la vista previa y el que se imprime como certificado expedido --->
					<div class="modal-body" id="cuerpo_vista_previa">
						<!-- Contenedor para el encabezado de todos los certificados -->
						<div style="width: 527px; margin-left: 70px; margin-top:150px">
							<center>
								<div style="font-size:16px" id="encabezado_certificados" hidden="true">
									<b>
										CORPORACIÓN INSTITUTO DE ADMINISTRACIÓN Y FINANZAS C.I.A.F <br>
										NIT.891.408.248-5 <br><br>
										REGISTRO Y CONTROL <br>
										CERTIFICA: <br><br>
									</b>
								</div>
							</center>
							<!-- Contenedor para los datos del certificado de calificaciones de todos los semestres -->
							<div align="justify" style="font-size:16px" id="calificaciones_todos" hidden="true">
								Que: <b><span id="certificado_1_nombre_estudiante" style="text-transform: uppercase;"></span></b>,identificado(a) con
								<span id="certificado_1_tipo_doc"></span> número <b>
								<span id="certificado_1_identificacion"></span></b>, cursó y aprobó los
								<b><span id="certificado_1_romano" style="text-transform: uppercase;"> </span></b> semestres del programa
								<b><span id="certificado_1_programa" style="text-transform: uppercase;"> </span></b>, obteniendo las siguientes calificaciones e intensidad horaria que a continuación se expresan:
							</div><br />
							<!-- Contenedor para los datos del certificado de calificaciones de semestre actual -->
							<div align="justify" style="font-size:16px" id="calificaciones_actual" hidden="true">Que: 
								<b><span id="certificado_2_nombre_estudiante" style="text-transform: uppercase;"></span></b>, identificado(a) con 
								<span id="certificado_2_tipo_doc"></span> número 
								<b><span id="certificado_2_identificacion"></span></b>, expedida en 
								<b><span id="certificado_2_expedido_en" style="text-transform: uppercase;"></span></b>, se encuentra cursando el 
								<b><span id="certificado_2_romano" style="text-transform: uppercase;"></span></b> semestre del programa 
								<b><span id="certificado_2_programa" style="text-transform: uppercase;"></span></b>, durante el periodo 
								<b> <span id="certificado_2_periodo_actual"></span></b> obteniendo las siguientes calificaciones: 
							</div>
							<br />
							<!-- Contenedor para los datos del certificado de calificaciones de semestre anterior -->
							<div align="justify" style="font-size:16px" id="calificaciones_anterior" hidden="true">Que: 
								<b><span id="certificado_3_nombre_estudiante" style="text-transform: uppercase;"></span></b>, identificado(a) con 
								<span id="certificado_3_tipo_doc"></span> número 
								<b><span id="certificado_3_identificacion"></span></b>, expedida en 
								<b><span id="certificado_3_expedido_en" style="text-transform: uppercase;"></span></b> cursó y aprobó el 
								<b><span id="certificado_3_romano" style="text-transform: uppercase;"></span></b> semestre del programa 
								<b><span id="certificado_3_programa" stylle="text-transform:uppercase;"></span></b> durante el periodo 
								<b><span id="certificado_3_periodo_anterior"></span></b> obteniendo las siguientes calificaciones: 
							</div><br />
							<!-- Contenedor para los datos del certificado de estudio del semestre actual -->
							<div align="justify" style="font-size:18px" id="estudio_actual" hidden="true">Que:
								<b><span id="certificado_4_nombre_estudiante" style="text-transform: uppercase;"></span></b>,
								identificado(a) con <span id="certificado_4_tipo_doc"></span> número <b>
									<span id="certificado_4_identificacion"></span></b>,
								expedida en <b><span id="certificado_4_expedido_en"
										style="text-transform: uppercase;"></span></b>
								se encuentra cursando el <b><span id="certificado_4_semestre_activo"></span></b> semestre del
								programa académico
								<b><span id="certificado_4_programa"></span></b> durante el periodo
								<b> <span id="certificado_4_periodo_actual"></span></b>
								en la jornada <b> <span id="certificado_4_jornada"></span> </b>, en el horario de
								<b> <span id="certificado_4_horario"></span></b></b><br><br><br>
								<span>La presente certificación se expide a solicitud del interesado(a).</span><br><br>
							</div>
							<!-- Contenedor para los datos del certificado de estiudio (inscripción al siguiente semestre)  -->
							<div align="justify" style="font-size:18px" id="estudio_siguiente" hidden="true">Que:
								<b><span id="certificado_5_nombre_estudiante" style="text-transform: uppercase;"></span></b>,
								identificado(a) con <span id="certificado_5_tipo_doc"></span> número <b>
									<span id="certificado_5_identificacion"></span></b>,
								expedida en <b><span id="certificado_5_expedido_en"
										style="text-transform: uppercase;"></span></b>
								se encuentra inscrito(a) para el <b> <span id="certificado_5_semestre_siguiente"></span></b>
								semestre del programa académico <b><span id="certificado_5_programa"></span></b>
								en la jornada <b> <span id="certificado_5_jornada"></span> </b>, en el horario de
								<b> <span id="certificado_5_horario"></span></b></b><br><br><br>
								<span>La presente certificación se expide a solicitud del interesado(a).</span><br><br>
							</div>
							<!-- Contenedor para los datos del certificado de solicitud de cesantías -->
							<div align="justify" style="font-size:18px" id="cesantias" hidden="true">Que:
								<b><span id="certificado_6_nombre_estudiante" style="text-transform: uppercase;"></span></b>,
								identificado(a) con <span id="certificado_6_tipo_doc"></span> número <b>
									<span id="certificado_6_identificacion"></span></b>,
								expedida en <b><span id="certificado_6_expedido_en"
										style="text-transform: uppercase;"></span></b>
								se encuentra inscrito(a) en el <b> <span id="certificado_6_semestre_actual"></span></b>
								semestre del programa académico <b><span id="certificado_6_programa"></span></b><br><br><br>
								El semestre tiene un valor de $. <br><br>
								<font size='3px'>Por favor consignar en la cuenta a nombre de la <b>CIAF</b></font>.
								<br><br><br><br><br>
								<span>La presente certificación se expide a solicitud del interesado(a).</span><br><br>
							</div>
							<!-- Contenedor para los datos del certificado de solicitud de paz y salvo -->
							<div align="justify" style="font-size:18px" id="paz_y_salvo" hidden="true">Que:
								<b><span id="certificado_7_nombre_estudiante" style="text-transform: uppercase;"></span></b>,
								identificado(a) con <span id="certificado_7_tipo_doc"></span> número <b>
									<span id="certificado_7_identificacion"></span></b>,
								expedida en <b><span id="certificado_7_expedido_en"
										style="text-transform: uppercase;"></span></b>
								cursó y aprobó los <b> <span id="certificado_7_semestre_actual"></span></b>
								semestres del programa académico <b><span id="certificado_7_programa"></span></b>, a la fecha se
								encuentra a
								<b>PAZ Y SALVO</b> con la institución por concepto <b>ACADÉMICO</b>.<br><br><br>
								<br><br><br><br><br>
								<span>La presente certificación se expide a solicitud del interesado(a).</span><br><br>
							</div>
							<!-- Contenedor para los datos del certificado de solicitud de Buena Conducta -->
							<div align="justify" style="font-size:18px" id="buena_conducta" hidden="true">Que:
								<b><span id="certificado_8_nombre_estudiante" style="text-transform: uppercase;"></span></b>,
								identificado(a) con <span id="certificado_8_tipo_doc"></span> número <b>
									<span id="certificado_8_identificacion"></span></b>,
								expedida en <b><span id="certificado_8_expedido_en"
										style="text-transform: uppercase;"></span></b>
								cursó y aprobó los <b> <span id="certificado_8_semestre_actual"></span></b>
								semestres del programa académico <b><span id="certificado_8_programa"></span></b>, a la fecha
								observó
								<b>BUENA CONDUCTA</b> durante el tiempo vinculado a la Institución Educativa como
								estudiante.<br><br><br>
								<br><br><br><br><br>
								<span>La presente certificación se expide a solicitud del interesado(a).</span><br><br>
							</div>
							<!-- Contenedor donde se imprimen los resultados de las consultas -->
							<div id="contenido_vista_previa">
							</div>
							<!-- Contenedor donde se muestra la fecha y la firma de coordinación Registro y Control -->
							<div id="pie_certificado" hidden="true">
								<b>
									<font size='3px'>Para constancia se firma en Pereira el día
										<span id="fecha_certificado"></span>.
									</font>
								</b><br><br><br><br>
								____________________________<br>
								<b>Wilbert Rene Ramirez Delgado</b><br>
								<b>Registro y Control Académico</b><br><br>
							</div>
							<div id="numero_sn" hidden="true">
								<span>SN 766-12-2015</span>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
<script type="text/javascript" src="scripts/certificados.js?<?php echo date(" Y-m-d-H:i:s"); ?>"></script>
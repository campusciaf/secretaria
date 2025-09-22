<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
	header("Location: ../");
} else {
	$menu = 14;
	$submenu = 1423;
	require 'header.php';
	if ($_SESSION['oncentervalentrevista'] == 1) {
?>
		<div id="precarga" class="precarga"></div>
		<div class="content-wrapper">
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-xl-6 col-9">
							<h2 class="m-0 line-height-16">
								<span class="titulo-2 fs-18 text-semibold">Entrevistas</span><br>
								<span class="fs-16 f-montserrat-regular">Aquí se da inicio a la transformación CIAF</span>
							</h2>
						</div>
						<div class="col-xl-6 col-3 pt-4 pr-4 text-right">
							<button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
						</div>
						<div class="col-12 migas">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
								<li class="breadcrumb-item active">Entrevistas</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
			<section class="container-fluid px-4 mx-0">
				<div class="row mx-0">
					<div class="col-12 m-0 p-0">
						<div class="row mx-0" id="data1"></div>
					</div>
					<div class="card col-12">
						<div class="row mx-0">
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
											<span class="text-semibold fs-20">Entrevistas</span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 table-responsive p-4" id="listadoregistros">
								<table id="tbllistado" class="table table-hover" style="width:100%">
									<thead>
										<th id="t-caso">Caso</th>
										<th id="t-identificacion" style="width:150px">Identificación</th>
										<th id="t-nombre">Nombre</th>
										<th id="t-whatsapp">Gestión estudiante</th>
										<th>% Riesgo</th>
                                        <th id="t-programa">Programa</th>
										<th id="t-jornada">Jornada</th>
										<th id="t-entrevista">Entrevista</th>
										<th id="t-validar">Validar</th>
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
	     <!-- inicio modal entrevista -->
		 <div id="myModalEntrevista" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Entrevista</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form action="formentrevista.php" method="POST">
                    <div class="row">
                        <input type="hidden" id="id_estudiante" name="id_estudiante">
                        <div class="form-group col-md-6">
                        <label for="salud_fisica">¿Cómo describirías tu salud física actualmente?</label>
                        <select name="salud_fisica" id="salud_fisica" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="5">Excelente</option>
                            <option value="4">Buena</option>
                            <option value="3">Regular</option>
                            <option value="2">Mala</option>
                            <option value="1">Muy mala</option>
                        </select>
                        </div>

                        <div class="form-group col-md-6">
                        <label for="salud_mental">¿Cómo describirías tu salud mental actualmente?</label>
                        <select name="salud_mental" id="salud_mental" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="5">Excelente</option>
                            <option value="4">Buena</option>
                            <option value="3">Regular</option>
                            <option value="2">Mala</option>
                            <option value="1">Muy mala</option>
                        </select>
                        </div>

                        <div class="col-12 py-2">
                        <div class="row">
                            <div class="col-12 pb-2">
                            <label for="condicion_especial">¿Tienes alguna condición médica, neurológica o emocional que requiera atención especial en CIAF?</label>
                            </div>
                            <div class="form-group col-4">
                            <select name="condicion_especial" id="condicion_especial" class="form-control">
                                <option value="" disabled selected>-- Selecciona una opción --</option>
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                            </div>
                            <div class="form-group col-md-8">
                            <input type="text" name="nombre_condicion_especial" id="nombre_condicion_especial" class="form-control" placeholder="Ingrese su condición">
                            </div>
                        </div>
                        </div>

                        <div class="form-group col-md-12 p-2">
                        <label for="estres_reciente">¿Has sentido estrés, ansiedad o tristeza con frecuencia en los últimos 6 meses?</label>
                        <select name="estres_reciente" id="estres_reciente" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                        </div>

                        <div class="form-group col-md-12 p-2">
                        <label for="desea_apoyo_mental">¿Te gustaría recibir apoyo en temas relacionados con la salud mental durante tu tiempo en CIAF?</label>
                        <select name="desea_apoyo_mental" id="desea_apoyo_mental" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                        </div>

                        <div class="form-group col-md-6 p-2">
                        <label for="costea_estudios">¿Eres tú quien asume los costos de tus estudios?</label>
                        <select name="costea_estudios" id="costea_estudios" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                        </div>

                        <div class="form-group col-md-6 p-2">
                        <label for="labora_actualmente">¿Laboras actualmente?</label>
                        <select name="labora_actualmente" id="labora_actualmente" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                        </div>

                        <div class="form-group col-md-6 p-2">
                        <label for="donde_labora">¿En qué empresa laboras?</label>
                        <input type="text" name="donde_labora" id="donde_labora" class="form-control" placeholder="Ingrese empresa">
                        </div>

                        <div class="form-group col-md-6 p-2">
                        <label for="tiempo_laborando">¿Cuánto tiempo llevas laborando en esta entidad?</label>
                        <select name="tiempo_laborando" id="tiempo_laborando" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="0 a 6 meses">0 a 6 meses</option>
                            <option value="6 meses a 1 año">6 meses a un año</option>
                            <option value="un año a dos años">un año a dos años</option>
                            <option value="mayor a dos años">mayor a dos años</option>
                        </select>
                        </div>

                        <div class="form-group col-xl-12 p-2">
                        <label for="desea_beca">¿Has solicitado o estás interesado en solicitar algún tipo de beca o ayuda financiera?</label>
                        <select name="desea_beca" id="desea_beca" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                        </div>

                        <div class="form-group col-xl-12 p-2">
                        <label for="responsabilidades_familiares">¿Tienes responsabilidades familiares que podrían afectar tu tiempo de estudio?</label>
                        <select name="responsabilidades_familiares" id="responsabilidades_familiares" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                        </div>

                        <div class="form-group col-xl-12 p-2">
                        <label for="seguridad_carrera">¿Qué tan seguro/a te sientes de que es el programa correcto para ti?</label>
                        <select name="seguridad_carrera" id="seguridad_carrera" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="5">Muy seguro</option>
                            <option value="4">Seguro</option>
                            <option value="3">Indeciso</option>
                            <option value="2">Poco seguro</option>
                            <option value="1">Nada seguro</option>
                        </select>
                        </div>

                        <div class="form-group col-xl-12 p-2">
                        <label for="penso_abandonar">¿Has considerado abandonar tus estudios en algún momento antes de comenzar?</label>
                        <select name="penso_abandonar" id="penso_abandonar" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                        </div>

                        <div class="form-group col-md-6 p-2">
                        <label for="desea_referir">¿Te gustaría referir personas para que inicien su experiencia profesional en CIAF?</label>
                        <select name="desea_referir" id="desea_referir" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                        </div>

                        <div class="form-group col-xl-6 p-2">
                        <label for="rendimiento_prev">¿Cómo describirías tu rendimiento académico en el colegio o estudios anteriores?</label>
                        <select name="rendimiento_prev" id="rendimiento_prev" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="5">Excelente</option>
                            <option value="4">Buena</option>
                            <option value="3">Regular</option>
                            <option value="2">Malo</option>
                            <option value="1">Muy malo</option>
                        </select>
                        </div>

                        <div class="col-12 py-2">
                        <div class="row">
                            <div class="col-12 pb-2">
                            <label for="necesita_apoyo_academico">¿Tienes alguna materia o área en la que sientas que necesitas apoyo adicional?</label>
                            </div>
                            <div class="form-group col-4">
                            <select name="necesita_apoyo_academico" id="necesita_apoyo_academico" class="form-control">
                                <option value="" disabled selected>-- Selecciona una opción --</option>
                                <option value="1">Sí</option>
                                <option value="2">No</option>
                            </select>
                            </div>
                            <div class="form-group col-md-8">
                            <input type="text" name="nombre_materia" id="nombre_materia" class="form-control" placeholder="¿Cuál materia?">
                            </div>
                        </div>
                        </div>

                        <div class="form-group col-xl-6 p-2">
                        <label for="tiene_habilidades_organizativas">¿Tienes las habilidades necesarias para organizarte y enfrentar las exigencias académicas?</label>
                        <select name="tiene_habilidades_organizativas" id="tiene_habilidades_organizativas" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                        </div>

                        <div class="form-group col-xl-6 p-2">
                        <label for="comodidad_herramientas_digitales">¿Qué tan cómodo te sientes con el uso de herramientas digitales para el aprendizaje?</label>
                        <select name="comodidad_herramientas_digitales" id="comodidad_herramientas_digitales" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="5">Muy cómodo</option>
                            <option value="4">Cómodo</option>
                            <option value="3">Neutral</option>
                            <option value="2">Poco cómodo</option>
                            <option value="1">Nada cómodo</option>
                        </select>
                        </div>

                        <div class="form-group col-md-6 p-2">
                        <label for="acceso_internet">¿Tienes internet en casa?</label>
                        <select name="acceso_internet" id="acceso_internet" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                        </div>

                        <div class="form-group col-md-6 p-2">
                        <label for="acceso_computador">¿Tienes computador en casa?</label>
                        <select name="acceso_computador" id="acceso_computador" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                        </div>

                        <div class="form-group col-md-6">
                        <label for="estrato">¿Cuál es tu estrato socioeconómico?</label>
                        <select name="estrato" id="estrato" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                        </select>
                        </div>

                        <div class="form-group col-md-6">
                        <label for="municipio_residencia">¿En qué municipio resides actualmente?</label>
                        <input type="text" name="municipio_residencia" id="municipio_residencia" class="form-control" placeholder="Ingrese el nombre">
                        </div>

                        <div class="form-group col-md-6">
                        <label for="direccion_residencia">¿Cuál es tu dirección de residencia actual?</label>
                        <input type="text" name="direccion_residencia" id="direccion_residencia" class="form-control" placeholder="Ingrese el nombre">
                        </div>

                        <div class="form-group col-xl-6 p-2">
                        <label for="nombre_referencia_familiar">Nombre completo de tu referencia familiar</label>
                        <input type="text" name="nombre_referencia_familiar" id="nombre_referencia_familiar" class="form-control" placeholder="Ingrese el nombre">
                        </div>

                        <div class="form-group col-md-6 p-2">
                        <label for="telefono_referencia_familiar">Número de contacto de tu referencia familiar</label>
                        <input type="text" name="telefono_referencia_familiar" id="telefono_referencia_familiar" class="form-control" placeholder="Teléfono">
                        </div>

                        <div class="form-group col-md-6 p-2">
                        <label for="parentesco_referencia_familiar">Parentesco con tu referencia familiar</label>
                        <select name="parentesco_referencia_familiar" id="parentesco_referencia_familiar" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="Padre">Padre</option>
                            <option value="Madre">Madre</option>
                            <option value="Pareja">Pareja</option>
                            <option value="Hermano/a">Hermano/a</option>
                            <option value="Tío/a">Tío/a</option>
                            <option value="Abuelo/a">Abuelo/a</option>
                            <option value="Otro">Otro</option>
                        </select>
                        </div>

                    </div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
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
<script type="text/javascript" src="scripts/oncentervalentrevista.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<script type="text/javascript" src="scripts/on_segui_tareas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<script type="text/javascript" src="scripts/whatsapp_module.js?<?= date("Y-m-d H:i:s") ?>"></script>
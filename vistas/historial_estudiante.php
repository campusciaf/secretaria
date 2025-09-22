<?php
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: login.php");
} else {

    $menu = 5;
    $submenu = 506;
    require 'header.php';
    if ($_SESSION['historial_estudiante'] == 1) {
?>
    <div id="precarga" class="precarga"></div>

    <div class="content-wrapper ">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-xl-8 col-9">
                        <h2 class="m-0 line-height-16">
                            <span class="titulo-2 fs-18 text-semibold">Historial Estudiante </span><br>
                            <span class="fs-14 f-montserrat-regular"> 
                                Todo lo que necesitas saber en un solo punto 
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
                            <li class="breadcrumb-item active"> Historial estudiante </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
            <section class="content" style="padding-top:0; margin:0; overflow-x:hidden;">

                <!--Fondo de la vista -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary" style="padding: 2% 1%">
                            <div class="row">
                                <div class="form-group col-xl-4 col-lg-5 col-md-5 col-12" id="seleccionprograma">
                                    <form class="row" name="formularioverificar" id="formularioverificar" method="POST">

                                        <div class="col-xl-10 col-lg-10 col-md-10 col-10 pr-0">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="form-floating">
                                                    <input type="number" placeholder="" value="" class="form-control border-start-0" name="credencial_identificacion" id="credencial_identificacion" maxlength="11">
                                                    <label>Número identificación</label>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback">Please enter valid input</div>
                                        </div>
                                        <div class="col-2 pl-0">
                                            <button type="submit" id="btnVerificar" class="btn btn-info py-3">Buscar</button>
                                        </div>

                                    </form>
                                </div>

                                <div id="mostrardatos" class="col-xl-8 col-lg-7 col-md-7 col-12"></div>

                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div id="buscar_caso_estudiante"></div>
                                    <div id="panel_resultado"></div><br>
                                </div>
                            </div>

                            <div id="ingresos_campus"></div>

                            <div id="menu_sofi"></div>
                            <div id="caracterizacion"></div>

                            <div id="listadospqrtabla">
                                <table id="tbllistapqr" class="table table-hover text-nowrap">
                                    <thead>
                                        <th>Asunto</th>
                                        <th>Opción</th>
                                        <th>Fecha</th>
                                        <th>estado</th>
                                        <th>opciones</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <th>Asunto</th>
                                        <th>Opción</th>
                                        <th>Fecha</th>
                                        <th>estado</th>
                                        <th>opciones</th>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="panel-body table-responsive" id="listadoregistros">
                                <table id="tbllistado" class="table table-hover text-nowrap">

                                    <thead>
                                        <th>Acciones</th>
                                        <th>Id estudiante</th>
                                        <th>Programa</th>
                                        <th>Jornada</th>
                                        <th>Semestre</th>
                                        <th>Grupo</th>
                                        <th>Escuela</th>
                                        <th>Estado</th>
                                        <th>Nuevo del</th>
                                        <th>Periodo Activo</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <th>Acciones</th>
                                        <th>Id estudiante</th>
                                        <th>Programa</th>
                                        <th>Jornada</th>
                                        <th>Semestre</th>
                                        <th>Grupo</th>
                                        <th>Escuela</th>
                                        <th>Estado</th>
                                        <th>Nuevo del</th>
                                        <th>Periodo Activo</th>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="panel-body" id="formularioregistros">
                                <h1>Generar Credenciales de Acceso</h1>
                                <form name="formulario" id="formulario" method="POST">
                                </form>
                            </div>

                            <div class="row">
                                <div id="listadomaterias" class="row" style="width: 100%"></div>
                            </div>

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
                                            <form action="mercadeo_entrevista_2.php" method="post" class="alert">
                                                <div class="row">

                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        ¿Quien sostiene sus estudios?<br>
                                                        <input type="text" name="sostiene" id="sostiene" class="form-control" value="" readonly="readonly">
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                        ¿Laboran actualmente?<br>
                                                        <input type="text" name="labora" id="labora" class="form-control" value="" readonly="readonly">
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        ¿Empresa?<br>
                                                        <input type="text" name="donde_labora" id="donde_labora" class="form-control" value="" readonly="readonly">
                                                    </div>
                                                    <div class="col-lg-6 col-md-4 col-sm-12 col-xs-12">
                                                        ¿cargo?<br>
                                                        <input type="text" name="cargo" id="cargo" class="form-control" value="" readonly="readonly">
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                        ¿Conoces el plan de estudios del programa?<br>
                                                        <input type="text" name="conoce_plan" id="conoce_plan" class="form-control" value="" readonly="readonly">
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    ¿Qué te motivó a estudiar este programa?<br><br>
                                                        <textarea name="motiva" id="motiva" rows="3" class="form-control" readonly="readonly"></textarea>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                        ¿Qué curso te gustaría tomar adicional?<br>
                                                        <input name="curso_ad" id="curso_ad" placeholder="Que curso te gustaria tomar" class="form-control" readonly="readonly"></input>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                        ¿Cuál crees que es tu mejor talento o habilidad?<br>
                                                        <input name="talento" id="talento" placeholder="Tienes algún talento o habilidad" class="form-control" readonly="readonly"></input>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                        ¿Te gustaría referir a personas para que inicien su proceso de formación en CIAF?<br>
                                                        <input name="referir" id="referir" placeholder="Referir a personas" class="form-control" readonly="readonly"></input>
                                                    </div>
                                                    <div class="form-group col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                        ¿Cuál sería el motivo o razón para que dejes de estudiar?<br>
                                                        <input name="dejar" id="dejar" placeholder="motivo o razón para que dejes de estudiar" class="form-control" readonly="readonly"></input>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        ¿Por qué eliges CIAF?<br>
                                                        <textarea name="razon" id="razon" rows="3" class="form-control" readonly="readonly"></textarea>
                                                    </div>
                                                </div>
                                                <!-- cierra row -->
                                            </form>
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="ocultar_tablas_pago">

                                <div class="tabla_info">
                                    <table id="tabla_info" class="table table-hover  table-responsive">
                                        <thead>
                                            <td>Cuotas</td>
                                            <td>Estado</td>
                                            <td>Periodo</td>
                                            <td>Consecutivo</td>
                                            <td>Programa</td>
                                            <td>Matrícula</td>
                                            <td>Financiado</td>
                                            <td>Descuento</td>
                                            <td>Inicio</td>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="9" class="jumbotron text-center bg-navy rounded-0"> Aquí aparecen
                                                    los estudiantes</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <td>Cuotas</td>
                                            <td>Estado</td>
                                            <td>Periodo</td>
                                            <td>Consecutivo</td>
                                            <td>Programa</td>
                                            <td>Matrícula</td>
                                            <td>Financiado</td>
                                            <td>Descuento</td>
                                            <td>Inicio</td>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <!-- muestra los soportes del estudiante -->
                            <form id="form_menutablist" method="post" class="menutablist"></form>

                            <div id="proceso_de_admision"></div>

                            <div id="listadosoportes">
                                <table id="tbllistadosoportes" class="table table-hover text-nowrap">
                                    <thead>
                                        <th>Nombre</th>
                                        <th>Soporte</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <th>Nombre</th>
                                        <th>Soporte</th>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- casos del estudiante -->
                            <div id="listadosquedate">
                                <table id="tbllistaquedate" class="table table-hover text-nowrap">
                                    <thead>
                                        <th>Caso</th>
                                        <th>Fecha</th>
                                        <th>Asunto</th>
                                        <th>Estado</th>
                                        <th>Ver</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <th>Caso</th>
                                        <th>Fecha</th>
                                        <th>Asunto</th>
                                        <th>Estado</th>
                                        <th>Ver</th>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="panel-body table-responsive" id="listaDatosocultar">
                                <table id="listadatos" class="table table-hover text-nowrap">
                                    <thead>

                                        <th>Nombre completo</th>
                                        <th>Genero</th>
                                        <th>Fecha de nacimiento</th>
                                        <th>Departamento de nacimiento</th>
                                        <th>Ciudad de nacimiento</th>
                                        <th>Departamento de residencia</th>
                                        <th>Municipio de residencia</th>
                                        <th>Dirección de residencia</th>
                                        <th>Barrio de residencia</th>
                                        <th>Estrato socioeconomico</th>
                                        <th>Telefono fijo</th>
                                        <th>Numero celular</th>
                                        <th>Grupo etnico</th>
                                        <th>Nombre etnico</th>
                                        <th>Tipo de sangre</th>
                                        <th>Instagram</th>
                                        <th>Correo personal</th>

                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
 <div id="listadosinfluencer" style="display:none;">
    <table id="tbllistainfluencer" class="table table-hover text-nowrap">
        <thead>
            <th>Fecha</th>
            <th>Mensaje</th>
            <th>Nivel</th>
            <th>Dimensión</th>
            <th>Docente</th>
            <th>Periodo</th>
            <th>Estado</th>
            <th>Responsable</th>
            <th>Respuesta</th>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>




                        </div><!-- /.box -->
                    </div><!-- /.col -->
            </section><!-- /.content -->
    </div><!-- /.content-wrapper -->


        <!-- modal casos del estudiante -->
        <div class="modal" id="myModalCasosQuedateEstudiante">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Casos Quedate</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div id="casosquedateestudiante"></div>
                    </div>


                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>

                </div>
            </div>
        </div>
        <!-- Modal para traer la tabla de los pagos por estudiante -->
        <div class="modal" id="myModaltraerpagos">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">SOFI</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div id="modal_pagos_estudiante"></div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>

                </div>
            </div>
        </div>


        <div id="myModalPQR" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">PQRSF</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div id="pqr"></div>
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
								
							</div>
						</form>
						<div id="resultado_cedula"></div>
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
<link href='../fullcalendar/css/main.css' rel='stylesheet' />
<script src='../fullcalendar/js/main.js'></script>
<script src='../fullcalendar/locales/es.js'></script>
<script type="text/javascript" src="scripts/historial_estudiante.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<script type="text/javascript" src="scripts/segui_tareas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<script type="text/javascript" src="scripts/agregar_segui_tareas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<script src="scripts/whatsapp_module.js?<?= date(" Y-m-d H:i:s") ?>"></script>
<style>
    .modal-fullscreen {
        width: 100vw;
        max-width: none;
        height: 100%;
        margin: 0;
    }

    .fc-daygrid-event-harness {
        cursor: pointer;
    }
</style>
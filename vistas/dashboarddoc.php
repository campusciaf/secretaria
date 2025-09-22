<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    if ($_SESSION['usuario_cargo'] != "Docente") {
        header("Location: ../");
    } else {
        $menu = 11;
        require 'header_docente.php';
    }
?>
<!-- fullCalendar -->
<link rel="stylesheet" href="../public/css/fullcalendar.min.css">
<link rel="stylesheet" href="../public/css/fullcalendar.print.min.css" media="print"> 	



<div class="content-wrapper">
   <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-xl-6 col-9">
					<h2 class="m-0 line-height-16 pl-4">
							<span class="titulo-2 fs-18 text-semibold" >Mi Tablero</span><br>
							<span class="fs-14 f-montserrat-regular">Tu plataforma virtual.</span>
					</h2>
                </div>
                <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                	<button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                </div>

            </div>
        </div>
    </div>

    <section class="container-fluid px-4">
		
		<div class="contenido" id="mycontenido">
			<div class="row">

				<div class="col-xl-7">
					<div class="row pb-2 boton-mandos">

                        <div class="col-xl-12 col-lg-12 d-flex  pb-2">
                            <ul>
                                <li><a onclick="listardatos(1)" id="opcion1">Hoy</a></li>
                                <li><a onclick="listardatos(2)" id="opcion2">Ayer</a></li>
                                <li><a onclick="listardatos(3)" id="opcion3">última semana</a></li>
                                <li><a onclick="listardatos(4)" id="opcion4">Este mes</a></li>
                                <li><a onclick="listardatos(5)" data-toggle="modal" data-target="#exampleModal" id="opcion5"> Rango de fecha </a></li>
                            </ul>
                        </div>

                        <div class="col-12 pt-2">
							<div class="row">

                                <div class="col-xl-4 col-lg-4 col-md-6 col-6 cursor-pointer my-2" onclick="mostrar_faltas()">
									<div class="row justify-content-center" id="t-paso1">
										<div class="col-12 hidden">
											<div class="row align-items-center">
												<div class="col-auto">
													<div class="avatar rounded bg-light-red text-red">
														<i class="fa-solid fa-check" aria-hidden="true"></i>
													</div>
												</div>
												<div class="col ps-0">
													<div class="small mb-0">Faltas</div>
													<h4 class="text-dark mb-0">
														<span class="text-semibold" id="dato_faltas">0</span> 
														<small class="text-regular fs-12">Faltas</small>
													</h4>
													<div class="small">Reportadas<span class="text-green"></span></div>
												</div>
											</div>
										</div>
									</div>
								</div>

                                <div class="col-xl-4 col-lg-4 col-md-6 col-6 cursor-pointer my-2" onclick="actividadesnuevas()">
									<div class="row justify-content-center" id="t-paso2">
										<div class="col-12 hidden">
											<div class="row align-items-center">
												<div class="col-auto">
													<div class="avatar rounded bg-light-blue text-primary">
                                                        <i class="fa-solid fa-laptop"></i>
													</div>
												</div>
												<div class="col ps-0">
													<div class="small mb-0">Actividades</div>
													<h4 class="text-dark mb-0">
														<span class="text-semibold" id="dato_actividades">0</span> 
														<small class="text-regular fs-12">Ok</small>
													</h4>
													<div class="small">Nuevas<span class="text-green"></span></div>
												</div>
											</div>
										</div>
									</div>
								</div>

                                <div class="col-xl-4 col-lg-4 col-md-6 col-6 cursor-pointer my-2" onclick="casosquedate()">
									<div class="row justify-content-center" id="t-paso3">
										<div class="col-12 hidden">
											<div class="row align-items-center">
												<div class="col-auto">
													<div class="avatar rounded bg-light-blue text-primary">
                                                        <i class="fa-solid fa-handshake-angle"></i>
													</div>
												</div>
												<div class="col ps-0">
													<div class="small mb-0">Casos</div>
													<h4 class="text-dark mb-0">
														<span class="text-semibold" id="dato_guia">0</span> 
														<small class="text-regular fs-12">Ok</small>
													</h4>
													<div class="small">Guia<span class="text-green"></span></div>
												</div>
											</div>
										</div>
									</div>
								</div>

                            </div>
						</div>

                        <div class="col-12 pt-3">

							<div class="row">

                                <div class="col-xl-4 col-lg-4 col-md-6 col-6 pointer" onclick="estudiantesacargo()" id="t-paso7">
									<div class="info-box">
										<span class="info-box-icon">
											<i class="fa-solid fa-database"></i>
										</span>
										<div class="info-box-content">
											<span class="info-box-text">Estudiantes a cargo</span>
											<span class="info-box-number fs-12" id="totalestudiantesacargo">0</span>
										</div>
									</div>
								</div>

                                <div class="col-xl-4 col-lg-4 col-md-6 col-6 pointer" onclick="verComentariosHeteroevaluacion()" data-toggle="modal" data-target="#modalPreguntas" title="Ver resultados por pregunta" id="t-paso8">
									<div class="info-box">
										<span class="info-box-icon">
                                            <i class="fa-solid fa-chart-line"></i>
										</span>
										<div class="info-box-content">
											<span class="info-box-text"> Evaluación Docente</span>
											<span class="info-box-number fs-12" id="porcentaje_evaluacion">0</span>
										</div>
									</div>
								</div>

                                <div class="col-xl-4 col-lg-4 col-md-6 col-12 pointer" id="t-paso9">
									<div class="info-box">
										<span class="info-box-icon">
                                            <i class="fa-solid fa-paperclip"></i>   
										</span>
										<div class="info-box-content">
											<span class="info-box-text"> Hoja de Vida</span>
											<span class="info-box-number fs-12" id="actualizacion_hoja_de_vida">0</span>
										</div>
									</div>
								</div>

                            </div>
                        </div>
                  

                    </div>
                </div>

                <div class="col-xl-5 ">
                    <div class="row">

                    
                        <div class="col-xl-4 col-lg-4 col-md-4 col-6 d-flex align-items-stretch" id="t-paso4">
                            <div class="card col-12 pt-2">

                                <div class="row">
                                    <div class="col-4">
                                        <i class="fa-solid fa-right-to-bracket bg-light-green p-2 rounded fa-2x text-success"></i>
                                    </div>
                                    <div class="col-8 line-height-18">
                                        <div class="small text-regular">Ingresos</div>
                                        <div class="fs-20">Campus</div>
                                    </div>
                                    <div class="col-12">
                                        <hr>
                                    </div>
                                    <div class="col-12" id="dato_ingreso">

                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-4 col-6 d-flex align-items-stretch" id="t-paso5">
                            <div class="card col-12 pt-2">

                                <div class="row">
                                    <div class="col-4">
                                        <i class="fa-brands fa-buromobelexperte  bg-light-green p-2 rounded fa-2x text-success"></i>
                                    </div>
                                    <div class="col-8 line-height-18">
                                        <div class="fs-14">Siguiente</div>
                                        <div class="fs-20">CLASE</div>
                                    </div>
                                    <div class="col-12">
                                        <hr>
                                    </div>
                                    <div class="col-12" id="datossiguienteclase">

                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="col-xl-4 col-lg-4 col-md-4 col-12 d-flex align-items-stretch" >
                            <div class="card col-12 pt-2" id="t-paso6">

                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-auto">
                                        <i class="fa-solid fa-user-check bg-light-green p-2 rounded fa-2x text-success"></i>
                                    </div>
                                    <div class="col-8 line-height-18">
                                        <div class="small text-regular">Mi</div>
                                        <div class="fs-20">Perfil</div>
                                    </div>
                                    <div class="col-12">
                                        <hr>
                                    </div>
                                    <div class="col-12" id="dato_perfil_actualizado">

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    
    </section>

    <section class="container-fluid px-4 mb-4">
        <div class="row">
            <div class="col-xl-8">
                <div class="row">
                    <div id="precarga1" class="precarga-mini"></div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">Ultimos ingresos al campus</div>
                    <div id="chartContainer" style="height: 370px; width: 100%;" class="col-12"></div>
                </div>
            </div>
        
            
            
        </div>
    </section>
</div>


    <div class="modal" id="myModalIngresosDocentes">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Ingreso Docentes</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="datosusuario_docente"></div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="myModalFaltas">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Faltas Reportadas</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="datosusuario_faltas"></div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="myModalActividades">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Actividades</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="datosusuario_actividades"></div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="myModalCasoQuedate">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Caso Quedate</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="datosusuario_quedate"></div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="myModalPerfilactualizado">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Perfil Actualizado</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="datosusuario_perfilactualizado"></div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="myModalEstudiantesacargo">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Estudiantes a cargo</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="datosusuario_estudiantesacargo"></div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="myModalHojadevidanueva">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Hoja de vida</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="datosusuario_hoja_de_vida_nueva"></div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para selcionar el rango de fecha-->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Seleccionar un rango</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">x</button>
                </div>
                <div class="modal-body">
                    <div class="group col-12">
                        <input type="date" value="" name="fecha-inicio" id="fecha-inicio">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Fecha de inicial</label>
                    </div>
                    <div class="group col-12">
                        <input type="date" value="" name="fecha-hasta" id="fecha-hasta">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Fecha de final</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                    <button class="btn btn-success" type="button" onclick="listarrango()"> Buscar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL Comentarios Heteroevaluacion -->
    <div class="modal fade" id="modalPreguntas" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Resultados Heteroevaluación </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row box_comentarios">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
        
    </div>


<?php
    require 'footer_docente.php';
}
ob_end_flush();
?>



<script type="text/javascript" src="scripts/dashboarddoc.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<script src="../bower_components/moment/moment.js"></script>
<script src="../bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<script src="../bower_components/fullcalendar/dist/locale/es.js"></script>

</body>

</html>
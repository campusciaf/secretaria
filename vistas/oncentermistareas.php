<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
   header("Location: ../");
} else {
   $menu = 14;
   $submenu = 1407;
   require 'header.php';

   if ($_SESSION['oncentermistareas'] == 1) {
?>
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
                     <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Mis tareas</span><br>
                        <span class="fs-16 f-montserrat-regular">Optimice tu rendimiento gestionando tus tareas</span>
                     </h2>
                  </div>
                  <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                     <button class="btn btn-sm btn-outline-warning px-2 py-0 primer_tour" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                     <button class="btn btn-sm btn-outline-warning px-2 py-0 d-none segundo_tour" onclick='iniciarSegundoTour()'><i class="fa-solid fa-play"></i> Tour 2da parte</button>
                  </div>

                  <div class="col-12 migas">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Mis Tareas</li>
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
               <div class="col-12">
                  <div class="row d-flex justify-content-center py-3">

                     <div class="col-xl-2 col-lg-4 col-md-6 col-6 cursor-pointer my-2">
                        <div class="row justify-content-center">
                           <div class="col-12 hidden">
                              <div class="row align-items-center" id="t-tg">
                                 <div class="col-auto">
                                    <div class="avatar rounded bg-light-white text-black">
                                       <i class="fa-solid fa-tags"></i>
                                    </div>
                                 </div>
                                 <div class="col ps-0">
                                    <div class="small mb-0">Total</div>
                                    <h4 class="text-dark mb-0">
                                       <span class="titulo-2 fs-24" id="datogeneral">0</span>
                                       <small class="text-regular">OK</small>
                                    </h4>
                                    <div class="small">General <span class="text-green"></span></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <div class="col-xl-2 col-lg-4 col-md-6 col-6 cursor-pointer my-2">
                        <div class="row justify-content-center">
                           <div class="col-12 hidden">
                              <div class="row align-items-center" id="t-tc">
                                 <div class="col-auto">
                                    <div class="avatar rounded bg-light-green text-success">
                                       <i class="fa-solid fa-check" aria-hidden="true"></i>
                                    </div>
                                 </div>
                                 <div class="col ps-0">
                                    <div class="small mb-0">Total</div>
                                    <h4 class="text-dark mb-0">
                                       <span class="titulo-2 fs-24" id="cumplidas">0</span>
                                       <small class="text-regular">OK</small>
                                    </h4>
                                    <div class="small">Cumplidas <span class="text-green"></span></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <div class="col-xl-2 col-lg-4 col-md-6 col-6 cursor-pointer my-2">
                        <div class="row justify-content-center">
                           <div class="col-12 hidden">
                              <div class="row align-items-center" id="t-tp">
                                 <div class="col-auto">
                                    <div class="avatar rounded bg-light-yellow text-warning">
                                       <i class="fa-solid fa-triangle-exclamation"></i>
                                    </div>
                                 </div>
                                 <div class="col ps-0">
                                    <div class="small mb-0">Total</div>
                                    <h4 class="text-dark mb-0">
                                       <span class="titulo-2 fs-24" id="pendientes">0</span>
                                       <small class="text-regular">OK</small>
                                    </h4>
                                    <div class="small">Pendientes <span class="text-green"></span></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <div class="col-xl-2 col-lg-4 col-md-6 col-6 cursor-pointer my-2">
                        <div class="row justify-content-center">
                           <div class="col-12 hidden">
                              <div class="row align-items-center" id="t-tn">
                                 <div class="col-auto">
                                    <div class="avatar rounded bg-light-red text-danger">
                                       <i class="fa-solid fa-xmark"></i>
                                    </div>
                                 </div>
                                 <div class="col ps-0">
                                    <div class="small mb-0">Total</div>
                                    <h4 class="text-dark mb-0">
                                       <span class="titulo-2 fs-24" id="nocumplidas">0</span>
                                       <small class="text-regular">OK</small>
                                    </h4>
                                    <div class="small">No Cumplidas <span class="text-green"></span></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <div class="col-xl-2 col-lg-4 col-md-6 col-6 cursor-pointer my-2">
                        <div class="row justify-content-center">
                           <div class="col-12 hidden">
                              <div class="row align-items-center" id="t-td">
                                 <div class="col-auto">
                                    <div class="avatar rounded bg-light-blue text-primary">
                                       <i class="fa-regular fa-sun"></i>
                                    </div>
                                 </div>
                                 <div class="col ps-0">
                                    <div class="small mb-0">Total</div>
                                    <h4 class="text-dark mb-0">
                                       <span class="titulo-2 fs-24" id="deldia">0</span>
                                       <small class="text-regular">OK</small>
                                    </h4>
                                    <div class="small">Del día <span class="text-green"></span></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                  </div>
               </div>

               <div class="col-xl-4 datoshoy px-4"></div>

               <div class="col-xl-8 datos px-4"></div>

               <div class="col-md-12 datos_usuario px-4" hidden></div>
               <!-- /.col -->
            </div>
            <!-- /.row -->
         </section>
         <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
      <!--Fin-Contenido-->
      <!-- inicio modal agregar seguimiento -->
      <div class="modal" id="myModalAgregar">
         <div class="modal-dialog modal-xl">
            <div class="modal-content">
               <!-- Modal Header -->
               <div class="modal-header">
                  <h4 class="modal-title">Consulta</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div class="modal-body">
                  <div id="agregarContenido">

                     <div class="row">
                        <div class="col-12" id="accordion">
                           <div class="card-header tono-4">
                              <h4 class="card-title w-100">
                                 <a class="d-block w-100 titulo-2 fs-14" data-toggle="collapse" href="#collapseOne" aria-expanded="true">
                                    <i class="fa-regular fa-address-card bg-light-blue text-primary p-2" aria-hidden="true"></i>
                                    Datos de Contacto
                                 </a>
                              </h4>
                           </div>
                           <div id="collapseOne" class="collapse in" data-parent="#accordion">
                              <div class="card-body tono-3">

                                 <div class="row">
                                    <div class="col-xl-6">
                                       <dt>Nombre</dt>
                                       <dd>Santiago Pérez Rojas</dd>
                                       <dt>Programa</dt>
                                       <dd>Nivel 1 - Técnica profesional en programación de software</dd>
                                       <dt>Celular</dt>
                                       <dd>3147897352</dd>
                                       <dt>Email</dt>
                                       <dd>feraligatr2045@gmail.com</dd>
                                       <dt>Fecha de Ingreso</dt>
                                       <dd>jueves, 15 de octubre de 2020 a las 16:30:41 del 2020-2</dd>
                                       <dt>Medio</dt>
                                       <dd>Asesor</dd>
                                    </div>
                                    <div class="col-xl-6">
                                       <dt>Conocio</dt>
                                       <dd>Búsqueda Google</dd>
                                       <dt>Contacto</dt>
                                       <dd>CIAF contactó</dd>
                                       <dt>Modalidad</dt>
                                       <dd></dd>
                                       <dt>Estado</dt>
                                       <dd>No_Interesado</dd>
                                       <dt>Campaña</dt>
                                       <dd>2021-1</dd>

                                    </div>
                                 </div>

                              </div>
                           </div>
                           <div class="card-header tono-4">
                              <h4 class="card-title w-100">
                                 <a class="d-block w-100 titulo-2 fs-14" data-toggle="collapse" href="#collapseTwo">
                                    <i class="fa-solid fa-school bg-light-blue p-2 text-primary" aria-hidden="true"></i>
                                    Datos Academicos
                                 </a>
                              </h4>
                           </div>
                           <div id="collapseTwo" class="collapse" data-parent="#accordion">
                              <div class="card-body tono-3">

                                 <div class="row">
                                    <div class="col-xl-6">
                                       <dl class="dl-horizontal">
                                          <dt>Nivel de Escolaridad</dt>
                                          <dd></dd>
                                          <dt>Nombre Colegio</dt>
                                          <dd></dd>
                                          <dt>Fecha Graduacion</dt>
                                          <dd>0000-00-00</dd>
                                          <dt>Jornada Academico</dt>
                                          <dd></dd>
                                          <dt>Departamento Academico</dt>
                                          <dd></dd>
                                          <dt>Municipio Academico</dt>
                                          <dd></dd>
                                       </dl>
                                    </div>
                                    <div class="col-xl-6">

                                       <dt>Codigo Pruebas</dt>
                                       <dd></dd>
                                       <dt>Codigo Saber Pro</dt>
                                       <dd></dd>
                                       <dt>Colegio Articulacion</dt>
                                       <dd></dd>
                                       <dt>Grado Articulacion</dt>
                                       <dd>10</dd>
                                       <dt>Campaña</dt>
                                       <dd>2021-1</dd>

                                    </div>
                                 </div>

                              </div>
                           </div>


                        </div>

                     </div>
                  </div>

                  <div class="row mt-4">

                     <div class="col-6">
                        <form name="formularioAgregarSeguimiento" id="formularioAgregarSeguimiento" method="POST" class="row p-0 m-0">
                           <div class="col-12 card p-2">
                              <div class="row">
                                 <div class="col-12">
                                    <div class="row p-0 borde-bottom">
                                       <div class="col-12 p-2">
                                          <div class="row align-items-center">
                                             <div class="pl-4">
                                                <span class="rounded bg-light-green p-2 text-success ">
                                                   <i class="fa-solid fa-list-check" aria-hidden="true"></i>
                                                </span>

                                             </div>
                                             <div class="col-10">
                                                <div class="col-5 fs-14 line-height-18">
                                                   <span class="">Registrar un</span> <br>
                                                   <span class="text-semibold fs-20">Seguimiento</span>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>

                                 <input type="hidden" name="id_estudiante_agregar" id="id_estudiante_agregar" value="24933">

                                 <div class="col-12 pt-3">
                                    <span id="contador small">150</span> Caracteres permitidos
                                    <textarea class="form-control" name="mensaje_seguimiento" id="mensaje_seguimiento" maxlength="150" placeholder="Escribir Seguimiento" rows="6" required="" onkeyup="cuenta()"></textarea>
                                 </div>

                                 <div class="col-12 mt-3 pl-3">
                                    <div class="radio pt-2">
                                       <label><input type="radio" name="motivo_seguimiento" id="motivo_seguimiento" value="Cita" required=""> Cita</label>
                                    </div>
                                    <div class="radio pt-2">
                                       <label><input type="radio" name="motivo_seguimiento" value="Llamada"> Llamada</label>
                                    </div>
                                    <div class="radio pt-2">
                                       <label><input type="radio" name="motivo_seguimiento" value="Seguimiento"> Seguimiento</label>
                                    </div>

                                 </div>

                                 <div class="col-12 text-right pt-4">
                                    <button class="btn btn-success" type="submit" id="btnGuardarSeguimiento"><i class="fa fa-save" aria-hidden="true"></i> Guardar Seguimiento</button>
                                 </div>
                              </div>
                           </div>
                        </form>
                     </div>

                     <div class="col-6">
                        <form name="formularioTarea" id="formularioTarea" method="POST" class="row p-0 m-0">
                           <div class="ol-12 card p-2">
                              <div class="row">

                                 <div class="col-12">
                                    <div class="row p-0 borde-bottom">
                                       <div class="col-12 p-2">
                                          <div class="row align-items-center">
                                             <div class="pl-4">
                                                <span class="rounded bg-light-red p-2 text-danger ">
                                                   <i class="fa-solid fa-list-check" aria-hidden="true"></i>
                                                </span>

                                             </div>
                                             <div class="col-10">
                                                <div class="col-5 fs-14 line-height-18">
                                                   <span class="">Programar una</span> <br>
                                                   <span class="text-semibold fs-20">Tarea</span>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>

                                 <input type="hidden" name="id_estudiante_tarea" id="id_estudiante_tarea" value="">
                                 <div class="col-12 pt-4" id="contadortarea">
                                    150 Caracteres permitidos
                                 </div>
                                 <div class="col-12">
                                    <textarea class="form-control" name="mensaje_tarea" id="mensaje_tarea" maxlength="150" placeholder="Escribir Mensaje" rows="6" required="" onkeyup="cuentatarea()"></textarea>
                                 </div>
                                 <div class="col-12">
                                    <div class="row">
                                       <div class="col-12 pb-4 pl-3">
                                          <div class="custom-control custom-radio custom-control-inline">
                                             <input type="radio" class="custom-control-input" id="customRadio4" name="motivo_tarea" value="cita" required="">
                                             <label class="custom-control-label" for="customRadio4">Cita</label>
                                          </div>
                                          <div class="custom-control custom-radio custom-control-inline">
                                             <input type="radio" class="custom-control-input" id="customRadio5" name="motivo_tarea" value="llamada" required="">
                                             <label class="custom-control-label" for="customRadio5">Llamada</label>
                                          </div>
                                          <div class="custom-control custom-radio custom-control-inline">
                                             <input type="radio" class="custom-control-input" id="customRadio6" name="motivo_tarea" value="seguimiento" required="">
                                             <label class="custom-control-label" for="customRadio6">Seguimiento</label>
                                          </div>
                                       </div>

                                       <div class="col-xl-6 col-lg-6 col-md-12 col-12">
                                          <div class="form-group mb-3 position-relative check-valid">
                                             <div class="form-floating">
                                                <input type="date" placeholder="" value="" class="form-control border-start-0" name="fecha_programada" id="fecha_programada" required="">
                                                <label>Día de la tarea</label>
                                             </div>
                                          </div>
                                          <div class="invalid-feedback">Please enter valid input</div>
                                       </div>

                                       <div class="col-xl-6 col-lg-6 col-md-12 col-12">
                                          <div class="form-group mb-3 position-relative check-valid">
                                             <div class="form-floating">
                                                <input type="time" placeholder="" value="" class="form-control border-start-0" name="hora_programada" id="hora_programada" required="">
                                                <label>Hora de la tarea</label>
                                             </div>
                                          </div>
                                          <div class="invalid-feedback">Please enter valid input</div>
                                       </div>


                                       <div class="col-12 text-right">
                                          <button type="submit" id="btnGuardarTarea" name="enviar tareas" class="btn btn-danger "><i class="fa fa-save" aria-hidden="true"></i> Guadar Tarea</button>
                                       </div>

                                    </div>
                                 </div>

                              </div>
                           </div>

                        </form>
                     </div>

                  </div>

               </div>

            </div>
         </div>
      </div>
      <!-- fin modal agregar seguimiento -->
      <!-- inicio modal historial -->
      <div class="modal" id="myModalHistorial">
         <div class="modal-dialog modal-xl">
            <div class="modal-content">
               <!-- Modal Header -->
               <div class="modal-header">
                  <h6 class="modal-title">Listado Consulta</h6>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div class="modal-body">

                  <div id="historial"></div>

                  <div class="col-12 mt-4">
                     <div class="card card-tabs">
                        <div class="card-header p-0 pt-1">
                           <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                              <li class="nav-item">
                                 <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Seguimiento</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Tareas Programadas</a>
                              </li>

                           </ul>
                        </div>
                        <div class="card-body p-0">
                           <div class="tab-content" id="custom-tabs-one-tabContent">
                              <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">

                                 <div class="row">
                                    <div class="col-12 p-4">
                                       <table id="tbllistadohistorial" class="table" width="100%">
                                          <thead>
                                             <th>Caso</th>
                                             <th>Motivo</th>
                                             <th>Observaciones</th>
                                             <th>Fecha de observación</th>
                                             <th>Asesor</th>
                                          </thead>
                                          <tbody>
                                          </tbody>
                                       </table>
                                    </div>
                                 </div>
                              </div>
                              <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">

                                 <table id="tbllistadoHistorialTareas" class="table" width="100%">
                                    <thead>
                                       <th>Estado</th>
                                       <th>Motivo</th>
                                       <th>Observaciones</th>
                                       <th>Fecha de observación</th>
                                       <th>Asesor</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>


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

   <?php
   } else {
      require 'noacceso.php';
   }

   require 'footer.php';
   ?>

   <script type="text/javascript" src="scripts/oncentermistareas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
   <script type="text/javascript" src="scripts/whatsapp_module.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>

<?php
}
ob_end_flush();
?>
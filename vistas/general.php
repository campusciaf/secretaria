<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
   header("Location: ../");
} else {
   $menu = 35;
   $submenu = 3501;
   require 'header.php';
   if ($_SESSION['general'] == 1) {
   }
?>
   <!-- fullCalendar -->
   <link rel="stylesheet" href="../public/css/fullcalendar.min.css">
   <link rel="stylesheet" href="../public/css/fullcalendar.print.min.css" media="print">
   <div id="precarga" class="precarga"></div>
   <div class="content-wrapper">
      <div class="content-header">
         <div class="container-fluid">
            <div class="row mb-2">
               <div class="col-xl-6 col-9">
                  <h2 class="m-0 line-height-16 pl-4">
                     <span class="titulo-2 fs-18 text-semibold">Mi Tablero</span><br>
                     <span class="fs-14 f-montserrat-regular">Tu plataforma virtual.</span>
                  </h2>
               </div>
               <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                  <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
               </div>
            </div>
         </div>
      </div>
      <section class="content p-0">
         <div class="contenido p-4" id="mycontenido">
            <!-- panel de mandos -->
            <div class="row ">
               <div class="col-xl-8">
                  <div class="row pb-2 boton-mandos">
                     <div class="col-xl-12 col-lg-12 d-flex  pb-2">
                        <ul>
                           <li><a onclick="listardatos(1)" id="opcion1"> Hoy </a></li>
                           <li><a onclick="listardatos(2)" id="opcion2"> Ayer </a></li>
                           <li><a onclick="listardatos(3)" id="opcion3"> Semana </a></li>
                           <li><a onclick="listardatos(4)" id="opcion4"> Mes </a></li>
                           <li><a onclick="listardatos(5)" data-toggle="modal" data-target="#exampleModal" id="opcion5"> Rango</a></li>
                        </ul>
                     </div>
                  </div>
                  <div class="row pb-2">
                     <div class="col-xl-4 col-lg-4 col-md-6 col-6 cursor-pointer my-2" onclick="caracterizados()">
                        <div class="row justify-content-center">
                           <div class="col-12 hidden">
                              <div class="row align-items-center" id="t-paso1">
                                 <div class="col-auto">
                                    <div class="avatar rounded bg-light-green text-success">
                                       <i class="fa-solid fa-check"></i>
                                    </div>
                                 </div>
                                 <div class="col ps-0">
                                    <div class="small mb-0">Estudiantes</div>
                                    <h4 class="text-dark mb-0">
                                       <span class="text-semibold" id="dato_caracterizados">52000</span>
                                       <small class="text-regular">OK</small>
                                    </h4>
                                    <div class="small">Caracterizados <span class="text-green"></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-xl-4 col-lg-4 col-md-6 col-6 cursor-pointer my-2" onclick="actividadesnuevas()">
                        <div class="row justify-content-center">
                           <div class="col-12 hidden">
                              <div class="row align-items-center" id="t-paso2">
                                 <div class="col-auto">
                                    <div class="avatar rounded bg-light-purple text-purple">
                                       <i class="fa-solid fa-laptop"></i>
                                    </div>
                                 </div>
                                 <div class="col ps-0">
                                    <div class="small mb-0">PEA</div>
                                    <h4 class="text-dark mb-0">
                                       <span class="text-semibold" id="dato_actividades">52000</span>
                                       <small class="text-regular">OK</small>
                                    </h4>
                                    <div class="small">Actividades <span class="text-green"></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-xl-4 col-lg-4 col-md-6 col-12 cursor-pointer my-2" onclick="hojadevidanueva()">
                        <div class="row justify-content-center" id="t-paso3">
                           <div class="col-12 hidden">
                              <div class="row align-items-center" id="t-paso3">
                                 <div class="col-auto">
                                    <div class="avatar rounded bg-light-green text-success">
                                       <i class="fa-solid fa-paperclip"></i>
                                    </div>
                                 </div>
                                 <div class="col ps-0">
                                    <div class="small mb-0">Banco HV</div>
                                    <h4 class="text-dark mb-0">
                                       <span class="text-semibold" id="dato_cv">52000</span>
                                       <small class="text-regular">HV</small>
                                    </h4>
                                    <div class="small">Hojas de vida <span class="text-green"></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-xl-3 col-lg-4 col-md-6 col-12" id="t-paso6">
                        <div class="info-box">
                           <span class="info-box-icon bg-light-red elevation-1">
                              <i class="fa-solid fa-person-circle-exclamation text-danger"></i>
                           </span>
                           <div class="info-box-content cursor-pointer" onclick="mostrar_faltas()">
                              <span class="info-box-text">Faltas reportadas</span>
                              <span class="info-box-number" id="dato_faltas">
                              </span>
                           </div>
                        </div>
                     </div>
                     <div class="col-xl-3 col-lg-4 col-md-6 col-12" id="t-paso7">
                        <div class="info-box">
                           <span class="info-box-icon "><i class="fa-solid fa-users-viewfinder"></i></span>
                           <div class="info-box-content cursor-pointer" onclick="casosquedate()">
                              <span class="info-box-text">Casos Quédate</span>
                              <span class="info-box-number" id="dato_quedate">
                              </span>
                           </div>
                        </div>
                     </div>

                     <div class="col-xl-3 col-lg-4 col-md-6 col-12" id="t-paso8">
                        <div class="info-box">
                           <span class="info-box-icon">
                              <i class="fa-solid fa-headset"></i>
                           </span>
                           <div class="info-box-content cursor-pointer" onclick="contactanos()">
                              <span class="info-box-text">PQRSF</span>
                              <span class="info-box-number" id="dato_contactanos">
                              </span>
                           </div>
                        </div>
                     </div>

                     <div class="col-xl-3 col-lg-4 col-md-6 col-12" id="t-paso9">
                        <div class="info-box">
                           <span class="info-box-icon" data-toggle="modal" data-target="#clasesDelDiaModal">
                              <i class="fa-solid fa-calendar-days "></i>
                           </span>
                           <div class="info-box-content cursor-pointer" data-toggle="modal" data-target="#clasesDelDiaModal">
                              <span class="info-box-text">Clases del día</span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-4 col-lg-8 col-md-6 col-12">
                  <div class="row">
                     <div class="col-xl-6 col-lg-6 col-md-6 col-12" id="t-paso4">
                        <div class="card col-12 pt-2">
                           <div class="row">
                              <div class="col-4">
                                 <i class="fa-solid fa-right-to-bracket bg-light-blue avatar rounded fa-2x text-azul"></i>
                              </div>
                              <div class="col-8 pt-2">
                                 <div class="small text-regular">Ingresos</div>
                                 <div class="fs-20">CAMPUS</div>
                              </div>
                              <div class="col-12">
                                 <hr>
                              </div>
                              <div class="col-6">
                                 <p class="text-secondary small mb-0">Colaboradores</p>
                                 <p class="pointer" id="dato_funcionarios" onclick="mostrar_nombre_funcionario()" title="Ver Estudiantes">55.15 k</p>
                              </div>
                              <div class="col-6 text-right">
                                 <p class="text-secondary small mb-0">Docentes</p>
                                 <p class="pointer" id="dato_docentes" onclick="mostrar_nombre_docente()" title="Ver Estudiantes">11.2 k</p>
                              </div>
                              <div class="col-6">
                                 <p class="text-secondary small mb-0">Estudiantes</p>
                                 <p class=" pointer" id="dato_estudiantes" onclick="mostrar_nombre_estudiante()" title="Ver Estudiantes">1.5 m</p>
                              </div>

                              <div class="col-6 text-right">
                                 <p class="text-secondary small mb-0">Total</p>
                                 <p>60.01 k</p>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-xl-6 col-lg-6 col-md-6 col-12" id="t-paso5">
                        <div class="card col-12 pt-2">
                           <div class="row">
                              <div class="col-4">
                                 <i class="fa-solid fa-user-check bg-light-green avatar rounded fa-2x text-success"></i>
                              </div>
                              <div class="col-8 pt-2">
                                 <div class="small text-regular">Perfiles</div>
                                 <div class="fs-20">OK</div>
                              </div>
                              <div class="col-12">
                                 <hr>
                              </div>
                              <div class="col-6">
                                 <p class="text-secondary small mb-0">Colaboradores</p>
                                 <p class="pointer" onclick="perfilesactualizadosadministradores()" id="dato_perfil">55.15 k</p>
                              </div>

                              <div class="col-6 text-right">
                                 <p class="text-secondary small mb-0">Docentes</p>
                                 <p class="pointer" onclick="perfilesactualizadosdocente()" id="dato_perfildoc">11.2 k</p>
                              </div>

                              <div class="col-6">
                                 <p class="text-secondary small mb-0">Estudiantes</p>
                                 <p class=" pointer" onclick="perfilesactualizadosestudiante()" id="dato_perfilest">1.5 m</p>
                              </div>

                              <div class="col-6 text-right">
                                 <p class="text-secondary small mb-0">Total</p>
                                 <p>60.01 k</p>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
   </div>

   <!-- Modal -->
   <div class="modal fade" id="clasesDelDiaModal" tabindex="-1" aria-labelledby="clasesDelDiaModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">
                  <h6 class="modal-title" id="clasesDelDiaModalLabel"> Clases del Día
               </h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               <div class="container-fluid pb-1">
                  <div class="row divEscuelas">
                  </div>
               </div>
               <div id="clasesDelDia"></div>
            </div>
         </div>
      </div>
   </div>

   <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Seleccionar un rango</h5>
               <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
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

   <!-- <div class="modal fade" id="modalCalendario" tabindex="-1" role="dialog" aria-labelledby="modalCalendario" aria-hidden="true">
      <form method="POST">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <b>
                     <h3 class="modal-title" id="modalCalendarioLabel">Ver Evento</h3>
                  </b>
               </div>
               <div class="modal-body">
                  <input type="hidden" id="idActividad" name="idActividad" /><br>
                  <div class="form-row">
                     <div class="form-group col-md-12">
                        <label>Título: </label>
                        <input class="form-control" type="text" id="txtTitulo" name="txtTitulo" placeholder="Título del Evento" disabled />
                     </div>
                     <div class="form-group col-md-6">
                        <label>Fecha Inicio:</label>
                        <input class="form-control" type="date" id="txtFechaInicio" name="txtFechaInicio" disabled />
                     </div>
                     <div class="form-group col-md-6">
                        <label>Fecha Fin:</label>
                        <input class="form-control" type="date" id="txtFechaFin" name="txtFechaFin" disabled />
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" onclick="LimpiarFormulario()" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
               </div>
            </div>
         </div>
      </form>
   </div> -->

   <div class="modal" id="myModalIngresosFuncionarios">
      <div class="modal-dialog modal-xl modal-dialog-centered">
         <div class="modal-content">            <div class="modal-header">
               <h4 class="modal-title">
                  <h6 class="modal-title">Ingreso Colaboradores
               </h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               <div id="datosusuario"></div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
         </div>
      </div>
   </div>
   <div class="modal" id="myModalIngresosDocentes">
      <div class="modal-dialog modal-xl modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">
                  <h6 class="modal-title">Ingreso Docentes
               </h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               <div id="datosusuario_docente"></div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
         </div>
      </div>
   </div>

   <div class="modal" id="myModalIngresosEstudiantes">
      <div class="modal-dialog modal-xl modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">
                  <h6 class="modal-title">Ingreso Estudiantes
               </h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               <div id="datosusuario_estudiante"></div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
         </div>
      </div>
   </div>

   <div class="modal" id="myModalFaltas">
      <div class="modal-dialog modal-xl modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">
                  <h6 class="modal-title">Faltas Reportadas
               </h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               <div id="datosusuario_faltas"></div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
         </div>
      </div>
   </div>

   <div class="modal" id="myModalCasoQuedate">
      <div class="modal-dialog modal-xl modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">
                  <h6 class="modal-title">Quédate
               </h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               <div id="datosusuario_quedate"></div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
         </div>
      </div>
   </div>

   <div class="modal" id="myModalCasoContactanos">
      <div class="modal-dialog modal-xl modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">
                  <h6 class="modal-title">PQRSF
               </h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               <div id="datosusuario_contactanos"></div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
         </div>
      </div>
   </div>

   <div class="modal" id="myModalCaracterizados">
      <div class="modal-dialog modal-xl modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">
                  <h6 class="modal-title" id="exampleModalLabel">Caracterización
               </h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               <div id="datosusuario_caracterizados"></div>
            </div>
         </div>
      </div>
   </div>

   <div class="modal" id="myModalActividades">
      <div class="modal-dialog modal-xl modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">
                  <h6 class="modal-title" id="exampleModalLabel">Actividades
               </h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               <div id="datosusuario_actividades"></div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
         </div>
      </div>
   </div>

   <div class="modal" id="myModalPerfilactualizadoadministradores">
      <div class="modal-dialog modal-xl modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">
                  <h6 class="modal-title" id="exampleModalLabel">Perfil Actualizado Administrativos
               </h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               <div id="datosusuario_perfilactualizadoadministradores"></div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
         </div>
      </div>
   </div>

   <div class="modal" id="myModalPerfilactualizadodocente">
      <div class="modal-dialog modal-xl modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">
                  <h6 class="modal-title" id="exampleModalLabel">Perfil Actualizado Docente
               </h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               <div id="datosusuario_perfilactualizadodocente"></div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
         </div>
      </div>
   </div>

   <div class="modal" id="myModalPerfilactualizadoestudiante">
      <div class="modal-dialog modal-xl modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">
                  <h6 class="modal-title" id="exampleModalLabel">Perfil Actualizado Estudiante
               </h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               <div id="datosusuario_perfilactualizadoestudiante"></div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
         </div>
      </div>
   </div>

   <div class="modal" id="myModalHojadevidanueva">
      <div class="modal-dialog modal-xl modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">
                  <h6 class="modal-title" id="exampleModalLabel">Nuevas Hojas de vida
               </h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               <div id="datosusuario_hoja_de_vida_nueva"></div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
         </div>
      </div>
   </div>

   <!-- Modal -->
   <div class="modal fade" id="modalEducacionContinuada" tabindex="-1" aria-labelledby="modalEducacionContinuadaLabel" aria-hidden="true">
      <div class="modal-dialog modal-md modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">
                  <div class="row">
                     <div class="col-12 p-2">
                        <div class="row">
                           <div class="pl-4 d-flex align-items-center">
                              <span class="rounded bg-light-yellow p-3 text-warning">
                                 <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                              </span>
                           </div>
                           <div class="col-8 fs-14 line-height-18 pl-4">
                              <span class="categoria_curso text-capitalize">tipo</span> en: <br>
                              <span class="text-semibold fs-18 nombre_curso">Eventos</span>
                           </div>
                        </div>
                     </div>
                  </div>
               </h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div id="precarga_modal" class="precarga_modal"></div>

         </div>
      </div>
   </div>
<?php
   require 'footer.php';
}
ob_end_flush();
?>
<script src='../public/js/sly.min.js'></script> 
<!-- fullCalendar -->
<script src="../bower_components/moment/moment.js"></script>
<script src="../bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<script src="../bower_components/fullcalendar/dist/locale/es.js"></script>
<script type="text/javascript" src="scripts/general.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>


</body>

</html>
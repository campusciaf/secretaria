<?php
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"]))
{
  header("Location: ../");
}
else
{
$menu=42;
require 'header.php';	
?> 

<link rel="stylesheet" href="../public/css/fullcalendar.min.css">
<link rel="stylesheet" href="../public/css/fullcalendar.print.min.css" media="print"> 		

<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
              <div class="col-xl-6 col-9">
                <h2 class="m-0 line-height-16">
                      <span class="titulo-2 fs-18 text-semibold">Calendario Institucional</span><br>
                      <span class="fs-14 f-montserrat-regular">Universitarios CIAF en la era digital</span>
                      <a onclick="crearevento()">Crear</a>
                </h2>
              </div>
              <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
              </div>
          </div>
        </div>
    </div>

   <section class="content" style="padding-top: 0px;">
        <div class="row justify-content-center">
            <div id="ingreso" class="col-12 text-center" ></div>
            <div id="calendar"></div>
        </div>
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>
<!-- /.content-wrappe-->

<!-- Modal (Agregar, Modificar, Borrar Calendario)-->
<div class="modal fade" id="modalCalendario" tabindex="-1" role="dialog" aria-labelledby="modalCalendario" aria-hidden="true">
    
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <b><h3 class="modal-title" id="modalCalendarioLabel">Agregar Evento</h3></b>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="LimpiarFormulario()">
                        <span aria-hidden="true">&times;</span>
                     </button>
                </div>
                <div class="modal-body">

                    
                    <div class="col-12">
                        <div class="card card-tabs">
                            <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Gestión de Eventos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Conclusiones</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-profile-tarea" data-toggle="pill" href="#custom-tabs-one-tarea" role="tab" aria-controls="custom-tabs-one-tarea" aria-selected="false">Tarea programada</a>
                                </li>
                            </ul>
                            </div>
                            <div class="card-body p-0">
                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                    <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                        <form name="calendarForm" id="calendarForm" >
                                                <div class="row mt-4">
                                                    
                                                    <input type="hidden" id="id" name="id"/>
                                                    <div class="col-12 px-4" ><span id="fechaseleccionada"></span><span id="casoseleccionado" class="pl-2"></span></div>

                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                                        <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                                <input type="text" name="eventTitle"  id="eventTitle" class="form-control" required>
                                                                <label>Añade un título:</label>
                                                            </div>
                                                        </div>
                                                        <div class="invalid-feedback">Please enter valid input</div>
                                                    </div>

                                                    <div class="col-xl-4 col-lg-12 col-md-12 col-12">
                                                        <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                                <input type="date" name="eventDate"  id="eventDate" class="form-control" required>
                                                                <label>Fecha del evento:</label>
                                                            </div>
                                                        </div>
                                                        <div class="invalid-feedback">Please enter valid input</div>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-12 col-md-12 col-12">
                                                        <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                                <input type="time" name="startTime"  id="startTime" class="form-control" required>
                                                                <label>Hora de inicio:</label>
                                                            </div>
                                                        </div>
                                                        <div class="invalid-feedback">Please enter valid input</div>
                                                    </div>

                                                    <div class="col-xl-4 col-lg-12 col-md-12 col-12">
                                                        <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                                <input type="time" name="endTime"  id="endTime" class="form-control" required>
                                                                <label>Hora de finalización:</label>
                                                            </div>
                                                        </div>
                                                        <div class="invalid-feedback">Please enter valid input</div>
                                                    </div>

                                                    <div class="col-12 p-2">
                                                        <div class="row">
                                                            <div class="col-auto">
                                                                <img src="../public/img/logo-meet.webp" width="50px" class="p-2">
                                                            </div>
                                                        
                                                            <div class="col-10" ><span id="meet"></span></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 px-4 py-2">Añade una descripción: <small class="text-danger">Opcional</small></div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                                        <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                                <textarea  name="eventDescription"  id="eventDescription" class="form-control" ></textarea>
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="invalid-feedback">Please enter valid input</div>
                                                    </div>

                                                    <div class="col-12 text-right">
                                                        <button type="submit" id="btnGuardar" class="btn btn-success btn-sm">Guardar</button>
                                                        <button type="button" id="botonEliminar" class="btn btn-danger btn-sm"  >Eliminar</button>
                                                        
                                                    </div>




                                                </div>
                                        </form>
                                    </div>

                                    <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                                        <form name="formconclusion" id="formconclusion" class="mt-4">
                                            <div class="row">
                                                <div class="col-12">
                                                <input type="hidden" id="id2" name="id2"/>
                                                <input type="hidden" id="id_calendarconclusion" name="id_calendarconclusion"/>
                                                <input type="hidden" id="titulo2" name="titulo2"/>
                                                <div class="col-12"><h2 class="titulo-2 fs-20 ">Conclusiones de la reunión</h2></div>
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <textarea  name="conclusion"  id="conclusion" class="form-control" ></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                </div>
                                            </div>
                                            <button type="submit" id="btnGuardar2" class="btn btn-success btn-sm">Guardar</button>
                                        </form>
                                    </div>

                                    <div class="tab-pane fade" id="custom-tabs-one-tarea" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tarea">
                                        <a onclick="validarTarea()" class="btn btn-warning btn-xs m-4" title="Tarea realizada"><i class="fas fa-check"></i> Marcar la tarea como terminada</a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" onclick="LimpiarFormulario()" class="btn btn-primary btn-sm" data-dismiss="modal">Cerrar ventana</button>
            </div>
        </div>
    
</div>





<?php

		
require 'footer.php';
?>
<script src="../bower_components/moment/moment.js"></script>
<script src="../bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<script src="../bower_components/fullcalendar/dist/locale/es.js"></script>
<script type="text/javascript" src="scripts/calendar.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
	ob_end_flush();
?>


<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
   header("Location: ../");
} else {
   $menu = 15;
   $submenu = 1508;
   require 'header.php';

   if ($_SESSION['deserciontareas'] == 1) {
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
                     <h1 class="m-0 titulo-4"><small id="nombre_programa"></small>Mis tareas </h1>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Gestión tareas</li>
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
               <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                  <div class="card card-primary" style="padding: 2% 1%">

                  <!-- <h1 class="titulo-4">Seguimiento Estudiante</h1> -->
                     <div class="col-md-12 datos"></div>
                     <div class="col-md-12 datos_usuario" hidden></div>
                  </div>
                  <!-- /.card -->
               </div>
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
                  <div style="overflow: auto">
                     <div id="agregarContenido"></div>
                     <br>
                     <div class="alert" style="width:100%; clear: both">
                        <div class="row">
                           <form name="formularioAgregarSeguimiento" id="formularioAgregarSeguimiento" method="POST" class="col-xl-6">
                              <h3>Registrar Seguimiento</h3>
                              <input type="hidden" name="id_estudiante_agregar" id="id_estudiante_agregar" value="">
                              <div class="form-group col-lg-12">
                                 <span id="contador">150</span> Caracteres permitidos
                                 <textarea class="form-control" name="mensaje_seguimiento" id="mensaje_seguimiento" maxlength="150" placeholder="Escribir Seguimiento" rows="6" required onKeyUp="cuenta()"></textarea>
                              </div>
                              <div class="form-group col-lg-12">
                                 <div class="radio">
                                    <label><input type="radio" name="motivo_seguimiento" id="motivo_seguimiento" value="Cita" required>Cita</label>
                                 </div>
                                 <div class="radio">
                                    <label><input type="radio" name="motivo_seguimiento" value="Llamada">Llamada</label>
                                 </div>
                                 <div class="radio">
                                    <label><input type="radio" name="motivo_seguimiento" value="Seguimiento">Seguimiento</label>
                                 </div>
                                 <button class="btn btn-success" type="submit" id="btnGuardarSeguimiento"><i class="fa fa-save"></i> Registrar</button>
                              </div>
                           </form>
                           <form name="formularioTarea" id="formularioTarea" method="POST" class="col-xl-6">
                              <input type="hidden" name="id_estudiante_tarea" id="id_estudiante_tarea">
                              <h3>Registrar Alerta</h3>
                              <span id="contadortarea">150</span> Caracteres permitidos<br>
                              <textarea class="form-control" name="mensaje_tarea" id="mensaje_tarea" maxlength="100" placeholder="Escribir Mensaje" rows="6" required onKeyUp="cuentatarea()"></textarea>
                              <div class="row">
                                 <div class="col-xl-12 col-lg-12 col-md-12 col-12">
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
                                 <div class="form-group col-xl-6 col-lg-6 col-md-12 col-12">
                                    <label>Día:</label>
                                    <div class="input-group mb-3">
                                       <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                       </div>
                                       <input type="date" name="fecha_programada" id="fecha_programada" class="form-control" required="">
                                    </div>
                                 </div>
                                 <div class="form-group col-xl-6 col-lg-6 col-md-12 col-12">
                                    <label>Hora:</label>
                                    <div class="input-group mb-3">
                                       <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                       </div>
                                       <input type="time" name="hora_programada" id="hora_programada" class="form-control" required="">
                                    </div>
                                 </div>
                                 <input type="submit" value="Programar Tarea" id="btnGuardarTarea" name="enviar tareas" class="btn btn-danger">
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Modal footer -->
               <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
               </div>
            </div>
         </div>
      </div>

      <!-- Modal para ver las acciones y los proyectos -->
         <div class="modal fade" id="myModalvizualizartareashoy"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow-y: scroll ;" >
      <div class="modal-dialog modal-md modal-dialog-centered" role="document">
         <div class="modal-content">   
            <div class="modal-header">
                  <h6 class="modal-title" id="exampleModalLabel">Tareas de hoy</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
            </div>
            <div class="modal-body">
               <div id="datosvizualizartareas" class="datostareas2"> </div>
                  
            </div>
            <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>         
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
                  <h4 class="modal-title">Listado Consulta</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div class="modal-body">
                  <div style="overflow: auto">
                     <div id="historial"></div>
                     <br>
                     <div class="alert" style="width:100%; clear: both">
                        <h3>Historial Seguimiento</h3>
                        <table id="tbllistadohistorial" class="table display compact table-bordered table-condensed table-hover" width="100%">
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
                        <h3>Historial Tareas Programadas</h3>
                        <table id="tbllistadoHistorialTareas" class="table display compact table-bordered table-condensed table-hover" width="100%">
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
               <!-- Modal footer -->
               <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
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

   <script type="text/javascript" src="scripts/deserciontareas.js"></script>

<?php
}
ob_end_flush();
?>
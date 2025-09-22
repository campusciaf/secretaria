<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
   header("Location: ../");
} else {
   $menu = 31;
   $submenu = 3104;
   require 'header.php';
   if ($_SESSION['desercion'] == 1) {
?>
      <div id="precarga" class="precarga"></div>
      <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <!--Contenido-->
      <div class="content-wrapper ">
         <!-- Main content -->
         <div class="content-header">
            <div class="container-fluid">
               <div class="row mb-2">
                  <div class="col-sm-6">
                     <h1><span class="titulo-4">Deserción </span></h1>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Deserción</li>
                     </ol>
                  </div>
                  <!-- /.col -->
               </div>
               <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
         </div>

         <section class="content" style="padding-top: 0px;">
            <div class="card card-primary" style="padding: 2% 1%">
               <div class="row ">
                  <div id="datos" class="col-12"></div>
                  <br>



               </div>


         </section>

         <section class="content" style="padding-top: 0px;" id="resultadoprofesional">
            <div class="card card-primary" style="padding: 2% 1%">
               <div class="row">
                  <div id="profesional" class="col-12 m-2 p-2"></div>
               </div>

         </section>

         <section class="content" style="padding-top: 0px;" id="inactivotaba">
            <div class="card card-primary" style="padding: 2% 1%">
               <div class="row">
                  <div class="col-12 m-2 p-2">
                     <table id="tbllistado" class="table table-bordered compact table-sm table-hover" style="width:100%">
                        <thead>
                           <th>Opciones</th>
                           <th>Identificación</th>
                           <th>Nombre estudiante</th>
                           <th>Correo CIAF</th>
                           <th>Correo personal</th>
                           <th>Celular</th>
                           <th>Periodo Ingreso</th>
                           <th>Periodo Activo</th>
                        </thead>
                        <tbody>
                        </tbody>
                     </table>
                  </div>

         </section>


         <section class="content" style="padding-top: 0px;" id="inactivotabla2">
            <div class="card card-primary" style="padding: 2% 1%">
               <div class="row">
                  <div class="col-12 m-2 p-2">
                  <a onclick="volverTabla()" class="btn btn-danger btn-sm d-flex float-right mb-1" style="color:#F4F3F2!important" > Volver</a>
                     <table id="totalestudiantes" class="table table-bordered compact table-sm table-hover" style="width:100%">
                        <thead>
                           <th>Opciones</th>
                           <th>Identificación</th>
                           <th>Nombre estudiante</th>
                        <tbody>
                        </tbody>
                     </table>
                  </div>

         </section>




         <!-- <button id="volver_tabla" onclick="volver()">Volver a la tabla</button> -->


         <div class="card card-primary" style="padding: 2% 1%">

            <div id="datos_table_desertado"> </div>

         </div>

         <!-- inicio modal agregar seguimiento -->
         <div class="modal" id="myModalAgregar">
            <div class="modal-dialog">
               <div class="modal-content">
                  <!-- Modal Header -->
                  <div class="modal-header">
                     <h4 class="modal-title">Agregar seguimiento</h4>
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <!-- Modal body -->
                  <div class="modal-body">
                     <div style="overflow: auto">
                        <div id="agregarContenido"></div>
                        <br>
                        <form name="formularioAgregarSeguimiento" id="formularioAgregarSeguimiento" method="POST" class="col-12">
                           <h3>Registrar Seguimiento</h3>
                           <input type="hidden" name="id_estudiante_agregar" id="id_estudiante_agregar" value="">
                           <div class="form-group col-lg-12">
                              <span id="contador">150 Caracteres permitidos</span>
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
                              <form id="form_soporte_digitales5" method="post" class="soporte_prueba"></form>

                              <!-- <div class="radio">
                        <label><input type="radio" name="motivo_seguimiento" value="Compromiso" >Compromiso</label>
                     </div> -->

                              <button class="btn btn-success" type="submit" id="btnGuardarSeguimiento"><i class="fa fa-save"></i> Registrar</button>
                           </div>
                        </form>
                        <form name="formularioTarea" id="formularioTarea" method="POST" class="card col-12">
                           <h3>Programar tarea</h3>
                           <input type="hidden" name="id_estudiante_tarea" id="id_estudiante_tarea">
                           <span id="contadortarea">150 Caracteres permitidos</span>
                           <textarea class="form-control" name="mensaje_tarea" id="mensaje_tarea" maxlength="100" placeholder="Escribir Mensaje" rows="6" required onKeyUp="cuentatarea()"></textarea>
                           <div class="row">
                              <div class="form-group col-xl-6 col-lg-6 col-md-12 col-12">
                                 <label>Dia:</label>
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
                           </div>
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

                           <input type="submit" value="Programar Tarea" id="btnGuardarTarea" name="enviar tareas" class="btn btn-danger">
                        </form>
                     </div>
                  </div>
                  <!-- Modal footer -->
                  <div class="modal-footer">
                     <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                  </div>
               </div>
            </div>
         </div>

         <div class="modal" id="myModalHistorialTareas">
            <div class="modal-dialog modal-xl">
               <div class="modal-content">
                  <!-- Modal Header -->
                  <div class="modal-header">
                     <h4 class="modal-title">Historial</h4>
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <!-- Modal body -->
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
                     <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
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
}
ob_end_flush();
   ?>
   <script type="text/javascript" src="scripts/desercion.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
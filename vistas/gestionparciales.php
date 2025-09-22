<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
   header("Location: ../");
} else {
   $menu = 1;
   $submenu = 16;
   require 'header.php';
   if ($_SESSION['gestionparciales']) {
?>

      <div id="precarga" class="precarga"></div>
      <div class="content-wrapper">
         <!-- Main content -->
         <div class="content-header">
            <div class="container-fluid">
               <div class="row mb-2">
                  <div class="col-sm-6">
                     <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Parciales</span><br>
                        <span class="fs-16 f-montserrat-regular">Gestiona los parciales de todos nuestros programas</span>
                     </h2>
                  </div>
                  <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                     <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                  </div>
                  <div class="col-12 migas">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Parciales</li>
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
                  <div class="card card-primary" style="padding: 2%">
                     <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                           <div class="row">
                              <div class="form-group col-xl-6 col-lg-6 col-md-12">
                                 <label>Programa:</label>
                                 <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                       <span class="input-group-text"><i class="fas fa-book-reader"></i></span>
                                    </div>
                                    <select name="programa" data-live-search="true" data-style="border" class="form-control programa" required></select>
                                 </div>
                              </div>
                              <div class="form-group col-xl-2 col-lg-3 col-md-6 col-sm-12">
                                 <label>Jornada:</label>
                                 <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                       <span class="input-group-text"><i class="fas fa-user-clock"></i></span>
                                    </div>
                                    <select name="jornada" data-live-search="true" data-style="border" class="form-control jornada" required></select>
                                 </div>
                              </div>
                              <div class="form-group col-xl-2 col-lg-3 col-md-6 col-sm-12">
                                 <label>Periodo:</label>
                                 <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                       <span class="input-group-text"> <i class="fas fa-hourglass-half"></i></span>
                                    </div>
                                    <select name="periodo" id="periodo" class="form-control periodo selectpicker" data-live-search="true" data-style="border" required>
                                       <option value="">Nothing selected</option>
                                    </select>
                                 </div>
                                 <div class="invalid-feedback">
                                    Por favor, seleccione un período válido.
                                 </div>
                              </div>
                              <div class="form-group col-xl-2 col-lg-3 col-md-6 col-sm-12">
                                 <label>Semestre:</label>
                                 <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                       <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    </div>
                                    <select name="semestre" data-live-search="true" data-style="border" class="form-control semestre"></select>
                                    <span class="input-group-btn">
                                       <input type="submit" value="Consultar" class="btn btn-success" />
                                    </span>
                                 </div>
                              </div>

                           </div>
                           <div class="col-xs-12" id="cortes">
                              <div class="row">
                                 <div class="form-group col-xl-3 col-lg-6 col-md-12 col-12">
                                    <label>Cortes</label>
                                    <div class="input-group mb-3">
                                       <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fas fa-cut"></i></span>
                                       </div>
                                       <select name="corte" class="form-control corte">
                                          <option selected>Cortes...</option>
                                          <option value="c1">C1</option>
                                          <option value="c2">C2</option>
                                          <option value="c3">C3</option>
                                          <option value="c4">C4</option>
                                          <option value="c5">C5</option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="form-group col-xl-3 col-lg-6 col-md-12 col-12">
                                    <label>Estado</label>
                                    <div class="input-group mb-3">
                                       <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fas fa-file-signature"></i></span>
                                       </div>
                                       <select name="val" onchange="estadoTodos()" class="form-control val">
                                          <option selected>Estado...</option>
                                          <option value="0">Bloquear</option>
                                          <option value="1">Activar</option>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </form>
                     </div>
                     <div class="col-md-12 conte"></div>
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




      <div class="modal fade" id="aggcortes" tabindex="-1" role="dialog">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Modal title</h4>
               </div>
               <div class="modal-body">
                  <form class="conte" id="form2" method="POST">
                  </form>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
               </div>
            </div><!-- /.modal-content -->
         </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->


   <?php
   } else {
      require 'noacceso.php';
   }

   require 'footer.php';
   ?>

   <script type="text/javascript" src="scripts/gestionparciales.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
ob_end_flush();
?>
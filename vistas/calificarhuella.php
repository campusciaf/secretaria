<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
   header("Location: ../");
} else {
   $menu = 8;
   $submenu = 804;
   require 'header.php';
   if ($_SESSION['calificarhuella'] == 1) {
?>

      <div id="precarga" class="precarga"></div>
      <div class="content-wrapper">
         <div class="content-header">
            <div class="container-fluid">
               <div class="row mb-2">
                  <div class="col-xl-6 col-9">
                     <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Calificaciones</span><br>
                        <span class="fs-14 f-montserrat-regular">....</span>
                     </h2>
                  </div>
                  <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                     <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                  </div>
                  <div class="col-12 migas mb-0">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Gestión calificaciones</li>
                     </ol>
                  </div>
               </div>
            </div>
         </div>
         <section class="container-fluid px-4">
            <div class="row col-12 mt-4 card">
               <div class="col-10 mt-3">
                  <h3 class="titulo-2 fs-14">Buscar Estudiante:</h3>
               </div>
               <div class="col-12 d-flex">
                  <div class="col-4 mt-4" id="seleccionprograma">
                     <form name="formularioverificar" id="formularioverificar" method="POST" class="row">
                        <div class="col-9 m-0 p-0">
                           <div class="form-group mb-3 position-relative check-valid">
                              <div class="form-floating">
                                 <input type="text" placeholder="" value="" required class="form-control border-start-0" name="credencial_identificacion" id="credencial_identificacion" maxlength="20">
                                 <label>Número Identificación</label>
                              </div>
                           </div>
                           <div class="invalid-feedback">Please enter valid input</div>
                        </div>
                        <div class="col-3 m-0 p-0">
                           <button type="submit" id="btnVerificar" class="btn btn-success py-3">Buscar</button>
                        </div>
                     </form>
                  </div>
                  <div class="col-8 mt-4">
                     <div class="row">
                        <div class="col-sm">
                           <div class="px-2  pb-2">
                              <div class="row align-items-center">
                                 <div class="col-2">
                                    <span class="rounded bg-light-blue p-2 text-primary ">
                                       <i class="fa-solid fa-user-slash"></i>
                                    </span>
                                 </div>
                                 <div class="col-10">
                                    <span class="">Nombre:</span> <br>
                                    <span class="text-semibold fs-12 box_nombre_estudiante">-</span>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-sm">
                           <div class="px-2  pb-2">
                              <div class="row align-items-center">
                                 <div class="col-2">
                                    <span class="rounded bg-light-red p-2 text-danger">
                                       <i class="fa-regular fa-envelope"></i>
                                    </span>
                                 </div>
                                 <div class="col-10">
                                    <span class="">Correo electrónico</span> <br>
                                    <span class="text-semibold fs-12 box_correo_electronico">-</span>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-sm">
                           <div class="px-2 pb-2">
                              <div class="row align-items-center">
                                 <div class="col-2">
                                    <span class="rounded bg-light-green p-2 text-success">
                                       <i class="fa-solid fa-mobile-screen"></i>
                                    </span>
                                 </div>
                                 <div class="col-10">
                                    <span class="">Número celular</span> <br>
                                    <span class="text-semibold fs-12 box_celular_estudiante">-</span>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-12 table-responsive p-4" id="listadoregistros">
                  <table id="tbllistado" class="table table-hover" style="width:100%">
                     <thead>
                        <th>Acciones</th>
                        <th>Id estudiante</th>
                        <th>Programa</th>
                        <th>Jornada</th>
                        <th>Semestre</th>
                        <th>Grupo</th>
                        <th>Escuela</th>
                        <th>Estado</th>
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
                        <th>Periodo Activo</th>
                     </tfoot>
                  </table>
               </div>
               <div class="panel-body" id="formularioregistros">
                  <h1>Generar Credenciales de Acceso</h1>
                  <form name="formulario" id="formulario" method="POST">
                  </form>
               </div>

               <div class="col-12" id="listadomaterias">
               </div>
            </div>
         </section>
      </div>



      <!-- espacio para modals -->
      <div class="modal fade" id="myModalMatriculaNovedad" role="dialog">
         <div class="modal-dialog modal-sm">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Cambio</h4>
               </div>
               <div class="modal-body">
                  <form name="formularionovedadjornada" id="formularionovedadjornada" method="POST">
                     <input type='hidden' value="" id='id_materia' name='id_materia'>
                     <input type='hidden' value="" id='ciclo' name='ciclo'>
                     <input type='hidden' value="" id='id_programa_ac' name='id_programa_ac'>
                     <input type='hidden' value="" id='id_estudiante' name='id_estudiante'>
                     <div class="form-group col-12">
                        <label>Cambio de Jornada a:</label>
                        <div class="input-group">
                           <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                           <select id="jornada_e" name="jornada_e" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>
                     </div>
                     <button type="submit" id="btnNovedad" class="btn btn-info btn-block">Cambiar Jornada</button>
                  </form>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
               </div>
            </div>
         </div>
      </div>
      <div class="modal fade" id="myModalMatriculaNovedadPeriodo" role="dialog">
         <div class="modal-dialog modal-sm">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Cambio</h4>
               </div>
               <div class="modal-body">
                  <form name="formularionovedadperiodo" id="formularionovedadperiodo" method="POST">
                     <input type='hidden' value="" id='id_materia_j' name='id_materia_j'>
                     <input type='hidden' value="" id='ciclo_j' name='ciclo_j'>
                     <input type='hidden' value="" id='id_programa_ac_j' name='id_programa_ac_j'>
                     <input type='hidden' value="" id='id_estudiante_j' name='id_estudiante_j'>
                     <div class="form-group col-12">
                        <label>Cambio de periodo a:</label>
                        <div class="input-group">
                           <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                           <select id="periodo" name="periodo" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>
                     </div>
                     <button type="submit" id="btnNovedadPeriodo" class="btn btn-info btn-block">Cambiar Periodo</button>
                  </form>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
               </div>
            </div>
         </div>
      </div>
      <div class="modal fade" id="myModalMatriculaNovedadGrupo" role="dialog">
         <div class="modal-dialog modal-sm">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Cambio</h4>
               </div>
               <div class="modal-body">
                  <form name="formularionovedadgrupo" id="formularionovedadgrupo" method="POST">
                     <input type='hidden' value="" id='id_materia_g' name='id_materia_g'>
                     <input type='hidden' value="" id='ciclo_g' name='ciclo_g'>
                     <input type='hidden' value="" id='id_programa_ac_g' name='id_programa_ac_g'>
                     <input type='hidden' value="" id='id_estudiante_g' name='id_estudiante_g'>
                     <div class="form-group col-12">
                        <label>Cambio de grupo a:</label>
                        <div class="input-group">
                           <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                           <select id="grupo" name="grupo" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>
                     </div>
                     <button type="submit" id="btnNovedadGrupo" class="btn btn-info btn-block">Cambiar Grupo</button>
                  </form>
               </div>
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

   <script type="text/javascript" src="scripts/calificarhuella.js"></script>
<?php
}
ob_end_flush();
?>
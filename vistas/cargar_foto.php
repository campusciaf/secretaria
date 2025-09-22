<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["cargarfoto"])) {
   header("Location: ../");
} else {
   $menu = 1;
   $submenu = 8;
   require 'header.php';

   if ($_SESSION['cargarfoto'] == 1) {

?>
      <div class="content-wrapper">
         <div class="content-header">
            <div class="container-fluid">
               <div class="row mb-2">
                  <div class="col-xl-8 col-lg-7 col-md-8 col-9">
                     <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Fotografía</span><br>
                        <span class="fs-16 f-montserrat-regular">Modifica la foto de perfil de los estudiantes, docentes y funcionarios</span>
                     </h2>
                  </div>
                  <div class="col-xl-4 col-lg-5 col-md-4 col-3 pt-4 pr-4 text-right">
                     <button class="btn btn-sm btn-outline-warning px-2 py-0" data-bs-toggle="tooltip" data-bs-placement="top" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                  </div>
                  <div class="col-12 migas">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Gestión Foto</li>
                     </ol>
                  </div>
               </div>
            </div>
         </div>
         <section class="content" style="padding-top: 0px;">
            <div class="card contenido">
               <div class="row">
                  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                     <div class="card card-primary" style="padding: 2%">
                        <div class="row">
                           <div class="col">
                              <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                 <h5>Formato (.jpg)</h5>
                                 <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                    <div class="form-group mb-3 position-relative check-valid">
                                       <div class="form-floating">
                                          <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="ubicacion" id="ubicacion">
                                             <option value="1">Estudiante</option>
                                             <option value="2">Docentes</option>
                                             <option value="3">Funcionarios</option>
                                          </select>
                                          <label>Roll</label>
                                       </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                 </div>
                                 <div class="col-12">
                                    <div class="form-group mb-3 position-relative check-valid">
                                       <div class="form-floating">
                                          <input type="text" placeholder="" value="" pattern="[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" title="Solo se permiten letras y números, estos caracteres no son permitidos < > = , ; * # $" class="form-control border-start-0" name="cedula" id="cedula" required>
                                          <label>Identificación</label>
                                       </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                    <input type="submit" value="Buscar" onclick="consultaBuscar()" class="btn btn-success btn-block" />
                                 </div>
                                 <div class="col-xl-6 col-lg-12 col-md-12 col-12">
                                    <form name="formulario_usuario" id="formulario_usuario" method="POST" enctype="multipart/form-data">
                                       <label for='usuario_imagen' style="cursor: pointer">
                                          <img id='img_foto_hoja_vida' src='../public/img/camara.svg' width='90px' height='110px' alt='Click aquí para subir tu foto' title='Click aquí para subir tu foto'>
                                       </label>
                                       <input id='usuario_imagen' name='usuario_imagen' type='file' style="display: none" />
                                       <div class='form-group col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                                          <input type="number" class="d-none id_usuario" id="id_usuario" name="id_usuario">
                                          <button class="btn btn-success btn-block" type="submit" id="btnGuardarUsuario"><i class="fa fa-save"></i> Guardar</button>

                                       </div>
                                    </form>
                                 </div>
                              </div>
                              <div class="col-xl-6" id="consultaBuscar"></div>
                           </div>
                           <div class="col">
                              <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                 <h5>Carga Masiva (.jpg)</h5>
                                 <div class="form-group">
                                    <div class="form-group mb-3 position-relative check-valid">
                                       <div class="form-floating">
                                          <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="ubicacion_masiva" id="ubicacion_masiva">
                                             <option value="1">Estudiante</option>
                                             <option value="2">Docentes</option>
                                             <option value="3">Funcionarios</option>
                                          </select>
                                          <label>Roll</label>
                                       </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                    <form name="formulario_carga_masiva" id="formulario_carga_masiva" method="POST" enctype="multipart/form-data">
                                       <label for='carga_masiva_imagen' style="cursor: pointer">
                                          <img id='img_carga_masiva' src='../public/img/camara.svg' width='90px' height='110px' alt='Click aquí para subir fotos masivamente' title='Click aquí para subir fotos masivamente'>
                                       </label>
                                       <input id='carga_masiva_imagen' name='carga_masiva_imagen[]' type='file' multiple="" style="display: none" />
                                       <div class='form-group'>
                                          <button class="btn btn-success btn-block" type="submit" id="btnGuardarCargaMasiva"><i class="fa fa-save"></i> Guardar</button>
                                       </div>
                                    </form>
                                 </div>
                              </div>
                           </div>
                        </div>
                        </form>
                     </div>
                  </div>
               </div>
         </section>
      </div>


   <?php
   } else {
      require 'noacceso.php';
   }

   require 'footer.php';
   ?>



   <script type="text/javascript" src="scripts/cargar_foto.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
ob_end_flush();
?>
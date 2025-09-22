<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
   header("Location: ../");
} else {
   $menu = 28;
   $submenu = 2804;
   require 'header.php';

   if ($_SESSION['hojavidaclavecliente'] == 1) {

?>
      <div id="precarga" class="precarga"></div>
      <div class="content-wrapper">
         <div class="content-header">
            <div class="container-fluid">
               <div class="row mb-2">
                  <div class="col-sm-6">
                     <h1 class="m-0"><small id="nombre_programa"></small>Reestablecer Clave Hoja de Vida</h1>
                  </div>
                  <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Gestión clave Hoja de vida</li>
                     </ol>
                  </div>
               </div>
            </div>
         </div>
         <section class="content" id="ocultar_restaurar" style="padding-top: 0px;">
            <div class="row">
               <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                  <div class="card card-primary" style="padding: 2%">
                     <div class="row">
                        <form action="#" id="form_restaurar_admision" method="POST" class="col-xl-6 col-lg-6 col-md-12 col-12">
                           <div class="form-group col-12">
                              <label>Numero de cédula:</label>
                              <div class="input-group mb-3">
                                 <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                 </div>
                                 <input type="text" id="cedula" name="cedula" required="required" pattern="[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" title="Solo se permiten letras y números, estos caracteres no son permitidos < > = , ; * # $" placeholder="Numero de Cédula" class="form-control" autocomplete="off" />
                                 <div class="input-group-append">
                                    <button class="btn btn-success" type="button" onclick="Listar_Usarios()">Consultar</button>
                                 </div>
                              </div>
                           </div>
                        </form>
                     </div>
                     <div id="listar_usarios_repetidos">

                     </div>
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

   <script type="text/javascript" src="scripts/hojavidaclavecliente.js"></script>
<?php
}
ob_end_flush();
?>
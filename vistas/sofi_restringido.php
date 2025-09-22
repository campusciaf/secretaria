<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])){
   header("Location: ../");
}else{
   $menu = 23;
   $submenu = 2314;
   require 'header.php';
   if($_SESSION['sofi_restringido']==1){
?>

<div id="precarga" class="precarga"></div>
   <div class="content-wrapper">
      <!-- Main content -->
      <div class="content-header">
         <div class="container-fluid">
            <div class="row mb-2">
               <div class="col-sm-6">
                  <h1 class="m-0"><small id="nombre_programa"></small>Restringir Usuario</h1>
               </div>
               <!-- /.col -->
               <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                     <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                     <li class="breadcrumb-item active">Restringir Usuario</li>
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
                  <div class="row">
                     <div class="form-group col-xl-6 col-lg-12 col-md-12 col-12">
                        <label>Número de identificación(*):</label>		
                        <div class="input-group mb-3">
                           <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-user"></i></span>
                           </div>
                           <input type="text" id="cedula" name="cedula" required="required" pattern="[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" title="Solo se permiten letras y números, estos caracteres no son permitidos < > = , ; * # $" placeholder="Documento de identificación" class="form-control" required />
                           <span class="input-group-btn">
                           <input type="submit" value="Consultar" onclick="consultaEstudiante()" class="btn btn-success"  />
                           </span>
                        </div>
                     </div>
                     <div class="col-xl-6 col-lg-12 col-md-12 col-12" id="consultaEstu"></div>
                  </div>
               </div>
               <!-- /.card -->
            </div>
            <!-- /.col -->
         </div>
         <!-- /.row -->
      </section>
      <!-- /.content -->
   </div>
</div>
<!-- /.content-wrapper -->
<!--Fin-Contenido-->


<?php
	}
	else
	{
	  require 'noacceso.php';
	}
		
require 'footer.php';
?>

<script type="text/javascript" src="scripts/sofi_restringido.js"></script>
<?php
}
	ob_end_flush();
?>

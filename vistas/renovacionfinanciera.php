<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])){
  header("Location: ../");
}else{
    $menu = 23;
        $submenu = 2310;
    require 'header.php';
	if ($_SESSION['renovacionfinanciera']==1){
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
               <h1><span class="titulo-4">Renovación Financiera </span></h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                  <li class="breadcrumb-item active">Renovacion financiera</li>
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
               <div class="col-xl-12 text-right">
                  <a onclick="configurar()" type="button" class="btn btn-primary btn-sm" >
                     Configurar programas
                  </a>
               
               </div>
               <div class="col-12"> <hr></div>

               <div id="datos" class="col-12"></div>
            </div>
            
   </section>

   <section class="content" style="padding-top: 0px;" id="resultadoprofesional">
        <div class="card card-primary" style="padding: 2% 1%">
            <div class="row">
               <div id="profesional" class="col-12 m-2 p-2"></div>
            </div> 
            
   </section>

              
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Listado estudiantes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

         <div class="row">
            <div class="col-12">
               <table id="tbllistado" class="table table-bordered compact table-sm table-hover" style="width:100%">
                  <thead>
                     <th>Identificación</th>
                     <th>Nombre estudiante</th>
                     <th>Programa</th>
                     <th>Jornada</th>
                     <th>Académica</th>
                  </thead>
                  <tbody>                            
                  </tbody>
               </table>
            </div>
         </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="configurar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Configurar programas</h5>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close"> x </button>
      </div>
      <div class="modal-body">
        <div class="row">
         <div class="panel-body col-12 ">
            <table id="tbllistadoconfig" class="table table-striped table-bordered table-condensed table-hover responsive" style="width:100%">
               <thead>
                  <th>Programa</th>
                  <th>Estado</th>
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


<?php
	}else{
	  require 'noacceso.php';
	}
    require 'footer.php';
}
	ob_end_flush();
?>
<script type="text/javascript" src="scripts/renovacionfinanciera.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
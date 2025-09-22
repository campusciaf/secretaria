<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
   header("Location: ../");
} else {

    if($_SESSION['usuario_cargo']=="Docente" or $_SESSION['usuario_cargo']=="Estudiante"){
        header("Location: ../");
    }else{
        $menu = 13;
        $submenu = 1312;
    require 'header.php';
    }

    
   if ($_SESSION['caracterizacionprograma'] == 1) {
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
               <h1 class="titulo-4">Consulta por programa</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                  <li class="breadcrumb-item active">caracterización programa</li>
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

            <div class="card card-primary" style="padding: 2%" id="lista_programas">
               <form id="buscar" name="buscar" method="POST">
                  <div class="row">
                     <div class="form-group col-xl-6 col-lg-4 col-md-6 col-12">
                        <label>Programas Academicos:</label>	
                        <div class="input-group mb-3">
                           <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                           </div>
                           <select id="id_programa_ac" name="id_programa_ac"  class="form-control selectpicker" data-live-search="true" required onChange="comprobar()" data-style="border"></select>
                        </div>
                     </div>
                     <div class="form-group col-xl-3 col-lg-4 col-md-6 col-12">
                        <label>Programas:</label>	
                        <div class="input-group mb-3">
                           <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                           </div>
                           <select id="id_categoria" name="id_categoria"  class="form-control selectpicker" data-live-search="true" required onChange="comprobar()" data-style="border"></select>
                        </div>
                     </div>
            
                     <div class="form-group col-xl-2 col-lg-3 col-md-6 col-12">
                        <label>Periodo Académico:</label>	
                        <div class="input-group mb-3">
                           <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                           </div>
                           <select id="periodo" name="periodo"  class="form-control" data-live-search="true" required onChange="comprobar()" data-style="border"></select>
                        </div>
                     </div>
                  </div>
               </form>

               <div class="col-12">
                  <div class="panel-body table-responsive" id="listadoregistros">
                     <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                     </table>
                  </div>
               </div>
            </div>



         </div>

         


       
 

      </div>
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!--Fin-Contenido-->





      <div class="modal" id="myModalEvento">
         <div class="modal-dialog modal-sm">
            <div class="modal-content">
               <!-- Modal Header -->
               <div class="modal-header">
                  <h4 class="modalTitulo">Información</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <!-- Modal body -->
               <div class="modal-body">
                  <p id="modalDia"></p>
                  <p id="modalTitle"></p>
               </div>
               <!-- Modal footer -->
               <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
               </div>
            </div>
         </div>
      </div>



<?php
	}
	else
	{
	  require 'noacceso.php';
	}
		
require 'footer.php';
?>

<script type="text/javascript" src="scripts/caracterizacionprograma.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
	ob_end_flush();
?>

  


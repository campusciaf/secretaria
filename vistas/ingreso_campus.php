<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])){
   header("Location: ../");
}else{
	$menu=22;
	$submenu=2203;
      require 'header.php';
	if ($_SESSION['ingresocampus']){
?>
<div class="content-wrapper">
   <!-- Main content -->
   <div class="content-header">
      <div class="container-fluid card card-primary table">
         <div class="row mb-2">
            <h1 class=" col-12 mt-4 "><small></small>Ingresos</h1>
            <div class="col-md-6 p-1 mt-4 card bg-blue">
               <div class="card-header" ><label for="estado_ingreso" class="card-title">Buscar</label></div>
                  <div class="card-body">
                  <!-- <label >Buscar</label> -->
                     <select class="form-control custom-select" id="estado_ingreso" name="estado_ingreso" onchange="ingresocampus()">
                        <option value="" selected disabled>Selecciona una opción</option>
                        <option value="Funcionario">Funcionario</option>
                        <option value="Docente">Docente</option>
                        <option value="Estudiante">Estudiante</option>
                        <option value="todos">Todos</option>
                     </select>
                  </div>
            </div>

            <div class="col-md-6 bg-blue p-1 mt-4 card">
               <div class="card-header"><label for="fecha_ingreso" class="card-title">Buscar</label></div>
                  <div class="card-body">
                     <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" onchange="ingresocampus()" value="<?php echo date("Y-m-d") ?>">
                  </div>
               </div>
            </div>   
         <div class="row mt-4 mb-3">
            <div class="col-12 table-responsive" id="ingreso">
            </div>
         </div>
      </div>
   </div>
      <!-- /.row -->
</div>
<?php
	}
	else
	{
      require 'noacceso.php';
	}
		
require 'footer.php';
?>
   <style>
      .rotate {
            transform: rotate(-90deg);
            /* Legacy vendor prefixes that you probably don't need... */
            /* Safari */
            -webkit-transform: rotate(-90deg);
            /* Firefox */
            -moz-transform: rotate(-90deg);
            /* IE */
            -ms-transform: rotate(-90deg);
            /* Opera */
            -o-transform: rotate(-90deg);
            /* Internet Explorer */
            filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
      }
      .bg_degradado{
         background: rgb(0,212,255); 
         background: linear-gradient(90deg, rgba(0,212,255,1) 0%, rgba(9,9,121,1) 50%, rgba(2,0,36,1) 100%);
      }
   </style>
      
   <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
      -->
   <script type="text/javascript" src="scripts/ingreso_campus.js"></script>
<?php
}
	ob_end_flush();
?>
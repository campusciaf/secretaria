<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"]))
{
  header("Location: ../");
}
else
{
	$menu=1;
	$submenu=17;
require 'header.php';
	if ($_SESSION['verificarcalificaciones'])
	{
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
               <h1 class="m-0"><small id="nombre_programa"></small>Reporte parciales</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                  <li class="breadcrumb-item active">Gestión reporte</li>
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
               <div id="mostrardatos" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <form id="formulario">
                     <div class="row">

                        <div class="col-xl-4">
                           <div class="campo-select col-xl-12 ">
                                 <select name="programa" id="programa" class="programa" data-live-search="true" onchange="validar(this.value)">
                                 </select>
                                 <span class="highlight"></span>
                                 <span class="bar"></span>
                                 <label>Seleccionar programa</label>
                           </div>
                        </div>

                        <div class="campo-select col-xl-3">
                           <select name="corte" id="corte" class="campo" onchange="validar(this.value)">
                              <option></option>
                              <option value="c1">C1</option>
                              <option value="c2">C2</option>
                              <option value="c3">C3</option>
                              <option value="c4">C4</option>
                              <option value="c5">C5</option>
                           </select>
                           <span class="highlight"></span>
                           <span class="bar"></span>
                           <label>Seleccionar corte</label>
                        </div>


                     </div>			                                
            
                  </form>
               </div>
            </div>
                        
            <div class="card col-12 m-0 pt-2" id="resultados">
               <table id="tbllistado" class="table  table-compact table-sm table-hover" style="width:100%">
                  <thead>
                     <th>Identificación</th>
                     <th>Apellidos</th>
                     <th>Nombres</th>
                     <th>Materia</th>
                     <th>Jornada</th>
                     <th>Semestre</th>
                     <th>Corte</th>
                     <th>Programa</th>
                     <th>Estado calificación</th>
                  </thead>
                  <tbody>                            
                  </tbody>
               </table>
            </div>
				
         </div>
      </div>

   </section>
</div>  

	  
<?php
	}
	else
	{
	  require 'noacceso.php';
	}
		
require 'footer.php';
?>

<script type="text/javascript" src="scripts/verificarcalificaciones.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
	ob_end_flush();
?>
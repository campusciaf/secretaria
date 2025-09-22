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
$menu=13;
$submenu=1302;
	
require 'header.php';
	if ($_SESSION['consultavariables']==1)
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
               <h1 class="m-0"><small id="nombre_programa"></small>Consultas variables </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                  <li class="breadcrumb-item active">Gestión consultas</li>
               </ol>
            </div>
            <!-- /.col -->
         </div>
         <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
   </div>
   <section class="content" style="padding-top: 0px;">
      <div class="row" style="margin:0px">
         <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card card-primary" style="padding: 2% 1%">
               <form name="formulario" id="formulario" method="POST">
                  <div class="row">
                     <div class="form-group col-xl-5 col-lg-6 col-md-6 col-12">
                        <label>Seleccionar Programa:</label>	
                        <div class="input-group mb-3">
                           <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-user"></i></span>
                           </div>
                           <select name="programa" id="programa" class="form-control" data-live-search="true" required data-style="border"></select>
                        </div>
                     </div>
                     <div class="form-group col-xl-2 col-lg-6 col-md-6 col-12">
                        <label>Seleccionar Jornada:</label>	
                        <div class="input-group mb-3">
                           <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-user"></i></span>
                           </div>
                           <select name="jornada" id="jornada" class="form-control" data-style="border" required></select>
                        </div>
                     </div>
                     <div class="form-group col-xl-2 col-lg-6 col-md-6 col-12">
                        <label>Seleccionar Semestre:</label>	
                        <div class="input-group mb-3">
                           <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-user"></i></span>
                           </div>
                           <select name="semestre" id="semestre" class="form-control" required>
                              <option value="">Seleccionar</option>
                              <option value="todas">Todos los semestres</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                              <option value="6">6</option>
                              <option value="7">7</option>
                              <option value="8">8</option>
                              <option value="9">9</option>
                              <option value="10">10</option>
                           </select>
                        </div>
                     </div>
                     <div class="form-group col-xl-3 col-lg-6 col-md-6 col-12">
                        <label>Seleccionar Periodo Ingreso:</label>	
                        <div class="input-group mb-3">
                           <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-user"></i></span>
                           </div>
                           <select name="periodo" id="periodo" class="form-control" data-style="border" required></select>
                           <input type="submit" value="Consultar" class="btn btn-success" />
                        </div>
                     </div>
                  </div>
            </div>
            </form>
            <div class="row col-12 alert"></div>
            <div id="resultado"></div>

            <div id="resultadolistarvariable" style="overflow: hidden"></div>
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




<!-- Modal que contiene el resultado de listado estudiantes-->
<div class="modal" id="myModalEstudiantes">
   <div class="modal-dialog modal-xl">
      <div class="modal-content">
         <!-- Modal Header -->
         <div class="modal-header">
            <h4 class="modal-title">Listado de Estudiantes</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <!-- Modal body -->
         <div class="modal-body">
            <table id="tbllistado" class="table table-striped table-condensed table-hover table-responsive " style="width: 100%;">
               <thead>
                  <th>Credencial</th>
                  <th>Identificación</th>
                  <th>Nombre</th>
                  <th>Sexo</th>
                  <th>Edad</th>
                  <th>Celular</th>
                  <th>Email P.</th>
                  <th>Email CIAF</th>
                  <th>Periodo</th>
               </thead>
               <tbody>                            
               </tbody>
            </table>
         </div>
         <!-- Modal footer -->
         <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
         </div>
      </div>
   </div>
</div>
<!--****************************-->


<!-- Modal que contiene el resultado de listado estudiantes-->
<div class="modal" id="myModalRespuestas">
   <div class="modal-dialog modal-xl">
      <div class="modal-content">
         <!-- Modal Header -->
         <div class="modal-header">
            <h4 class="modal-title">Resultado</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <!-- Modal body -->
         <div class="modal-body">
            <div id="respuestas"></div>
         </div>
         <!-- Modal footer -->
         <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
         </div>
      </div>
   </div>
</div>
<!--****************************-->

<?php
	}
	else
	{
	  require 'noacceso.php';
	}
		
require 'footer.php';
?>
<script type="text/javascript" src="scripts/consultavariablesprograma.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>

<?php
}
	ob_end_flush();
?>


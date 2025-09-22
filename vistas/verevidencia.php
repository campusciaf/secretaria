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
$menu=2;
$submenu=211;
require 'header.php';

	if ($_SESSION['verevidencia']==1)
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
               <h1 class="m-0"><small id="nombre_programa"></small>Evidencias </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                  <li class="breadcrumb-item active">Gestión evidencias</li>
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
         <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <div class="card card-primary" style="padding: 2% 1%">
				
				<div class="col-xl-3 col-lg-4 col-md-12 col-12">
					<form name="formularioperiodo" id="formularioperiodo" method="POST">
						<label>Seleccionar Periodo</label>
						<select name="periodo" id="periodo" class="form-control selectpicker" data-live-search="true" required>
						</select>
						 <button class="btn btn-primary btn-block" type="submit" id="btnBuscar"><i class="fa fa-save"></i> Click para buscar evidencia</button>
					</form>	
				</div>	

					
			
			 <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Dependencia</th>
                            <th>Meta</th>
						  	<th>Archivo</th>
						  	<th>Fecha Meta</th>
						  	<th>Acción</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                        </table>
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
<!-- /.content-wrapper -->
<!--Fin-Contenido-->


<!-- Modal -->
<div id="myModalNoValidarForm" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">No validar Meta</h4>
      </div>
      <div class="modal-body">
			<form name="formulario" id="formulario" method="POST">
				<input type="hidden" name="id_meta" id="id_meta" class="form-control">
				<input type="hidden" name="email" id="email" class="form-control">
				<input type="hidden" name="fila" id="fila" class="form-control"> 
				
				<label>Mensaje(*):</label>
				<textarea name="mensaje" id="mensaje" rows="10" class="form-control"></textarea>
				 <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Enviar y no validar</button>
		 	</form>
      </div>
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

<script type="text/javascript" src="scripts/verevidencia.js"></script>

<?php
}
	ob_end_flush();
?>

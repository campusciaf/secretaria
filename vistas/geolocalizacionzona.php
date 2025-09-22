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
$submenu=1306;
require 'header.php';
	if ($_SESSION['geolocalizacionzona']==1)
	{
?>


    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100vh;
      }

    </style>

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
               <h1 class="m-0"><small id="nombre_programa"></small>Geolocalización </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                  <li class="breadcrumb-item active">Gestión geolocalización</li>
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
				
			<form name="formulario" id="formulario" method="POST" >	
				<div class="row">
			
					 <div class="form-group col-xl-3 col-lg-6 col-md-6 col-12">
                           <label>Departamento:</label>		
                           <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                 <span class="input-group-text"><i class="fa fa-city"></i></span>
                              </div>
                              <select id="departamento" name="departamento"  class="form-control selectpicker" data-live-search="true" required onChange="mostrarmunicipio(this.value)"></select>
                           </div>
                        </div>
					
					<div class="form-group col-xl-3 col-lg-6 col-md-6 col-12">
                           <label>Municipio:</label>		
                           <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                 <span class="input-group-text"><i class="fa fa-city"></i></span>
                              </div>
                              <select id="municipio" name="municipio"  class="form-control selectpicker" data-live-search="true" required onChange="mostrarcodpostal(this.value)"></select>
                           </div>
                        </div>
					<div class="form-group col-xl-6 col-lg-12 col-md-12 col-12">
                           <label>Código Postal:</label>		
                           <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                 <span class="input-group-text"><i class="fa fa-city"></i></span>
                              </div>
                              <select id="cod_postal" name="cod_postal"  class="form-control selectpicker" data-live-search="true" required></select>
                           </div>
                        </div>
						<div class="form-group col-xl-3 col-lg-12 col-md-12 col-12">
                           <label>Programa:</label>		
                           <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                 <span class="input-group-text"><i class="fas fa-user"></i></span>
                              </div>
                              <select name="programa" id="programa" class="form-control" data-live-search="true" required></select>
                           </div>
                        </div>
					<div class="form-group col-xl-3 col-lg-6 col-md-6 col-12">
                           <label>Jornada:</label>		
                           <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                 <span class="input-group-text"><i class="fas fa-user"></i></span>
                              </div>
                              <select name="jornada" id="jornada" class="form-control" required></select>
                           </div>
                        </div>
					
					<div class="form-group col-xl-3 col-lg-6 col-md-6 col-12">
                           <label>Semestre:</label>		
                           <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                 <span class="input-group-text"><i class="fas fa-user"></i></span>
                              </div>
                              <select name="semestre" id="semestre" class="form-control" required>
								<option value="">Seleccionar Semestre</option>
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
						<span class="input-group-btn">
							<input type="submit" value="Consultar" class="btn btn-success" />
						</span>
                           </div>
                        </div>

<!--
					<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
						<div class="input-group">
							<span class="input-group-addon"><i class="fas fa-user"></i></span>
							<select name="periodo" id="periodo" class="form-control" required>
							</select>
							
						</div>

					</div>
-->
					<div class="form-group col-xl-3 col-lg-3 col-md-12 col-12">
						<label>Resultados:</label><br>
						<button type="button" class="btn btn-primary" id="datos" data-toggle="modal" data-target="#myModalResultado" style="display: nones">Mostrar Datos <span class="badge" id="cantidad">7</span></button>
					</div>

				</div>
			</form>		

							
	</div>
	
	
	<!-- Modal -->
<div id="myModalResultado" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Datos Geolocalización (Zona)</h4>
      </div>
      <div class="modal-body">
        
		  
		<div class="panel-body table-responsive" id="listadoregistros">
			<table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Identificacion</th>
					<th>Nombre Completo</th>
					<th>Telefono</th>
					<th>Correo CIAF</th>
					<th>Dirección</th>
					
				</thead>
			<tbody>                            
			</tbody>
				<tfoot>
					<th>Identificacion</th>
					<th>Nombre Completo</th>
					<th>Telefono</th>
					<th>Correo CIAF</th>
					<th>Dirección</th>
				</tfoot>
			</table>
		</div>
		  
		  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>

  </div>
</div>
	
	
	
	
	
	 
		  
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					
					 <div id="map"></div>

					<!--Fin centro -->
				</div><!-- /.box -->
			</div><!-- /.col -->
		</div><!-- /.row -->
	</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<!--Fin-Contenido-->
<?php
	}
	else
	{
	  require 'noacceso.php';
	}
		
require 'footer.php';
?>
<script type="text/javascript" src="scripts/geolocalizacionzona.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD-9GbQKtTGVtTsUJiUfMwFfbsB0hN8UGw&callback" async defer></script>  

<?php
}
	ob_end_flush();
?>
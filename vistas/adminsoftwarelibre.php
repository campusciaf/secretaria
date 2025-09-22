<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"]))
{
  header("Location: login.html");
}
else
{
require 'header.php';
?>
<link rel="stylesheet" type="text/css" href="../public/css/biblioteca.css">

<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content" style="padding-top: 0px;">
			<!--Fondo de la vista -->
            <div class="row">
              <div class="col-md-12">
              	<div class="fondo_stamp col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: -20px;">
				<div class="alert col-xs-12 col-sm-12 col-md-4 col-lg-4 logo_3_0" style="background-color: rgba(201,201,201,0.4); border-radius: 4px;"> 
					<p class="text-center" style="font-size:30px; color: #fff; font-weight: bolder;">Admin Biblioteca Gustavo <br> Antonio Restrepo</p> 
				</div>
				<!-- Botones -->
				<div class="btn-group alert col-xs-12 col-sm-12 col-md-8 col-lg-8">
					<div style="text-align: right">
						<a class="btn btn-primary col-xs-12 col-sm-12 col-md-12 col-lg-3" href="adminbiblioteca.php" style="text-decoration: none;">
						<i class="fas fa-eye"></i> Admin Biblioteca</a>
						<a href="adminsoftwarelibre.php" class="btn btn-success col-xs-12 col-sm-12 col-md-4 col-lg-3">
						<i class="fas fa-desktop"></i> Admin Software Libre</a>
						<a href="adminbasesdatosgratuitas.php" class="btn btn-danger col-xs-12 col-sm-12 col-md-4 col-lg-3">
						<i class="fas fa-database"></i> Admmin Bases de Datos</a>
					</div>
				</div>
				<style>
					a:hover{
						text-decoration: none;
					}
					a:link{
						text-decoration: none;
					}
					a:visited{
						text-decoration: none;
					}
					a:active{
						text-decoration: none;
					}
				</style>
				<!--
				<div class="alert col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<form action="libros_resultado.php" method="post">
						<div class="input-group col-xs-12 col-sm-12 col-md-12 col-lg-6 centrar_campo"  style="margin: 0px auto;">
							<span class="input-group-addon"><i class="fas fa-book-open fa-2x"></i></span>
							  <input type="text" id="busquedad" name="busquedad" required="required" pattern="[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" title="Solo se permiten letras y números, estos caracteres no son permitidos < > = , ; * # $" placeholder="Titulo, Autor; Palabra clave o ISBN" class="form-control input-lg" /> 
								<span class="input-group-btn">
									<input type="submit" value="Buscar" class="btn btn-success btn-lg" />
								</span>
						</div>
					</form>
				</div>-->
				<!-- Final fondo stamp -->	
				</div>
			</div>
		</div>
			<button class="col-xs-12 col-sm-12 col-md-3 col-lg-3 btn btn-info" id="filtro_0"> » Todos </button>
			<button class="col-xs-12 col-sm-12 col-md-3 col-lg-3 btn btn-info" id="filtro_1"> » Almacenamiento en la nube </button> 
			<button class="col-xs-12 col-sm-12 col-md-3 col-lg-3 btn btn-info" id="filtro_2"> » Bancos de imágenes </button>
			<button class="col-xs-12 col-sm-12 col-md-3 col-lg-3 btn btn-info" id="filtro_3"> » Edición de imagenes </button> 
			<button class="col-xs-12 col-sm-12 col-md-4 col-lg-4 btn btn-info" id="filtro_4"> » Edición de audio y video </button> 
			<button class="col-xs-12 col-sm-12 col-md-4 col-lg-4 btn btn-info" id="filtro_5"> » Programación </button> 
			<button class="col-xs-12 col-sm-12 col-md-4 col-lg-4 btn btn-info" id="filtro_6"> » Envio de archivos </button> 	
		<div class="row"></div>
			
		<div class="row" style="margin:10px 0px; padding:0px">
			<button class="btn btn-success" id="btnAbrirModalSoftwareLibre"><i class="fas fa-plus"> Agregar Software</i>
		</div>
		<div class="row contenido_libre_admin">
			
		</div>
		</section>				  
    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->

<?php
require 'footer.php';
?>

<script src="scripts/softwarelibre.js"></script>
<!-- Page specific script -->

<!-- Modal (Agregar, Modificar, Borrar Software Libre-->
<div class="modal fade" id="modalSoftwareLibre" tabindex="-1" role="dialog" aria-labelledby="modalSoftwareLibre" aria-hidden="true">
 <form method="POST" id="form_sw">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <b><h3 class="modal-title" id="tituloModalSoftwareLibre">Agregar Software Libre</h3></b>
      </div>
      <div class="modal-body">
        <div class="form-row">
        	<input type="hidden" id="id_software_libre" name="id_software_libre"/>
        	<div class="form-group col-md-6">
        		<label>Logo Software Libre:</label>
        		<input type="file" name="file_url" id="file_url"/> <br>
        		<div id="imagen_editar"></div>
        	</div>
        </div>
        <div class="form-row">
	         <div class="form-group col-md-6">
	          <label>Nombre: </label>
	          <input class="form-control" type="text" id="txtNombre" name="txtNombre" placeholder="Nombre de la base da Datos" required/>
	         </div>
	         <div class="form-group col-md-6">
	          <label>Sitio: </label>
	         <input class="form-control" type="text" id="txtSitio" name="txtSitio" placeholder="Sitio de la base de Datos" required/>
	       </div>
	        <div class="form-group col-md-6">
	         <label>Url: </label>
	         <input class="form-control" type="text" id="txtUrl" name="txtUrl" placeholder="Url de la base de Datos" required/>
	       </div>
	       <div class="form-group col-md-6">
	         <label>Descripción: </label>
	         <input class="form-control" type="text" id="txtDescripcion" name="txtDescripcion" placeholder="Descripción"required/>
	       </div>
	       <div class="form-group col-md-6">
	         <label>Valor: </label>
	         <input class="form-control" type="text" id="txtValor" name="txtValor" placeholder="Valor" required/>
	       </div>
	       <div class="form-group col-md-6">
	         <label>categoría: </label>
	         <input class="form-control" type="text" id="txtCategoria" name="txtCategoria" placeholder="Categoria" required/>
	       </div>
       </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="botonAgregar" class="btn btn-success">Agregar</button>
        <button type="button" id="botonModificar" class="btn btn-success">Modificar</button>
        <button type="button" id="botonEliminar" class="btn btn-danger">Eliminar</button>
        <button type="button" onclick="LimpiarFormulario()" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<?php
}
	ob_end_flush();
?>
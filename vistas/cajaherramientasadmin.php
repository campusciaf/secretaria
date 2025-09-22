<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])){
    header("Location: ../");
}else{
    $menu = 4;
    $submenu = 404;
    require 'header.php';
    if($_SESSION['cajadeherramientasadmin']==1){
?>



<!--Contenido-->
<div class="content-wrapper">
   <section class="content">
      <div class="row mx-0">
         
         <div class="contenido">

            <div>
               <h2 class="titulo-5">Administrador Cajas Herramientas</h2>
            </div>
            
				<!-- Botones -->

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
				 <div class="card col-xl-12 m-2 p-2">
					<div class="btn-group btn-group-toggle  m-2 p-2" data-toggle="buttons" >
                    <div class="btn-group btn-group-toggle" data-toggle="buttons"   id="mostrar_categorias"></div>
                        

					</div>
				
                    <div class="card col-xl-12 m-2 p-2">
                        <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalAdminBiblioteca" title="Agregar"><i class="fa fa-plus"></i></button>
                    </div>


					<div class="row mx-0"></div>
					<div class="row contenido_libre">

				</div>
			
		</div>
		</section>				  
    </div><!-- /.content-wrapper -->

    <div class="modal fade" id="modalAdminBiblioteca" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Administrador Caja Herramientas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form name="formulariosoftware" id="formulariosoftware" method="POST" enctype="multipart/form-data">

                        <div class="row">

                            <div class="form-group col-6">
                                <label for="exampleInputEmail1">Ruta imagen</label>
                                <input type="file" class="form-control-file" id="file_url" name="file_url" required>
                                <div id="imagen_editar">
                                </div>
                            </div>

                            <div class="form-group col-6">
                                <label for="exampleInputEmail1">Nombre</label>
                                <input type="text" class="form-control" id="nombre_herramienta" name="nombre">
                            </div>
                            <div class="form-group col-6">
                                <label for="exampleInputEmail1">Sitio</label>
                                <input type="text" class="form-control" id="sitio_herramienta" name="sitio">
                            </div>
                            <div class="form-group col-6">
                                <label for="exampleInputEmail1">Url</label>
                                <input type="text" class="form-control" id="url_herramienta" name="url">
                            </div>

                            <div class="form-group col-6">
                                <label for="exampleInputEmail1">Descripción</label>
                                <input type="text" class="form-control" id="descripcion_herramienta" name="descripcion">
                            </div>
                            <div class="form-group col-6">
                                <label for="exampleInputEmail1">Valor</label>
                                <input type="text" class="form-control" id="valor_herramienta" name="valor">
                            </div>


                            <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                    <label>Categoria:</label>
                                    <div class="input-group mb-3">
                                        
                                        <select id="categoria_software" name="categoria_software" class="form-control selectpicker" data-live-search="true" data-style="border" required></select>

                                        
                                    </div>
                                </div>
                            </div> 
                    
                        </div>
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                            <input type="number" class="d-none id_software" id="id_software" name="id_software">
                            <button type="submit" class="btn btn-primary mt-4" id="botonAgregarHerramienta"> <i class="fa fa-save"></i> Guardar </button>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
        </div>
    </div>


<!-- <style>
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
    .barra-libros{
        background-color: #000;
        overflow: hidden; 
        border-radius: 0px; 
        border-top: 8px solid #000; 
        padding: 0px; 
        margin: 0px; 
        height: 135px;
    }
</style> -->
<?php
	}else{
        require 'noacceso.php';
	}
    require 'footer.php';
}
ob_end_flush();
?>
<script src="scripts/cajaherramientasadmin.js"></script>











































































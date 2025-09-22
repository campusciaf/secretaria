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
	
$menu=15;
$submenu=1507;
require 'header.php';
	if ($_SESSION['vershopping']==1)
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
               <h2 class="m-0 line-height-16">
                     <span class="titulo-2 fs-18 text-semibold">Feria de emprendimientos</span><br>
                     <span class="fs-16 f-montserrat-regular">Hemos creado un espacio para todos nuestros estudiantes emprendedores</span>
               </h2>
            </div>

            <div class="col-12 migas">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                     <li class="breadcrumb-item active">Emprendimientos</li>
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
         
         <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 p-3">
            <div class="row">
               <div class="col-12">
                  <div class="row">

                     <div class="col-12 p-4 tono-3">
                        <div class="row align-items-center">
                           <div class="pl-1">
                              <span class="rounded bg-light-blue p-3 text-primary ">
                                    <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                              </span> 
                           
                           </div>
                           <div class="col-10">
                           <div class="col-5 fs-14 line-height-18"> 
                              <span class="">Resultados</span> <br>
                              <span class="text-semibold fs-20 titulo-2 line-height-16">Emprendimientos</span> 
                           </div> 
                           </div>
                        </div>
                     </div>

                    <div class="col-12 card table-responsive p-4" id="listadoregistros">
                        <table id="tbllistado" class="table table-hover" style="width: 100%;">
                            <thead>
                                <th>Acciones</th>
                                <th>Identificación</th>
                                <th>Imagen</th>
                                <th>Emprendimiento</th>
                                <th>Descripción</th>
                                <th>Redes sociales</th>
                                <th>Redes CIAF</th>
                                <th>Estado</th>
                            </thead>
                            <tbody>                            
                            </tbody>
                        </table>
                    </div>
                  </div>
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


<div class="modal fade" id="modalFoto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="foto"></div>
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

<script type="text/javascript" src="scripts/vershopping.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
	ob_end_flush();
?>
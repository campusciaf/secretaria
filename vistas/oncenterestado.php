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
$menu=14;
$submenu=1401;
require 'header.php';
	if ($_SESSION['oncenterestado']==1)
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
                     <span class="titulo-2 fs-18 text-semibold">Estados</span><br>
                     <span class="fs-16 f-montserrat-regular"> Gestiona el estado de tus clientes</span>
               </h2>
            </div>
            <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
               <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
            </div>

            <div class="col-12 migas">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                     <li class="breadcrumb-item active">Estados</li>
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
         
         <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-4">
            <div class="row">
               <div class="card col-12">
                  <div class="row">

                  <div class="col-6 p-4 tono-3">
                           <div class="row align-items-center">
                              <div class="pl-4">
                                 <span class="rounded bg-light-blue p-3 text-primary ">
                                       <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                 </span> 
                              
                              </div>
                              <div class="col-10">
                              <div class="col-5 fs-14 line-height-18"> 
                                 <span class="">Resultados</span> <br>
                                 <span class="text-semibold fs-20">Estados</span> 
                              </div> 
                              </div>
                           </div>
                     </div>

                     <div class="col-6 py-4 pr-4 text-right tono-3">
                        <button id="t-As" class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar Estado</button>
                     </div>

                     <div class="col-12">
                        <div class="panel-body table-responsive p-4 m-0" id="listadoregistros">
                           <table id="tbllistado" class="table p-0 m-0" style="width: 100%;">
                              <thead>
                                 <th id="t-Ac">Acciones</th>
                                 <th id="t-no">Nombre</th>
                                 <th id="t-at" >Activado</th>
                              </thead>
                              <tbody>                            
                              </tbody>
                           </table>
                        </div>
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

<div class="modal" id="gestion">
   <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">
         <!-- Modal Header -->
         <div class="modal-header">
            <h6 class="modal-title">Estados</h6>
            <button type="button" class="close" data-dismiss="modal" onclick="cancelarform()">&times;</button>
         </div>
         <div class="modal-body">
            <div class="panel-body p-3" id="formularioregistros">
               <form name="formulario" id="formulario" method="POST">

                  <input type="hidden" name="id_estado" id="id_estado">

                  <div class="col-12">
                     <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                              <input type="text" placeholder="" value="" class="form-control border-start-0" name="nombre" id="nombre" required>
                              <label>Nombre Estado</label>
                        </div>
                     </div>
                     <div class="invalid-feedback">Please enter valid input</div>
                  </div>


                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                     <button class="btn btn-success btn-block" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                  </div>
               </form>
            </div>
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

<script type="text/javascript" src="scripts/oncenterestado.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
	ob_end_flush();
?>
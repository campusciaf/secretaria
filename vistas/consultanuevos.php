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
$menu=10;
$submenu=1011;
require 'header.php';

	if ($_SESSION['consultanuevos']==1)
	{
?>
<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mx-2">
              <div class="col-xl-6 col-9">
                <h2 class="m-0 line-height-16">
                      <span class="titulo-2 fs-18 text-semibold">Nuevos</span><br>
                      <span class="fs-14 f-montserrat-regular">Vista que contiene los estudiantes a primer curso</span>
                </h2>
              </div>
              <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
              </div>
              <div class="col-12 migas">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                      <li class="breadcrumb-item active">Nuevos</li>
                    </ol>
              </div>
          </div>
        </div>
    </div>
   <section class="container-fluid px-4 mb-4">
      <div class="row mx-0">
         <div class="col-12 mb-3 text-right">
            <a onclick="configurar()" type="button" class="btn btn-primary btn-sm" >
               <i class="fa-solid fa-gear"></i> Configurar programas
            </a>
         </div>
         <div class="col-12 tono-3">
            <div class="row mx-0">
               <div class="col-xl-9 col-lg-8 col-md-8 col-12 pt-4 pl-4">
                  <div class="row align-items-center pt-2">
                     <div class="col-xl-auto col-lg-auto col-md-auto col-2">
                           <span class="rounded bg-light-green p-3 text-success ">
                              <i class="fa-solid fa-headset" aria-hidden="true"></i>
                           </span> 
                     </div>
                     <div class="col-xl-10 col-lg-10 col-md-10 col-10">
                      
                           <span class="fs-14 line-height-18">Estudiantes</span> <br>
                           <span class="text-semibold fs-16 titulo-2 line-height-16" id="dato_periodo">Nuevos 2024-1</span> 
                        
                     </div>
                  </div>
               </div>

               <div class="col-xl-3 col-lg-4 col-md-4 col-12 px-4 pt-4">
                  <div class="form-group mb-3 position-relative check-valid">
                     <div class="form-floating">
                        <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="periodo" id="periodo" onChange="listarNuevos(this.value,1)"></select>
                        <label>Seleccionar periodo</label>
                     </div>
                  </div>
                  <div class="invalid-feedback">Please enter valid input</div>
               </div>

               <div id="resultado" class="col-12"></div>
               <div id="resultadoDos" class="card col-12 px-4 mb-0"></div>
            </div>
         </div>
      </div>
   </section><!-- /.content -->

</div><!-- Main content -->
<!-- Modal -->
<div class="modal" id="myModalListado">
   <div class="modal-dialog modal-xl">
      <div class="modal-content">
         <!-- Modal Header -->
         <div class="modal-header">
            <h6 class="modal-title">Listado Consulta</h6>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <!-- Modal body -->
         <div class="modal-body">
            <div class="card p-4" id="listadoregistrostres">
               <div id="titulo"></div>
               <table id="tbllistadoestudiantes" class="table table-hover " style="width:100%">
                  <thead>
                     <th>Identificación</th>
                     <th>Nombre</th>
                     <th>Programa</th>
                     <th>Jornada</th>
                     <th>Semestre</th>
                     <th>Correo</th>
                     <th>Correo P.</th>
                     <th>Edad</th>
                  </thead>
                  <tbody>                            
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>




<!-- Modal -->
<div class="modal fade" id="configurar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Configurar programas</h5>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close"> x </button>
      </div>
      <div class="modal-body">
        <div class="row">
         <div class="panel-body col-12 responsive">
            <table id="tbllistadoconfig" class="table table-hover" style="width:100%">
               <thead>
                  <th>Programa</th>
                  <th>Estado</th>
               </thead>
               <tbody>                            
               </tbody>
            </table>
         </div>
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

<script type="text/javascript" src="scripts/consultanuevos.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>

<?php
}
	ob_end_flush();
?>

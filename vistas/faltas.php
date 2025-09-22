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
$submenu=12;
require 'header.php';

	if ($_SESSION['faltas']==1)
	{
		
?>

<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
              <div class="col-xl-6 col-9">
                <h2 class="m-0 line-height-16">
                      <span class="titulo-2 fs-18 text-semibold">Gestión faltas</span><br>
                      <span class="fs-14 f-montserrat-regular">Universitarios CIAF en la era digital</span>
                </h2>
              </div>
              <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
              </div>
              <div class="col-12 migas">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                      <li class="breadcrumb-item active">Faltas</li>
                    </ol>
              </div>
          </div>
        </div>
    </div>

   <section class="content" style="padding-top: 0px;">
      <div class="row">

      <div class="col-12 px-3">
         <div class="row tono-3">
            <div class="col-xl-9 col-lg-8 col-md-8 col-12 pt-4 pl-4">
               <div class="row align-items-center pt-2">
                  <div class="col-xl-auto col-lg-auto col-md-auto col-2">
                        <span class="rounded bg-light-green p-3 text-success ">
                           <i class="fa-solid fa-headset" aria-hidden="true"></i>
                        </span> 
                  </div>
                  <div class="col-xl-10 col-lg-10 col-md-10 col-10">
                     
                        <span class="fs-14 line-height-18">Reporte</span> <br>
                        <span class="text-semibold fs-16 titulo-2 line-height-16" id="dato_periodo">Faltas <span id="miperiodo"></span></span> 
                     
                  </div>
               </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-4 col-12 px-4 pt-4">
               <div class="form-group mb-3 position-relative check-valid">
                  <div class="form-floating">
                     <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="periodo" id="periodo" onChange="listar(this.value)"></select>
                     <label>Seleccionar periodo</label>
                  </div>
               </div>
               <div class="invalid-feedback">Please enter valid input</div>
            </div>

         </div>
      </div>


         <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card card-primary" style="padding: 2%">
				
             <table id="tbllistado" class="table table-striped table-compact table-sm table-hover ">
                <thead>
                    <tr>
                      <th scope="col">Identificación</th>
                      <th scope="col">Nombre estudiante</th>
                      <th scope="col">Motivo</th>
                      <th scope="col">Docente</th>
                      <th scope="col">Fecha falta</th>
                      <th scope="col">Asignatura</th>
                      <th scope="col">Programa</th>
                      <th scope="col">Jornada</th>
                      <th scope="col">Acción</th>
                    </tr>
                </thead>
                            
            </table>

            </div>
            <!-- /.card -->
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>
<!-- /.content-wrappe-->
<?php
	}
	else
	{
	  require 'noacceso.php';
	}
		
require 'footer.php';
?>

<script type="text/javascript" src="scripts/faltas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
	ob_end_flush();
?>

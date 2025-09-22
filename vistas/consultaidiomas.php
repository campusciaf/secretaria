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
$submenu=1023;
require 'header.php';

	if ($_SESSION['consultaidiomas']==1)
	{
?>
<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-xl-6 col-9">
               <h2 class="m-0 line-height-16">
                     <span class="titulo-2 fs-18 text-semibold">Cifras</span><br>
                     <span class="fs-14 f-montserrat-regular">Vista que contiene los estudiantes a primer curso</span>
               </h2>
            </div>
            <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
               <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
            </div>
            <div class="col-12 migas">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                     <li class="breadcrumb-item active">Cifras</li>
                  </ol>
            </div>
         </div>
      </div>
   </div>
   <section class="container-fluid px-4">
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-4 col-12 px-4 pt-4">
                <div class="form-group mb-3 position-relative check-valid">
                    <div class="form-floating">
                        <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="periodo" id="periodo" onChange="buscarp(this.value)"></select>
                        <label>Seleccionar periodo</label>
                    </div>
                </div>
                <div class="invalid-feedback">Please enter valid input</div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-4 col-12 px-4 pt-4">
                <div class="form-group mb-3 position-relative check-valid">
                    <div class="form-floating">
                        <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="escuelas" id="escuelas" onChange="buscare(this.value)"></select>
                        <label>Seleccionar escuela</label>
                    </div>
                </div>
                <div class="invalid-feedback">Please enter valid input</div>
            </div>
        </div>

        <div class="card col-12 table-responsive p-4" id="listadoregistros">
            <table id="tbllistado" class="table" style="width: 100%;">
                <thead>
                    <th>Credencial</th>
                    <th>Id Est.</th>
                    <th>Identificación</th>
                    <th>Nombre estudiante</th>
                    <th>Programa</th>
                    <th>Jornada</th>
                    <th>Sem.</th>
                    <th>A1-2</th>
                    <th>A1-3</th>
                    <th>A1-4</th>
                    <th>Activo</th>
                    <th>A2-1</th>
                    <th>A2-2</th>
                    <th>A2-3</th>
                    <th>Activo</th>
                    <th>B1-1</th>
                    <th>B1-2</th>
                    <th>B1-3</th>
                    <th>Activo</th>
                </thead>
                <tbody>
                </tbody>
            </table>
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

<script type="text/javascript" src="scripts/consultaidiomas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>

<?php
}
	ob_end_flush();
?>

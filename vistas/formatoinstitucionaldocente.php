<?php
ob_start();
 session_start();
if (!isset($_SESSION["usuario_nombre"]))
{
  header("Location: ../");
}
else
{
$menu=3;
require 'header_docente.php';
if (!empty($_SESSION['id_usuario']))
	{
?>

<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
              <div class="col-xl-6 col-9">
                <h2 class="m-0 line-height-16">
                      <span class="titulo-2 fs-18 text-semibold">Formatos institucionales</span><br>
                      <span class="fs-14 f-montserrat-regular">Este Manual describe las pautas y normas para el correcto uso de la marca</span>
                </h2>
              </div>
              <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
              </div>
              <div class="col-12 migas">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="panel_docente.php">Inicio</a></li>
                      <li class="breadcrumb-item active">Formatos insitucionales</li>
                    </ol>
              </div>
          </div>
        </div>
    </div>

   <section class="container-fluid px-4">
      <div class="row">
         <div class="col-12 card p-4 table-responsive" id="listadoregistros">
            <table id="tbllistado" class="table table-hover" style="width:100%">
               <thead>
                  <th>Nombre</th>
                  <th>Archivo</th>
               </thead>
               <tbody>                            
               </tbody>
            </table>
         </div>
      </div>
   </section>

</div>


<?php
	}
	else
	{
	  require 'noacceso.php';
	}
		
require 'footer_docente.php';
?>

<script type="text/javascript" src="scripts/formatoinstitucionaldocente.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
	ob_end_flush();
?>


</body>

</html>




<?php
ob_start();
 session_start();
if (!isset($_SESSION["usuario_nombre"]))
{
  header("Location: ../");
}
else
{
$menu=10;
require 'header_docente.php';
if (!empty($_SESSION['id_usuario']))
	{
?>

<!-- <link rel="stylesheet" href="../public/css/print.min.css"> -->


<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
              <div class="col-xl-8 col-9">
                <h2 class="m-0 line-height-16">
                      <span class="titulo-2 fs-18 text-semibold">Caracterización</span><br>
                      <span class="fs-14 f-montserrat-regular"> Conocerte en diferentes aspectos como el familiar, académico, emocional, físico y socioeconómico es nuestra misión</span>
                </h2>
              </div>
              <div class="col-xl-4 col-3 pt-4 pr-4 text-right">
                <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
              </div>
              <div class="col-12 migas">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="panel_docente.php">Inicio</a></li>
                      <li class="breadcrumb-item active">CARACTERIZACION</li>
                    </ol>
              </div>
          </div>
        </div>
    </div>

    

 

   <section class="container-fluid px-4">
         <div class="row "> 
            <form name="formulariodatos" id="formulariodatos" method="POST">
              <div class="col-xl-12" id="preguntas"></div>
            </form>
         </div> 
   </section>

</div>
<!--Fin-Contenido-->

	<!-- Modal -->
<div id="myModalAcepto" class="modal fade" role="dialog">
  <div class="modal-dialog modal-dialog-centered">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-body">
        <div class="row">

            <div class="col-12 tono-3 py-4">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="rounded bg-light-blue p-3 text-primary ">
                            <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                        </span> 
                    </div>
                    <div class="col-10 line-height-18">
                        <span class="">Caracterización</span> <br>
                        <span class="titulo-2 text-semibold fs-20 line-height-18">Docente</span> 
                    </div>
                </div>
            </div>
            <div class="col-12 py-4">

                <p class="text-justify">
                ¡Te invitamos a responder las siguientes preguntas, queremos conocerte más para que sigamos creando experiencias juntos! 
                </p>
                <h2 class="fs-18 titulo-2 text-semibold ">Autorización de datos personales</h2>

                <p class="text-justify">
                    Conforme lo establece la Ley 1581 de 2012 y sus decretos reglamentarios, 
                    manifiesto, de manera libre, previa y expresa, que con el diligenciamiento 
                    de la presento encuesta, autorizo a CIAF, para realizar la recolección, 
                    tratamiento, almacenamiento y uso de los datos que suministro, cuya finalidad es: 
                    Brindar al estudiante servicios de bienestar institucional y social, 
                    Realizar Gestión administrativa, contable y financiera, Atención de (PQRS), 
                    Obtener datos con Fines históricos y estadísticos, Realizar Publicidad y mercadeo, 
                    Cumplir Requerimientos institucionales y del Ministerio de Educación Nacional.
                </p>

                <p class="text-justify">
                    En virtud de lo anterior, autorizo a CORPORACIÓN INSTITUTO DE ADMINISTRACIÓN Y FINANZAS –CIAF-, 
                    a realizar el tratamiento de datos personales para los fines previamente comunicados y acepto la política 
                    de tratamiento de datos personales publicada 
                    <a href="https://ciaf.edu.co/tratamientodatos" target="_blank" title="Tratamiento de datos">https://ciaf.edu.co/tratamientodatos</a>
                </p>

                <form name="formulariodata" id="formulariodata" method="POST">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value="1" name="acepto" id="acepto" required>
                            <a href="https://ciaf.digital/public/web_tratamiento_datos/politicaciaf_tratamientodatos.pdf" target="_blank">Acepto terminos y condiciones</a></label><br>
                        <button class="btn btn-success btn-block" type="submit" id="btnData"> Continuar</button>
                    </div>
                </form>
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
		
require 'footer_docente.php';
?>

<script type="text/javascript" src="scripts/caracterizaciondocente.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
	ob_end_flush();
?>


</body>

</html>
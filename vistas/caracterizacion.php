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
	$menu=3;
require 'header_estudiante.php';


?>

<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
              <div class="col-xl-6 col-9">
                <h2 class="m-0 line-height-16">
                      <span class="titulo-2 fs-18 text-semibold">Caracterización</span><br>
                      <span class="fs-16 f-montserrat-regular">Mensaje en esta parte</span>
                </h2>
              </div>
              <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
              </div>
              <div class="col-12 migas">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="panel_estudiante.php">Inicio</a></li>
                      <li class="breadcrumb-item active">caracterización</li>
                    </ol>
              </div>
          </div>
        </div>
    </div>


		<section class="container-fluid px-4">
			<div class="row">

				<div class="card col-12" style="padding: 2%">	
					
					 <div class="box-header with-border">
                        <div id="botones"></div> <!--  div para traer los botones-->
					</div>

					<div class="panel-body" id="formularioregistros" style="display: block">
						<form name="formulario" id="formulario" method="POST">

							<input type="hidden" name="id_categoria" id="id_categoria" value="">
							<input type="hidden" name="id_tipo_pregunta" id="id_tipo_pregunta" value="">

							<div id="preguntas"></div>

							<div class="alert col-lg-12 col-md-12 col-sm-12 col-xs-12">        
								<button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar y Continuar</button>

							 </div>       

						</form>
					</div>
					
				</div>
		
				
				<!--<div class="experiencias">
					<iframe src="https://prueba.ciaf.edu.co/plataformatecnologica/vistas/slider.php" scrolling="no" frameborder="0" width="100%" height="100%" style=""></iframe>
				</div>-->

			</div>
			<!-- /.row -->
		</section>				  
	</div><!-- /.content-wrapper -->



    <!-- Main content -->
    <section class="content">
        <div class="row">
          <div class="col-md-12">
              <div class="box">

               

                <!--Fin centro -->
              </div><!-- /.box -->
          </div><!-- /.col -->
      </div><!-- /.row -->
    </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->


	<!-- Modal -->
<div id="myModalAcepto" class="modal fade" role="dialog">
  <div class="modal-dialog modal-dialog-centered">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title text-1">CARACTERIZACIÓN ESTUDIANTES</h4>
      </div>
      <div class="modal-body p-4">
		<h2>Estimado/a Estudiante: </h2>
        <p class="text-justify">
		En CIAF queremos conocerte un poco más para que podamos seguir creciendo juntos. 
		Con esta información nos permitirás definir planes, programas y actividades para ayudarte a cumplir tu meta: el grado.
		</p>
		<h3 class="fs-4">Autorización de datos personales</h3>

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

<?php
	
require 'footer_estudiante.php';
?>
<script src="scripts/caracterizacion.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>

<?php
}
	ob_end_flush();
?>
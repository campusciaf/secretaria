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
$menu=8;
$submenu=803;
require 'header.php';
	if ($_SESSION['certificadosporsemestre']==1)
	{

?>


<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
              <div class="col-xl-6 col-9">
                <h2 class="m-0 line-height-16">
                      <span class="titulo-2 fs-18 text-semibold">Certificados por semestre</span><br>
                      <span class="fs-14 f-montserrat-regular">Universitarios CIAF en la era digital</span>
                </h2>
              </div>
              <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
              </div>
              <div class="col-12 migas">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                      <li class="breadcrumb-item active">Gestión certificados</li>
                    </ol>
              </div>
          </div>
        </div>
    </div>

    

   <section class="content" style="padding-top: 0px;">
      <div class="row">
         <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card card-primary" style="padding: 2% 1%">
               <!-- /.row -->
               <!-- CONTENEDOR PARA BUSCAR POR NUMERO DE IDENTIFICACIÓN-->
               <div class="row" id="contenedor_busqueda">
                  <!-- INPUT PARA CAPTURAR LA CÉDULA A BUSCAR EN LA BASE DE DATOS -->
                   <div class="col-5">
                     <div class="row">
                        <div class="col-xl-9 col-lg-9 col-md-9 col-8 pr-0">
                           <div class="form-group mb-3 position-relative check-valid">
                              <div class="form-floating">
                                    <input type="number" placeholder="" value="" required="" class="form-control border-start-0" name="input_cedula" id="input_cedula">
                                    <label>Digite el número de documento</label>
                              </div>
                           </div>
                           <div class="invalid-feedback">Please enter valid input</div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-4 px-0 mx-0">
                           <button title='Buscar Estudiante' id="buscar_estudiante" class="btn btn-success py-3">&nbsp;<span class="fa fa-search"></span> Consultar</button>
                        </div>
                     </div>
                   </div>

                  <div class="col-7">

                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-12 py-2">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <span class="rounded  p-2 text-gray ">
                                          <img class="img-circle" id="user-photograph" style="width:30px; height:30px;" src="../files/null.jpg" alt="User Avatar">
                                        </span>

                                    </div>
                                    <div class="col-10">
                                        <span class="" id="nombre_completo_estudiante">Nombres </span> <br>
                                        <span class="text-semibold fs-14"  id="apellido_completo_estudiante">Apellidos </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-12 py-2">
                                <div class="row align-items-center">
                                    <div class="col-2 ">
                                        <span class="rounded bg-light-white p-2 text-gray">
                                            <i class="fa-regular fa-envelope" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <div class="col-10">
                                        <span class="">Correo electrónico</span> <br>
                                        <span class="text-semibold fs-14" id="correo_estudiante">correo@correo.com</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-12 py-2">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <span class="rounded bg-light-white p-2 text-gray">
                                            <i class="fa-solid fa-mobile-screen" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <div class="col-10">
                                        <span class="">Número celular</span> <br>
                                        <span class="text-semibold fs-14">+570000000</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                  </div>

                  <div class="col-12">
                     <input type="hidden" name="id_credencial" id="id_credencial"/>
                     <input type="hidden" name="id_estudiante" id="id_estudiante"/>
                  </div>
                  <!-- Tabla para listar los programmas del estudiante -->
                  <div class="col-12" id="listadoregistros">
                     <div class="panel-body table-responsive" >
                        <table id="tbllistado" class="table table-striped  table-hover">
                           <thead>
                              <th>Acciones</th>
                              <th>Id estudiante</th>
                              <th>Programa</th>
                              <th>Jornada</th>
                              <th>Escuela</th>
                              <th>Estado</th>
                              <th>Periodo Activo</th>
                           </thead>
                           <tbody>                            
                           </tbody>
                        </table>
                        <br>
                     </div>
                  </div>
                     

                  <!-- BOTÓN PARA SELECCIONAR EL TIPO DE CERTIFICADO A GENERAR -->
                  <div class="col-12" id="generador_certificados">
                     <form class="row" method="post" id="ver_certificado" name="ver_certificado" >
                        <div class="col-12 border-bottom py-1"></div>
                        <div class="col-12 text-right my-2">
                           <a onclick="volver()" class="btn btn-primary">Volver</a>
                        </div>

                        <div class="col-12 alert alert-info">
                           <p>Actualmente te encuentras en la sección de Certificado por Semestre. Desde aquí puedes acceder a la información y gestión de los certificados académicos correspondientes a cada semestre.</p>
                        </div>
                        
                     <div class="col-xl-3 col-lg-4 col-md-4 col-6 pr-0">
                        <div class="form-group mb-3 position-relative check-valid">
                           <div class="form-floating">
                                 <select value="" required="" class="form-control border-start-0" name="selector_semestre" id="selector_semestre"></select>
                                 <label>Seleccionar un semestre</label>
                           </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                     </div>
                     <div class="col-xl-3 px-0">
                        <input type="submit" value="Previsualizar" class="btn btn-success py-3" />
                     </div>

                     </form>
                  </div>

               </div>
               <!-- BOTÓN PARA EL HISTORIAL DE CERTIFICADOS -->
            </div>
         </div>
         <!-- /.card -->
      </div>
      <!-- /.col -->
   </section>
<!-- /.content -->
</div><!-- /.content-wrapper -->

<?php
	}
	else
	{
	  require 'noacceso.php';
	}
require 'footer.php';
?>
<!-- AdminLTE App -->
<?php
}
	ob_end_flush();
?>

<!-- Modal Para Previsualizar el Certificado -->
<div class="modal fade" id="vistaprevia_modal" tabindex="-1" role="dialog" aria-labelledby="vistaprevia_modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
		<div class="row">
			<div class="col-md-6">
				<h3 class="modal-title" id="vistaprevia_modaletiqueta">Vista Previa del Certificado</h3>
			</div>
			<!-- Contenedor de los botones de impresión -->
			<div id="botones" class="col-md-6">
				<div id="imprimir">
					<a class="btn btn-link pull-right" id="boton_imprimir"><i class="fas fa-print fa-3x fa-lg"></i></a>
				</div>
			</div>
		</div>
	  </div>
	  <!-- Este es el contenedor que da la vista previa y el que se imprime como certificado expedido --->
      <div class="modal-body" id="cuerpo_vista_previa">
	  <!-- Contenedor para el encabezado de todos los certificados -->
	  <div style="width: 527px; margin-left: 70px; margin-top:150px">
	  <center>
	  <div style="font-size:16px" id="encabezado_certificados" hidden="true"><b>
	  CORPORACIÓN INSTITUTO DE ADMINISTRACIÓN Y FINANZAS C.I.A.F<br>NIT.891.408.248-5<br><br> REGISTRO Y CONTROL 
	  <br>CERTIFICA:</b><br><br>
	  </div>
	  </center>
		<!-- Contenedor para los datos del certificado de calificaciones -->
		<div align="justify" style="font-size:16px" id="calificaciones" hidden="true">Que: <b>
		<span id="calificaciones_nombre_estudiante" style="text-transform: uppercase;"></span></b>,
		identificado(a) con <span id="calificaciones_tipo_doc"></span> número <b>
		<span id="calificaciones_identificacion"></span></b>,
		expedida en <b><span id="calificaciones_expedido_en" style="text-transform: uppercase;"></span></b>, 
		cursó el <b><span id="calificaciones_romano" style="text-transform: uppercase;"></span></b>
		<b>semestre</b> del programa <b><span id="calificaciones_programa" style="text-transform: uppercase;"></span></b>,
		obteniendo las siguientes calificaciones: </div><br/>
        <!-- Contenedor donde se imprimen los resultados de las consultas -->
		<div id="contenido_vista_previa">
	  	</div>
		<!-- Contenedor donde se muestra la fecha y la firma de coordinación Registro y Control -->
		<div id="pie_certificado" hidden="true">
		<b><font size='3px'>Para constancia se firma en Pereira el día 
		<span id="fecha_certificado"></span>.</font></b><br><br><br><br>
		____________________________<br>
		<b>Wilbert René Ramírez Delgado</b><br>
		<b>Registro y Control Académico</b><br><br>
		</div>
		<div id="numero_sn" hidden="true">
		<span>SN 766-12-2015</span>
		</div>
      	</div>

	  </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="scripts/certificadosporsemestre.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>

</body>
</html>
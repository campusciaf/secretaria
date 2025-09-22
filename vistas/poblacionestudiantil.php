<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"]))
{
    header("Location: login.html");
}
else
{
$menu=29;
$submenu=295;
require 'header.php';

	if ($_SESSION['poblacionestudiantil']==1)
	{
?>



<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
              <div class="col-xl-6 col-9">
                <h2 class="m-0 line-height-16">
                      <span class="titulo-2 fs-18 text-semibold">Población estudiantil</span><br>
                      <span class="fs-14 f-montserrat-regular">Universitarios CIAF en la era digital</span>
                </h2>
              </div>
              <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
              </div>
              <div class="col-12 migas">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                      <li class="breadcrumb-item active">Población estudiantil</li>
                    </ol>
              </div>
          </div>
        </div>
    </div>
   <section class="content" style="padding-top: 0px;">
        <div class="card card-primary" style="padding: 2% 1% 0% 1%">
            <div class="row">

                <div class="col-xl-12">

                    <form action="#" method="post" class="row" id="form_consulta_filtrada">



                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                            <div class="form-group position-relative check-valid">
                                <div class="form-floating">
                                    <select name="periodo" id="periodo" class="form-control border-start-0"   onchange="buscar()"></select>
                                    <label>Periodo académico</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please enter valid input</div>
                        </div>

                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                            <div class="form-group  position-relative check-valid">
                                <div class="form-floating">
                                  <select name="escuela" id="escuela" class="form-control border-start-0 selectpicker" multiple data-live-search="true" onchange="buscar()">
                                    <option value="1">Administración</option>
                                    <option value="2">Ingeniería</option>
                                    <option value="3">SST</option>
                                    <option value="5">Industrial</option>
                                    <option value="6">Contaduría</option>
                                    <option value="7">Formación para el trabajo</option>
                                  </select>
                                  <label>Programa</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please enter valid input</div>
                        </div>

                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                            <div class="form-group  position-relative check-valid">
                                <div class="form-floating">
                                  <select name="nivel" id="nivel" class="form-control border-start-0 selectpicker" multiple data-live-search="true" onchange="buscar()">
                                    <option value="1">Técnico</option>
                                    <option value="2">Tecnólogo</option>
                                    <option value="3">Profesional</option>
                                    <option value="5">Nivelatorios</option>
                                    <option value="7">Formación para el trabajo</option>
                                  </select>
                                  <label>Nivel de formación</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please enter valid input</div>
                        </div>

                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                            <div class="form-group  position-relative check-valid">
                                <div class="form-floating">
                                  <select name="programa_ac" id="programa_ac" class="form-control border-start-0 selectpicker" multiple data-live-search="true" onchange="buscar()">
                                  </select>
                                  <label>Progama académico</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please enter valid input</div>
                        </div>

                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                            <div class="form-group  position-relative check-valid">
                                <div class="form-floating">
                                  <select name="semestre" id="semestre" class="form-control border-start-0 selectpicker" multiple data-live-search="true" onchange="buscar()">
                                    <option value="1">1 - Técnico </option>
                                    <option value="2">2 - Técnico </option>
                                    <option value="3">3 - Técnico </option>
                                    <option value="4">4 - Técnico </option>
                                    <option value="5">5 - Técnico </option>
                                    <option value="1">5 - Tecnólogo </option>
                                    <option value="2">6 - Tecnólogo </option>   
                                    <option value="3">7 - Tecnólogo </option>
                                    <option value="1">7 - Profesional </option> 
                                    <option value="2">8 - Profesional </option>
                                    <option value="3">9 - Profesional </option> 
                                    <option value="4">10 - Profesional </option> 
                                  </select>
                                  <label>Semestre</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please enter valid input</div>
                        </div>

                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                            <div class="form-group  position-relative check-valid">
                                <div class="form-floating">
                                  <select name="jornada" id="jornada" class="form-control border-start-0 selectpicker" multiple data-live-search="true" onchange="buscar()">
                                  </select>
                                  <label>Jornada</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please enter valid input</div>
                        </div>

                       

                        

                    </form>

                </div>
         </div><!-- /.card-->
   </section><!-- /.content -->


   <section>
      <div class="col-xl-12" style="padding: 2% 1%">
          <div class="row" id="activos">
              
          </div>
      </div>
   </section>


</div><!-- /.content-wrapper -->

<!--Fin-Contenido-->




<!-- Modal -->
<div class="modal fade" id="configacademico" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
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

<script type="text/javascript" src="scripts/poblacionestudiantil.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
	ob_end_flush();
?>
<script>

</script>

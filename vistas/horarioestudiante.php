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
$menu=7;
$submenu=705;
require 'header.php';
	if ($_SESSION['horarioestudiante']==1)
	{
?>

<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
              <div class="col-xl-6 col-9">
                <h2 class="m-0 line-height-16">
                      <span class="titulo-2 fs-18 text-semibold">Horario estudiante</span><br>
                      <span class="fs-16 f-montserrat-regular">Visualice el horario académico de tus  estudiantes</span>
                </h2>
              </div>
              <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
              </div>
              <div class="col-12 migas">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                      <li class="breadcrumb-item active">Horario estudiante</li>
                    </ol>
              </div>
          </div>
        </div>
    </div>

    <section class="container-fluid px-4">
      <div class="row m-0">
        <form name="formularioverificar" id="formularioverificar" method="POST" class="col-12 m-0 p-0">
            <div class="row">
               <div class="col-4 p-4">
                  <div class="row">
                    <div class="col-12" >
                      <h3 class="titulo-2 fs-14">Buscar por:</h3>
                    </div>
                    <div class="col-10 p-0 m-0" id="t-identificacion">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="credencial_identificacion" id="credencial_identificacion" maxlength="11" >
                                <label>Número de identificación</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>
                    <div class="group col-2 p-0 m-0">
                      <button type="submit" id="btnVerificar" class="btn btn-success py-3">Verificar</button>
                    </div>
                  </div>
                </div>

                <div class="col-8 p-4" id="datos_estudiante">

                  <div class="row">

                    <div class="col-12">
                      <h3 class="titulo-2 fs-14">Datos estudiante:</h3>
                    </div>

                    <div class="col-4 px-2 py-2 " id="t-personal">
                      <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="rounded bg-light-white p-2 text-gray">
                              <i class="fa-regular fa-user"></i>
                            </span>
                          </div>
                          <div class="col-10">
                            <span class="">Nombres</span> <br>
                            <span class="text-semibold fs-14">Apellidos</span> 
                          </div>
                      </div>
                    </div>

                    <div class="col-4 px-2 py-2 " id="t-correo">
                      <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="rounded bg-light-white p-2 text-gray">
                              <i class="fa-regular fa-envelope" aria-hidden="true"></i>
                            </span>
                          </div>
                          <div class="col-10">
                            <span class="">Correo electrónico</span> <br>
                            <span class="text-semibold fs-14">correo@correo.com</span> 
                          </div>
                      </div>
                    </div>

                    <div class="col-4 px-2 py-2 " id="t-celular">
                      <div class="row align-items-center">
                        <div class="col-auto">
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

                <div id="mostrardatos" class="col-8 p-4"></div>
            </div>
        </form>

        <div class="table-responsive" id="t-info">
              <div class="card col-12 p-2" id="listadoregistros">
                <table id="tbllistado" class="table table-hover" style="width:100%">
                  <thead>
                    <th id="t-acciones">Acciones</th>
                    <th id="t-idE">Id estudiante</th>
                    <th id="t-programas">Programa</th>
                    <th id="t-jornadas">Jornada</th>
                    <th id="t-semestres">Semestre</th>
                    <th id="t-grupos">Grupo</th>
                    <th id="t-estado1">Estado</th>
                    <th id="t-nuevo">Nuevo del</th>
                    <th id="t-periodo">Periodo Activo</th>
                  </thead>
                  <tbody>                            
                  </tbody>
                </table>
            </div>
        </div>


        <div class="col-12" id="listadomaterias">


               
        
       
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

<script type="text/javascript" src="scripts/horarioestudiante.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
	ob_end_flush();
?>
<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])){
    header("Location: ../");
}else{
    $menu = 15;
    $submenu = 1501;
    require 'header.php';
    if($_SESSION['abrircaso'] == 1){
?>
<!-- fullCalendar -->
<link rel="stylesheet" href="../public/css/fullcalendar.min.css">
<link rel="stylesheet" href="../public/css/fullcalendar.print.min.css" media="print">
<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-xl-6 col-9">
                <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Quédate</span><br>
                        <span class="fs-14 f-montserrat-regular">Conectar con los estudiantes y superar los obstáculos</span>
                </h2>
            </div>
            <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
            </div>
            <div class="col-12 migas mb-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Quédate</li>
                    </ol>
            </div>
            </div>
        </div>
    </div>
    <section class="container-fluid px-4">
        <div class="row">
            <div class="col-12 panel-body " id="listadoregistros">
                <div class="busqueda row">
                    <div class="col-12">
                        <form name="buscar_estudiante" id="buscar_estudiante" action="#"  class="row col-12 py-3">

                            <div class="col-4 pr-4">
                                <div class="row">
                                    <div class="col-12 ">
                                        Buscar estudiante por:
                                    </div>
                                    <div class="col-9 m-0 p-0">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating" id="t-B">
                                                <input type="text" placeholder="" value="" required class="form-control border-start-0" name="input_estudiante" id="input_estudiante" maxlength="20">
                                                <label>Número Identificación</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>

                                    <div class="col-3 m-0 p-0">
                                        <button type="submit" class="btn btn-success btn-buscar btn-fla py-3" id="btn-buscar-estudiante"><i class="fas fa-search "></i> Buscar</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-8" id="datos_estudiante">
                                <div class="row">
                                    <div class="col-4 py-2 " id="t-NC">
                                        <div class="row align-items-center">
                                            <div class="col-2">
                                                <span class="rounded  text-gray ">
                                                    <img src="../files/null.jpg" width="35px" height="35px" class="img-circle img_estudiante" img-bordered-sm="">
                                                </span> 
                                            
                                            </div>
                                            <div class="col-10 line-height-16" >
                                                <span class="fs-12 nombre_estudiante">-----</span> <br>
                                                <span class="text-semibold fs-12 titulo-2 line-height-16 apellido_estudiante"> ------ </span> 
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-4 py-2" id="t-C">
                                        <div class="row align-items-center">
                                            <div class="col-2">
                                                <span class="rounded bg-light-red p-2 text-red">
                                                    <i class="fa-regular fa-envelope" aria-hidden="true"></i>
                                                </span> 
                                            
                                            </div>
                                            <div class="col-10">
                                                <span class="fs-12">Correo electrónico</span> <br>
                                                <span class="text-semibold fs-12 titulo-2 line-height-16 correo">-----</span> 
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-4 py-2" id="t-NT">
                                        <div class="row align-items-center">
                                            <div class="col-2">
                                                <span class="rounded bg-light-green p-2 text-success">
                                                    <i class="fa-solid fa-mobile-screen" aria-hidden="true"></i>
                                                </span> 
                                            
                                            </div>
                                            <div class="col-10">
                                                <span class="fs-12">Número celular</span> <br>
                                                <span class="text-semibold fs-12 titulo-2 line-height-16 celular">-----</span>  
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-4 py-2" id="t-CD">
                                        <div class="row align-items-center">
                                            <div class="col-2">
                                                <span class="rounded bg-light-green p-2 text-success">
                                                    <i class="fa-regular fa-id-card"></i>
                                                </span> 
                                            
                                            </div>
                                            <div class="col-10">
                                                <span class="fs-12 tipo_identificacion">----</span> <br>
                                                <span class="text-semibold fs-12 titulo-2 line-height-16 numero_documento">-----</span>  
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-4 py-2" id="t-D">
                                        <div class="row align-items-center">
                                            <div class="col-2">
                                                <span class="rounded bg-light-green p-2 text-success">
                                                    <i class="fa-solid fa-location-dot"></i>
                                                </span> 
                                            
                                            </div>
                                            <div class="col-10">
                                                <span class="fs-12">Dirección</span> <br>
                                                <span class="text-semibold fs-12 titulo-2 line-height-16 direccion">-----</span>  
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12" id="matriculaccordion">
                                <div class="row">
                                    <div class="col-12 titulo-2 fs-14">
                                        Programas y cursos matriculados
                                    </div>
                                    <div class="col-12 lista_programas">
                                       
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

                <div class="col-12">
                    <div class="row" id="t-caso">

                        <div class="col-12 tono-3 p-4">
                            <div class="row">
                                <div class="col-8">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="rounded bg-light-blue p-2 text-primary">
                                                <i class="fa-solid fa-handshake-angle"></i>
                                            </span> 
                                        
                                        </div>
                                        <div class="col-10">
                                            <span class="fs-12">Casos</span> <br>
                                            <span class="text-semibold fs-12 titulo-2 line-height-16">Quédate</span> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 text-right">
                                
                                    <button  data-toggle="modal" data-target="#modal-nuevo-caso" class="btn btn-success" id="btnabrircaso" > <i  class="fas fa-plus" style="padding-right: 5px;" id="t-Acaso" ></i>Abrir Caso</button >
                                
                                </div>
                            </div>
                        </div>
                        <div class="col-12 card">
                            <div class="tabla_busquedas col-12 p-4">
                                <table id="tabla_casos" class="table table-hover table-nowarp">
                                    <thead>
                                        <tr>
                                            <th id="t-E">Estado</th>
                                            <th id="t-CA">Categoria</th>
                                            <th id="t-AS">Asunto</th>
                                            <th id="t-FE">Fecha <small>(AA-MM-DD)</th>
                                            <th id="t-FC">Fecha Cerrado<small>(AA-MM-DD)</th>
                                            <th id="t-DO">Dep. Origen </th>
                                            <th id="t-V">Ver</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th colspan="11">
                                                <div class=" text-center" style="margin:0px !important"><h3>Aquí aparecerán los casos del estudiante.</h3> </div>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
		</div>
	</section>

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
    <!--Modal Abrir Caso-->
    <div class="modal" tabindex="-1" role="dialog" id="modal-nuevo-caso" aria-labelledby="nuevoCaso">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content ">
                <form action="#" method="POST" id="formabrircaso">
                    <div class="modal-header">
                        <h6 class="modal-title" id="gridSystemModalLabel">Abrir nuevo caso</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body" >
                        <div class="form-group">
                            <input type="hidden" name="id-estudiante" id="id-estudiante-nuevo-caso" required="">
                        </div>

                        <div class="col-12 pb-4">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="rounded bg-light-green p-2 text-success">
                                        <i class="fa-regular fa-user"></i>
                                    </span> 
                                
                                </div>
                                <div class="col-10">
                                    <span class="fs-12">Estudiante</span> <br>
                                    <span class="text-semibold fs-12 titulo-2 line-height-16" id="cedula-estudiante"></span> 
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="form-floating">
                                    <input type="text" placeholder="" value="" required class="form-control border-start-0" name="asunto-nuevo-caso" id="asunto-nuevo-caso" maxlength="30" >
                                    <label>Asunto corto y concreto</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please enter valid input</div>
                        </div>


                        <div class="col-12">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="form-floating">
                                    <input type="date" placeholder="" value="" required class="form-control border-start-0" name="fecha_caso" id="fecha_caso"  required>
                                    <label>Fecha de Caso</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please enter valid input</div>
                        </div>

                        <div class="col-12">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="form-floating">
                                    <select value="" required class="form-control border-start-0"  name="categoria-caso" id="categoria-caso"></select>
                                    <label>Seleccione una categoría</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please enter valid input</div>
                        </div>
                    


                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Abrir caso</button>
                    </div>
                </form> 
            </div>
        </div>
    </div>    
<!--    cerrar modal abrir caso -->
<?php
	}else{
	  require 'noacceso.php';
	}
require 'footer.php';
}
  ob_end_flush();
?>
<!-- fullCalendar -->
<script src="../bower_components/moment/moment.js"></script>
<script src="../bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<script src="../bower_components/fullcalendar/dist/locale/es.js"></script>
<!-- Script para cargar los eventos js del calendario -->
<script src="scripts/quedateabrircaso.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<!-- Page specific script -->
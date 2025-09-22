<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
   header("Location: ../");
} else {
   $menu = 7;
   $submenu = 704;
   require 'header.php';
   if ($_SESSION['cargadocente'] == 1) {
?>
<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
   <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-xl-6 col-9">
                <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Carga docente</span><br>
                        <span class="fs-14 f-montserrat-regular">Visualice las horas académicas del docente en el centro de datos.</span>
                </h2>
                </div>
                <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                </div>
                <div class="col-12 migas mb-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Carga docente</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

   <section class="container-fluid px-4">
        <div class="row">

            <div class="col-8 pt-4 pl-4 tono-3 ">
                <div class="row align-items-center pt-2">
                    <div class="pl-3">
                        <span class="rounded bg-light-green p-3 text-success ">
                            <i class="fa-solid fa-headset" aria-hidden="true"></i>
                        </span> 
                    </div>
                    <div class="col-10">
                    <div class="col-8 fs-14 line-height-18"> 
                        <span class="">Resultados</span> <br>
                        <span class="text-semibold fs-16" id="dato_periodo">Campaña</span> 
                    </div> 
                    </div>
                </div>
            </div>
            <div class="col-4 pt-4 pl-4 tono-3 ">
                <div class="row">
                    <form name="formulario" id="formulario" method="POST" class="col-12">

                        <div class="col-12" id="t-programa">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="form-floating">
                                <select value="" required name="periodo" id="periodo" class="form-control border-start-0 selectpicker" data-live-search="true"  onChange="buscarDatos()"></select>
                                <label>Periodo</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please enter valid input</div>
                        </div>

                    </form>
                </div>
            </div>
            

            <div class="card col-12 p-4" id="listadoregistros">
                <table id="tbllistado" class="table table-hover" style="width:100%">
                    <thead>
                        <th id="t-foto">Foto</th>
                        <th id="t-cedula">Cedula</th>
                        <th id="t-nombre">Nombre</th>
                        <th id="t-contacto">Contacto</th>
                        <th id="t-correo">Correo</th>
                        <th id="t-contrato">Contrato</th>
                        <th id="t-grupos">Grupos</th>
                        <th id="t-horas">Horas Clase</th>
                        <th id="t-horasc">Horas a convenir</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>


        </div>

    </section>
</div>




    <div class="modal" id="myModalHorario">
        <div class="modal-dialog modal-xl" style="width:100%">
            <div class="modal-content">
                <div class="modal-header">
                    
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 p-4 tono-3">
                            <div class="row align-items-center">
                                    <div class="pl-3">
                                        <span class="rounded bg-light-green p-3 text-success ">
                                            <i class="fa-solid fa-headset" aria-hidden="true"></i>
                                        </span> 
                                    </div>
                                    <div class="col-10">
                                    <div class="col-8 fs-14 line-height-18"> 
                                        <span class="">Resultados</span> <br>
                                        <span class="text-semibold fs-16" id="dato_periodo">Carga 2024-1</span> 
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="card col-12" id="calendar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="myModalEvento">
         <div class="modal-dialog modal-sm">
            <div class="modal-content">
               <!-- Modal Header -->
               <div class="modal-header">
                  <h4 class="modalTitulo">Información</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <!-- Modal body -->
               <div class="modal-body">
                  <p id="modalDia"></p>
                  <p id="modalTitle"></p>
               </div>
               <!-- Modal footer -->
               <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
               </div>
            </div>
         </div>
      </div>
                

    <div class="modal" id="myModalaConvenir">
        <div class="modal-dialog modal-xl" style="width:100%">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Horario a convenir</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body table-responsive">
                    <table id="escuela" class="table-bordered" cellpadding="0px" cellspacing="0px"></table>
                    <table class="table table-bordered table-responsive-md">
                        <tbody> 
                            <tr>
                                <td> <label for="nombre">Nombre</label></td>
                                <td><input type="text" name="escuela" id="escuela" value="" class="form-control" required="" placeholder="Nombre"></td>
                            </tr>
                            <tr>
                                <td> <label for="nombre">Observaciones</label></td>
                                <td><input type="text" name="observacion" id="observacion" value="" class="form-control" required="" placeholder="Observaciones"></td> 
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">

                    <button type="submit" class="btn btn-primary" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                    <!-- <button type="submit" class="btn btn-primary" id="escuela"><i class="fa fa-save"></i> Guardar</button> -->
                    
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerar</button>
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

<script type="text/javascript" src="scripts/cargadocente.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
	ob_end_flush();
?>

  
<link href='../fullcalendar/css/main.css' rel='stylesheet' />
<script src='../fullcalendar/js/main.js'></script>
<script src='../fullcalendar/locales/es.js'></script>
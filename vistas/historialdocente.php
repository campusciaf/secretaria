<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])){
    header("Location: ../");
}else{
	$menu = 6;
	$submenu = 603;
    require 'header.php';
	if ($_SESSION['docentehistorial']==1){
?>
<div id="precarga" class="precarga"></div>

<div class="content-wrapper ">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
              <div class="col-xl-6 col-9">
                <h2 class="m-0 line-height-16">
                      <span class="titulo-2 fs-18 text-semibold">Historial docente</span><br>
                      <span class="fs-14 f-montserrat-regular">Universitarios CIAF en la era digital</span>
                </h2>
              </div>
              <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
              </div>
              <div class="col-12 migas">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                      <li class="breadcrumb-item active">Historial docente</li>
                    </ol>
              </div>
          </div>
        </div>
    </div>
	<section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary" style="padding: 2% 1%">	
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding:10px;" >      
                        <table class="table table-hover table-nowarp" id="tbl_docente" >
                            <thead>
                                <tr>
                                    <th scope="col">Identificación</th>
                                    <th scope="col"></th>
                                    <th scope="col">Apellidos</th>
                                    <th scope="col">Nombres</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Correo</th>
                                    <th scope="col">Total Asignaturas</th>
                                    <th scope="col">Historico Contrato</th>
                                    <th scope="col">Ingresos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="modal" id="modal_historial" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Total Asignaturas</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <br>
                                <div id="mostar_video_modal"></div>

                                <div class="modal-body">
                                    <table class="table table-hover table-nowarp" id="tbl_historial">
                                        <thead>
                                            <tr>
                                                <th scope="col">Programa</th>
                                                <th scope="col">Materia</th>
                                                <th scope="col">En lista</th>
                                                <th scope="col">Aprobados</th>
                                                <th scope="col">No aprobados</th>
                                                <th scope="col">Periodo</th>
                                                <th scope="col">Promedio grupo</th>
                                                <th scope="col">Jornada</th>
                                                <th scope="col">Horario</th>
                                                <th scope="col">Horas</th>
                                            </tr>
                                        </thead>
                                    </table>
                                   
                                </div>

                               
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.box -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->


<!-- Modal para mostrar la grafica de ingresos de los docentes por dia -->
<div class="modal" id="myModaltraerpagos">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Ingresos Docentes</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="modal_ingresos_docentes"></div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>

        </div>
    </div>
</div>


<!-- Modal para mostrar la grafica de ingresos de los docentes por dia -->
<div class="modal" id="myModalhistoricodocentescontrato">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Historico Docentes Contrato</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="historicodocentescontrato"></div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>

        </div>
    </div>
</div>

<?php
    }else{
        require 'noacceso.php';
	}	
    require 'footer.php';
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/historialdocente.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
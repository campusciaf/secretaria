<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])){
    header("Location: ../");
}else{
    $menu = 27;
    $submenu = 2701;
    require 'header.php';
    if($_SESSION['guiaabrircaso'] == 1){
?>
<!-- fullCalendar -->
<link rel="stylesheet" href="../public/css/fullcalendar.min.css">
<link rel="stylesheet" href="../public/css/fullcalendar.print.min.css" media="print">
<div id="precarga" class="precarga" style="display: none;"></div>
<div class="content-wrapper">        
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><small id="nombre_programa"></small>Abrir Caso</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Abrir Caso</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary" style="padding: 2% 1%">
					<div class="panel-body " id="listadoregistros">
						<div class="busqueda row">
                            <div class="col-sm-12 col-md-12">
                                <form action="#" id="buscar_docente">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" id="input_docente" class="form-control pull-right" placeholder="Buscar..." style="padding: 6px 12px;" value="" required>
                                            <span class="input-group-append">
                                                <button type="submit" class="btn btn-success btn-buscar btn-flat" id="btn-buscar-docente" style="font-size: 20px !important"><i class="fas fa-search "></i> </button>
                                            </span>
                                        </div>
                                        <small class="help-block">Buscar por identificación docente</small>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header border-1">
                                <h3 class="card-title">Datos Docente</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body box-profile-mat" aria-expanded="true" id="datos_docente">
                                <div class="row box-profile">
                                    <div class="col-md-4 text-center">
                                        <img class="profile-user-img img-responsive img-circle img_docente" style="height: 100px;" src="../files/null.jpg" alt="User profile picture">
                                        <h3 class="nombre_docente box-profiledates text-center">Nombre del Docente</h3>
                                        <p class="text-muted apellido_docente box-profiledates text-center"> ---------------- </p>
                                        <div class="text-center hide" >
                                            <button data-toggle="modal" data-target="#modal-nuevo-caso" class="btn btn-success" id="btnabrircaso"><i class="fas fa-plus" style="padding-right: 5px;"></i>Abrir Caso</button>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <br>
                                        <ul class="list-group list-group-unbordered" style="padding-right: 8px;padding-left: 8px; background: white; color: black">
                                            <li class="list-group-item">
                                                <b class="tipo_identificacion"> --------------- </b> <a class="pull-right box-profiledates numero_documento"> ---------------- </a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Dirección:</b> <a class="pull-right box-profiledates direccion"> ---------------- </a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Cel:</b> <a class="pull-right box-profiledates celular"> ---------------- </a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Email:</b><a class="box-profiledates pull-right correo "> -------------- </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4">
                                        <br>
                                        <div class="box-primary acordion-matricula">
                                            <div class="box-header with-border collapsed" href="#" >
                                                <h3 class="box-title col-lg-12 col-md-12 col-sm-12" >
                                                Programas
                                                </h3>
                                            </div>
                                            <div id="matriculaccordion">
                                                <div class="box-body" style="background: white">
                                                    <ul class="list-group list-group-bordered lista_programas">
                                                        <li class="list-group-item">
                                                        <b>Programa:</b> <br> <a class=" box-profiledates profile-programa">----------------</a>
                                                        </li>
                                                        <li class="list-group-item">
                                                        <b>Semestre:</b> <a class="pull-right box-profiledates profile-semestre">----------------</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						<br>
						<div class="tabla_busquedas col-12">
                            <br>
							<table id="tabla_casos" class="table table-hover table-nowarp">
								<thead>
                                    <tr>
                                        <th>Estado</th>
                                        <th>Categoria</th>
                                        <th>Asunto</th>
                                        <th>Fecha <small>(AA-MM-DD)</th>
                                        <th>Fecha Cerrado<small>(AA-MM-DD)</th>
                                        <th>Dep. Origen </th>
                                        <th>Ver</th>
								    </tr>
                                </thead>
								<tbody>
									<tr><th colspan="11">
										<div class="jumbotron text-center" style="margin:0px !important"><h3>Aquí aparecerán los casos del docente.</h3> </div>
									</th>
								</tr></tbody>
								<tfoot>
								    <tr>
                                        <th>Estado</th>
                                        <th>Categoria</th>
                                        <th>Asunto</th>
                                        <th>Fecha <small>(AA-MM-DD)</th>
                                        <th>Fecha Cerrado<small>(AA-MM-DD)</th>
                                        <th>Dep. Origen </th>
                                        <th>Ver</th>
								    </tr>	
                                </tfoot>
							</table>
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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="#" method="POST" id="formabrircaso">
                    <div class="modal-header">
                        <h4 class="modal-title" id="gridSystemModalLabel">Abrir nuevo caso</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body" style="background-color: whitesmoke; border-top: 1px solid lightgrey; border-bottom: 1px solid lightgrey">
                        <div class="form-group">
                            <label>Docente:  #<strong id="cedula-docente"></strong></label>
                            <input type="hidden" name="id-docente" id="id-docente-nuevo-caso" required="">
                        </div>
                        <div class="form-group">
                            <label for="asunto-nuevo-caso">Asunto</label>
                            <input type="text" class="form-control" name="asunto-nuevo-caso" id="asunto-nuevo-caso" placeholder="Asunto" required="">
                            <span class="help-block">Asunto corto y concreto</span>
                        </div>
                        <div class="form-group">
                            <label for="asunto-nuevo-caso">Fecha</label>
                            <input class="form-control" type="date" name="fecha_caso" required>
                        </div>
                        <div class="form-group">
                            <label for="asunto-nuevo-caso">Categoria</label>
                            <select  class="form-control" name="categoria-caso" id="categoria-caso" required=""></select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Abrir</button>
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
<script src="scripts/guia_abrircaso.js"></script>
<!-- Page specific script -->
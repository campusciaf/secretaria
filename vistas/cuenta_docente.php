<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])){
    header("Location:  ../");
}else{
	$menu = 6;
	$submenu = 602;
    require 'header.php';
	if($_SESSION['cuentadocente']==1){
?>



<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 mx-0">
                <div class="col-xl-6 col-9">
                    <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Cuenta docente</span><br>
                        
                    </h2>
                </div>



                <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                    <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i
                            class="fa-solid fa-play"></i> Tour</button>
                </div>
                <div class="col-12 migas mb-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Cuenta Docente</li>
                    </ol>
                </div>
            </div>
    <!-- Contenedor donde se muestra la tabla que lista los docentes -->
	<section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary" style="padding: 2% 1%">

                    <h4>
                        <button id="boton_regresar" type="button" class="btn btn-primary float-right mr-4" ><i class="fas fa-angle-double-left"> Volver </i></button>
                    </h4>

                    <div class="col-12 table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-sm compact table-nowarp">
                            <thead>
                                <th>Foto</th>
                                <th>Documento</th>
                                <th>Apellidos</th>
                                <th>Nombres</th>
                                <th>Contacto</th>
                                <th>Correo</th>
                                <th>Tipo de Contrato</th>
                                <th>Opciones</th>
                                
                            </thead>
                            <tbody>                            
                            </tbody>
                        </table>
                    </div>

                    <div class="panel-body" id="informacion_grupos">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box"> 
                                    <!-- BOTÓN PARA SELECCIONAR EL GRUPO -->
                                    <div class="alert" id="listado_grupos" hidden="true">
                                        <form method="post" id="listado_grupos_docente" name="listado_grupos_docente">
                                               
                                            <div class="row">
                                                <div class="campo-select col-lg-8">
                                                    <input type="hidden" id="id_docente"/>
                                                    <select name="selector_grupo" id="selector_grupo" data-live-search="true" style="text-decoration:none"></select>
                                                    <span class="highlight"></span>
                                                    <span class="bar"></span>
                                                    <label>Grupos</label>
                                                </div>
                                                <div class="col-4">
                                                    <input type="submit" value="Cargar Estudiantes" class="btn btn-success btn-flat" id="boton_cargar" />
                                                   
                                                </div>

                                            </div>
                                            
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box">
                           
                            <div class="box-body">
                                <div class="col-md-12">
                                    <div id="tblgrupos">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row col-xl-12" id="calendario">
                        <div class="card" id="calendar" style="width: 100%;"></div>
                    </div>



                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
    <div class="modal fade in" id="modal-pea" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLongTitle">Plan Educativo de Aula</h3>
                </div>
                <div class="modal-body" id="body-modal-pea" hidden="true">
                    <div id="contenedor_tabla">
                        <table id="tblpea" class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                                <th>Opciones</th>
                                <th>Tema</th>
                                <th>Conceptuales</th>
                                <th>Procedimentales</th>
                                <th>Actitudinales</th>
                                <th>Criterios</th>
                            </thead>
                            <tbody>                            
                            </tbody>
                            <tfoot>
                                <th>Opciones</th>
                                <th>Tema</th>
                                <th>Conceptuales</th>
                                <th>Procedimentales</th>
                                <th>Actitudinales</th>
                                <th>Criterios</th>
                            </tfoot>
                        </table>
                    </div>
                    <div id="mostrarActividades">	
						<div class="box-header with-border">
                            <h1 class="box-title">  
                                <div>
                                    <button class="btn btn-info" onclick="volver()" type="button">
                                        <i class="fa fa-arrow-circle-left"></i> Volver
                                    </button>
                                </div>
                            </h1>
                            <div id="listadosactividades"></div>	
                        </div>
				    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Horario -->
    <div class="modal fade in" id="modal-horario" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLongTitle">Horario Docente</h3>
                </div>
                <div class="modal-body" id="body-modal-horario">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box">
                                <div class="btn-group">  
                                    <a id="boton_semana" class="btn btn-info">Ver Semana</a>
                                    <a id="boton_fds" class="btn btn-info">Ver fin de Semana</a>
                                    <a id="boton_sabado" class="btn btn-info">Ver Sólo Sábados</a>
                                </div>
                                <div class="panel-body table-responsive" id="listadohorarios">
                                    <div id="tblhorarios"></div>
                                </div>
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div><!-- /.content-wrapper -->
<?php
	}else{
        require 'noacceso.php';
	}
    require 'footer.php';
}
	ob_end_flush();
?>

<link href='../fullcalendar/css/main.css' rel='stylesheet' />
<script src='../fullcalendar/js/main.js'></script>
<script src='../fullcalendar/locales/es.js'></script>

<script type="text/javascript" src="scripts/cuenta_docente.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>

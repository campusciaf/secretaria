<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])){
    header("Location:  ../");
}else{
	$menu = 8;
	$submenu = 807;
    require 'header.php';
	if($_SESSION['controlnotas']==1){
?>
<div id="precarga" class="precarga" style="display: none;"></div>
<div class="content-wrapper">        
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><small id="nombre_programa"></small>Cuenta Docente</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Cuenta Docente</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Contenedor donde se muestra la tabla que lista los docentes -->
	<section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary" style="padding: 2% 1%">
                    <h4>
                        Listado de Docentes Activos 
                        <button id="boton_regresar" type="button" class="btn btn-primary pull-right" ><i class="fas fa-angle-double-left"> Volver </i></button>
                    </h4>
                    <div class="panel-body" id="listadoregistros">
                        <table id="tbllistado" class="table table-hover table-nowarp">
                            <thead>
                                <th>Nombre Completo</th>
                                <th>Documento</th>
                                <th>Jornada</th>
                                <th>Asignatura</th>
                                <th>Programa</th>
                                <th>Entregada</th>
                                <th>Semestre </th>
                            </thead>
                            <tbody>                            
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-body" id="información_grupos" hidden="true">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box"> 
                                    <!-- BOTÓN PARA SELECCIONAR EL GRUPO -->
                                    <div class="alert" id="listado_grupos" hidden="true">
                                        <form method="post" id="listado_grupos_docente" name="listado_grupos_docente">
                                            <div class="form-group col-12">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-book"></i></span>
                                                    </div>
                                                    <input type="hidden" id="id_docente"/>
                                                    <select name="selector_grupo" id="selector_grupo" class="form-control">
                                                    </select>
                                                    <input type="submit" value="Cargar Estudiantes" class="btn btn-success btn-flat" id="boton_cargar" />
                                                    <button class="btn btn-info btn-flat" id="boton_horario" data-toggle="modal" data-target="#modal-horario">Cargar Horario</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box">
                            <div class="row">
                                <div class="col-md-12" id="boton_pea" hidden="true">
                                    <div class="float-right">
                                        <a id="boton_ver_pea" class="btn btn-app bg-secondary" data-toggle="modal" data-target="#modal-pea">
                                            <i class="fas fa-tasks"></i> Ver PEA
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="col-md-12">
                                    <div id="tblgrupos">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
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
<script type="text/javascript" src="scripts/controlnotas.js"></script>
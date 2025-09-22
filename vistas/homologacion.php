<?php
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])){
    header("Location: login.php");
}else{
	$menu = 5;
	$submenu = 505;
    require 'header.php';
	if($_SESSION['homologacion']==1){
?>
<div id="precarga" class="precarga" style="display: none;">
</div>
<div class="content-wrapper">        
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><small id="nombre_programa"></small>Homologación</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Homologación</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content" style="padding-top: 0px;">
		<!--Fondo de la vista -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary" style="padding: 2% 1%">
                    <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12" id="seleccionprograma">
                        <form name="formularioverificar" id="formularioverificar" method="POST">
                            <div class="input-group input-group-md">
                                <input type="number" class="form-control" name="credencial_identificacion" id="credencial_identificacion" maxlength="11" required placeholder="Número de Identificación">
                                <span class="input-group-btn">
                                    <button type="submit" id="btnVerificar" class="btn btn-info btn-flat">Verificar</button>
                                </span>
				            </div>				
				        </form>
				    </div>
                    <div id="mostrardatos" class="col-lg-4 col-md-6 col-sm-12 col-xs-12 row">
                    </div>
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-hover text-nowrap">
                            <thead>
                                <th>Acciones</th>
                                <th>Id estudiante</th>
                                <th>Programa</th>
                                <th>Jornada</th>
                                <th>Semestre</th>
                                <th>Grupo</th>
                                <th>Escuela</th>
                                <th>Estado</th>
                                <th>Nuevo del</th>
                                <th>Periodo Activo</th>
                            </thead>
                            <tbody>                            
                            </tbody>
                            <tfoot>
                                <th>Acciones</th>
                                <th>Id estudiante</th>
                                <th>Programa</th>
                                <th>Jornada</th>
                                <th>Semestre</th>
                                <th>Grupo</th>
                                <th>Escuela</th>
                                <th>Estado</th>
                                <th>Nuevo del</th>
                                <th>Periodo Activo</th>
                            </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                        <h1>Generar Credenciales de Acceso</h1>
                        <form name="formulario" id="formulario" method="POST">
                        </form>
					</div>
                    <div class="row">
                        <div id="listadomaterias" class="row" style="width: 100%"></div>
				    </div>
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<div class="modal fade" id="myModalMatriculaNovedad" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cambio</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form name="formularionovedadjornada" id="formularionovedadjornada" method="POST">
                    <input type='hidden' value="" id='id_materia' name='id_materia'>
                    <input type='hidden' value="" id='ciclo' name='ciclo'>
                    <input type='hidden' value="" id='id_programa_ac' name='id_programa_ac'>
                    <input type='hidden' value="" id='id_estudiante' name='id_estudiante'>
                    <div class="form-group col-12">		
                        <label>Cambio de Jornada a:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                            </div>
                            <select id="jornada_e" name="jornada_e"  class="form-control selectpicker" data-live-search="true" data-style="border" required></select>
                        </div>
                    </div>
                    <button type="submit" id="btnNovedad" class="btn btn-info btn-block">Cambiar Jornada</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModalMatriculaNovedadPeriodo" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cambio</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form name="formularionovedadperiodo" id="formularionovedadperiodo" method="POST">
                    <input type='hidden' value="" id='id_materia_j' name='id_materia_j'>
                    <input type='hidden' value="" id='ciclo_j' name='ciclo_j'>
                    <input type='hidden' value="" id='id_programa_ac_j' name='id_programa_ac_j'>
                    <input type='hidden' value="" id='id_estudiante_j' name='id_estudiante_j'>
                    <div class="form-group col-12">		
                        <label>Cambio de periodo a:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                            </div>
                            <select id="periodo" name="periodo"  class="form-control selectpicker" data-live-search="true" data-style="border" required></select>
                        </div>
                    </div>
                    <button type="submit" id="btnNovedadPeriodo" class="btn btn-info btn-block">Cambiar Periodo</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>  
    </div>
</div>
<!-- Modal matricular_asignatura especial-->
<div class="modal fade" id="myModalMatriculaNovedadGrupo" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cambio</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form name="formulariogrupo" id="formulariogrupo" method="POST">
                    <input type='hidden' value="" id='id_materia_h' name='id_materia_h'>
                    <input type='hidden' value="" id='ciclo_h' name='ciclo_h'>
                    <input type='hidden' value="" id='id_programa_ac_h' name='id_programa_ac_h'>
                    <input type='hidden' value="" id='id_estudiante_h' name='id_estudiante_h'>
                    <div class="form-group col-12">		
                        <label>Cambio de grupo a:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                            </div>
                            <select id="grupo" name="grupo"  class="form-control selectpicker" data-live-search="true" data-style="border" required></select>
                        </div>
                    </div>
                    <button type="submit" id="btnNovedadGrupo" class="btn btn-info btn-block">Cambiar Grupo</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal matricular_asignatura especial-->
<div class="modal fade" id="myModalHomologacion" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Homologar Materia</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form name="formulariohomologacion" id="formulariohomologacion" method="POST">
                    <input type='hidden' value="" id='id_materia_homolohacion' name='id_materia_homolohacion'>
                    <!-- <input type='hiddenf' value="" id='id_programa_ac_homologacion' name='id_programa_ac_homologacion'> -->
                    <input type='hidden' value="" id='ciclo_materia_homolohacion' name='ciclo_materia_homolohacion'>
                    <input type='hidden' value="" id='id_programa_ho_' name='id_programa_ho_'>
                    <div class="form-group col-12">		
                        <div class="input-group">
                            <div id="homologacion_select"> </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- <div class="modal" id="myModalDocente" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Materias Disponibles</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      <form name="formulariohomologacion" id="formulariohomologacion" method="POST">
                    <input type='hidden' value="" id='periodo_actual' name='periodo_actual'>
                    <input type='hidden' value="" id='nombre_materia' name='nombre_materia'>
                    <div class="form-group col-12">		
                        <div class="input-group">
                            <div id="selecionar_docente"> </div>
                        </div>
                    </div>
                </form>


      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-primary">Save changes</button> -->
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>  -->


<!-- Modal matricular_asignatura especial-->
<div class="modal fade" id="myModalDocente" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Docentes Disponibles</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form name="formulariohomologacion" id="formulariohomologacion" method="POST">
                    <input type='hidden' value="" id='periodo_actual' name='periodo_actual'>
                    <input type='hidden' value="" id='nombre_materia' name='nombre_materia'>
                    <div class="form-group col-12">		
                        <div class="input-group">
                            <div id="selecionar_docente"> </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
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
<script type="text/javascript" src="scripts/homologacion.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
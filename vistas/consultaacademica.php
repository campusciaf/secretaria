<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])){
    header("Location: ../");
}else{
    $menu = 10;
    $submenu = 1009;
    require 'header.php';
	if ($_SESSION['consultaacademica']==1){
?>
<div id="precarga" class="precarga" style="display: none;"></div>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Consulta Académica</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Consulta Académica</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
	<section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary" style="padding: 2% 1%">	      								
					<div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" id="seleccionprograma">
                            <form name="formularioverificar" id="formularioverificar" method="POST">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="credencial_identificacion" id="credencial_identificacion" maxlength="11" required placeholder="Número de Identificación">
                                    <span class="input-group-append">
                                        <button type="submit" id="btnVerificar" class="btn btn-info btn-flat">Verificar</button>
                                    </span>
                                 </div>
                            </form>
                        </div>
                        <div id="mostrardatos" class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        </div>
                    </div>
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-hover table-nowarp">
                            <thead>
                                <th>Acciones</th>
                                <th>Id estudiante</th>
                                <th>Programa</th>
                                <th>Jornada</th>
                                <th>Semestre</th>
                                <th>Grupo</th>
                                <th>Escuela</th>
                                <th>Estado</th>
                                <th>Periodo Activo</th>
                            </thead>
                            <tbody>                            
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                        <h1>Generar Credenciales de Acceso</h1>
                        <form name="formulario" id="formulario" method="POST">
                        </form>
                    </div>
                    <div class="row">  
                        <div id="listadomaterias" class="col-12"></div>
                    </div>
                </div><!-- /.card -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div>
<!--
<div id="myModalAgregarPrograma" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 90%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Matricular Materias</h4>
      </div>
      <div class="modal-body">
		  <div class="row"> 
            <div id="listadomaterias">
            </div>
          </div>       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
-->
<!-- Modal matricular_asignatura especial-->
<div class="modal fade" id="myModalMatriculaNovedad" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Cambio</h4>
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
                            <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                            <select id="jornada_e" name="jornada_e"  class="form-control selectpicker" data-live-search="true" required></select>
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
<!-- Modal matricular_asignatura especial-->
<div class="modal fade" id="myModalMatriculaNovedadPeriodo" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Cambio</h4>
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
                            <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                            <select id="periodo" name="periodo"  class="form-control selectpicker" data-live-search="true" required></select>
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
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Cambio</h4>
            </div>
            <div class="modal-body">
		        <form name="formularionovedadgrupo" id="formularionovedadgrupo" method="POST">
                    <input type='hidden' value="" id='id_materia_g' name='id_materia_g'>
                    <input type='hidden' value="" id='ciclo_g' name='ciclo_g'>
                    <input type='hidden' value="" id='id_programa_ac_g' name='id_programa_ac_g'>
                    <input type='hidden' value="" id='id_estudiante_g' name='id_estudiante_g'>
                    <div class="form-group col-12">		
                        <label>Cambio de grupo a:</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                            <select id="grupo" name="grupo"  class="form-control selectpicker" data-live-search="true" required></select>
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
<?php
	}else{
        require 'noacceso.php';
    }
require 'footer.php';
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/consultaacademica.js"></script>
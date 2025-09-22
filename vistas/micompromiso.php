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
$menu=2;
$submenu=205;
require 'header.php';

	if ($_SESSION['micompromiso']==1)
	{
?>

<div id="precarga" class="precarga"></div>
<!--Contenido-->
<!-- Content Wrapper. Contains page content -->
<!--Contenido-->
<div class="content-wrapper">
   <!-- Main content -->
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1 class="m-0"><small id="nombre_programa"></small>Mis compromisos </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                  <li class="breadcrumb-item active">Gestión compromisos</li>
               </ol>
            </div>
            <!-- /.col -->
         </div>
         <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
   </div>
   <section class="content" style="padding-top: 0px;">
      <div class="row">
         <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card card-primary" style="padding: 2% 1%">
               <div id="progreso" style="overflow: auto; background-color:#F7F7F7"></div>
               <br>
               <span id="tllistado"class="col-12"></span>
               <div class="panel-body" id="formularioregistros">
                  <form name="formulario" id="formulario" method="POST">
                     <div class="row">
                        <input type="hidden" name="id_meta" id="id_meta">	
                        <input type="hidden" name="id_compromiso" id="id_compromiso">
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                           <label>Nombre de la meta</label>	
                           <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                 <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                              </div>
                              <input type="text" class="form-control" name="meta_nombre" id="meta_nombre" maxlength="255" placeholder="Nombre de la meta" onchange="javascript:this.value=this.value.toUpperCase();" required>
                           </div>
                        </div>
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                           <label>Eje estrategico</label>	
                           <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                 <span class="input-group-text"><i class="fas fa-chalkboard-teacher"></i></span>
                              </div>
                              <select id="meta_ejes" name="meta_ejes"  class="form-control selectpicker" data-live-search="true"></select>
                           </div>
                        </div>
                        <!--
                           <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12" id="campo_val_admin">	
                           		<label>Validado por admin</label>
                           		<div class="input-group">
                           			<span class="input-group-addon"><i class="fas fa-check-double"></i></span>
                           	   		<select id="meta_val_admin" name="meta_val_admin"  class="form-control selectpicker" data-live-search="true"></select>
                           		</div>
                                               </div>
                           	
                           <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12" id="campo_val_usuario">	
                           		<label>Validado por usuario</label>
                           		<div class="input-group">
                           			<span class="input-group-addon"><i class="fas fa-user-check"></i></span>
                           	   		<select id="meta_val_usuario" name="meta_val_usuario"  class="form-control selectpicker" data-live-search="true" required></select>
                           		</div>
                                               </div>							
                           -->
                        <div class="form-group col-xl-6 col-lg-6 col-md-6 col-6">
                           <label>Fecha entrega meta:</label>	
                           <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                 <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                              </div>
                              <input type="date" class="form-control" name="meta_fecha" id="meta_fecha" required >
                           </div>
                        </div>
                        <div class="form-group col-xl-6 col-lg-6 col-md-6 col-6">
                           <label>Periodo</label>	
                           <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                 <span class="input-group-text"><i class="fas fa-hourglass-end"></i></span>
                              </div>
                              <select id="meta_periodo" name="meta_periodo"  class="form-control selectpicker" data-live-search="true" required></select>
                           </div>
                        </div>
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                           <label>Valida</label>	
                           <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                 <span class="input-group-text"><i class="fas fa-user-check"></i></span>
                              </div>
                              <select id="meta_valida" name="meta_valida"  class="form-control selectpicker" data-live-search="true" required></select>
                           </div>
                        </div>
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                           <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                           <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
            <!-- /.card -->
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!--Fin-Contenido-->
<!-- Modal -->
<div class="modal fade" id="myModalFuente" role="dialog">
   <div class="modal-dialog modal-sm">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Fuente de verificación</h4>
         </div>
         <div class="modal-body">
            <form name="formulario_fuente" id="formulario_fuente" method="POST">
               <input type="hidden" name="id_meta_fuente" id="id_meta_fuente">	
               <input type="file" class="form-control" name="fuente_archivo" id="fuente_archivo" required><br><br>
               <button class="btn btn-primary" type="submit" id="btnGuardarFuente"><i class="fa fa-save"></i> Guardar</button>
               <button class="btn btn-danger" onclick="cancelarformfuente()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
            </form>
         </div>
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

<script type="text/javascript" src="scripts/micompromiso.js"></script>

<?php
}
	ob_end_flush();
?>

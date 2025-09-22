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
	$menu=11;
$submenu=1100;
require 'header.php';

	if ($_SESSION['tarifasmovilizaciones']==1)
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
               <h1 class="m-0"><small id="nombre_programa"></small>Tarifas <a class="btn btn-success" onClick="abrir_registrar_municipio()"><i class="fa fa-plus"></i> Registrar Municipio</a></h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                  <li class="breadcrumb-item active">Gestión movilización</li>
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
               <div class="row">
                  <div class="col-xl-6">
                     <table id="tbl_municipios" class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                           <tr>
                              <th width="40%" class="">Municipio</th>
                              <th width="30%"># Colegios Registrados</th>
                              <th width="30%">Opciones</th>
                           </tr>
                        </thead>
                        <tbody>
                        </tbody>
                     </table>
                  </div>
                  <div class="col-xl-6 hide" id="div_listarcolegios">
                     <div class="titulo alert alert-success col-lg-12 col-md-12">
                        <a class="close" onClick="cerrar_listado_colegios()" title="Cerrar listado colegios"><i class="fa fa-times"></i></a>
                        <div class="col-lg-8 col-md-8">
                           <h4 id="titulo_listado_colegios">Colegios</h4>
                        </div>
                     </div>
                     <table id="tbl_colegios" class="table table-striped table-bordered table-condensed table-hover"
                        style="width: 100%; font-size: 14px;">
                        <thead>
                           <tr>
                              <th width="40%" class="">Colegio</th>
                              <th width="30%">tarifa</th>
                              <th width="30%">Opciones</th>
                           </tr>
                        </thead>
                        <tbody>
                        </tbody>
                     </table>
                  </div>
               </div>
               <!-- The Modal -->
               <div class="modal" id="modal-editar">
                  <div class="modal-dialog  modal-sm">
                     <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                           <h4 class="modal-title">Actualizar nombre municipio</h4>
                           <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                           <div class="form-group">
                              <label for="exampleInputEmail1">Nombre:</label>
                              <input type="hidden" id="id_municipio">
                              <input type="text" class="form-control" id="nombre_municipio" aria-describedby="emailHelp"
                                 placeholder="Nombre:">
                           </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                           <button type="button" onclick="editar()" class="btn btn-success">Editar</button>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- The Modal -->
               <div class="modal" id="modal-registrar">
                  <div class="modal-dialog  modal-sm">
                     <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                           <h4 class="modal-title">Registrar Colegio</h4>
                           <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                           <input type="hidden" id="id_colegio" name="id_colegio" value="vacio">
                           <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                              <label>Nombre colegio:</label>		
                              <div class="input-group mb-3">
                                 <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-school"></i></span>
                                 </div>
                                 <input type="hidden" id="id_muni">
                                 <input pattern="" placeholder="Digite el nombre" type="text" required class="form-control" id="nombre_colegio">
                              </div>
                           </div>
                           <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                              <label>Tarifa:</label>		
                              <div class="input-group mb-3">
                                 <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-dollar-sign"></i></span>
                                 </div>
                                 <input pattern="" placeholder="Digite la tarifa" type="number" required class="form-control" id="tarifa_colegio">
                              </div>
                           </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                           <button type="button" onclick="aggColegio()" class="btn btn-primary">Registrar</button>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- The Modal -->
               <div class="modal" id="modal-editar-colegio">
                  <div class="modal-dialog  modal-sm">
                     <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                           <h4 class="modal-title">Registrar Colegio</h4>
                           <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                           <input type="hidden" id="id_colegio" name="id_colegio" value="vacio">
                           <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                              <label>Nombre colegio:</label>		
                              <div class="input-group mb-3">
                                 <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-school"></i></span>
                                 </div>
                                 <input type="hidden" id="id_colegio">
                                 <input pattern="" placeholder="Digite el nombre" type="text" required class="form-control"
                                    id="nombre_colegio_edit">
                              </div>
                           </div>
                           <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                              <label>Tarifa:</label>		
                              <div class="input-group mb-3">
                                 <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-dollar-sign"></i></span>
                                 </div>
                                 <input type="hidden" id="id_colegio">
                                 <input pattern="" placeholder="Digite la tarifa" type="number" required class="form-control"
                                    id="tarifa_colegio_edit">
                              </div>
                           </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                           <button type="button" onclick="updaColegio()" class="btn btn-success">Editar</button>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- The Modal -->
               <div class="modal" id="modal_registro_municipios">
                  <div class="modal-dialog  modal-sm">
                     <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                           <h4 class="modal-title">Registrar Municipio</h4>
                           <button type="button" class="close" onClick="cerrar_registro_mun()">&times;</button>
                           <center>
                              <p id="titulo_registro_municipios" class="text-info"></p>
                           </center>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                           <input type="hidden" id="id_municipio" name="id_municipio" value="vacio">
                           <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                              <label>Nombre municipio:</label>		
                              <div class="input-group mb-3">
                                 <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-globe"></i></span>
                                 </div>
                                 <input pattern="" placeholder="Digite el nombre" type="text" required class="form-control"
                                    name="nombre_municipio" id="agg_nombre_municipio">
                              </div>
                           </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                           <button type="button" onClick="guardar_municipio()" class="btn btn-success"><i class="fa fa-save"></i>
                           Guardar</button>
                        </div>
                     </div>
                  </div>
               </div>
               <!--Fin centro -->
            </div>
            <!-- /.box -->
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!--Fin-Contenido-->


<?php
	}
	else
	{
	  require 'noacceso.php';
	}
		
require 'footer.php';
?>

<script type="text/javascript" src="scripts/movilizacion.js"></script>
<?php
}
	ob_end_flush();
?>
<script>

</script>

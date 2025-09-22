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
$submenu=1101;
require 'header.php';

	if ($_SESSION['solicitudesdocentes']==1)
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
               <h1 class="m-0"><small id="nombre_programa"></small>Solicitudes Docentes </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                  <li class="breadcrumb-item active">Gestión viaticos</li>
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
		
		
        <div class="panel-body table-responsive col-lg-12 col-md-12 col-sm-12 col-xs-12" id="listado_solicitudes">            
            <div class="col-lg-6 col-md-8 col-sm-10 col-xs-12">
                <div class="alert alert-info" style="width: fit-content; text-align: center;">
                    <p class="text-white"><i class="fa fa-filter"></i> <b>Filtrar Solicitudes</b></p>
                    <div class="btn-group">
                        <button   id="btn_filtrar_todas"  title="Listar todas las solicitudes"  onClick="filtar_todas()" class="btn btn-sm btn-default"><span class="hidden-xs"></span>Pendientes <span id="icono_btn_solicitudes_todas"><i class="fa fa-check"></i></span></button>
                        
                        <button  id="btn_filtrar_aprobadas"  title="Filtrar solicitudes aprobadas"  onClick="filtrar_solicitudes_aprobadas()" class="btn btn-sm btn-success">Aprobadas <span id="icono_btn_solicitudes_aprobadas" style="display: none;"><i class="fa fa-check"></i></span></button>
                        
                        <button  id="btn_filtrar_rechazadas"  title="Filtrar solicitudes rechazadas"  onClick="filtrar_solicitudes_rechazadas()" class="btn btn-sm btn-danger">Rechazadas <span id="icono_btn_solicitudes_rechazadas" style="display: none;"><i class="fa fa-check"></i></span></button>
                    </div>
                </div>
            </div>
            <!--<div style="text-align: center;" class="col-lg-12"><label style="font-size: 15px;"class="label label-default">Solicitudes enviadas a dirección de escuela</label></div>-->
            <table id="tbl_solicitudes" class="table table-striped table-bordered table-condensed table-hover" style="width: 100%; font-size:12px;">
            <thead>
                <tr>
                    <th width="30%" align="center">Docente</th>
                    <th>Fecha solicitud</th>
                    <th>Valor Viaticos</th>
                    <th>Estado</th>
                    <th>Clases Registradas</th>
                </tr>
            </thead>
            <tbody>                            
            </tbody>
            </table>
        </div>


        <!-- Modal donde se cargan las clases registradas en una solicitud -->
        <div id="modal_clases_registradas" class="modal fade " data-backdrop='static' data-keyboard='false' role="dialog">
            <div class="modal-dialog modal-lg ">
            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="alert alert-warning" style="width: fit-content; margin-bottom: 5px;">
                    <h4 class="modal-title"><b>Listado clases registradas</b></h4>
                </div>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="tbl_clases" class="table table-striped table-bordered table-condensed table-hover" style="width: 100%; font-size:12px;">
                    <thead>
                        <tr>
                            <th>Municipio</th>
                            <th>Colegio</th>
                            <th>Tarifa</th>
                            <th>Materia</th>
                            <th>Fecha</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>                           
                    </tbody>
                    </table>
                </div>
                <p>&nbsp;</p>
            </div>
            <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-danger" data-dismiss="modal"> Cerrar</button>
            </div>
            </div>
            </div>
        </div>




	                    <!--Fin centro -->
                  </div><!-- /.box -->
				</div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->


<?php
	}
	else
	{
	  require 'noacceso.php';
	}
		
require 'footer.php';
?>

<script type="text/javascript" src="scripts/solicitudesdocentes.js"></script>
<?php
}
	ob_end_flush();
?>
<script>

</script>

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
$submenu=1102;
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
               <h1 class="m-0"><small id="nombre_programa"></small>Solicitudes aprobadas </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                  <li class="breadcrumb-item active">Gestión solicitudes</li>
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



        <div class="panel-body table-responsive col-lg-12 col-md-12 col-sm-12 col-xs-12" id="listado_solicitudes_aprobadas">	
            <table id="tbl_solicitudes_aprobadas" class="table table-striped table-bordered table-condensed table-hover" style="width: 100%; font-size:12px;">
                <thead>
                    <tr>
						<th></th>
                        <th>Docente</th>
                        <th>Fecha Solicitud</th>
                        <th>Valor Viaticos</th>
                        <th>Total Abonado</th>
                        <th>Saldo Pendiente</th>
                        <th>Clases Registradas</th>
                    </tr>
                </thead>
                <tbody>                            
                </tbody>
            </table>
        </div>
        <style>
            label
            {
                display: flex;
            }
        </style>

        <!-- modal donde se realizan los pagos a las solicitudes -->
        <div id="modal_pagar_viaticos" class="modal fade"  data-backdrop='static' data-keyboard='false' role="dialog">
            <div class="modal-dialog ">
            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="alert alert-warning" style="width: fit-content; margin-bottom: 5px;">
                    <h4 class="modal-title" id="titulo_registro_pagos"></h4>
                </div>
            </div>
            <div class="modal-body">
                
                    <div class="form-group col-lg-12 col-md-12 col-sm-12"> 
                        <label for="valor">Valor</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-dollar-sign"></i></span>
                            <input type="hidden" id="id_pago" class="limpiar">
                            <input type="hidden" id="id_soli" class="limpiar">
                            <input  type="text" placeholder="Digite el valor del pago" required name="valor" id="valor" class="form-control limpiar" >
                            </input>
                        </div>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12"> 
                        <label for="observacion">observación</label>
                        <textarea class="form-control limpiar" placeholder="Digite la observación" name="observacion" id="observacion" cols="30" rows="10"></textarea>
                    </div>
                    <p>&nbsp;</p>
            </div>
            <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success" onclick="updatePago()" ><i class="fa fa-save"></i> Guardar</button>
            </div>
                
            </div>
            </div>
        </div>
        <!-- final modal donde se realizan los pagos a las solicitudes -->

        <!-- modal donde se realizan los pagos a las solicitudes -->
        <div id="modal_regis_viaticos" class="modal fade"  data-backdrop='static' data-keyboard='false' role="dialog">
            <div class="modal-dialog ">
            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="alert alert-warning" style="width: fit-content; margin-bottom: 5px;">
                    <h4 class="modal-title" id="titulo_registro_pagos2"></h4>
                </div>
            </div>
            <div class="modal-body">
                
                    <div class="form-group col-lg-12 col-md-12 col-sm-12"> 
                        <label for="valor">Valor</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-dollar-sign"></i></span>
                            <input type="hidden" id="id_pago_re" class="limpiar">
                            
                            <input  type="text" placeholder="Digite el valor del pago" required name="valor" id="valor_re" class="form-control limpiar" >
                            </input>
                        </div>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12"> 
                        <label for="observacion">observación</label>
                        <textarea class="form-control limpiar" placeholder="Digite la observación" name="observacion" id="observacion_re" cols="30" rows="10"></textarea>
                    </div>
                    <p>&nbsp;</p>
            </div>
            <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success" onclick="aggPago()" ><i class="fa fa-save"></i> Guardar</button>
            </div>
                
            </div>
            </div>
        </div>
        <!-- final modal donde se realizan los pagos a las solicitudes -->


        <!-- Modal donde se cargan las clases registradas en una solicitud -->
        <div id="modal_clases_registradas" class="modal fade " data-backdrop='static' data-keyboard='false' role="dialog">
            <div class="modal-dialog modal-lg ">
            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="alert alert-warning" style="width: fit-content; margin-bottom: 5px;">
                    <h4 class="modal-title text-info"><b>Listado clases registradas</b></h4>
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
        <!-- final modal donde se cargan las clases registradas en una solicitud -->

        <!-- Modal donde se listan los pagos realizados a una determinada solicitud -->
        <div id="modal_pagos_realizados" class="modal fade " data-backdrop='static' data-keyboard='false' role="dialog">
            <div class="modal-dialog modal-lg ">
            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="alert alert-warning" style="width: fit-content; margin-bottom: 5px;">
                    <h4 class="modal-title text-info"><b>Listado pagos realizados</b></h4>
                </div>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                        <table id="tbl_pagos" class="table table-striped table-bordered table-condensed table-hover" style="width: 100%; font-size:12px;">
                        <thead>
                            <tr>
                                <th>Valor pago</th>
                                <th>Fecha pago</th>
                                <th width="40%">Observaciones</th>
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
        <!-- final modal donde se listan los pagos de una determinada solicitud -->



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


<?php
	}
	else
	{
	  require 'noacceso.php';
	}
		
require 'footer.php';
?>

<script type="text/javascript" src="scripts/solicitudesaprobadas.js"></script>
<?php
}
	ob_end_flush();
?>
<script>

</script>

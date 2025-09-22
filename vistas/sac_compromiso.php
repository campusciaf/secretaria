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
$submenu=214;
require 'header.php';

    if ($_SESSION['saccrearcompromiso']==1)
    {
        require_once "../modelos/SacCompromiso.php";
        $sac_compromiso = new SacCompromiso();
        date_default_timezone_set("America/Bogota");	
        $fecha=date('Y-m-d');
        $hora=date('H:i:s');
?>
<!-- <div id="precarga" class="precarga"></div> -->
<!--Contenido-->
<!-- Content Wrapper. Contains page content -->
<!--Contenido-->
<div class="content-wrapper">
<!-- Main content -->
<div class="content-header col-xl-8">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0"><small id="nombre_programa"></small>Compromisos </h1>
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
        <div class="contenido">
            <div class="card card-primary" style="padding: 2% 1%">
            <span id="tllistado"></span>	  
            <div class="panel-body" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                    <div class="row">
                        <input type="hidden" name="id_compromiso" id="id_compromiso">	
                        <input type="hidden" name="id_eje" id="id_eje">
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                        <label>Compromiso</label>	
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                            </div>
                            <input type="text" class="form-control" name="nombre_compromiso" id="nombre_compromiso" maxlength="255" placeholder="Nombre del Compromiso" onchange="javascript:this.value=this.value.toUpperCase();" required>
                        </div>
                    </div>
                        <!--
                        <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">	
                                <label>Validado por admin</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-check-double"></i></span>
                                    <select id="compromiso_val_admin" name="compromiso_val_admin"  class="form-control selectpicker" data-live-search="true"></select>
                                </div>
                                            </div>
                            
                        <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">	
                                <label>Val por usuario</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-user-check"></i></span>
                                    <select id="compromiso_val_usuario" name="compromiso_val_usuario"  class="form-control selectpicker" data-live-search="true" required></select>
                                </div>
                                            </div>							
                        -->
                        <div class="form-group col-xl-3 col-lg-6 col-md-6 col-12">
                        <label>Fecha del compromiso:</label>	
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                            </div>
                            <input type="date" class="form-control" name="fecha_compromiso" id="fecha_compromiso" required>
                        </div>
                        </div>
                        <div class="form-group col-xl-3 col-lg-6 col-md-6 col-12">
                        <label>Periodo</label>	
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-hourglass-end"></i></span>
                            </div>
                            <input type="text" id="compromiso_periodo" name="compromiso_periodo"  class="form-control" readonly>
                        </div>
                        </div>
                        <div class="form-group col-xl-6 col-lg-12 col-md-12 col-12">
                            <label>Responsable</label>	
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user-check"></i></span>
                                </div>
                                <select id="resposable_compromiso" name="resposable_compromiso"  class="form-control selectpicker" data-live-search="true" required></select>
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
        <div class="experiencias">
            <iframe src="https://prueba.ciaf.edu.co/plataformatecnologica/vistas/slider.php" scrolling="no" frameborder="0" width="100%" height="100%" ></iframe>
        </div>
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!--Fin-Contenido-->
<!-- The Modal -->
<div class="modal" id="myModalMeta">
<div class="modal-dialog">
    <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Metas</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
            <button type="button" id="btnAgregarMeta" onClick="mostrarformmeta(true)"class="btn btn-primary btn-block"><i class="fas fa-plus"></i> Agregar Metas</button>
            <div id="formularioregistrometa" class="row">
            <form name="formulario_meta" id="formulario_meta" method="POST">
                <div class="row">
                    <input type="hidden" name="id_meta" id="id_meta">	
                    <input type="hidden" name="id_compromiso_meta" id="id_compromiso_meta">
                    <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                        <label>Nombre de la meta</label>	
                        <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                        </div>
                        <input type="text" class="form-control" name="nombre_meta" id="nombre_meta" maxlength="255" placeholder="Nombre de la meta" onchange="javascript:this.value=this.value.toUpperCase();" required>
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
                    <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                        <label>Condiciones Institucionales:</label>
                        <ul style="list-style: none;" id="condiciones_institucionales">
                        </ul>
                    </div>
                    <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                        <label>Condiciones De programa:</label>
                        <ul style="list-style: none;" id="condiciones_programa">
                        </ul>
                    </div>
                    <div class="form-group col-xl-6 col-lg-6 col-md-6 col-6">
                        <label>Val. admin</label>	
                        <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-check-double"></i></span>
                        </div>
                        <select id="meta_val_admin" name="meta_val_admin"  class="form-control selectpicker" data-live-search="true"></select>
                        </div>
                    </div>
                    <div class="form-group col-xl-6 col-lg-6 col-md-6 col-6">
                        <label>Val. usuario</label>	
                        <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user-check"></i></span>
                        </div>
                        <select id="meta_val_usuario" name="meta_val_usuario"  class="form-control selectpicker" data-live-search="true" required></select>
                        </div>
                    </div>
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
                        <label>Corresponsable</label>
                        <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user-check"></i></span>
                        </div>
                        <select id="corresponsabilidad" name="corresponsabilidad"  class="form-control selectpicker" data-live-search="true" required></select>
                        </div>
                    </div>
                    <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                        <button class="btn btn-primary" type="submit" id="btnGuardarMeta"><i class="fa fa-save"></i> Guardar</button>
                        <button class="btn btn-danger" onclick="cancelarformmeta()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                    </div>
                </div>
            </form>
            </div>
            <div class="modal-body" id="resultadometas"></div>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="cancelarformmeta()">Cerrar</button>
        </div>
    </div>
</div>
</div>
<!-- The Modal -->
<div class="modal" id="myModalImprimir">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Rendimiento | <a onclick="printDiv('areaImprimir')" class="btn bg-orange btn-flat margin" id="imprime" data-dismiss="modal"><i class="fas fa-print"></i> Imprimir</a> </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body" id="areaImprimir">
            <table width="100%">
            <tr>
                <td>
                    <b>Responsable:</b> <?php echo $_SESSION['usuario_cargo']; ?><br>
                    <b>Fecha de Impresión:</b> <?php echo $compromiso->fechaesp($fecha); ?>
                </td>
                <td align="right">
                    <img src="../public/img/logo_print.jpg" width="180px">
                </td>
            </tr>
            </table>
            <div id="resultado_imprimir"></div>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal" onClick="cerrar()">Cerrar</button>
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

<script type="text/javascript" src="scripts/saccompromiso.js"></script>

<?php
}
    ob_end_flush();
?>

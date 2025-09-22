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
$submenu=204;
require 'header.php';

	if ($_SESSION['crearcompromiso']==1)
	{
?>

<div id="precarga" class="precarga"></div>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Compromiso</span><br>
                        <span class="fs-16 f-montserrat-regular">Gestione los compromisos
                            </span>
                    </h2>
                </div>
                <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                    <button class="btn btn-sm btn-outline-warning px-2 py-0 primer_tour" onclick='iniciarTour()'><i
                            class="fa-solid fa-play"></i> Tour</button>
                </div>
                <div class="col-12 migas">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Crear compromiso</li>
                    </ol>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>

    </div>
    <section class="content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-4">
                <div class="row">
                    <div class="col-12 card">
                        <div class="row">

                            <div class="col-6 p-2 tono-3">
                                <div class="row align-items-center">
                                    <div class="pl-3">
                                        <span class="rounded bg-light-blue p-3 text-primary ">
                                            <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <div class="col-10">
                                        <div class="col-5 fs-14 line-height-18">
                                            <span class="">Crear compromiso</span> <br>
                                            <span class="text-semibold fs-20">Campus virtual</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 tono-3 text-right py-4 pr-4">
                                <button class="btn btn-success btn-sm pull-right" id="btnagregar"
                                    title="Agregar Compromiso"
                                    onclick="mostrarform(true);numerocampo(<?php echo $_SESSION['id_usuario'];?>)"><i
                                        class="fa fa-plus-circle"></i> Agregar Compromiso</button>
                            </div>


                            <div class="col-12 table-responsive p-2" id="listadoregistros">
                                <table id="tbllistado" class="table" style="width: 100%;">
                                    <thead>
                                        <th>Opciones</th>
                                        <th>Nombre del eje</th>
                                        <th>Periodo</th>
                                        <th>Objetivo</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>


                            <div class="col-6 p-2 tono-3">
                                <div class="row align-items-center">
                                    <div class="pl-3">
                                        <span class="rounded bg-light-blue p-3 text-primary ">
                                            <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <div class="col-10">
                                        <div class="col-5 fs-14 line-height-18">
                                            <span class="">Formatos institucionales</span> <br>
                                            <span class="text-semibold fs-20">Campus virtual</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 table-responsive p-2">
                                <table id="tbllistado2" class="table" style="width: 100%;">
                                    <thead>
                                        <th>Opciones</th>
                                        <th>Nombre del eje</th>
                                        <th>Periodo</th>
                                        <th>Objetivo</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<div class="panel-body" id="formularioregistros">
    <form name="formulario" id="formulario" method="POST">
        <div class="row">
            <input type="hidden" name="id_compromiso" id="id_compromiso">
            <input type="hidden" name="id_usuario" id="id_usuario">
            <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                <label>Compromiso</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                    </div>
                    <input type="text" class="form-control" name="compromiso_nombre" id="compromiso_nombre"
                        maxlength="255" placeholder="Nombre del Compromiso"
                        onchange="javascript:this.value=this.value.toUpperCase();" required>
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
                    <input type="date" class="form-control" name="compromiso_fecha" id="compromiso_fecha" required>
                </div>
            </div>
            <div class="form-group col-xl-3 col-lg-6 col-md-6 col-12">
                <label>Periodo</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-hourglass-end"></i></span>
                    </div>
                    <select id="compromiso_periodo" name="compromiso_periodo" class="form-control selectpicker"
                        data-live-search="true" required></select>
                </div>
            </div>
            <div class="form-group col-xl-6 col-lg-12 col-md-12 col-12">
                <label>Valida</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user-check"></i></span>
                    </div>
                    <select id="compromiso_valida" name="compromiso_valida" class="form-control selectpicker"
                        data-live-search="true" required></select>
                </div>
            </div>
            <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>
                    Guardar</button>
                <button class="btn btn-danger" onclick="cancelarform()" type="button"><i
                        class="fa fa-arrow-circle-left"></i> Cancelar</button>
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
                <button type="button" id="btnAgregarMeta" onClick="mostrarformmeta(true)"
                    class="btn btn-primary btn-block"><i class="fas fa-plus"></i> Agregar Metas</button>
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
                                    <input type="text" class="form-control" name="meta_nombre" id="meta_nombre"
                                        maxlength="255" placeholder="Nombre de la meta"
                                        onchange="javascript:this.value=this.value.toUpperCase();" required>
                                </div>
                            </div>
                            <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                <label>Eje estrategico</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-chalkboard-teacher"></i></span>
                                    </div>
                                    <select id="meta_ejes" name="meta_ejes" class="form-control selectpicker"
                                        data-live-search="true"></select>
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
                            <!--
                        <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">	
                        		<label>Val. admin</label>
                        		<div class="input-group">
                        			<span class="input-group-addon"><i class="fas fa-check-double"></i></span>
                        	   		<select id="meta_val_admin" name="meta_val_admin"  class="form-control selectpicker" data-live-search="true"></select>
                        		</div>
                                            </div>
                        	
                        <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">	
                        		<label>Val. usuario</label>
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
                                    <input type="date" class="form-control" name="meta_fecha" id="meta_fecha" required>
                                </div>
                            </div>
                            <div class="form-group col-xl-6 col-lg-6 col-md-6 col-6">
                                <label>Periodo</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-hourglass-end"></i></span>
                                    </div>
                                    <input type="text" name="meta_periodo" id="meta_periodo" class="form-control"
                                        readonly>
                                    <!--<select id="meta_periodo" name="meta_periodo"  class="form-control selectpicker" data-live-search="true" required></select>-->
                                </div>
                            </div>
                            <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                <label>Valida</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user-check"></i></span>
                                    </div>
                                    <select id="meta_valida" name="meta_valida" class="form-control selectpicker"
                                        data-live-search="true" required></select>
                                </div>
                            </div>
                            <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                <label>Corresponsable</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user-check"></i></span>
                                    </div>
                                    <select id="corresponsabilidad" name="corresponsabilidad"
                                        class="form-control selectpicker" data-live-search="true" required></select>
                                </div>
                            </div>
                            <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                <button class="btn btn-primary" type="submit" id="btnGuardarMeta"><i
                                        class="fa fa-save"></i> Guardar</button>
                                <button class="btn btn-danger" onclick="cancelarformmeta()" type="button"><i
                                        class="fa fa-arrow-circle-left"></i> Cancelar</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-body" id="resultadometas"></div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"
                    onclick="cancelarformmeta()">Cerrar</button>
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

<script type="text/javascript" src="scripts/crearcompromiso.js"></script>

<?php
}
	ob_end_flush();
?>
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
$menu=1;
$submenu=6;
require 'header.php';

	if ($_SESSION['adminformatosinstitucionales']==1)
	{
?>


<div id="precarga" class="precarga"></div>
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Formatos</span><br>
                        <span class="fs-16 f-montserrat-regular">Gestione los formatos institucionales</span>
                    </h2>
                </div>
                <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                    <button class="btn btn-sm btn-outline-warning px-2 py-0 primer_tour" onclick='iniciarTour()'><i
                            class="fa-solid fa-play"></i> Tour</button>
                </div>
                <div class="col-12 migas">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Gestión de Formatos</li>
                    </ol>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
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
                                            <span class="">Formatos institucionales</span> <br>
                                            <span class="text-semibold fs-20">Campus virtual</span>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-6 tono-3 text-right py-4 pr-4">
                                <h1 class="m-0"><small id="nombre_programa"></small><button
                                        class="btn btn-success pull-right" id="btnagregar"
                                        onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar
                                        Formato</button></h1>
                            </div>
                            <div class="col-12 table-responsive p-2" id="listadoregistros">
                                <table id="tbllistado" class="table" style="width: 100%;">
                                    <thead>
                                        <th>Opciones</th>
                                        <th>Foto</th>
                                        <th>Nombre</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>


                            <div class="card panel-body" id="formularioregistros">
                                <form name="formulario" id="formulario" method="POST">
                                    <div class="row">
                                        <input type="hidden" name="id_formato" id="id_formato">
                                        <div class="form-group col-xl-6 col-lg-6 col-md-6 col-12">
                                            <label>Nombre del archivo(*):</label>
                                            <input type="text" class="form-control" name="formato_nombre"
                                                id="formato_nombre" maxlength="100" placeholder="Nombre" required
                                                onchange="javascript:this.value=this.value.toUpperCase();">
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-6 col-md-6 col-12">
                                            <label>Archivo:</label>
                                            <input type="file" class="form-control" name="formato_archivo"
                                                id="formato_archivo">
                                            <input type="hidden" name="archivoactual" id="archivoactual">
                                            <img src="" width="150px" height="120px" id="archivomuestra">
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-6 col-md-6 col-12">
                                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i
                                                    class="fa fa-save"></i> Guardar</button>
                                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i
                                                    class="fa fa-arrow-circle-left"></i> Cancelar</button>
                                        </div>
                                    </div>
                                </form>
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

<script type="text/javascript" src="scripts/adminformatosinstitucionales.js?<?php echo date("Y-m-d-H:i:s"); ?>">
</script>
<?php
}
	ob_end_flush();
?>
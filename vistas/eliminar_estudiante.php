<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["eliminarestudiante"]))
{
  header("Location: ../");
}
else
{
$menu=1;
$submenu=10;
require 'header.php';
if ($_SESSION['eliminarestudiante']==1)
{
?>

<div class="content-wrapper ">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-xl-6 col-9">
                    <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Eliminar Estudiante</span><br>
                        <span class="fs-14 f-montserrat-regular">Aquí podrás eliminar definitivamente a un ser original
                            de nuestro sistema</span>
                    </h2>
                </div>
                <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                    <button class="btn btn-sm btn-outline-warning px-2 py-0 primer_tour" onclick='iniciarTour()'><i
                            class="fa-solid fa-play"></i> Tour</button>
                </div>
                <div class="col-12 migas mb-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Eliminar Estudiante</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content" style="padding-top: 0px;">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card card-primary" style="padding: 2%">
                    <div class="row">
                        <div class="alert alert-danger col-xl-12" style="margin: 1em;">
                            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10"><i
                                    class="red fas fa-exclamation-triangle"></i>Elimina a los seres originales que se requieran de manera definitiva des nuestro almacenamiento interno, no genera ningun tipo de reporte dado el caso que sea matricula fallida 
                                    
                                    
                            </div>
                        </div>
                        <div class="form-group mb-3 position-relative check-valid"
                            style="display: flex; align-items: center;">
                            <div class="form-floating" style="flex-grow: 1;">
                                <input type="text" placeholder="" value="" required class="form-control border-start-0"
                                    name="identificacion" id="identificacion" maxlength="20" required>
                                <label for="identificacion">Número Identificación</label>
                            </div>
                            <div style="margin-left: 10px;">
                                <input type="submit" value="Buscar" onclick="buscar()" class="btn btn-info" />
                            </div>
                        </div>
                        <div class="form-group col-xl-8 col-lg-6 col-md-12 col-12">
                            <form id="programas">
                                <label>Programas matriculados:</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                    
                                    </div>
                                    <select class="form-control aggProgramas"></select>

                                    <button type="button" onclick="consultaPrograma()"
                                        class="btn btn-success">Consultar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div id="imprime" style="margin: 1em;">
                    </div>

                    
                    <div class="panel-body table-responsive" id="listadoregistros">
    <table id="tbl_notas" class="table table-condensed table-hover" style="width:100%">
        <thead>
            <tr id="aggCortes">
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>




<?php
}
	else
	{
	  require 'noacceso.php';
	}	
	
		
require 'footer.php';
?>

<script type="text/javascript" src="scripts/eliminar_estudiante.js"></script>
<?php
}
	ob_end_flush();
?>
<script>

</script>
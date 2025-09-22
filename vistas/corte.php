<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"]))
{
  header("Location: login");
}
else
{
require 'header.php';
?>

<link rel="stylesheet" href="../public/css/bootstrap-toggle.min.css">


<div id="precarga" class="precarga" style="display: none;"></div>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <label for="">Corte</label>
                                    <input type="checkbox" onclick="cambiar()" data-toggle="toggle" id="estadoCorte" data-on="Corte 1" data-off="Corte 2" data-onstyle="success" data-offstyle="primary" data-size="mini">
                                    <button type="button" class="btn btn-success btn-xs" id="cambiar">Cambiar</button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
    <!-- fin modal reservas finalizadas -->

<?php
	
	
		
require 'footer.php';
?>
<script src="../public/js/bootstrap-toggle.min.js"></script>
<script type="text/javascript" src="scripts/corte.js"></script>

<?php
}
	ob_end_flush();
?>
<script>

</script>

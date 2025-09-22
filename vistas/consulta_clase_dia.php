<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();


if (!isset($_SESSION["usuario_nombre"]))
{
  header("Location: login.html");
}
else
{
	$menu=7;
require 'header.php';
	if($_SESSION['horariodia']==1){
?>
<div id="precarga" class="precarga hide"></div>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
	
	<section class="content-header">
      <h1>
        Consulta 
        <small>dia</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">General Elements</li>
      </ol>
    </section>
	
	 <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top: 10px;">
            <form action="#" method="post" id="form_consulta">
                <div class="form-group">
                    <div class="col-xs-12 col-sm-4 col-md-6 col-lg-4">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fas fa-user"></i></span>
                            <select name="dia" id="dia" class="form-control selectpicker"  data-live-search="true" required>
                                <option value="" disabled selected>Dia</option>
                                <option value="Lunes">Lunes</option>
                                <option value="Martes">Martes</option>
                                <option value="Miercoles">Miercoles</option>
                                <option value="Jueves">Jueves</option>
                                <option value="Viernes">Viernes</option>
                                <option value="Sabado">Sabado</option>

                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fas fa-user"></i></span>
                            <select name="periodo" id="periodo" class="form-control"></select>
                            <span class="input-group-btn">
                                <input type="submit" value="Consultar" class="btn btn-success buttuno" />
                            </span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="conte" style="padding-top: 10px;"></div>
        
    </div>

 	 <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->					
						
</section>
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

<script type="text/javascript" src="scripts/consulta_clase_dia.js?001"></script>
<?php
}
	ob_end_flush();
?>
<script>

</script>

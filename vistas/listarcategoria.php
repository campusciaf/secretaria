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
require 'header.php';
	if ($_SESSION['listarestudiantecategoria']==1)
	{
?>

<div id="precarga" class="precarga hide"></div>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
	
	<section class="content-header">
      <h1>
        Consulta 
        <small>Filtrada</small>
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
            <div class="form-group">
                <div class="col-xs-12 col-sm-4 col-md-6 col-lg-4">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-user"></i></span>
                        <select name="ubicacion" id="programa" class="form-control" data-live-search="true">
                            <option>Programa</option>
                            <option value="todos1">Todos</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-user"></i></span>
                        <select name="ubicacion" id="jornada" class="form-control">
                            <option>Jornada</option>
                            <option value="todos2">Todas</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-user"></i></span>
                        <select name="ubicacion" id="semestre" class="form-control">
                            <option>Semestre</option>
                            <option value="todos3">Todos</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                        </select>
                        <span class="input-group-btn">
                            <input type="submit" value="Consultar" onclick="consultaEstudiantes()" class="btn btn-success" />
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top: 10px;">
            <table class="table table-striped" id="dtl_estudiantes">
                <thead>
                    <tr>
                        <th scope="col">Identificación</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Programa</th>
                        <th scope="col">Jornada</th>
                        <th scope="col">Semestre</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Estado</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        
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

<script type="text/javascript" src="scripts/listarcategoria.js"></script>
<?php
}
	ob_end_flush();
?>
<script>

</script>

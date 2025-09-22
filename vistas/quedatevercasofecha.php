<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])){
  header("Location: ../");
}else{
	$menu = 15;
	$submenu = 1505;
    require 'header.php';
	if ($_SESSION['casosfecha']==1){
?>
<div id="precarga" class="precarga" hidden></div>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Casos por fecha</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Casos por fecha</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary" style="padding: 1% 1%">
                    <div class="row">
                        <div class="form-group col-12 col-sm-12 col-md-6">
                            <label for="exampleFormControlSelect1">Año</label>
                            <select id="select-programa-ano" class="form-control">
                                <option value="" disabled selected>--Seleccionar Año--</option>
                                <?php
                                    $fecha = 2019;
                                    $actual = DATE('Y');
                                    while ($actual >= $fecha) {
                                        echo '<option value="'.$actual.'">'.$actual.'</option>';
                                        $actual--;
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-12 col-sm-12 col-md-6">
                            <label for="exampleFormControlSelect1">Mes</label>
                            <select id="select-programa-mes" class="form-control" onchange="buscar(this.value)">
                                <option value="" disabled selected>--Seleccionar Mes--</option>
                                <option value="01">Enero</option>
                                <option value="02">Febrero</option>
                                <option value="03">Marzo</option>
                                <option value="04">Abril</option>
                                <option value="05">Mayo</option>
                                <option value="06">Junio</option>
                                <option value="07">Julio</option>
                                <option value="08">Agosto</option>
                                <option value="09">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>

                            </select>
                        </div>
                    </div>
                    <div class="col-12 tbl_casos"></div>    
                </div>
            </div><!-- /.box -->
        </div><!-- /.col -->
    </section><!-- /.content -->
</div>
<?php
	}else{
	  require 'noacceso.php';
	}
    require 'footer.php';
}
	ob_end_flush();
?>
<script type="text/javascript" src="scripts/quedatevercasofecha.js"></script>
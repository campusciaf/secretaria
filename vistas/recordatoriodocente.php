<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])){
    header("Location: ../");
}else{
	$menu = 12;
	$submenu = 1201;
    require 'header.php';
	if ($_SESSION['usuario_nombre']){
?>
<div id="precarga" class="precarga"></div>
<div class="content-wrapper">        
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Recordatorio Docente</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Recordatorio Docente</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
	<section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary" style="padding: 2% 1%">
                    <div class="box-header with-border">							
						<div id="mostrardatos" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-xs-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend"> 
                                            <span class="input-group-text"><i class="fas fa-book-reader"></i></span> 
                                        </div>
                                        <select class="form-control jornada" required>
                                            <option value="" selected disabled> - Jornada - </option>
                                            <option value="todos">Todos</option>
                                            <option value="D01">Diurna</option>
                                            <option value="N01">Nocturna</option>
                                            <option value="F01">Fds</option>
                                        </select>
                                        <span class="input-group-append">
                                            <input type="submit" onclick="consulta()" value="Consultar" class="btn btn-success" />
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                        <div class="col-md-12 conte">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Asunto</label>
                                <input type="text" class="form-control asunto">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Correos</label>
                                <textarea class="form-control correos" rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <textarea id="editor1" name="texto"></textarea>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success btn-flat btn-block" onclick="enviar()">Enviar a correos</button>
                            </div>
                        </div>
                    </div>
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php
    }else{
        require 'noacceso.php';
	}	
    require 'footer.php';
}
	ob_end_flush();
?>
<script type="text/javascript" src="scripts/recordatoriodocente.js"></script>
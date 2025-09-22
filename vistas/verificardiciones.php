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
	if ($_SESSION['programa']==1)
	{
?>

<!--Contenido-->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content-header">
        <h1>
            Verificar
            <small>Adicionales</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Verificar adicionales</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 uno">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user-graduate"></i></span>
                                <select name="titulo" id="titulo" class="form-control" required>
                                    <option value="Tecnico">Técnico</option>
                                    <option value="Tecnologo">Tecnólogo</option>
                                    <option value="Profesional">Profesional</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4 uno" >
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fas fa-id-card"></i></span>
                                <input class="form-control" id="verificar_estudiante" type="number"
                                    placeholder="Documento de Identificacion" required>
                                <span class="input-group-btn">
                                    <input type="submit" value="Continuar" onclick="consulta()" class="btn btn-success" name="comprobar" />
                                </span>
                            </div>
                        </div>
                        <div class="col-md-12 dos hide">
                            <div class="container form-group" id="agregar_estado_div">
                                <br><br>
                               
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="alert alert-danger" role="alert">
                                            <center><b>Completa estos datos para continuar</b></center>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 1%;">
                                        <label for="">Estado:</label>
                                        <input type="hidden" id="periodo">
                                        <select name="estado_est" class="form-control" id="estado_est" onChange="estado(this.value);" required>
                                            <option value=""></option>
                                            <option value="retirado">Retirado</option>
                                            <option value="graduado">Graduado</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hide datos_graduado" >
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <input type="hidden" id="guia">
                                            <label for="numero_acta">Numero de acta:</label>
                                            <input class="form-control" name="numero_acta" id="numero_acta" type="text" />
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <label for="folio">Folio:</label>
                                            <input class="form-control" name="folio" id="folio" type="text" />
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <label for="ano_graduacion">Año de graduacion:</label>
                                            <input class="form-control" name="ano_graduacion" id="ano_graduacion" type="date" />
                                            
                                        </div><br>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <center>
                                            <input onclick="guardarEstado()" type="button" value="Continuar" class="btn btn-success" name="guardar_estado"
                                                style="margin-top: 1%;" />
                                        </center>
                                    </div>
                                
                            </div>
                        </div>
                        <div class="col-md-12 tres"></div>
                       
                    </div><!-- div panel footer -->
                    <!--Fin centro -->
                </div><!-- /.box -->
            </div><!-- /.col -->
            
        </div><!-- /.row -->

    </section>
</div><!-- /.content-wrapper -->

<!-- modal editar materia -->

<div class="modal fade bs-example-modal-lg" tabindex="-1" id="editarMateria" role="dialog">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                        <input type="hidden" id="id">
                        <label for="nombre_asig">Nombre Materia:</label>
                        <input class="form-control" id="nombre_asig_e" type="text" placeholder="Nombre Materia" required>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
                        <label for="creditos_asig">Creditos:</label>
                        <input class="form-control" id="creditos_asig_e" type="number" required>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
                        <label for="semestre_asig">Semestre:</label>
                        <select name="semestre_asig" id="semestre_asig_e" class="form-control">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="6">7</option>
                            <option value="6">8</option>
                            <option value="6">9</option>
                            <option value="6">10</option>
                        </select>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
                        <label for="nota_asig">Nota Final:</label>
                        <input class="form-control" id="nota_asig_e" type="text" required>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
                        <label>Periodo:</label>
                        <select class="form-control periodo_asig_e">
                            <option value="2012-2">2012-2</option>
                            <option value="2012-1">2012-1</option>
                            <option value="2011-2">2011-2</option>
                            <option value="2011-1">2011-1</option>
                            <option value="2010-2">2010-2</option>
                            <option value="2010-1">2010-1</option>
                            <option value="2009-2">2009-2</option>
                            <option value="2009-1">2009-1</option>
                            <option value="2008-2">2008-2</option>
                            <option value="2008-1">2008-1</option>
                            <option value="2007-2">2007-2</option>
                            <option value="2007-1">2007-1</option>
                            <option value="2006-2">2006-2</option>
                            <option value="2006-1">2006-1</option>
                            <option value="2005-2">2005-2</option>
                            <option value="2005-1">2005-1</option>
                            <option value="2004-2">2004-2</option>
                            <option value="2004-1">2004-1</option>
                            <option value="2003-2">2003-2</option>
                            <option value="2003-1">2003-1</option>
                            <option value="2002-2">2002-2</option>
                            <option value="2002-1">2002-1</option>
                            <option value="2001-2">2001-2</option>
                            <option value="2001-1">2001-1</option>
                            <option value="2000-2">2000-2</option>
                            <option value="2000-1">2000-1</option>
                            <option value="1999-2">1999-2</option>
                            <option value="1999-1">1999-1</option>
                            <option value="1998-2">1998-2</option>
                            <option value="1998-1">1998-1</option>
                            <option value="1997-2">1997-2</option>
                            <option value="1997-1">1997-1</option>
                            <option value="1996-2">1996-2</option>
                            <option value="1996-1">1996-1</option>
                            <option value="1995-2">1995-2</option>
                            <option value="1995-1">1995-1</option>
                            <option value="1994-2">1994-2</option>
                            <option value="1994-1">1994-1</option>
                            <option value="1993-2">1993-2</option>
                            <option value="1993-1">1993-1</option>
                            <option value="1992-2">1992-2</option>
                            <option value="1992-1">1992-1</option>
                            <option value="1991-2">1991-2</option>
                            <option value="1991-1">1991-1</option>
                            <option value="1990-2">1990-2</option>
                            <option value="1990-1">1990-1</option>
                            <option value="1989-2">1989-2</option>
                            <option value="1989-1">1989-1</option>
                            <option value="1988-2">1988-2</option>
                            <option value="1988-1">1988-1</option>
                            <option value="1987-2">1987-2</option>
                            <option value="1987-1">1987-1</option>
                            <option value="1986-2">1986-2</option>
                            <option value="1986-1">1986-1</option>
                            <option value="1985-2">1985-2</option>
                            <option value="1985-1">1985-1</option>
                            <option value="1984-2">1984-2</option>
                            <option value="1984-1">1984-1</option>
                            <option value="1983-2">1983-2</option>
                            <option value="1983-1">1983-1</option>
                            <option value="1982-2">1982-2</option>
                            <option value="1982-1">1982-1</option>
                            <option value="1981-2">1981-2</option>
                            <option value="1981-1">1981-1</option>
                            <option value="1980-2">1980-2</option>
                            <option value="1980-1">1980-1</option>
                            <option value="1979-2">1979-2</option>
                            <option value="1979-1">1979-1</option>
                            <option value="1978-2">1978-2</option>
                            <option value="1978-1">1978-1</option>
                            <option value="1977-2">1977-2</option>
                            <option value="1977-1">1977-1</option>
                            <option value="1976-2">1976-2</option>
                            <option value="1976-1">1976-1</option>
                            <option value="1975-2">1975-2</option>
                            <option value="1975-1">1975-1</option>
                            <option value="1974-2">1974-2</option>
                            <option value="1974-1">1974-1</option>
                            <option value="1973-2">1973-2</option>
                            <option value="1973-1">1973-1</option>
                            <option value="1972-2">1972-2</option>
                            <option value="1972-1">1972-1</option>
                        </select>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
                        <label>Jornada:</label>
                        <select class="form-control jornada_asig_e"></select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" onclick="editarMateria()" class="btn btn-success"><i class="fas fa-pencil-alt"></i> Editar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--Fin-Contenido-->
<?php
	}
	else
	{
	  require 'noacceso.php';
	}
		
require 'footer.php';
?>

<script type="text/javascript" src="scripts/verificardiciones.js"></script>
<?php
}
	ob_end_flush();
?>
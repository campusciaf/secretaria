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
<div id="precarga" class="precarga hide"></div>
<link rel="stylesheet" href="../public/css/bootstrap-toggle.min.css">
<link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet" />
<link rel="stylesheet" href="../public/css/boostrap-check.css">
<!--Contenido-->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content-header">
        <h1>
            Consulta 
            <small>graduados</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Consulta graduados</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <form class="consultaDatos" id="form2" method="POST">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4" >
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="far fa-calendar-alt"></i></span>
                                    <select data-live-search="true" name="periodoBus" class="form-control selectpicker">
                                        <option value="todos" selected>Todos</option>
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
                                    <span class="input-group-btn">
                                        <input type="submit" value="Continuar" class="btn btn-success consultaDatos" />
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> <br>
                                        <input id="p1" type="checkbox" onchange="todo()" data-toggle="toggle" data-on="Todos" data-off="Ninguno" data-onstyle="success" data-size="mini" name="todoprincipal">
                                    </div>
                                    
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox1" class="styled parteUno" name="identificacion" type="checkbox" checked>
                                            <label for="checkbox1">Identificación</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox2" class="styled parteUno" name="programa" type="checkbox">
                                            <label for="checkbox2">Programa</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox3" class="styled parteUno" name="estado" type="checkbox">
                                            <label for="checkbox3">Estado</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox4" class="styled parteUno" name="numer_acta" type="checkbox">
                                            <label for="checkbox4">Numero de acta</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox5" class="styled parteUno" name="folio" type="checkbox">
                                            <label for="checkbox5">Folio</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox6" class="styled parteUno" name="ano_gradu" type="checkbox">
                                            <label for="checkbox6">Año de graduacion</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox7" class="styled parteUno" name="escuela" type="checkbox">
                                            <label for="checkbox7">Escuela</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> <br>
                                        <label for="p2">Informacion personal:</label>
                                        <input id="p2" type="checkbox" data-toggle="toggle" data-on="Todos" data-off="Ninguno" data-onstyle="success"
                                            data-size="mini" onchange="parteDos()" name="todopersonal" />
                                    </div>
                                
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox8" class="styled partedos" name="nombre1" type="checkbox" checked>
                                            <label for="checkbox8">Primer nombre</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox9" class="styled partedos" name="nombre2" type="checkbox">
                                            <label for="checkbox9">Segundo nombre</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox10" class="styled partedos" name="fecha_expe" type="checkbox">
                                            <label for="checkbox10">Fecha de Expedición</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox20" class="styled partedos" name="nombre_dis" type="checkbox">
                                            <label for="checkbox20">Nombre Discapacidad</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox12" class="styled partedos" name="jornada" type="checkbox">
                                            <label for="checkbox12">Jornada</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox13" class="styled partedos" name="discapacidad" type="checkbox">
                                            <label for="checkbox13">Discapacidad</label>
                                        </div>
                                    </div>                                    
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox14" class="styled partedos" name="apellido1" type="checkbox">
                                            <label for="checkbox14">Primer apellido</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox16" class="styled partedos" name="tipo_docu" type="checkbox">
                                            <label for="checkbox16">Tipo de documento</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox11" class="styled partedos" name="genero" type="checkbox">
                                            <label for="checkbox11">Genero</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox17" class="styled partedos" name="lugar_naci" type="checkbox">
                                            <label for="checkbox17">Lugar de Nacimiento</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox18" class="styled partedos" name="tipo_sangre" type="checkbox">
                                            <label for="checkbox18">Tipo de sangre</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox19" class="styled partedos" name="periodo" type="checkbox">
                                            <label for="checkbox19">Periodo</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox15" class="styled partedos" name="apellido2" type="checkbox">
                                            <label for="checkbox15">Segundo apellido</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox21" class="styled partedos" name="lugar_expe" type="checkbox">
                                            <label for="checkbox21">Lugar de Expedición</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox22" class="styled partedos" name="Fecha_naci" type="checkbox">
                                            <label for="checkbox22">Fecha de Nacimiento</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox23" class="styled partedos" name="nombre_et" type="checkbox">
                                            <label for="checkbox23">Nombre Etnico</label>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> <br>
                                        <label for="p3">Informacion de contácto:</label>
                                        <input id="p3" type="checkbox" data-toggle="toggle" data-on="Todos" data-off="Ninguno" data-onstyle="success"
                                            data-size="mini" onchange="parteTre()" name="todocontacto" />
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox24" class="styled parteTres" name="direc_resi" type="checkbox">
                                            <label for="checkbox24">Dirección Residencia</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox25" class="styled parteTres" name="barrio_resi" type="checkbox">
                                            <label for="checkbox25">Barrio de Residencia</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox26" class="styled parteTres" name="tele1" type="checkbox">
                                            <label for="checkbox26">Teléfono Fijo 1</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox27" class="styled parteTres" name="tele2" type="checkbox">
                                            <label for="checkbox27">Teléfono Fijo 2</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox28" class="styled parteTres" name="celular" type="checkbox">
                                            <label for="checkbox28">Número Celular</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox29" class="styled parteTres" name="correo" type="checkbox">
                                            <label for="checkbox29">Correo</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox30" class="styled parteTres" name="ciudad_resi" type="checkbox">
                                            <label for="checkbox30">Ciudad de Residencia</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> <br>
                                        <label for="p4">Informacion académica:</label>
                                        <input id="p4" type="checkbox" data-toggle="toggle" data-on="Todos" data-off="Ninguno" data-onstyle="success"
                                            data-size="mini" onchange="parteCuatro()" name="todoacademi">
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox31" class="styled parteCuatro" name="nom_cole" type="checkbox">
                                            <label for="checkbox31">Nombre del colegio</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox32" class="styled parteCuatro" name="jor_inst" type="checkbox">
                                            <label for="checkbox32">Jornada Institución</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox33" class="styled parteCuatro" name="ano_termi" type="checkbox">
                                            <label for="checkbox33">Año de terminación</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox34" class="styled parteCuatro" name="ciudad_colegio" type="checkbox">
                                            <label for="checkbox34">Municipio Colegio</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox35" class="styled parteCuatro" name="fecha_icfes" type="checkbox">
                                            <label for="checkbox35">Fecha de presentación icfes</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox36" class="styled parteCuatro" name="codigo_icfes" type="checkbox">
                                            <label for="checkbox36">Codigo Icfes</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox37" class="styled parteCuatro" name="tipo_inst" type="checkbox">
                                            <label for="checkbox37">Tipo de Institución</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> <br>
                                        <label for="p5">Informacion laboral:</label>
                                        <input id="p5" type="checkbox" data-toggle="toggle" data-on="Todos" data-off="Ninguno" data-onstyle="success"
                                            data-size="mini" onchange="parteCinco()" name="todolabora">
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox38" class="styled parteCinco" name="traba_actu" type="checkbox">
                                            <label for="checkbox38">Trabaja Actualmente</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox39" class="styled parteCinco" name="cargo_desem" type="checkbox">
                                            <label for="checkbox39">Cargo Desempeñado</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox40" class="styled parteCinco" name="nombre_empre" type="checkbox">
                                            <label for="checkbox40">Nombre Empresa</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox41" class="styled parteCinco" name="sec_empre" type="checkbox">
                                            <label for="checkbox41">Sector Empresa</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox42" class="styled parteCinco" name="tele_empre" type="checkbox">
                                            <label for="checkbox42">Teléfono Empresa</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox43" class="styled parteCinco" name="correo_empre" type="checkbox">
                                            <label for="checkbox43">Correo</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" >
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> <br>
                                        <label for="p6">Informacion complementaria:</label>
                                        <input id="p6" type="checkbox" data-toggle="toggle" data-on="Todos" data-off="Ninguno" data-onstyle="success"
                                            data-size="mini" onchange="parteSeis()" name="todocomple">
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox44" class="styled parteSeis" name="segun_idioma" type="checkbox">
                                            <label for="checkbox44">Segundo Idioma</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox45" class="styled parteSeis" name="aficiones" type="checkbox">
                                            <label for="checkbox45">Aficiones</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox46" class="styled parteSeis" name="tiene_compu" type="checkbox">
                                            <label for="checkbox46">Tiene Computador</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox47" class="styled parteSeis" name="tiene_inter" type="checkbox">
                                            <label for="checkbox47">Tiene acceso a internet</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox48" class="styled parteSeis" name="tiene_hijos" type="checkbox">
                                            <label for="checkbox48">Tiene Hijos</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox49" class="styled parteSeis" name="estado_civil" type="checkbox">
                                            <label for="checkbox49">Estado Civil</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-4 col-md-2 col-lg-2">
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox50" class="styled parteSeis" name="cual_idiomas" type="checkbox">
                                            <label for="checkbox50">Cual Idioma</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                       
                    </div><!-- div panel footer -->
                    <!--Fin centro -->
                </div><!-- /.box -->
            </div><!-- /.col -->
            
        </div><!-- /.row -->

    </section>
</div><!-- /.content-wrapper -->

<div class="modal fade bs-example-modal-lg" id="modalDatos" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal datos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!--Fin-Contenido-->
<?php
	}
	else
	{
	  require 'noacceso.php';
	}
		
require 'footer.php';
?>

<script type="text/javascript" src="../public/js/bootstrap-toggle.min.js"></script>
<script type="text/javascript" src="scripts/consultagraduados2012.js"></script>
<?php
}
	ob_end_flush();
?>
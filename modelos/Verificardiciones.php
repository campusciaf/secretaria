<?php
require "../config/Conexion.php";
class Verifica
{
    public function consultaCedula($cedula,$titulo)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `estado_estudiantes_antes_2012` WHERE identificacion = '$cedula' AND titulo = '$titulo' ");
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        
        $data['result'] = $registro;

        if ($data['result'] !== false) {
            $datos = self::consultaDatos($cedula);
            $data['result'] = "ok";
            $data['conte'] = $datos['conte'];
        }

        echo json_encode($data);
    }

    public function guardarEstado($titulo,$verificar_estudiante,$estado_est,$numero_acta,$folio,$ano_graduacion,$periodo)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" INSERT INTO `estado_estudiantes_antes_2012`(`identificacion`, `estado`, `numero_acta`, `folio`, `ano_graduacion`, `titulo`, `periodo`) VALUES ( '$verificar_estudiante', '$estado_est', '$numero_acta', '$folio', '$ano_graduacion', '$titulo', '$periodo' ) ");

        if ($sentencia->execute()) {
            $data['result'] = "ok";
        } else {
            $data['result'] = "error";
        }

        return $data;
    }

    public function consultaDatos($cedula)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM estado_estudiantes_antes_2012 INNER JOIN estudiantes_antes_2012 ON estado_estudiantes_antes_2012.identificacion = estudiantes_antes_2012.identificacion WHERE estado_estudiantes_antes_2012.identificacion = :cc AND estudiantes_antes_2012.identificacion = :cc ");
        $sentencia->bindParam(":cc",$cedula);
        $sentencia->execute();
        $datos = $sentencia->fetch(PDO::FETCH_ASSOC);
        //$registro['conte'] = $registro['datos']['folio'];
        $registro['conte'] = '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="overflow: auto;">
                                <b><i class="fa fa-book"></i>  '.$datos['fo_programa'].'</b>  /
                                <i class="fa fa-user-graduate">  '.$datos['nombre'].' '.$datos['nombre_2'].' '.$datos['apellidos'].' '.$datos['apellidos_2'].' </i>  /
                                <b><i class="fa fa-id-card"></i>  '.$datos['identificacion'].' </b> 
                            </div><br/></br>
                            <div class="container alert bg-primary col-xs-12 col-sm-12 col-md-12 col-lg-12" role="alert>
                                <div id="estado_estu_ant">
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <label><b>Estado: </b>'.$datos['estado'].'</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <label><b>Numero de acta: </b>'.$datos['numero_acta'].'</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <label><b>Folio: </b>'.$datos['folio'].'</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <label><b>Fecha de grado: </b>'.self::convertir_fecha($datos['ano_graduacion']).'</label>
                                    </div>
                                </div>
                            </div>
                            <div class="alert alert-light" role="alert">
                                <!-- Formulario agregar asignatura nueva -->
                                <div class="form-group">
                                    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
                                        <label for="nombre_asig">Nombre Materia:</label>
                                        <input class="form-control" name="nombre_asig" id="nombre_asig" type="text" placeholder="Nombre Materia"
                                            required>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-1 col-lg-1">
                                        <label for="creditos_asig">Creditos:</label>
                                        <input class="form-control" name="creditos_asig" id="creditos_asig" type="number" required>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
                                        <label for="semestre_asig">Semestre:</label>
                                        <select name="semestre_asig" id="semestre_asig" class="form-control">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
                                        <label for="nota_asig">Nota Final:</label>
                                        <input class="form-control" name="nota_asig" id="nota_asig" type="text" required>
                                        <input id="programa" type="hidden" value="'.$datos['fo_programa'].'">
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
                                        <label>Periodo:</label>
                                        <select  data-live-search="true" class="form-control periodo_asig">
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
                                        <select data-live-search="true" class="form-control jornada_asig"></select>
                                    </div>
                                    <center>
                                        <input type="submit" onclick=guardarMateria("'.$datos['identificacion'].'","'.$datos['titulo'].'","'.$datos['escuela_ciaf'].'") value="Registrar Materia" id="btn_registrar_materia" class="btn btn-success" name="registrar_materia" style="margin-top: 1%;">
                                    </center>
                                </div>
                            </div>
                            <script>
                                $(document).ready(inicio);
                                function inicio() {
                                    listarMaterias("'.$datos['identificacion'].'","'.$datos['titulo'].'");
                                    mostrarJornada();
                                }
                            </script>
                            <div class="col-md-12 cuatro"></div>


        ';
        return $registro;
    }


    public function consultaSemestres($cedula,$tipo)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT DISTINCT semestre FROM `materias_antes_2012` WHERE `identificacion` = :cc AND titulo_materia = :tipo ORDER BY `materias_antes_2012`.`semestre` ASC ");
        $sentencia->bindParam(":cc", $cedula);
        $sentencia->bindParam(":tipo", $tipo);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        return $registro;
    }
    public function consultaMateria($cedula,$tipo,$semestre)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `materias_antes_2012` WHERE `identificacion` = :cc AND titulo_materia = :tipo AND semestre = :semestre ");
        $sentencia->bindParam(":cc", $cedula);
        $sentencia->bindParam(":tipo", $tipo);
        $sentencia->bindParam(":semestre", $semestre);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        return $registro;
    }

    public function aggMaterias($cc,$tipo,$escuela,$programa,$materia,$creditos,$semestre,$nota,$periodo,$jornada)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" INSERT INTO `materias_antes_2012`(`identificacion`, `titulo_materia`, `nombre_materia`, `estado`, `jornada`, `periodo`, `semestre`, `nota`, `creditos`, `programa`, `escuela`) VALUES ('$cc', '$tipo', '$materia', 'Registrado', '$jornada', '$periodo', '$semestre', '$nota', '$creditos', '$programa', '$escuela') ");
        if ($sentencia->execute()) {
            $data['status'] = "ok";
        } else {
            $data['status'] = "erro";
        }

        echo json_encode($data);
    
    }

    public function mostrarJornada()
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM jornada ");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode ($registro);
    }

    public function eliminarMateria($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" DELETE FROM materias_antes_2012 WHERE id_materia = :id ");
        $sentencia->bindParam(":id",$id);

        if ($sentencia->execute()) {
            $data['status'] = "ok";
        }else {
            $data['status'] = "erro";
        }

        echo json_encode($data);

    }

    public function consultaMateriaDatos($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `materias_antes_2012` WHERE `id_materia` = :id ");
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        echo json_encode ($registro);
    }

    public function editarMateria($id,$asignatura,$creditos,$semestre,$nota,$periodo,$jornada)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" UPDATE `materias_antes_2012` SET `nombre_materia`= :asig,`jornada`=:jor,`periodo`=:perio,`semestre`=:semes,`nota`=:nota,`creditos`=:credi WHERE `id_materia` = :id ");

        
        $sentencia->bindParam(":asig",$asignatura);
        $sentencia->bindParam(":credi",$creditos);
        $sentencia->bindParam(":semes",$semestre);
        $sentencia->bindParam(":nota",$nota);
        $sentencia->bindParam(":perio",$periodo);
        $sentencia->bindParam(":jor",$jornada);
        $sentencia->bindParam(":id",$id);

        if ($sentencia->execute()) {
            $data['status'] = "ok";
        } else {
            $data['status'] = "error";
        }

        echo json_encode($data);
        
        

    }

    public function convertir_fecha($date) 
    {
        $dia    = explode("-", $date, 3);
        $year   = $dia[0];
        $month  = (string)(int)$dia[1];
        $day    = (string)(int)$dia[2];

        $dias       = array("domingo","lunes","martes","mi&eacute;rcoles" ,"jueves","viernes","s&aacute;bado");
        $tomadia    = $dias[intval((date("w",mktime(0,0,0,$month,$day,$year))))];
        $meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
        return $day." de ".$meses[$month]." de ".$year;
    }
    

}


?>
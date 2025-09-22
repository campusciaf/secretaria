<?php
require "../config/Conexion.php";

Class ReporteSnies{
    // Implementamos nuestro constructor
	public function __construct() {
    }
    
    // Cargamos los datos del periodo para filtrar los estudiantes
    public function cargarDatosPeriodo(){
        $sql = "SELECT * FROM periodo_actual";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    // Cargamos todos los estudiantes que tienen periodo = periodo_actual
    public function cargarRelacionInscritos($periodo_actual){
        $sql = "SELECT * FROM estudiantes WHERE periodo=:periodo";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":periodo",$periodo_actual);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
    // Cargamos los datos de la tabla credencial_estudiante
    public function cargarDatosCredencial($id_credencial){
        $sql = "SELECT * FROM credencial_estudiante WHERE id_credencial=:id_credencial";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial",$id_credencial);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    // Cargamos los datos personales del estudiante
    public function cargarDatosPersonales($id_credencial){
        $sql = "SELECT * FROM estudiantes_datos_personales WHERE id_credencial=:id_credencial";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial",$id_credencial);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    // Cargamos los datos del programa del estudiante
    public function cargarDatosPrograma($id_programa_ac){
        $sql = "SELECT cod_snies FROM programa_ac WHERE id_programa=:id_programa_ac";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa_ac",$id_programa_ac);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    // Cargamos el id del departamento
    public function cargarCodDepartamento($departamento){
        $sql = "SELECT id_departamento FROM departamentos WHERE departamento=:departamento";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":departamento", $departamento);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //SELECT estudiantes_datos_personales.* FROM estudiantes_datos_personales inner join credencial_estudiante on credencial_estudiante.id_credencial = estudiantes_datos_personales.id_credencial inner join estudiantes on estudiantes.id_estudiante = estudiantes_datos_personales.id_estudiante where


    // Cargamos el código del municipio respecto a la divisón política administrativa
    public function cargarCodDivipola($cod_departamento,$municipio){
        $sql = "SELECT cod_divipola FROM municipios WHERE departamento_id=:departamento AND municipio=:municipio";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":departamento", $cod_departamento);
        $consulta->bindParam(":municipio", $municipio);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    // Cargamos el código del nombre étnico
    public function cargarCodigoEtnico($categoria,$nombre){
        $sql = "SELECT codigo FROM nombre_etnico WHERE categoria=:categoria AND nombre=:nombre";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":categoria", $categoria);
        $consulta->bindParam(":nombre", $nombre);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    // Cargamos los estudiantes con matrícula vigente en este periodo
    public function cargarMatriculados($periodo_actual){
        $sql = "SELECT * FROM estudiantes WHERE periodo_activo=:periodo_activo";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":periodo_activo",$periodo_actual);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    // Cargamos las materias inscritas del estudiante
    public function cargarMateriasInscritas($id_estudiante,$ciclo,$periodo_actual){
        // Definimos la tabla en la que se va a hacer la búsqueda
        $tabla = "materias".$ciclo;
        $sql = "SELECT id_materia FROM $tabla WHERE id_estudiante=:id_estudiante AND periodo=:periodo_actual";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_estudiante",$id_estudiante);
        $consulta->bindParam(":periodo_actual",$periodo_actual);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    // Cargamos las materias aprobadas del estudiante
    public function cargarMateriasAprobadas($id_estudiante,$ciclo,$periodo_actual){
        // Definimos la tabla en la que se va a hacer la búsqueda
        $tabla = "materias".$ciclo;
        $sql = "SELECT id_materia FROM $tabla WHERE id_estudiante=:id_estudiante AND periodo=:periodo_actual AND promedio >= '3'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_estudiante",$id_estudiante);
        $consulta->bindParam(":periodo_actual",$periodo_actual);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    // Cargamos los estudiantes graduados en el periodo actual
    public function cargarGraduados($periodo_actual){
        $sql = "SELECT * FROM graduados WHERE periodo_grado=:periodo_actual";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":periodo_actual",$periodo_actual);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
}
?>
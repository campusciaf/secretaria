<?php

//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class Configuracion
{

    public function mostrar($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `usuario` WHERE `id_usuario` = :id ");
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        return $registro;
    }

    //Implementar un método para listar los tipos de sangre
	public function selectTipoSangre()
	{	
		$sql="SELECT * FROM tipo_sangre";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

    //Implementar un método para listar los Departamentos
    public function selectDepartamento()
    {
        $sql = "SELECT * FROM `departamentos`";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para listar los municipios en un select
	public function selectDepartamentoMunicipioActivo($id_usuario)
	{	
		$sql="SELECT * FROM usuario WHERE id_usuario= :id_usuario";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

    		//Implementar un método para listar los departamentos en un select
	public function selectDepartamentoDos($departamento)
	{	
		$sql="SELECT * FROM departamentos WHERE departamento= :departamento";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":departamento", $departamento);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
    	//Implementar un método para listar los municipios en un select
	public function selectMunicipio($id_departamento)
	{	
		$sql="SELECT * FROM municipios WHERE departamento_id= :id_departamento";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_departamento", $id_departamento);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


    
    
    public function listarDatos($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `usuario` WHERE `id_usuario` = :id ");
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        return $registro;
    }

    public function cambiarContra($id,$anterior,$nueva)
    {
        global $mbd;
        $nueva = md5($nueva);
        $sentencia = $mbd->prepare(" SELECT * FROM `usuario` WHERE `id_usuario` = :id ");
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        if ($registro['usuario_clave'] == md5($anterior)) {
            $sentencia2 = $mbd->prepare(" UPDATE `usuario` SET `usuario_clave` = :clave WHERE `id_usuario` = :id ");
            $sentencia2->bindParam(":clave", $nueva);
            $sentencia2->bindParam(":id", $id);
            if ($sentencia2->execute()) {
               $data['status'] = "ok";
            } else {
               $data['status'] = "Error al actualizar la contraseña, ponte en contacto con el administrador del sistema.";
            }
            

        } else {
            $data['status'] = "La contraseña anterior no coincide.";
        }

        echo json_encode($data);
    }

    public function editarDatospersonales($nombre1,$nombre2,$apellido,$apellido2,$fecha_n,$depar_naci,$ciudad_naci,$tipo_sangre,$dirrecion,$telefono,$celular,$fecha_actualizacion)
    {
        $id = intval($_SESSION["id_usuario"]);
        
       
        $sql=" UPDATE `usuario` SET `usuario_nombre`='$nombre1',`usuario_nombre_2`='$nombre2',`usuario_apellido`='$apellido',`usuario_apellido_2`='$apellido2',`usuario_direccion`='$dirrecion', `usuario_telefono`= '$telefono',`usuario_celular`='$celular',`usuario_fecha_nacimiento`='$fecha_n',`usuario_tipo_sangre`='$tipo_sangre', `usuario_departamento_nacimiento` = '$depar_naci', `usuario_municipio_nacimiento` = '$ciudad_naci', `fecha_actualizacion` = '$fecha_actualizacion' WHERE `id_usuario` = '$id' ";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
		return $consulta;
        

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

    public function validar($validar)
    {
        $contra = md5($validar);
        $id = intval($_SESSION["id_usuario"]);
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT `usuario_clave` FROM `usuario` WHERE `id_usuario` = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        if ($registro['usuario_clave'] == $contra) {
            $data['status'] = "ok";
        } else {
            $data['status'] = "Error, contraseña incorrecta";
        }

        echo json_encode($data);
        

    }
   function base64_to_jpeg($base64_string, $output_file){
    if (empty($output_file)) {
        return false;
    }
    $ifp = fopen($output_file, 'wb');
    if (!$ifp) {
        return false;
    }
    $data = explode(',', $base64_string);
    if (count($data) < 2) {
        fclose($ifp);
        return false;
    }
    fwrite($ifp, base64_decode($data[1]));
    fclose($ifp);
    return $output_file;
}
     function actualizarCampoBD($campo, $id_usuario) {
        global $mbd;
        $sentencia = $mbd->prepare(" UPDATE `usuario` SET `usuario_imagen` = :campo WHERE `id_usuario` = :id_usuario ");
        $sentencia->bindParam(":campo", $campo);
        $sentencia->bindParam(":id_usuario", $id_usuario);
        if ($sentencia->execute()) {
            return true;
        } else {
            return false;
        }
    }

}


?>
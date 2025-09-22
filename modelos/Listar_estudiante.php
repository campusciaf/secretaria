<?php

require "../config/Conexion.php";
class Listar
{

    public function listarEstudiante(){
        $sql = "SELECT * FROM credencial_estudiante ce INNER JOIN estudiantes_datos_personales edp ON ce.id_credencial=edp.id_credencial WHERE ce.credencial_condicion = 1";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
      }

    public function mostrar($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT *

            FROM `credencial_estudiante` INNER JOIN estudiantes_datos_personales ON credencial_estudiante.`id_credencial` = estudiantes_datos_personales.`id_credencial` WHERE credencial_estudiante.`id_credencial` = :id AND estudiantes_datos_personales.`id_credencial`= :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $registro  = $sentencia->fetch(PDO::FETCH_ASSOC);
        echo json_encode($registro);
    }
    public function editar($tipo_docu,$lugar_expe,$fecha_expe,$nombre_1,$id,$nombre_2,$apellido_1,$apellido_2,$fe_naci,$de_na,$mu_na,$co_ciaf,$co_per,$cel,$tele,$muni,$dire,$barrio,$tipo_resi,$zo_re,$what,$ins,$face,$twi)
    {
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE `credencial_estudiante` SET 
        `credencial_nombre`=:nombre,
        `credencial_nombre_2`=:nombre2,
        `credencial_apellido`=:apellido,
        `credencial_apellido_2`=:apellido2,
        `credencial_login`=:correo 
        WHERE id_credencial = :id ");

        $sentencia->bindParam(":nombre",$nombre_1);
        $sentencia->bindParam(":nombre2",$nombre_2);
        $sentencia->bindParam(":apellido",$apellido_1);
        $sentencia->bindParam(":apellido2",$apellido_2);
        $sentencia->bindParam(":correo",$co_ciaf);
        $sentencia->bindParam(":id",$id);

        $sentencia2 = $mbd->prepare("UPDATE `estudiantes_datos_personales` SET 
        `celular`=:celular,
        `municipio`=:municipio,
        `direccion`=:direccion,
        `barrio`=:barrio,
        tipo_documento = :tipo_iden,
        expedido_en = :lugar_ex,
        fecha_expedicion = :fe_ex,
        fecha_nacimiento = :fe_na,
        departamento_nacimiento = :de_na,
        lugar_nacimiento = :mu_na,
        email = :email,
        telefono = :telefo,
        tipo_residencia = :ti_resi,
        zona_residencia = :zo_re,
        whatsapp = :what,
        instagram = :ins,
        facebook = :face,
        twiter = :twi

        WHERE id_credencial = :id_cre ");

        $sentencia2->bindParam(":celular",$cel);
        $sentencia2->bindParam(":municipio",$muni);
        $sentencia2->bindParam(":direccion",$dire);
        $sentencia2->bindParam(":barrio",$barrio);
        $sentencia2->bindParam(":tipo_iden",$tipo_docu);
        $sentencia2->bindParam(":lugar_ex",$lugar_expe);
        $sentencia2->bindParam(":fe_ex",$fecha_expe);
        $sentencia2->bindParam(":fe_na",$fe_naci);
        $sentencia2->bindParam(":de_na",$de_na);
        $sentencia2->bindParam(":mu_na",$mu_na);
        $sentencia2->bindParam(":email",$co_per);
        $sentencia2->bindParam(":telefo",$tele);
        $sentencia2->bindParam(":ti_resi",$tipo_resi);
        $sentencia2->bindParam(":zo_re",$zo_re);
        $sentencia2->bindParam(":what",$what);
        $sentencia2->bindParam(":ins",$ins);
        $sentencia2->bindParam(":face",$face);
        $sentencia2->bindParam(":twi",$twi);
        $sentencia2->bindParam(":id_cre",$id);

        if ($sentencia->execute()) {
            
            if ($sentencia2->execute()) {
                $data['status'] = "ok";
            }
        } else {
            $data['status'] = "Error, Ponte en contacto con el administrador del sistema.";
        }

        echo json_encode($data);
    

    }

    public function fechaesp($date) {
		$dia 	= explode("-", $date, 3);
		$year 	= $dia[0];
		$month 	= (string)(int)$dia[1];
		$day 	= (string)(int)$dia[2];

		$dias 		= array("domingo","lunes","martes","mi&eacute;rcoles","jueves","viernes","s&aacute;bado");
		$tomadia 	= $dias[intval((date("w",mktime(0,0,0,$month,$day,$year))))];

		$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

		return $tomadia.", ".$day." de ".$meses[$month]." de ".$year;
	}


}


?>
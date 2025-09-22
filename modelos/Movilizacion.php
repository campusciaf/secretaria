<?php
require "../config/conexion.php";

class Movilizacion
{
    const MUNICIPIOS = 'municipios_articulacion';
    const COLEGIOARTICULACION = 'colegios_articulacion';

    public function __construct() {
        
    }


    public function listarmunicipios()
	{
		global $mbd;
		$sentencia = $mbd->prepare('SELECT id,nombre FROM '.self::MUNICIPIOS);
        $sentencia->execute();
        
        while ($registros = $sentencia->fetch(PDO::FETCH_ASSOC)) {

            $sentencia2 = $mbd->prepare('SELECT COUNT(id) AS colegios FROM '.self::COLEGIOARTICULACION.' WHERE id_municipio='.$registros['id']);
            $sentencia2->execute();

            $senten=$sentencia2->fetch(PDO::FETCH_ASSOC);

            $data[]=array(
					"0"=>$registros['nombre'],
					"1"=>'<label class="label label-primary">'.$senten['colegios'].'</label>',
					"2"=>'<div class="btn-group">
							<a title="Editar nombre municipio" data-toggle="tooltip"  data-placement="right" class="btn btn-sm btn-warning" onclick="editar_municipio('.$registros['id'].')"><i class="fa fa-edit"></i></a>
							<a title="Eliminar municipio" data-toggle="tooltip"  data-placement="right" class="btn btn-sm btn-danger" onclick="delete_municipio('.$registros['id'].')"><i class="fa fa-trash"></i></a>
							<a title="Registrar colegio" data-toggle="tooltip"  data-placement="right" class="btn btn-sm btn-success" onclick="registrar_colegio('.$registros['id'].')"><i class="fa fa-plus"></i></a>
							<a title="Ver colegios municipio" data-toggle="tooltip"  data-placement="right" class="btn btn-sm btn-info" onclick="ver_colegios('.$registros['id'].','.$senten['colegios'].')"><i class="fa fa-eye"></i></a>
						  </div>	
						'
            );
        }
        $result = array(
			"sEcho"=>1, //Información para el datatble
			"iTotalRecords"=>count($data),
			"iTotalDisplayRecords"=>count($data),
			"aaData"=>$data
		);

        echo json_encode($result);
        
	}

	public function consultaMunicipio($id)
	{
		global $mbd;
		$sentencia = $mbd->prepare('SELECT id,nombre FROM '.self::MUNICIPIOS.' WHERE id=:id');
		$sentencia->bindParam(":id", $id);
		$sentencia->execute();
		$datos = $sentencia->fetchAll();
		
		echo json_encode ($datos);

	}

	public function editarMunicipio($id,$nombre)
	{
		global $mbd;
		$sentencia = $mbd->prepare('UPDATE '.self::MUNICIPIOS.' SET nombre = :nombre WHERE id=:id');
		$sentencia->bindParam(":nombre", $nombre);
		$sentencia->bindParam(":id", $id);
		if($sentencia->execute()){
			$data['status'] = 'ok';				//estado con ok
			$data['result'] = 'Registro guardado con exito';
			
		}else{
			$data['status'] = 'err';				//estado con ok
            $data['result'] = 'No se guardo el registro';
		}

		$mbd = null;
		echo json_encode($data);
	}

	public function deleteMunicipio($id)
	{
		global $mbd;
		$sentencia = $mbd->prepare('DELETE FROM '.self::MUNICIPIOS.' WHERE id=:id');
		$sentencia->bindParam(":id", $id);
		if($sentencia->execute()){
			$sentencia = $mbd->prepare('DELETE FROM '.self::COLEGIOARTICULACION.' WHERE id_municipio=:id');
			$sentencia->bindParam(":id", $id);
			$data['status'] = 'ok';				//estado con ok
			$data['result'] = 'Registro guardado con exito';
			
		}else{
			$data['status'] = 'err';				//estado con ok
            $data['result'] = 'No se guardo el registro';
		}

		$mbd = null;
		echo json_encode($data);
	}

	public function aggColegio($id_muni,$nombre,$valor)
	{
		global $mbd;
		$sentencia = $mbd->prepare('INSERT INTO '.self::COLEGIOARTICULACION.' (id_municipio,nombre,tarifa) VALUES (:id_muni, :nombre, :valor)');
		$sentencia->bindParam(":nombre", $nombre);
		$sentencia->bindParam(":id_muni", $id_muni);
		$sentencia->bindParam(":valor", $valor);
		if($sentencia->execute()){
			$data['status'] = 'ok';				//estado con ok
			$data['result'] = 'Registro guardado con exito';
			
		}else{
			$data['status'] = 'err';				//estado con ok
            $data['result'] = 'No se guardo el registro';
		}

		$mbd = null;
		echo json_encode($data);
	}
	public function listarColegios($id)
	{
		global $mbd;
		$sentencia = $mbd->prepare('SELECT * FROM '.self::COLEGIOARTICULACION.' WHERE id_municipio = :id');
		$sentencia->bindParam(":id", $id);
        $sentencia->execute();
        
        while ($registros = $sentencia->fetch(PDO::FETCH_ASSOC)) {

            $data[]=array(
					"0"=>$registros['nombre'],
					"1"=>$registros['tarifa'],
					"2"=>'<div class="btn-group">
							<a title="Editar información colegio" data-toggle="tooltip"  data-placement="left" class="btn btn-sm btn-warning" onclick="abrir_editar_colegio('.$registros["id"].')"><i class="fa fa-edit"></i></a>
							<a title="Eliminar colegio" data-toggle="tooltip"  data-placement="right" class="btn btn-sm btn-danger" onclick="eliminar_colegio('.$registros["id"].','.$registros["id_municipio"].')"><i class="fa fa-trash"></i></a>
						  </div>'
					);
        }
        $results = array(
				"sEcho"=>1, //Información para el datatables
				"iTotalRecords"=>count($data), //enviamos el total registros al datatable
				"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
				"aaData"=>$data);

        echo json_encode($results);
	}

	public function consultarColegios($id)
	{
		global $mbd;
		$sentencia = $mbd->prepare('SELECT * FROM '.self::COLEGIOARTICULACION.' WHERE id=:id');
		$sentencia->bindParam(":id", $id);
		$sentencia->execute();
		$datos = $sentencia->fetchAll();
		
		echo json_encode ($datos);

	}

	public function editarColegios($id,$nombre,$tarifa)
	{
		global $mbd;
		$sentencia = $mbd->prepare('UPDATE '.self::COLEGIOARTICULACION.' SET nombre = :nombre, tarifa = :tari WHERE id=:id');
		$sentencia->bindParam(":nombre", $nombre);
		$sentencia->bindParam(":tari", $tarifa);
		$sentencia->bindParam(":id", $id);
		if($sentencia->execute()){
			$data['status'] = 'ok';				//estado con ok
			$data['result'] = 'Registro guardado con exito';
			
		}else{
			$data['status'] = 'err';				//estado con ok
            $data['result'] = 'No se guardo el registro';
		}

		$mbd = null;
		echo json_encode($data);
	}

	public function aggMunicipio($nombre)
	{
		global $mbd;
		$sentencia = $mbd->prepare('INSERT INTO '.self::MUNICIPIOS.' (nombre) VALUES (:nom)');
		$sentencia->bindParam(":nom", $nombre);
		if($sentencia->execute()){
			$data['status'] = 'ok';				//estado con ok
			$data['result'] = 'Registro guardado con exito';
			
		}else{
			$data['status'] = 'err';				//estado con ok
            $data['result'] = 'No se guardo el registro';
		}

		$mbd = null;
		echo json_encode($data);
	}

	public function deletColegio($id)
	{
		global $mbd;
		$sentencia = $mbd->prepare('DELETE FROM '.self::COLEGIOARTICULACION.' WHERE id=:id');
		$sentencia->bindParam(":id", $id);
		if($sentencia->execute()){
			$data['status'] = 'ok';				//estado con ok
			$data['result'] = 'Registro guardado con exito';
			
		}else{
			$data['status'] = 'err';				//estado con ok
            $data['result'] = 'No se guardo el registro';
		}

		$mbd = null;
		echo json_encode($data);
	}
    
}




?>
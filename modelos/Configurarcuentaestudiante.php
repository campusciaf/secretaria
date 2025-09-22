<?php

//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";


class Configuracion
{

    public function listarDatos()
    {
        global $mbd;
        $id = $_SESSION["id_usuario"];
        $sentencia = $mbd->prepare(" SELECT * FROM credencial_estudiante INNER JOIN estudiantes_datos_personales ON credencial_estudiante.id_credencial = estudiantes_datos_personales.id_credencial WHERE credencial_estudiante.id_credencial = :id ");
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        return $registro;
    }

    public function cambiarContra($anterior, $nueva)
    {
        $id=$_SESSION['id_usuario'];
        global $mbd;
        $nueva = md5($nueva);
        $sentencia = $mbd->prepare(" SELECT credencial_clave FROM `credencial_estudiante` WHERE `id_credencial` = $id ");
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        if ($registro['credencial_clave'] == md5($anterior)) {
            $sql = "UPDATE `credencial_estudiante` SET `credencial_clave` = :clave WHERE `id_credencial` = $id ";
            $sentencia2= $mbd->prepare($sql);
            $sentencia2->bindParam(":clave", $nueva);
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

    public function editarDatospersonales($direccion, $celular, $grupo_etnico, $nombre_etnico, $estrato, $tipo_sangre, $instagram, $email, $whatsapp, $facebook, $twiter, $linkedin, $barrio, $depar_residencia, $muni_residencia)
    {
        //  $sql="UPDATE credencial_estudiante AS uno INNER JOIN estudiantes_datos_personales AS dos ON uno.id_credencial = dos.id_credencial SET dos.direccion = :direcci WHERE uno.id_credencial = :id";
        $id=$_SESSION["id_usuario"];
       $sql="UPDATE credencial_estudiante ce INNER JOIN estudiantes_datos_personales edp ON ce.id_credencial=edp.id_credencial set ce.status_update='1', edp.grupo_etnico='$grupo_etnico', edp.nombre_etnico='$nombre_etnico', edp.depar_residencia='$depar_residencia',edp.muni_residencia='$muni_residencia',edp.direccion='$direccion',edp.barrio='$barrio', edp.estrato='$estrato', edp.celular='$celular', edp.whatsapp='$whatsapp',edp.facebook='$facebook', edp.instagram='$instagram', edp.twiter='$twiter', edp.linkedin='$linkedin', edp.email='$email', edp.tipo_sangre='$tipo_sangre' WHERE ce.id_credencial=$id";

		global $mbd;
		$consulta = $mbd->prepare($sql);
        // $consulta->bindParam(":grupo_etnico", $grupo_etnico);
        // $consulta->bindParam(":nombre_etnico", $nombre_etnico);
        // $consulta->bindParam(":depar_residencia", $depar_residencia);
        // $consulta->bindParam(":muni_residencia", $muni_residencia);
        // $consulta->bindParam(":direccion", $direccion);
        // $consulta->bindParam(":barrio", $barrio);
        // $consulta->bindParam(":estrato", $estrato);
        // $consulta->bindParam(":celular", $celular);
        // $consulta->bindParam(":instagram", $instagram);
        // $consulta->bindParam(":email", $email);
        // $consulta->bindParam(":tipo_sangre", $tipo_sangre);
        // $consulta->bindParam(":id", $_SESSION["id_usuario"]);

		return $consulta->execute();

    }



    
	//Implementar un método para mirar si el punto esta otorgado
	public function validarpuntos($evento,$periodo){	
        $id=$_SESSION["id_usuario"];
		$sql=" SELECT * FROM puntos WHERE id_credencial= :id and punto_nombre= :evento and punto_periodo= :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id", $id);
		$consulta->bindParam(":evento", $evento);
        $consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;	
	}

    //Insertar punto en tabla puntos
	public function insertarPunto($id_credencial,$punto_nombre,$puntos_cantidad,$punto_fecha,$punto_hora,$punto_periodo)
	{
		$sql="INSERT INTO puntos (`id_credencial`, `punto_nombre`, `puntos_cantidad`, `punto_fecha`, `punto_hora`, `punto_periodo`) VALUES ('$id_credencial','$punto_nombre','$puntos_cantidad','$punto_fecha','$punto_hora','$punto_periodo')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

    //Implementar un método para ver los puntos del estudiante
	public function verpuntos(){	
        $id=$_SESSION["id_usuario"];
		$sql=" SELECT * FROM credencial_estudiante WHERE id_credencial= :id";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id", $id);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;	
	}

	//Implementamos un método para actualizar el valor de los puntos
	public function actulizarValor($puntos)
	{
        $id=$_SESSION["id_usuario"];
		$sql="UPDATE credencial_estudiante SET puntos= :puntos WHERE id_credencial= :id ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id", $id);
        $consulta->bindParam(":puntos", $puntos);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
	}


    public function convertir_fecha($date)
    {
        $dia    = explode("-", $date, 3);
        $year   = $dia[0];
        $month  = (string)(int)$dia[1];
        $day    = (string)(int)$dia[2];

        $dias       = array("domingo", "lunes", "martes", "mi&eacute;rcoles", "jueves", "viernes", "s&aacute;bado");
        $tomadia    = $dias[intval((date("w", mktime(0, 0, 0, $month, $day, $year))))];
        $meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
        return $day . " de " . $meses[$month] . " de " . $year;
    }



    public function mostarDepar()
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `departamentos` ");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($registro);
    }

    public function mostarMuni($depa)
    {
        global $mbd;
    
        // Preparar y ejecutar la consulta para buscar el departamento
        $sentencia = $mbd->prepare("SELECT * FROM `departamentos` WHERE `departamento` LIKE :depa");
        $sentencia->bindParam(":depa", $depa);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
    
        // Validar si se encontró el departamento
        if (!$registro) {
            // Enviar una respuesta adecuada si no se encuentra el departamento
            echo json_encode([
                "error" => "No se encontró el departamento especificado.",
            ]);
            return; // Salir de la función
        }
    
        // Extraer el ID del departamento
        $id = $registro['id_departamento'];
    
        // Preparar y ejecutar la consulta para buscar los municipios
        $sentencia2 = $mbd->prepare("SELECT * FROM `municipios` WHERE `departamento_id` = :id");
        $sentencia2->bindParam(":id", $id);
        $sentencia2->execute();
        $registro2 = $sentencia2->fetchAll(PDO::FETCH_ASSOC);
    
        // Enviar los resultados como JSON
        echo json_encode($registro2);
    }
    
    public function id_mu_na($depa, $muni)
    {
        global $mbd;

        $sentencia = $mbd->prepare(" SELECT * FROM `departamentos` WHERE `departamento` LIKE :depa ");
        $sentencia->bindParam(":depa", $depa);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        $id = $registro['id_departamento'];

        $sentencia2 = $mbd->prepare(" SELECT * FROM `municipios` WHERE `municipio` = :muni AND departamento_id = :depa ");
        $sentencia2->bindParam(":muni", $muni);
        $sentencia2->bindParam(":depa", $id);
        $sentencia2->execute();
        $registro2 = $sentencia2->fetch(PDO::FETCH_ASSOC);

        return $registro2['cod_divipola'];
    }

    public function tiposangre()
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `tipo_sangre` ");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($registro);
    }

    public function consultaestado()
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT `status_update` FROM `credencial_estudiante` WHERE `id_credencial` = :id ");
        $sentencia->bindParam(":id", $_SESSION['id_usuario']);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        echo json_encode($registro);
    }
    function base64_to_jpeg($base64_string, $output_file){
        // open the output file for writing
        $ifp = fopen($output_file, 'wb');
        // split the string on commas
        $data = explode(',', $base64_string);
        // we could add validation here with ensuring count( $data ) > 1
        fwrite($ifp, base64_decode($data[1]));
        // clean up the file resource
        fclose($ifp);
        return $output_file;
    }

    
    // Implementamos una función para cargar los edatos del estudiant
    public function listar($id_credencial){

        $sql = "SELECT * FROM carseresoriginales cso INNER JOIN estudiantes_datos_personales edp ON cso.id_credencial=edp.id_credencial WHERE cso.id_credencial= :id_credencial";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function editarDatos($id_credencial,$p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8,$p9,$p10,$p11,$p12,$p13,$p14,$p15,$p16,$p17,$p18,$fecha)
    {
       
        $sql=" UPDATE `carseresoriginales` SET
		 `p1`='$p1',`p2`='$p2',`p3`='$p3',`p4`='$p4',`p5`='$p5',`p6`='$p6',`p7`='$p7',`p8`='$p8',`p9`='$p9',`p10`='$p10',`p11`='$p11',`p12`='$p12',`p13`='$p13',`p14`='$p14',`p15`='$p15',`p16`='$p16',`p17`='$p17',`p18`='$p18',

		 `updatedata`='$fecha', `estado`='0'

		 WHERE `id_credencial` = '$id_credencial'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
		return $consulta;
        

    }

    
    // Implementamos una función para cargar los edatos del estudiant
    public function listar3($id_credencial){

        $sql = "SELECT * FROM carempresas cso INNER JOIN estudiantes_datos_personales edp ON cso.id_credencial=edp.id_credencial WHERE cso.id_credencial= :id_credencial";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function editarDatos3($id_credencial,$p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8,$p9,$p10,$p11,$p12,$p13,$p14,$p15,$p16,$p17,$p18,$p19,$fecha)
    {
       
       $sql=" UPDATE `carempresas` SET
		 `ep1`='$p1',`ep2`='$p2',`ep3`='$p3',`ep4`='$p4',`ep5`='$p5',`ep6`='$p6',`ep7`='$p7',`ep8`='$p8',`ep9`='$p9',`ep10`='$p10',
         `ep11`='$p11',`ep12`='$p12',`ep13`='$p13',`ep14`='$p14',`ep15`='$p15',`ep16`='$p16',`ep17`='$p17',`ep18`='$p18',`ep19`='$p19',

		 `updatedata`='$fecha', `estado`='0'

		 WHERE `id_credencial` = '$id_credencial'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
		return $consulta;
        

    }

    // Implementamos una función para cargar los edatos del estudiant
    public function listar4($id_credencial){

        $sql = "SELECT * FROM carconfiamos cso INNER JOIN estudiantes_datos_personales edp ON cso.id_credencial=edp.id_credencial WHERE cso.id_credencial= :id_credencial";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function editarDatos4($id_credencial,$p1,$p2,$p3,$p4,$p5,$p6,$fecha)
    {
        
        $sql=" UPDATE `carconfiamos` SET
            `cop1`='$p1',`cop2`='$p2',`cop3`='$p3',`cop4`='$p4',`cop5`='$p5',`cop6`='$p6',

            `updatedata`='$fecha', `estado`='0'

            WHERE `id_credencial` = '$id_credencial'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        return $consulta;
        
    }

    // Implementamos una función para cargar los edatos del estudiant
    public function listar5($id_credencial){

        $sql = "SELECT * FROM carexperiencia cso INNER JOIN estudiantes_datos_personales edp ON cso.id_credencial=edp.id_credencial WHERE cso.id_credencial= :id_credencial";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function editarDatos5($id_credencial,$p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8,$p9,$p10,$fecha)
    {
        $sql=" UPDATE `carexperiencia` SET
            `eap1`='$p1',`eap2`='$p2',`eap3`='$p3',`eap4`='$p4',`eap5`='$p5',`eap6`='$p6',`eap7`='$p7',`eap8`='$p8',`eap9`='$p9',
            `eap10`='$p10',

            `updatedata`='$fecha', `estado`='0'

            WHERE `id_credencial` = '$id_credencial'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        return $consulta;

    }

        // Implementamos una función para cargar los edatos del estudiant
        public function listar6($id_credencial){

            $sql = "SELECT * FROM carbienestar cso INNER JOIN estudiantes_datos_personales edp ON cso.id_credencial=edp.id_credencial WHERE cso.id_credencial= :id_credencial";
            global $mbd;
            $consulta = $mbd->prepare($sql);
            $consulta->bindParam(":id_credencial", $id_credencial);
            $consulta->execute();
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        }
    
	public function editarDatos6($id_credencial,$p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8,$p9,$p10,$p11,$p12,$p13,$p14,$p15,$p16,$p17,$p18,$p19,$p20,$p21,$p22,$p23,$fecha)
    {
       
       $sql=" UPDATE `carbienestar` SET
		 `bp1`='$p1',`bp2`='$p2',`bp3`='$p3',`bp4`='$p4',`bp5`='$p5',`bp6`='$p6',`bp7`='$p7',`bp8`='$p8',`bp9`='$p9',`bp10`='$p10',
         `bp11`='$p11',`bp12`='$p12',`bp13`='$p13',`bp14`='$p14',`bp15`='$p15',`bp16`='$p16',`bp17`='$p17',`bp18`='$p18',`bp19`='$p19',
        `bp20`='$p20',`bp21`='$p21',`bp22`='$p22',`bp23`='$p23',
		 `updatedata`='$fecha', `estado`='0'

		 WHERE `id_credencial` = '$id_credencial'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
		return $consulta;
    }


    
}

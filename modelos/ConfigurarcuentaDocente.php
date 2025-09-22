<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
class Configuracion
{
    public function listarDatos()
    {
        global $mbd;
        $id = intval($_SESSION["id_usuario"]);
        $sentencia = $mbd->prepare(" SELECT * FROM `docente` WHERE `id_usuario` = :id ");
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    // Implementamos una función para cargar los edatos del docente
    public function listar()
    {
        $id_docente = intval($_SESSION["id_usuario"]);
        $sql = "SELECT * FROM caracterizaciondocente WHERE id_docente= :id_docente";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_docente", $id_docente);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function cambiarContra($id, $anterior, $nueva)
    {
        global $mbd;
        $nueva = md5($nueva);
        $sentencia = $mbd->prepare(" SELECT * FROM `docente` WHERE `id_usuario` = :id ");
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        if ($registro['usuario_clave'] == md5($anterior)) {
            $sentencia2 = $mbd->prepare(" UPDATE `docente` SET `usuario_clave` = :clave WHERE `id_usuario` = :id ");
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
    public function editarDatospersonales($nombre1, $nombre2, $apellido, $apellido2, $fecha_n, $depar_naci, $ciudad_naci, $tipo_sangre, $dirrecion, $barrio, $celular, $fecha)
    {
        global $mbd;
        $id = intval($_SESSION["id_usuario"]);
        $sentencia = $mbd->prepare(" UPDATE `docente` SET `usuario_nombre`=:nombre,`usuario_nombre_2`=:nombre2,`usuario_apellido`=:apellido,`usuario_apellido_2`=:apellido2,`usuario_direccion`=:direcci,`usuario_barrio`=:barrio,`usuario_celular`=:celular,`usuario_fecha_nacimiento`=:fech_na,`usuario_tipo_sangre`=:tipo_san, usuario_departamento_res = :depa_naci, usuario_municipio = :muni_naci, fecha_actualizacion = :fecha WHERE `id_usuario` = :id ");
        $sentencia->bindParam(":nombre", $nombre1);
        $sentencia->bindParam(":nombre2", $nombre2);
        $sentencia->bindParam(":apellido", $apellido);
        $sentencia->bindParam(":apellido2", $apellido2);
        $sentencia->bindParam(":direcci", $dirrecion);
        $sentencia->bindParam(":barrio", $barrio);
        $sentencia->bindParam(":celular", $celular);
        $sentencia->bindParam(":fech_na", $fecha_n);
        $sentencia->bindParam(":tipo_san", $tipo_sangre);
        $sentencia->bindParam(":depa_naci", $depar_naci);
        $sentencia->bindParam(":muni_naci", $ciudad_naci);
        $sentencia->bindParam(":fecha", $fecha);
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
        return $sentencia;
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
    public function validar($validar)
    {
        $contra = md5($validar);
        $id = intval($_SESSION["id_usuario"]);
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT `usuario_clave` FROM `docente` WHERE `id_usuario` = :id ");
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        if ($registro['usuario_clave'] == $contra) {
            $data['status'] = "ok";
        } else {
            $data['status'] = "Error, contraseña incorrecta";
        }
        echo json_encode($data);
    }
    function base64_to_jpeg($base64_string, $output_file)
    {
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
    function actualizarCampoBD($campo, $id_usuario)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" UPDATE `docente` SET `usuario_imagen` = :campo WHERE `id_usuario` = :id_usuario ");
        $sentencia->bindParam(":campo", $campo);
        $sentencia->bindParam(":id_usuario", $id_usuario);
        if ($sentencia->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function editarDatos( $p1, $p2, $p3, $p4, $p5, $p6, $p7, $p8, $p9, $p10, $p11, $p12, $p13, $p14, $p15, $p16, $p17, $p18, $p19, $p20, $p21, $p22, $p23, $p24, $p25, $p26, $p27, $p28, $p29, $p30, $p31, $p32, $p33, $p34, $p35, $p36, $p37, $p38, $p39, $p40, $p41, $p42, $p43, $p44, $p45, $p46, $p47, $p48, $p49, $p50, $fecha) {
        $id_docente = intval($_SESSION["id_usuario"]);
        // Lista de preguntas que deben ser NULL si están vacías
        $preguntasNullables = [ 'p1', 'p2', 'p3', 'p4', 'p7', 'p8', 'p10', 'p11', 'p13', 'p14', 'p16', 'p18', 'p19', 'p20', 'p21', 'p27', 'p28', 'p30', 'p31', 'p32', 'p33', 'p34', 'p35', 'p36', 'p37', 'p38', 'p40', 'p41', 'p42', 'p47', 'p48', 'p50'
        ];
        // Arreglo de todos los parámetros para procesarlos dinámicamente
        $params = compact( 'p1', 'p2', 'p3', 'p4', 'p5', 'p6', 'p7', 'p8', 'p9', 'p10', 'p11', 'p12', 'p13', 'p14', 'p15', 'p16', 'p17', 'p18', 'p19', 'p20', 'p21', 'p22', 'p23', 'p24', 'p25', 'p26', 'p27', 'p28', 'p29', 'p30', 'p31', 'p32', 'p33', 'p34', 'p35', 'p36', 'p37', 'p38', 'p39', 'p40', 'p41', 'p42', 'p43', 'p44', 'p45', 'p46', 'p47', 'p48', 'p49', 'p50');
        // Procesar las preguntas para reemplazar valores vacíos con NULL
        foreach ($preguntasNullables as $pregunta) {
            if (isset($params[$pregunta]) && trim($params[$pregunta]) === '') {
                $params[$pregunta] = null; // Reemplazar vacío por NULL
            }
        }
        // Construir la consulta con los parámetros procesados
        $sql = "UPDATE `caracterizaciondocente` SET 
                `p1` = :p1, `p2` = :p2, `p3` = :p3, `p4` = :p4, `p5` = :p5, `p6` = :p6, 
                `p7` = :p7, `p8` = :p8, `p9` = :p9, `p10` = :p10, `p11` = :p11, `p12` = :p12, 
                `p13` = :p13, `p14` = :p14, `p15` = :p15, `p16` = :p16, `p17` = :p17, 
                `p18` = :p18, `p19` = :p19, `p20` = :p20, `p21` = :p21, `p22` = :p22, 
                `p23` = :p23, `p24` = :p24, `p25` = :p25, `p26` = :p26, `p27` = :p27, 
                `p28` = :p28, `p29` = :p29, `p30` = :p30, `p31` = :p31, `p32` = :p32, 
                `p33` = :p33, `p34` = :p34, `p35` = :p35, `p36` = :p36, `p37` = :p37, 
                `p38` = :p38, `p39` = :p39, `p40` = :p40, `p41` = :p41, `p42` = :p42, 
                `p43` = :p43, `p44` = :p44, `p45` = :p45, `p46` = :p46, `p47` = :p47, 
                `p48` = :p48, `p49` = :p49, `p50` = :p50, `updatedata` = :fecha 
                WHERE `id_docente` = :id_docente";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $params['id_docente'] = $id_docente;
        $params['fecha'] = $fecha;
        $consulta->execute($params);
        return $consulta;
    }
    //Implementar un método para mirar si el punto esta otorgado
    public function validarpuntos($evento, $periodo)
    {
        $id = $_SESSION["id_usuario"];
        $sql = " SELECT * FROM puntos_docente WHERE id_usuario= :id and punto_nombre= :evento and punto_periodo= :periodo";
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
    public function insertarPunto($punto_nombre, $puntos_cantidad, $punto_fecha, $punto_hora, $punto_periodo)
    {
        $id_usuario = $_SESSION["id_usuario"];
        $sql = "INSERT INTO puntos_docente (`id_usuario`, `punto_nombre`, `puntos_cantidad`, `punto_fecha`, `punto_hora`, `punto_periodo`) VALUES ('$id_usuario','$punto_nombre','$puntos_cantidad','$punto_fecha','$punto_hora','$punto_periodo')";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        return $consulta->execute();
    }
    //Implementar un método para ver los puntos del estudiante
    public function verpuntos()
    {
        $id = $_SESSION["id_usuario"];
        $sql = " SELECT * FROM docente WHERE id_usuario= :id";
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
        $id = $_SESSION["id_usuario"];
        $sql = "UPDATE docente SET puntos= :puntos WHERE id_usuario= :id ";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id", $id);
        $consulta->bindParam(":puntos", $puntos);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
}

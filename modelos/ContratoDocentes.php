<?php
require "../config/Conexion.php";
class ContratoDocentes
{
    public function __construct() {}
    public function BuscarDocenteContratado($id_docente_contrato, $periodo)
    {
        global $mbd;
        $sql = "SELECT * FROM `contrato_docente` WHERE `id_docente_contrato` = :id_docente_contrato AND periodo = :periodo";
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_docente_contrato", $id_docente_contrato, PDO::PARAM_STR);
        $consulta->bindParam(":periodo", $periodo, PDO::PARAM_STR);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }
    public function Nombre_Usuario_Creo_Contrato($id_usuario)
    {
        global $mbd;
        $sql = "SELECT * FROM `usuario` WHERE `id_usuario` = :id_usuario";
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario, PDO::PARAM_STR);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }
    public function Buscar_Docente($usuario_identificacion)
    {
        global $mbd;
        $sql = "SELECT * FROM `docente` WHERE `usuario_identificacion` = :usuario_identificacion";
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":usuario_identificacion", $usuario_identificacion, PDO::PARAM_STR);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }
    function numero_a_letras($numero)
    {
        $numero = (int)$numero;
        $unidades = ["", "uno", "dos", "tres", "cuatro", "cinco", "seis", "siete", "ocho", "nueve"];
        $decenas = ["", "diez", "veinte", "treinta", "cuarenta", "cincuenta", "sesenta", "setenta", "ochenta", "noventa"];
        $especiales = ["diez", "once", "doce", "trece", "catorce", "quince", "dieciséis", "diecisiete", "dieciocho", "diecinueve"];
        $centenas = ["", "ciento", "doscientos", "trescientos", "cuatrocientos", "quinientos", "seiscientos", "setecientos", "ochocientos", "novecientos"];
        if ($numero == 0) return "cero";
        $texto = "";
        // Manejo de miles de millones
        if ($numero >= 1000000000) {
            $texto .= self::numero_a_letras((int)($numero / 1000000000)) . " mil millones ";
            $numero %= 1000000000;
        }
        // Manejo de millones
        if ($numero >= 1000000) {
            $millones = (int)($numero / 1000000);
            if ($millones == 1) {
                $texto .= "un millón ";
            } else {
                $texto .= self::numero_a_letras($millones) . " millones ";
            }
            $numero %= 1000000;
        }
        // Manejo de miles
        if ($numero >= 1000) {
            $miles = (int)($numero / 1000);
            if ($miles == 1) {
                $texto .= "mil ";
            } else {
                $texto .= self::numero_a_letras($miles) . " mil ";
            }
            $numero %= 1000;
        }
        // Manejo de centenas
        if ($numero >= 100) {
            if ($numero == 100) {
                $texto .= "cien ";
            } else {
                $texto .= $centenas[(int)($numero / 100)] . " ";
            }
            $numero %= 100;
        }
        // Manejo especial de números entre 21 y 29 con tildes
        if ($numero >= 21 && $numero <= 29) {
            $veinti_especiales =
                [1 => "veintiún", 2 => "veintidós", 3 => "veintitrés", 4 => "veinticuatro", 5 => "veinticinco", 6 => "veintiséis", 7 => "veintisiete", 8 => "veintiocho", 9 => "veintinueve"];
            $texto .= $veinti_especiales[$numero % 10] ?? "veinti" . $unidades[$numero % 10];
        }
        // Manejo de decenas
        elseif ($numero >= 20) {
            $texto .= $decenas[(int)($numero / 10)];
            if ($numero % 10 > 0) {
                $texto .= " y " . $unidades[$numero % 10];
            }
        }
        // Manejo de números entre 10 y 19 con tildes
        elseif ($numero >= 10) {
            $texto .= $especiales[$numero - 10];
        }
        // Unidades
        else {
            $texto .= $unidades[$numero];
        }
        return trim($texto);
    }
    function convertirAnioALetrasSimple($anio)
    {
        $años_en_texto = [
            '2023' => 'dos mil veintitrés',
            '2024' => 'dos mil veinticuatro',
            '2025' => 'dos mil veinticinco',
            '2026' => 'dos mil veintiséis',
            '2027' => 'dos mil veintisiete',
            '2028' => 'dos mil veintiocho',
            '2029' => 'dos mil veintinueve',
            '2030' => 'dos mil treinta'
        ];
        return isset($años_en_texto[$anio]) ? $años_en_texto[$anio] : 'Año no definido';
    }
}

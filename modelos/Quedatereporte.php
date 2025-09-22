<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
class Reporte
{
    public function categorias()
    {
        global $mbd;
        $sentecia = $mbd->prepare(" SELECT * FROM `categoria_casos` ");
        $sentecia->execute();
        return $sentecia->fetchAll(PDO::FETCH_ASSOC);
    }
    // public function programas()
    // {
    //     global $mbd;
    //     $sentecia = $mbd->prepare(" SELECT * FROM `programa_ac` WHERE estado = 1 ORDER BY `programa_ac`.`nombre` ASC ");
    //     $sentecia->execute();
    //     return $sentecia->fetchAll(PDO::FETCH_ASSOC);
    // }
    public function programas()
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `programa_ac` WHERE `estado` = 1 AND `nombre` IN ('Nivel 1 - Técnica profesional en programación de software','Nivel 1 - Técnico Profesional en Logística de Producción','Nivel 1 - Técnico Profesional en Procesos de Seguridad y Salud en el Trabajo','Nivel 1 - Técnico Profesional en Procesos Empresariales','Nivel 2 - Tecnología en Gestión de la Seguridad y Salud en el Trabajo','Nivel 2 - Tecnología en Gestión Industrial','Nivel 2 - Tecnología en Gestión y auditoria administrativa','Nivel 2- Tecnología en desarrollo de software','Nivel 3 - Administración de empresas','Nivel 3 - Profesional en ingeniería de software','Nivel 3 - Profesional en Ingeniería Industrial','Nivel 3 - Profesional en Seguridad y Salud en el Trabajo','Profesional en Administración de Empresas','Profesional en Contaduría','PROFESIONAL EN CONTADURIA PUBLICA INTEP 2021','Técnica Profesional en Gestión Empresarial','Técnica Profesional en Gestión Financiera','Técnico Laboral en Mecánica y Mantenimiento de Motocicletas','Técnico Laboral por Competencias en Administrativo en Salud','Técnico Laboral por Competencias en Asistencia en Cuidado al Adulto Mayor','Técnico laboral por competencias en auxiliar de veterinaria y cuidado de mascotas','Técnico laboral por competencias en auxiliar en enfermería','Técnico laboral por competencias en mecánica de motocicletas','Técnico profesional en operaciones contables y financieras','Tecnología en Gestión Contable INTEP','TECNOLOGIA EN GESTION CONTABLE INTEP 2021','TECNOLOGIA EN GESTION CONTABLE INTEP 2025')  ORDER BY `nombre` ASC ");
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }


    public function buscar($categoria, $programa, $mes)
    {
        global $mbd;
        // $periodo = $_SESSION['periodo_actual'];
        $ano = date('Y');
        $sentencia = $mbd->prepare(" SELECT * FROM `casos` as uno INNER JOIN estudiantes as dos ON uno.id_estudiante = dos.id_credencial WHERE uno.categoria_caso = :categoria AND dos.id_programa_ac = :programa AND uno.created_at LIKE '$ano-$mes-%' AND uno.caso_estado = 'Activo'");

        $sentencia->bindParam(":categoria", $categoria);
        // $sentencia->bindParam(":periodo", $periodo);
        $sentencia->bindParam(":programa", $programa);
        // $sentencia->bindParam(":mes",$mes);
        // $sentencia->bindParam(":ano",$ano);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    //     public function buscar($categoria, $programa, $mes)
    // {
    //     global $mbd;
    //     $periodo = $_SESSION['periodo_actual'];
    //     $ano = date('Y');

    //     $sentencia = $mbd->prepare("
    //         SELECT * 
    //         FROM `casos` as uno 
    //         WHERE uno.categoria_caso = :categoria 
    //         AND uno.created_at LIKE :fecha 
    //         AND uno.id_estudiante IN (
    //             SELECT id_credencial 
    //             FROM estudiantes 
    //             WHERE id_programa_ac = :programa AND periodo_activo = :periodo
    //         )
    //     ");

    //     $fecha = "$ano-$mes-%";
    //     $sentencia->bindParam(":categoria", $categoria);
    //     $sentencia->bindParam(":fecha", $fecha);
    //     $sentencia->bindParam(":programa", $programa);
    //     $sentencia->bindParam(":periodo", $periodo);

    //     $sentencia->execute();
    //     return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    // }

    public function buscar2($categoria, $mes)
    {
        global $mbd;
        // $periodo = $_SESSION['periodo_actual'];
        $ano = date('Y');
        // $sentencia = $mbd->prepare(" SELECT * FROM `casos` as uno WHERE uno.categoria_caso = :categoria AND uno.created_at LIKE '$ano-$mes-%' AND caso_estado = 'Activo' ");
        $sentencia = $mbd->prepare(" SELECT * FROM `casos` AS uno INNER JOIN `estudiantes` AS dos ON uno.id_estudiante = dos.id_credencial WHERE uno.categoria_caso = :categoria AND uno.created_at LIKE '$ano-$mes-%' AND uno.caso_estado = 'Activo'AND dos.fo_programa IN ('Nivel 1 - Técnica profesional en programación de software','Nivel 1 - Técnico Profesional en Logística de Producción','Nivel 1 - Técnico Profesional en Procesos de Seguridad y Salud en el Trabajo','Nivel 1 - Técnico Profesional en Procesos Empresariales','Nivel 2 - Tecnología en Gestión de la Seguridad y Salud en el Trabajo','Nivel 2 - Tecnología en Gestión Industrial','Nivel 2 - Tecnología en Gestión y auditoria administrativa','Nivel 2- Tecnología en desarrollo de software','Nivel 3 - Administración de empresas','Nivel 3 - Profesional en ingeniería de software','Nivel 3 - Profesional en Ingeniería Industrial','Nivel 3 - Profesional en Seguridad y Salud en el Trabajo','Profesional en Administración de Empresas','Profesional en Contaduría','PROFESIONAL EN CONTADURIA PUBLICA INTEP 2021','Técnica Profesional en Gestión Empresarial','Técnica Profesional en Gestión Financiera','Técnico Laboral en Mecánica y Mantenimiento de Motocicletas','Técnico Laboral por Competencias en Administrativo en Salud','Técnico Laboral por Competencias en Asistencia en Cuidado al Adulto Mayor','Técnico laboral por competencias en auxiliar de veterinaria y cuidado de mascotas','Técnico laboral por competencias en auxiliar en enfermería','Técnico laboral por competencias en mecánica de motocicletas','Técnico profesional en operaciones contables y financieras','Tecnología en Gestión Contable INTEP','TECNOLOGIA EN GESTION CONTABLE INTEP 2021','TECNOLOGIA EN GESTION CONTABLE INTEP 2025');");

        $sentencia->bindParam(":categoria", $categoria);
        // $sentencia->bindParam(":periodo", $periodo);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    public function categorias_cerrados()
    {
        global $mbd;
        $sentecia = $mbd->prepare(" SELECT * FROM `categoria_casos_cerrados` ");
        $sentecia->execute();
        return $sentecia->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscar_cerrados($categoria, $programa, $mes)
    {
        global $mbd;
        // $periodo = $_SESSION['periodo_actual'];
        $ano = date('Y');
        $sentencia = $mbd->prepare(" SELECT * FROM `casos` as uno INNER JOIN estudiantes as dos ON uno.id_estudiante = dos.id_credencial WHERE uno.categoria_caso_cerrado = :categoria  AND dos.id_programa_ac = :programa AND uno.created_at LIKE '$ano-$mes-%' AND caso_estado = 'Cerrado' ");
        // $sentencia = $mbd->prepare(" SELECT * FROM `casos` as uno INNER JOIN estudiantes as dos ON uno.id_estudiante = dos.id_credencial WHERE uno.categoria_caso_cerrado = $categoria AND dos.periodo_activo = $periodo AND dos.id_programa_ac = $programa AND uno.created_at LIKE '$ano-$mes-%' AND caso_estado = 'Cerrado' ");

        $sentencia->bindParam(":categoria", $categoria);
        // $sentencia->bindParam(":periodo", $periodo);
        $sentencia->bindParam(":programa", $programa);
        // $sentencia->bindParam(":mes",$mes);
        // $sentencia->bindParam(":ano",$ano);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    public function buscar2_cerrados($categoria, $mes)
    {
        global $mbd;
        $ano = date('Y');
        // $periodo = $_SESSION['periodo_actual'];
        // $sentencia = $mbd->prepare(" SELECT * FROM `casos` as uno WHERE uno.categoria_caso_cerrado = :categoria AND uno.created_at LIKE '$ano-$mes-%'");
        $sentencia = $mbd->prepare(" SELECT uno.caso_id, uno.caso_asunto, uno.created_at, uno.caso_estado, uno.categoria_caso, CONCAT(dos.credencial_nombre, ' ', dos.credencial_nombre_2, ' ', dos.credencial_apellido, ' ', dos.credencial_apellido_2) AS nombre, tres.fo_programa, tres.jornada_e FROM casos AS uno INNER JOIN credencial_estudiante AS dos ON uno.id_estudiante = dos.id_credencial INNER JOIN estudiantes AS tres ON uno.id_estudiante = tres.id_credencial WHERE uno.categoria_caso_cerrado = :categoria AND uno.created_at LIKE '$ano-$mes-%' AND uno.caso_estado = 'Cerrado' AND tres.fo_programa IN ('Nivel 1 - Técnica profesional en programación de software','Nivel 1 - Técnico Profesional en Logística de Producción','Nivel 1 - Técnico Profesional en Procesos de Seguridad y Salud en el Trabajo','Nivel 1 - Técnico Profesional en Procesos Empresariales','Nivel 2 - Tecnología en Gestión de la Seguridad y Salud en el Trabajo','Nivel 2 - Tecnología en Gestión Industrial','Nivel 2 - Tecnología en Gestión y auditoria administrativa','Nivel 2- Tecnología en desarrollo de software','Nivel 3 - Administración de empresas','Nivel 3 - Profesional en ingeniería de software','Nivel 3 - Profesional en Ingeniería Industrial','Nivel 3 - Profesional en Seguridad y Salud en el Trabajo','Profesional en Administración de Empresas','Profesional en Contaduría','PROFESIONAL EN CONTADURIA PUBLICA INTEP 2021','Técnica Profesional en Gestión Empresarial','Técnica Profesional en Gestión Financiera','Técnico Laboral en Mecánica y Mantenimiento de Motocicletas','Técnico Laboral por Competencias en Administrativo en Salud','Técnico Laboral por Competencias en Asistencia en Cuidado al Adulto Mayor','Técnico laboral por competencias en auxiliar de veterinaria y cuidado de mascotas','Técnico laboral por competencias en auxiliar en enfermería','Técnico laboral por competencias en mecánica de motocicletas','Técnico profesional en operaciones contables y financieras','Tecnología en Gestión Contable INTEP','TECNOLOGIA EN GESTION CONTABLE INTEP 2021','TECNOLOGIA EN GESTION CONTABLE INTEP 2025') ORDER BY uno.created_at DESC;");
        // $sentencia->bindParam(":periodo", $periodo);
        $sentencia->bindParam(":categoria", $categoria);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
}

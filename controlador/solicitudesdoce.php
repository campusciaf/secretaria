<?php
require_once "../modelos/Solicitudesdocentes.php";

class Controllsolicitudes
{
    public function listar($otra)
    {
        Solicitudes::listar($otra);
    }
    public function listarClasesSolicitadas($id)
    {
        Solicitudes::listarClasesSolicitadas($id);
    }
    public function respuestaSolicitud($id,$guia)
    {
        Solicitudes::respuestaSolicitud($id,$guia);
    }
}

switch ($_GET['op']) {
    case 'listar':
        $guia = $_GET['pregunta'];
        $obj = new Controllsolicitudes();
        $obj->listar($guia);
        
        break;
    case 'listar_clases_solicitud':
        $id = $_GET['id_solicitud'];
        $obj = new Controllsolicitudes();
        $obj->listarClasesSolicitadas($id);
        break;
    case 'respuesta_solicitud_dir':
        $id = $_POST['id'];
        $guia = $_POST['guia'];
        $obj = new Controllsolicitudes();
        $obj->respuestaSolicitud($id,$guia);
        break;
}


?>
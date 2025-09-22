<?php
require_once "../modelos/SolicitudesAprobadas.php";

class Controllsolicitudes
{
    public function listar()
    {
        SolcitudesAprobadas::listar();
    }
    public function listarPagos($id)
    {
        SolcitudesAprobadas::listarPagos($id);
    }
    public function modificarPagos($id)
    {
        SolcitudesAprobadas::modificarPagos($id);
    }
    public function updatePago($id,$id_soli,$valor,$obser)
    {
        SolcitudesAprobadas::updatePago($id,$id_soli,$valor,$obser);
    }
    public function deletePago($id_pa,$id_sol)
    {
        SolcitudesAprobadas::deletePago($id_pa,$id_sol);
    }
    public function aggPago($id,$valor,$obser)
    {
        SolcitudesAprobadas::aggPago($id,$valor,$obser);
    }
    public function listar_clases_solicitud($id)
    {
        SolcitudesAprobadas::listar_clases_solicitud($id);
    }
    public function prueba($id)
    {
        SolcitudesAprobadas::valor_pagos($id);
    }
}

switch ($_GET['op']) {
    case 'listar_solicitudes_coordinacion':
        $obj = new Controllsolicitudes();
        $obj->listar();
        break;
    case 'listar_pagos':
        $id = $_GET['id_solicitud'];
        $obj = new Controllsolicitudes();
        $obj->listarPagos($id);
        break;
    case 'info_pago':
        $id = $_POST['id'];
        $obj = new Controllsolicitudes();
        $obj->modificarPagos($id);
        break;
    case 'updatePago':
        $id = $_POST['id'];
        $id_soli = $_POST['id_soli'];
        $valor = $_POST['valor'];
        $obser = $_POST['obser'];
        $obj = new Controllsolicitudes();
        $obj->updatePago($id,$id_soli,$valor,$obser);
        break;
    case 'deletePago':
        $id_pa = $_POST['id_pa'];
        $id_sol = $_POST['id_sol'];
        $obj = new Controllsolicitudes();
        $obj->deletePago($id_pa,$id_sol);
        break;
    case 'aggPago':
        $id = $_POST['id'];
        $valor = $_POST['valor'];
        $obser = $_POST['obser'];
        $obj = new Controllsolicitudes();
        $obj->aggPago($id,$valor,$obser);
        break;
    case 'listar_clases_solicitud':
        $id = $_GET['id_solicitud'];
        $obj = new Controllsolicitudes();
        $obj->listar_clases_solicitud($id);
        break;

    case 'prueba':
        $id = '21';
        $obj = new Controllsolicitudes();
        $obj->prueba($id);
        break;
}


?>
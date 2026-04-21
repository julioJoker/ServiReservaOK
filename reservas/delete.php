<?php

require('../class/rutas.php');
require('../class/config.php');
require('../class/session.php');
require('../class/reservaModel.php');

$session = new Session();

if (!isset($_SESSION['autenticado'])) {
    header('Location: ' . LOGIN);
    exit;
}
//var_dump($_SESSION);
//exit;
/* 🔐 CONTROL DE PERMISOS */
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'Administrador') {
    $_SESSION['error'] = "No tienes permisos para eliminar reservas";
    header('Location: ' . RESERVAS);
    exit;
}

$rol = strtolower($_SESSION['usuario_rol'] ?? '');

if ($rol !== 'administrador') {
    $_SESSION['error'] = "No tienes permisos para eliminar reservas";
    header('Location: ' . RESERVAS);
    exit;
}

/* ELIMINAR */
if (isset($_GET['id'])) {

    $id = (int) $_GET['id'];

    $reserva = new ReservaModel();
    $reserva->deleteReserva($id);

    $_SESSION['success'] = "Reserva eliminada correctamente";

    header('Location: ' . RESERVAS);
    exit;
}
<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();

require('../class/config.php');
require('../class/horarioModel.php');

if (isset($_SESSION['autenticado']) && $_SESSION['usuario_rol'] == 'Administrador') {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $id = $_POST['id'] ?? null;

        if ($id) {
            $horario = new HorarioModel();

            if ($horario->tieneReservas($id)) {
                $_SESSION['error'] = "⛔ Este horario ya está tomado y no puede ser eliminado.";
            } else {
                $horario->deleteHorario($id);
                $_SESSION['success'] = "✅ Horario eliminado correctamente.";
            }
        }

        header('Location: index.php');
        exit;
    }

} else {
    header('Location: ' . LOGIN);
}
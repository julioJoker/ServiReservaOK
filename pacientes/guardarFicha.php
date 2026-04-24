<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

require('../class/config.php');
require('../class/reservaModel.php');

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido');
    }

    // ✅ Obtener datos seguros
    $id           = (int) ($_POST['id'] ?? 0);
    $peso         = trim($_POST['peso'] ?? '');
    $altura       = trim($_POST['altura'] ?? '');
    $sintomas     = trim($_POST['sintomas'] ?? '');
    $observacion  = trim($_POST['observacion'] ?? '');
    $tratamiento  = trim($_POST['tratamiento'] ?? '');

    $nombre_profe     = $_POST['nombre_profe'] ?? '';
    $especialidad_nom = $_POST['especialidad'] ?? '';
    $nombre_paciente  = $_POST['nombre_paciente'] ?? '';
    $rutPaciente      = $_POST['rut'] ?? '';

    // ✅ Validaciones
    if (!$id) {
        throw new Exception('ID inválido');
    }

    if (empty($peso) || empty($altura)) {
        throw new Exception('Peso y altura son obligatorios');
    }

    // Modelo
    $reservaModel = new ReservaModel();

    $res = $reservaModel->getAddFichaPaciente(
        $id,
        $nombre_profe,
        $especialidad_nom,
        $nombre_paciente,
        $rutPaciente,
        $peso,
        $altura,
        $sintomas,
        $observacion,
        $tratamiento
    );

    if (!$res) {
        throw new Exception('Error al guardar en BD');
    }

    echo json_encode([
        'status' => 'success',
        'msg' => 'Ficha guardada correctamente'
    ]);

} catch (Exception $e) {

    echo json_encode([
        'status' => 'error',
        'msg' => $e->getMessage()
    ]);
}
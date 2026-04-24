<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require('../class/config.php');
require('../class/pacienteModel.php');

$id = isset($_GET['paciente']) ? (int)$_GET['paciente'] : 0;

if ($id <= 0) {
    die("No se recibió ID válido");
}

$model = new PacienteModel();
$fichas = $model->getFichasPaciente($id);

if (empty($fichas)) {
    die("Ficha no encontrada");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ficha del Paciente</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- ÍCONOS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow-lg">

        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="bi bi-file-medical"></i> Ficha Clínica del Paciente
            </h4>
        </div>

        <div class="card-body">

            <?php foreach ($fichas as $ficha): ?>

                <div class="border rounded p-3 mb-3 bg-white">

                    <!-- PROFESIONAL -->
                    <h5 class="text-primary mb-3">
                        <i class="bi bi-person-badge"></i>
                        <?= $ficha['nombre_profe'] ?? 'Sin profesional'; ?>
                        -
                        <?= $ficha['especialidad'] ?? 'Sin especialidad'; ?>
                    </h5>

                    <div class="row">

                        <!-- DATOS PACIENTE -->
                        <div class="col-md-6">

                            <p>
                                <i class="bi bi-person"></i>
                                <strong>Paciente:</strong>
                                <?= $ficha['nombre_paciente'] ?? '-' ?>
                            </p>

                            <p>
                                <i class="bi bi-card-text"></i>
                                <strong>RUT:</strong>
                                <?= $ficha['rut'] ?? '-' ?>
                            </p>

                            <p>
                                <i class="bi bi-speedometer2"></i>
                                <strong>Peso:</strong>
                                <?= $ficha['peso'] ? $ficha['peso'] . ' kg' : '-' ?>
                            </p>

                            <p>
                                <i class="bi bi-arrows-expand"></i>
                                <strong>Altura:</strong>
                                <?= $ficha['altura'] ? $ficha['altura'] . ' m' : '-' ?>
                            </p>

                        </div>

                        <!-- FECHA -->
                        <div class="col-md-6 text-end">

                            <p>
                                <i class="bi bi-calendar-event"></i>
                                <strong>Fecha:</strong><br>

                                <?= !empty($ficha['created_at'])
                                    ? (new DateTime($ficha['created_at']))->format('d-m-Y H:i')
                                    : '-'; ?>
                            </p>

                        </div>

                    </div>

                    <hr>

                    <!-- SÍNTOMAS -->
                    <p>
                        <i class="bi bi-activity text-danger"></i>
                        <strong>Síntomas:</strong><br>
                        <?= nl2br($ficha['sintomas'] ?? '-') ?>
                    </p>

                    <!-- OBSERVACIÓN -->
                    <p>
                        <i class="bi bi-eye text-warning"></i>
                        <strong>Observación:</strong><br>
                        <?= nl2br($ficha['observacion'] ?? '-') ?>
                    </p>

                    <!-- TRATAMIENTO -->
                    <p>
                        <i class="bi bi-capsule text-success"></i>
                        <strong>Tratamiento:</strong><br>
                        <?= nl2br($ficha['tratamiento'] ?? '-') ?>
                    </p>


                </div>


                

            <?php endforeach; ?>
            
                <div class="mt-3">
                    <a href="../pacientes/show.php?paciente=<?= $id ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Volver al paciente
                    </a>
                </div>
        </div>
    </div>

</div>

</body>
</html>
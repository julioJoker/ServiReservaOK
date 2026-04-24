<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require('../class/rutas.php');
require('../class/config.php');
require('../class/session.php');
require('../class/pacienteModel.php');
require('../class/reservaModel.php');
require('../class/empleadoModel.php');

$session = new Session();

// Validar sesión
if (!isset($_SESSION['autenticado'])) {
    header('Location: ' . LOGIN);
    exit;
}

// Validar parámetro
if (!isset($_GET['paciente'])) {
    header('Location: ' . PACIENTES);
    exit;
}

$id = (int) $_GET['paciente'];

// Modelos
$pacienteModel = new PacienteModel();
$reservaModel = new ReservaModel();
$empleadoModel = new EmpleadoModel();

// Datos
$paciente = $pacienteModel->getPacienteId($id);
$profesional = $empleadoModel->getEmpleadoId($id);

// Validaciones
if (!$paciente) {
    die('Paciente no encontrado');
}
if (!$profesional) {
    die('Profesional no encontrado');
}

$title = 'Ficha Pacientes';
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?php echo TITLE . $title; ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>

<style>
body {
    background: #f4f6f9;
    padding-top: 80px;
}

/* Card */
.card-custom {
    background: #fff;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
}

/* Inputs */
.form-control {
    border-radius: 10px;
}

/* Iconos */
.input-group-text {
    background: #f1f1f1;
}

/* Textareas */
.textarea-large {
    min-height: 140px;
    resize: vertical;
}

/* Inputs pequeños */
.input-small {
    max-width: 140px;
}

/* Info */
.info-box {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 20px;
}

/* Responsive */
@media (max-width: 768px) {
    .input-small {
        max-width: 100%;
    }
}
</style>
</head>

<body>

<?php include('../partials/menu.php'); ?>

<!-- MODAL CARGANDO -->
<div class="modal fade" id="modalLoading" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center p-4">

      <div class="spinner-border text-primary mx-auto mb-3" role="status"></div>

      <h5>Guardando ficha...</h5>
      <p class="text-muted mb-0">Por favor espera</p>

    </div>
  </div>
</div>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-12">

            <div class="card-custom">

                <h5 class="mb-3">
                    <i class="bi bi-clipboard2-pulse"></i> Ficha Paciente
                </h5>

                <div id="alerta"></div>

                <!-- Info paciente -->
                <div class="info-box">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <p><i class="bi bi-person-badge"></i> <strong>Profesional:</strong> <?php echo $profesional['nombre']; ?></p>
                            <p><i class="bi bi-person"></i> <strong>Paciente:</strong> <?php echo $paciente['nombre']; ?></p>
                        </div>
                        <div class="col-md-6 col-12">
                            <p><i class="bi bi-credit-card"></i> <strong>RUT:</strong> <?php echo $paciente['rut']; ?></p>
                            <p><i class="bi bi-calendar"></i> <strong>Edad:</strong> <?php echo $paciente['edad']; ?> años</p>
                        </div>
                    </div>
                </div>

                <form id="formFicha">

                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="nombre_profe" value="<?php echo $profesional['nombre']; ?>">
                    <input type="hidden" name="especialidad" value="<?php echo $profesional['rol']; ?>">
                    <input type="hidden" name="nombre_paciente" value="<?php echo $paciente['nombre']; ?>">
                    <input type="hidden" name="rut" value="<?php echo $paciente['rut']; ?>">

                    <!-- Peso / Altura -->
                    <div class="row">
                        <div class="col-md-6 col-12 mb-3">
                            <label>Peso *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-speedometer2"></i></span>
                                <input type="number" step="0.1" name="peso" class="form-control input-small" required>
                            </div>
                        </div>

                        <div class="col-md-6 col-12 mb-3">
                            <label>Altura *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-arrows-vertical"></i></span>
                                <input type="number" step="0.01" name="altura" class="form-control input-small" required>
                            </div>
                        </div>
                    </div>

                    <!-- Textareas -->
                    <div class="mb-3">
                        <label><i class="bi bi-activity"></i> Síntomas</label>
                        <textarea name="sintomas" class="form-control textarea-large"></textarea>
                    </div>

                    <div class="mb-3">
                        <label><i class="bi bi-journal-text"></i> Observación</label>
                        <textarea name="observacion" class="form-control textarea-large"></textarea>
                    </div>

                    <div class="mb-3">
                        <label><i class="bi bi-capsule"></i> Tratamiento</label>
                        <textarea name="tratamiento" class="form-control textarea-large"></textarea>
                    </div>

                    <!-- Botones -->
                    <div class="d-flex flex-column flex-md-row gap-2">
                        <button class="btn btn-primary w-100">
                            <i class="bi bi-save"></i> Guardar
                        </button>

                        <a href="<?php echo PACIENTES; ?>" class="btn btn-secondary w-100">
                            <i class="bi bi-arrow-left"></i> Volver
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>



</body>
</html>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('formFicha');
    const modal = new bootstrap.Modal(document.getElementById('modalLoading'));

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        // 👉 MOSTRAR MODAL
        modal.show();

        fetch('guardarFicha.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {

            if (data.status === 'success') {

                // esperar un poco para efecto visual
                setTimeout(() => {
                    window.location.href = "show.php?paciente=<?php echo $id; ?>";
                }, 800);

            } else {
                modal.hide();

                document.getElementById('alerta').innerHTML = `
                    <div class="alert alert-danger">${data.msg}</div>
                `;
            }
        })
        .catch(err => {
            modal.hide();
            console.error(err);
        });
    });

});
</script>
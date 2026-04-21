<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require('../class/rutas.php');
require('../class/config.php');
require('../class/session.php');
require('../class/pacienteModel.php');

$session = new Session();
$paciente = new PacienteModel();

$title = 'Nuevo Paciente';
$msg = null;

$rut = trim($_POST['rut'] ?? '');
$nombre = trim($_POST['nombre'] ?? '');
$direccion = trim($_POST['direccion'] ?? '');
$email = $_POST['email'] ?? '';
$fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
$fonasa = $_POST['fonasa'] ?? '';
$sexo = $_POST['sexo'] ?? '';

if (($_POST['confirm'] ?? '') == 1) {

    if (strlen($rut) < 9 || strlen($rut) > 10) {
        $msg = 'Ingrese un RUT válido';
    } elseif (!$nombre) {
        $msg = 'Ingrese el nombre del paciente';
    } elseif (!$sexo) {
        $msg = 'Seleccione el sexo del paciente';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = 'Ingrese un correo válido';
    } elseif (!$direccion) {
        $msg = 'Ingrese la dirección del paciente';
    } elseif (!$fecha_nacimiento) {
        $msg = 'Ingrese la fecha de nacimiento';
    } elseif (!$fonasa) {
        $msg = 'Seleccione la previsión del paciente';
    } else {

        if ($paciente->getPacienteRut($rut)) {
            $msg = 'El paciente ya existe';
        } else {

            $res = $paciente->addPaciente(
                $rut,
                $nombre,
                $email,
                $fecha_nacimiento,
                $fonasa,
                $sexo,
                $direccion
            );

            if ($res) {
                $_SESSION['success'] = 'Paciente registrado correctamente';
                header('Location: ' . PACIENTES);
                exit;
            }
        }
    }
}
?>

<?php if(isset($_SESSION['autenticado'])): ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title><?= TITLE . $title ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(135deg, #0f172a, #020617);
    color: #e5e7eb;
    padding-top: 90px;
    font-family: 'Segoe UI', sans-serif;
}

/* Card */
.card-form {
    background: rgba(15, 23, 42, 0.8);
    backdrop-filter: blur(12px);
    border-radius: 18px;
    padding: 35px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.6);
    transition: transform .2s ease;
}
.card-form:hover {
    transform: translateY(-5px);
}

/* Inputs */
.form-control, select {
    background: #020617 !important;
    border: 1px solid #334155 !important;
    color: #e2e8f0 !important;
    border-radius: 10px;
}

.form-control:focus {
    border-color: #22c55e !important;
    box-shadow: 0 0 0 0.2rem rgba(34,197,94,.25);
}

/* Botones */
.btn-outline-success:hover {
    background: #22c55e;
    color: #000;
}

.btn-outline-primary:hover {
    background: #38bdf8;
    color: #000;
}

/* Alert */
.alert-danger {
    background: rgba(127, 29, 29, 0.8);
    border-radius: 10px;
    border: none;
}

/* Título */
h4 {
    font-weight: 600;
}
</style>
</head>

<body>

<?php include('../partials/menu.php'); ?>

<div class="container-fluid px-3 px-md-5">
    <div class="row justify-content-center">
        
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card-form">

                <h4 class="mb-3 text-center text-md-start"><?= $title ?></h4>
                <p class="text-danger small text-center text-md-start">Campos obligatorios *</p>

                <?php if($msg): ?>
                    <div class="alert alert-danger text-center"><?= $msg ?></div>
                <?php endif; ?>

                <form method="post">
                    <input type="hidden" name="confirm" value="1">

                    <div class="row">

                        <div class="col-12 col-md-6 mb-3">
                            <label>RUT *</label>
                            <input type="text" name="rut" value="<?= htmlspecialchars($rut) ?>" class="form-control" required>
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label>Nombre *</label>
                            <input type="text" name="nombre" value="<?= htmlspecialchars($nombre) ?>" class="form-control" required>
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label>Sexo *</label>
                            <select name="sexo" class="form-control" required>
                                <option value="">Seleccione...</option>
                                <option value="1" <?= $sexo=='1'?'selected':'' ?>>Femenino</option>
                                <option value="2" <?= $sexo=='2'?'selected':'' ?>>Masculino</option>
                                <option value="3" <?= $sexo=='3'?'selected':'' ?>>Transgénero</option>
                                <option value="4" <?= $sexo=='4'?'selected':'' ?>>Agénero</option>
                                <option value="5" <?= $sexo=='5'?'selected':'' ?>>Otro</option>
                            </select>
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label>Email *</label>
                            <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" class="form-control" required>
                        </div>

                        <div class="col-12 mb-3">
                            <label>Dirección *</label>
                            <input type="text" name="direccion" value="<?= htmlspecialchars($direccion) ?>" class="form-control" required>
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label>Fecha de nacimiento *</label>
                            <input type="date" name="fecha_nacimiento" value="<?= $fecha_nacimiento ?>" class="form-control" required>
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label>Previsión *</label>
                            <select name="fonasa" class="form-control" required>
                                <option value="">Seleccione...</option>
                                <option value="1" <?= $fonasa=='1'?'selected':'' ?>>Fonasa</option>
                                <option value="2" <?= $fonasa=='2'?'selected':'' ?>>Isapre</option>
                                <option value="3" <?= $fonasa=='3'?'selected':'' ?>>Particular</option>
                            </select>
                        </div>

                    </div>

                    <!-- Botones -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                        <button class="btn btn-outline-success w-100 w-md-auto">Guardar</button>
                        <a href="<?= PACIENTES ?>" class="btn btn-outline-primary w-100 w-md-auto">Volver</a>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

</body>
</html>

<?php else: header('Location: ' . LOGIN); endif; ?>
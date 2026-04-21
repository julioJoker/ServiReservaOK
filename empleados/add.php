<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require('../class/rutas.php');
require('../class/config.php');
require('../class/session.php');
require('../class/empleadoModel.php');
require('../class/rolModel.php');
require('../class/especialidadModel.php');

$session = new Session();

$empleadoModel = new EmpleadoModel();
$rolModel = new RolModel();
$especialidadModel = new EspecialidadModel();

$roles = $rolModel->getRoles();
$especialidades = $especialidadModel->getEspecialidades();

$msg = '';

/* =========================
   PROCESAR FORMULARIO
========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['confirm'] ?? 0) == 1) {

    $rut  = trim(strip_tags($_POST['rut'] ?? ''));
    $nombre = trim(strip_tags($_POST['nombre'] ?? ''));
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $fecha = $_POST['fecha_nacimiento'] ?? '';
    $rol = filter_var($_POST['rol'] ?? null, FILTER_VALIDATE_INT);
    $especialidad = filter_var($_POST['especialidad'] ?? null, FILTER_VALIDATE_INT);

    // 🔎 Validaciones
    if (strlen($rut) < 9 || strlen($rut) > 10) {
        $msg = 'Ingrese un RUT válido';
    } elseif (strlen($nombre) < 4) {
        $msg = 'El nombre debe tener al menos 4 caracteres';
    } elseif (!$email) {
        $msg = 'Ingrese un email válido';
    } elseif (!$fecha) {
        $msg = 'Ingrese la fecha de nacimiento';
    } elseif (!$rol) {
        $msg = 'Seleccione un rol';
    } elseif (!$especialidad) {
        $msg = 'Seleccione una especialidad';
    } else {

        // 🔍 duplicados
        if ($empleadoModel->getEmpleadoRutEmail($rut, $email)) {
            $msg = 'El RUT o email ya están registrados';
        } else {

            if ($empleadoModel->addEmpleado($rut, $nombre, $email, $fecha, $rol, $especialidad)) {
                $_SESSION['success'] = 'Empleado registrado correctamente';
                header('Location: ' . EMPLEADOS);
                exit;
            }

            $msg = 'Error al registrar empleado';
        }
    }
}

$title = 'Nuevo Empleado';

/* =========================
   SEGURIDAD
========================= */
if (empty($_SESSION['autenticado']) || $_SESSION['usuario_rol'] !== 'Administrador') {
    header('Location: ' . LOGIN);
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= TITLE . $title ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    body {
        background: #0f172a;
        color: #e2e8f0;
    }

    .card {
        background: #1e293b;
        border: 1px solid #334155;
        color: #e2e8f0;
        border-radius: 12px;
    }

    .form-control, select {
        background: #0b1220 !important;
        border: 1px solid #334155 !important;
        color: #e2e8f0 !important;
    }

    .form-control:focus, select:focus {
        background: #0b1220;
        border-color: #38bdf8;
        box-shadow: 0 0 0 0.2rem rgba(56,189,248,.25);
        color: #fff;
    }

    .btn-success {
        background: #22c55e;
        border: none;
    }

    .btn-success:hover {
        background: #16a34a;
    }

    .btn-outline-secondary {
        color: #cbd5e1;
        border-color: #475569;
    }

    .btn-outline-secondary:hover {
        background: #334155;
        color: #fff;
    }

    .alert-danger {
        background: #7f1d1d;
        border: none;
        color: #fecaca;
    }

    h4 {
        color: #f1f5f9;
    }

    .container {
        padding-top: 40px;
    }
</style>
<body>

<?php include('../partials/menu.php'); ?>

<div class="container mt-5">
<div class="row justify-content-center">

<div class="col-md-6">

    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="mb-3"><?= $title ?></h4>

            <?php if ($msg): ?>
                <div class="alert alert-danger"><?= $msg ?></div>
            <?php endif; ?>

            <form method="post" id="formEmpleado">

                <input class="form-control mb-2" name="rut" placeholder="RUT *" required>
                <input class="form-control mb-2" name="nombre" placeholder="Nombre *" required>
                <input class="form-control mb-2" type="email" name="email" placeholder="Email *" required>
                <input class="form-control mb-2" type="date" name="fecha_nacimiento" required>

                <select name="rol" class="form-control mb-2" required>
                    <option value="">Seleccione rol</option>
                    <?php foreach ($roles as $r): ?>
                        <option value="<?= $r['id'] ?>"><?= $r['nombre'] ?></option>
                    <?php endforeach; ?>
                </select>

                <select name="especialidad" class="form-control mb-3" required>
                    <option value="">Seleccione especialidad</option>
                    <?php foreach ($especialidades as $e): ?>
                        <option value="<?= $e['id'] ?>"><?= $e['nombre'] ?></option>
                    <?php endforeach; ?>
                </select>

                <input type="hidden" name="confirm" value="1">

                <button class="btn btn-success w-100">Guardar empleado</button>
                <a href="<?= EMPLEADOS ?>" class="btn btn-outline-secondary w-100 mt-2">Volver</a>

            </form>

        </div>
    </div>

</div>
</div>
</div>

<!-- 🔥 VALIDACIÓN SIMPLE FRONTEND -->
<script>
document.getElementById("formEmpleado").addEventListener("submit", function(e) {

    const rut = this.rut.value.trim();
    const nombre = this.nombre.value.trim();

    if (rut.length < 8 || rut.length > 12) {
        alert("RUT inválido");
        e.preventDefault();
        return;
    }

    if (nombre.length < 4) {
        alert("Nombre muy corto");
        e.preventDefault();
        return;
    }

});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
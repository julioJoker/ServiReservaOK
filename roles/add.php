<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require('../class/rutas.php');
require('../class/config.php');
require('../class/session.php');
require('../class/rolModel.php');

$session = new Session;
$rol = new RolModel;

$title = 'Nuevo Rol';

if (isset($_POST['confirm']) && $_POST['confirm'] == 1) {

    $nombre = trim(strip_tags($_POST['nombre']));

    if (empty($nombre)) {
        $msg = 'Ingrese el nombre del rol';
    } else {
        $res = $rol->getRolNombre($nombre);

        if (!empty($res)) {
            $msg = 'El rol ingresado ya existe... intente con otro';
        } else {
            $res = $rol->setRol($nombre);

            if (!empty($res)) {
                $_SESSION['success'] = 'El rol se ha registrado correctamente';
                header('Location: ' . ROLES);
                exit;
            }
        }
    }
}
?>

<?php if(isset($_SESSION['autenticado']) && $_SESSION['usuario_rol'] == 'Administrador'): ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= TITLE . $title ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
        background: linear-gradient(135deg, #667eea, #764ba2);
        padding-top: 90px;
        min-height: 100vh;
        font-family: 'Segoe UI', sans-serif;
    }

    /* Card */
    .card-modern {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        animation: fadeIn 0.4s ease-in-out;
    }

    /* Animación */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Título */
    h4 {
        font-weight: 600;
        color: #333;
    }

    /* Inputs */
    .form-control {
        border-radius: 10px;
        border: 1px solid #ddd;
        transition: 0.2s;
    }

    .form-control:focus {
        border-color: #764ba2;
        box-shadow: 0 0 0 0.2rem rgba(118,75,162,0.2);
    }

    /* Botones */
    .btn-modern {
        border-radius: 10px;
        padding: 6px 16px;
        font-weight: 500;
    }

    .btn-success {
        background: linear-gradient(45deg, #28a745, #20c997);
        border: none;
    }

    .btn-success:hover {
        opacity: 0.9;
    }

    /* Alert */
    .alert {
        border-radius: 10px;
    }

    /* Texto ayuda */
    .text-muted {
        font-size: 0.9rem;
    }
</style>

</head>

<body>

<header>
    <?php include('../partials/menu.php'); ?>
</header>

<div class="container d-flex justify-content-center align-items-center">

    <div class="card-modern p-4 col-md-6 col-lg-5">

        <h4 class="mb-3"><?= $title ?></h4>
        <p class="text-muted mb-4">
            Complete el formulario <span class="text-danger">*</span>
        </p>

        <?php if(isset($msg)): ?>
            <div class="alert alert-danger">
                <?= $msg ?>
            </div>
        <?php endif; ?>

        <form method="post">

            <div class="mb-3">
                <label class="form-label fw-semibold">
                    Nombre del Rol <span class="text-danger">*</span>
                </label>
                <input 
                    type="text" 
                    name="nombre" 
                    class="form-control"
                    placeholder="Ej: Administrador"
                    required
                >
            </div>

            <input type="hidden" name="confirm" value="1">

            <div class="d-flex justify-content-between mt-4">
                <a href="<?= ROLES ?>" class="btn btn-outline-secondary btn-modern">
                    ← Volver
                </a>

                <button type="submit" class="btn btn-success btn-modern">
                    Guardar
                </button>
            </div>

        </form>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php else: ?>
<?php header('Location: ' . LOGIN); ?>
<?php endif; ?>
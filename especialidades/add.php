<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();

require('../class/rutas.php');
require('../class/config.php');
require('../class/especialidadModel.php');

// Seguridad
if (!isset($_SESSION['autenticado']) || $_SESSION['usuario_rol'] !== 'Administrador') {
    header('Location: ' . LOGIN);
    exit;
}

$especialidades = new EspecialidadModel;
$title = 'Nueva Especialidad';
$msg = '';

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = trim($_POST['nombre'] ?? '');
    $nombre = htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8');

    if (strlen($nombre) < 3) {
        $msg = 'El nombre debe tener al menos 3 caracteres';
    } else {

        $existe = $especialidades->getEspecialidadNombre($nombre);

        if (!empty($existe)) {
            $msg = 'La especialidad ya existe';
        } else {

            if ($especialidades->setEspecialidad($nombre)) {
                $_SESSION['success'] = 'Especialidad registrada correctamente';
                header('Location: ' . ESPECIALIDADES);
                exit;
            } else {
                $msg = 'Error al guardar';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo TITLE . $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            min-height: 100vh;
            padding-top: 90px;
        }

        .card-modern {
            border-radius: 18px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(10px);}
            to {opacity: 1; transform: translateY(0);}
        }

        .form-control {
            border-radius: 10px;
            padding: 10px;
        }

        .form-control:focus {
            border-color: #764ba2;
            box-shadow: 0 0 0 0.2rem rgba(118,75,162,0.2);
        }

        .btn {
            border-radius: 10px;
        }
    </style>
</head>

<body>

<header>
    <?php include('../partials/menu.php'); ?>
</header>

<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-6">
            <div class="card card-modern p-4">

                <h4 class="text-center mb-4"><?php echo $title ?></h4>

                <?php if (!empty($msg)): ?>
                    <div class="alert alert-danger text-center">
                        <?php echo $msg; ?>
                    </div>
                <?php endif; ?>

                <form method="post">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Especialidad <span class="text-danger">*</span>
                        </label>

                        <input 
                            type="text" 
                            name="nombre" 
                            class="form-control"
                            placeholder="Ej: Cardiología"
                            required
                        >

                        <small class="text-muted">
                            Ingrese una especialidad médica
                        </small>
                    </div>

                    <!-- BOTONES -->
                    <div class="d-flex justify-content-between mt-4">

                        <a href="<?php echo ESPECIALIDADES; ?>" class="btn btn-outline-blue">
                            ← Volver
                        </a>

                        <button type="submit" class="btn btn-success px-4">
                            Guardar
                        </button>

                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

</body>
</html>
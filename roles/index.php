<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require('../class/rutas.php');
require('../class/config.php');
require('../class/session.php');
require('../class/rolModel.php');

$session = new Session;

// 🔒 Validación
if (!isset($_SESSION['autenticado']) || $_SESSION['usuario_rol'] !== 'Administrador') {
    header('Location: ' . LOGIN);
    exit;
}

$rolModel = new RolModel;
$roles = $rolModel->getRoles();

$title = 'Roles';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= TITLE . $title ?></title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="../img/favicon.png">

    <style>
        body {
            padding-top: 100px;
            min-height: 100vh;
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            font-family: 'Segoe UI', sans-serif;
        }

        /* Card moderna */
        .card-custom {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .card-header {
            background: #ffffff;
            border-bottom: 1px solid #eee;
        }

        .card-header h5 {
            font-weight: 600;
            color: #333;
        }

        /* Botón */
        .btn-success {
            border-radius: 8px;
            font-weight: 500;
            padding: 5px 12px;
        }

        /* Tabla */
        .table {
            margin-bottom: 0;
        }

        .table thead {
            background: #f8f9fa;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0,0,0,0.03);
            transition: 0.2s;
        }

        /* Links */
        .link-rol {
            color: #0d6efd;
            transition: 0.2s;
        }

        .link-rol:hover {
            color: #6610f2;
            text-decoration: underline;
        }

        /* Alert */
        .alert {
            border-radius: 10px;
        }
    </style>
</head>

<body>

<header>
    <?php include('../partials/menu.php'); ?>
</header>

<div class="container py-5">

    <div class="card card-custom">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Gestión de Roles</h5>

            <a href="<?= ADD_ROL; ?>" class="btn btn-success btn-sm">
                + Nuevo Rol
            </a>
        </div>

        <div class="card-body">

            <?php include('../partials/mensajes.php'); ?>

            <?php if (!empty($roles)): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre del Rol</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($roles as $rol): ?>
                                <tr>
                                    <td><?= htmlspecialchars($rol['id']); ?></td>
                                    <td>
                                        <a class="link-rol fw-semibold text-decoration-none"
                                           href="<?= SHOW_ROL . $rol['id']; ?>">
                                            <?= htmlspecialchars($rol['nombre']); ?>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info text-center mb-0">
                    No hay roles registrados.
                </div>
            <?php endif; ?>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
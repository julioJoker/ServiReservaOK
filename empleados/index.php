<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require('../class/rutas.php');
require('../class/config.php');
require('../class/session.php');
require('../class/empleadoModel.php');

$session = new Session;

// Seguridad
if (
    !isset($_SESSION['autenticado']) ||
    ($_SESSION['usuario_rol'] !== 'Administrador' && $_SESSION['usuario_rol'] !== 'Supervisor')
) {
    header('Location: ' . LOGIN);
    exit;
}

$model = new EmpleadoModel;
$empleados = $model->getEmpleados();

$title = 'Empleados';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo TITLE . $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="../img/favicon.png">

    <!-- Bootstrap moderno -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
        background: #0f172a; /* azul oscuro elegante */
        color: #e5e7eb;
        padding-top: 80px;
    }

    /* Card */
    .card-custom {
        background: #1e293b;
        border-radius: 16px;
        border: 1px solid #334155;
        box-shadow: 0 10px 25px rgba(0,0,0,0.4);
    }

    /* Títulos */
    h4 {
        color: #f1f5f9;
        font-weight: 600;
    }

    /* Tabla */
    .table {
        color: #e5e7eb;
    }

    .table thead {
        background: #020617;
        color: #38bdf8;
    }

    .table-hover tbody tr:hover {
        background: #1e293b;
    }

    /* Inputs */
    .form-control {
        background: #020617;
        border: 1px solid #334155;
        color: #e5e7eb;
        border-radius: 10px;
    }

    .form-control:focus {
        background: #020617;
        color: #fff;
        border-color: #38bdf8;
        box-shadow: 0 0 0 0.2rem rgba(56,189,248,0.2);
    }

    /* Botones */
    .btn {
        border-radius: 10px;
    }

    .btn-success {
        background: linear-gradient(45deg, #22c55e, #16a34a);
        border: none;
    }

    .btn-success:hover {
        opacity: 0.9;
    }

    .btn-outline-secondary {
        border-color: #64748b;
        color: #cbd5f5;
    }

    .btn-outline-secondary:hover {
        background: #334155;
        color: #fff;
    }

    /* Badge */
    .badge {
        background: #0ea5e9;
    }

    /* Alert */
    .alert {
        border-radius: 10px;
    }

    /* Title bar */
    .title-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Botón tipo glass (Ver) */
        .btn-glass-info {
            background: rgba(56, 189, 248, 0.15);
            color: #38bdf8;
            border: 1px solid rgba(56, 189, 248, 0.3);
            backdrop-filter: blur(6px);
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .btn-glass-info:hover {
            background: rgba(56, 189, 248, 0.3);
            color: #fff;
        }

        /* Botón tipo glass (Editar) */
        .btn-glass-primary {
            background: rgba(99, 102, 241, 0.15);
            color: #818cf8;
            border: 1px solid rgba(99, 102, 241, 0.3);
            backdrop-filter: blur(6px);
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .btn-glass-primary:hover {
            background: rgba(99, 102, 241, 0.3);
            color: #fff;
        }

        /* Base badge */
.badge-role {
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.5px;
    backdrop-filter: blur(6px);
    border: 1px solid transparent;
    display: inline-block;
}

/* Administrador */
.badge-admin {
    background: rgba(239, 68, 68, 0.15);
    color: #f87171;
    border-color: rgba(239, 68, 68, 0.3);
}

/* Supervisor */
.badge-supervisor {
    background: rgba(251, 191, 36, 0.15);
    color: #facc15;
    border-color: rgba(251, 191, 36, 0.3);
}

/* Usuario normal */
.badge-user {
    background: rgba(56, 189, 248, 0.15);
    color: #38bdf8;
    border-color: rgba(56, 189, 248, 0.3);
}
</style>
</head>

<body>

<header>
    <?php include('../partials/menu.php'); ?>
</header>

<div class="container py-4">

    <div class="card card-custom p-4">

        <!-- Título + botón -->
        <div class="title-bar mb-3">
            <h4 class="mb-0"><?php echo $title; ?></h4>

            <a href="<?php echo ADD_EMPLEADO; ?>" class="btn btn-success btn-sm">
                + Nuevo Empleado
            </a>
        </div>

        <?php include('../partials/mensajes.php'); ?>

        <?php if (!empty($empleados)): ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">

                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Rol</th>
                        <th>Especialidad</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($empleados as $emp): ?>
                        <tr>

                            <td>
                                <a href="<?php echo SHOW_EMPLEADO . $emp['id']; ?>" 
                                class="text-decoration-none fw-semibold text-info">
                                    <?php echo $emp['nombre']; ?>
                                </a>
                            </td>

                            <td>
                            <?php
                            $rolIcon = match($emp['rol']) {
                                'Administrador' => '👑',
                                'Supervisor' => '🛠',
                                default => '👤'
                            };
                            ?>

                            <span class="badge-role <?php echo $rolClass; ?>">
                                <?php echo $rolIcon . ' ' . $emp['rol']; ?>
                            </span>
                            </td>

                            <td>
                                <?php echo $emp['especialidad'] ?? '<span class="text-muted">Sin asignar</span>'; ?>
                            </td>

                            <td class="text-end">

                                <a href="<?php echo SHOW_EMPLEADO . $emp['id']; ?>" 
                                class="btn btn-sm btn-glass-info me-1">
                                     Ver
                                </a>

                                <a href="<?php echo EDIT_EMPLEADO . $emp['id']; ?>" 
                                class="btn btn-sm btn-glass-primary">
                                     Editar
                                </a>



                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>

        <?php else: ?>

            <div class="alert alert-info text-center">
                No hay empleados registrados
            </div>

        <?php endif; ?>

    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
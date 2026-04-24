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

$title = 'Funcionarios';
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

/* ===== FONDO ===== */
body {
    background: #4c505f;
    color: #1e293b;
    padding-top: 80px;
    font-family: system-ui, sans-serif;
}

/* ===== CONTENEDOR ===== */
.container {
    max-width: 1100px;
}

/* ===== CARD ===== */
.card-custom {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    padding: 25px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
}

/* ===== HEADER ===== */
.title-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.title-bar h4 {
    font-size: 1.5rem;
    font-weight: 600;
    color: #0f172a;
}

/* ===== TABLA ===== */
.table {
    background: white;
    border-radius: 12px;
    overflow: hidden;
}

.table thead {
    background: #f8fafc;
    color: #64748b;
    font-size: 0.85rem;
    text-transform: uppercase;
}

.table th {
    border-bottom: 1px solid #e2e8f0;
}

.table td {
    border-bottom: 1px solid #f1f5f9;
}

.table tbody tr:hover {
    background: #f8fafc;
}

/* ===== LINKS ===== */
a.text-info {
    color: #2563eb !important;
}

a.text-info:hover {
    text-decoration: underline;
}

/* ===== BOTÓN PRINCIPAL ===== */
.btn-success {
    background: #2563eb;
    border: none;
    font-weight: 500;
}

.btn-success:hover {
    background: #1d4ed8;
}

/* ===== BOTONES ACCIONES ===== */
.btn-glass-info {
    background: #e0f2fe;
    color: #0284c7;
    border: none;
}

.btn-glass-info:hover {
    background: #bae6fd;
}

.btn-glass-primary {
    background: #eef2ff;
    color: #4f46e5;
    border: none;
}

.btn-glass-primary:hover {
    background: #e0e7ff;
}

/* ===== BADGES ===== */
.badge-role {
    padding: 5px 10px;
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 600;
}

/* Roles */
.badge-admin {
    background: #fee2e2;
    color: #dc2626;
}

.badge-supervisor {
    background: #fef3c7;
    color: #d97706;
}

.badge-user {
    background: #e0f2fe;
    color: #0284c7;
}

/* ===== ALERT ===== */
.alert {
    border-radius: 10px;
}

/* ===== BOTONES ===== */
.btn {
    border-radius: 8px;
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
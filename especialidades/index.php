<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();

require('../class/rutas.php');
require('../class/config.php');
require('../class/especialidadModel.php');

$model = new EspecialidadModel;
$especialidades = $model->getEspecialidades();

$title = 'Especialidades';
?>

<?php if(isset($_SESSION['autenticado']) && $_SESSION['usuario_rol'] == 'Administrador'): ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= TITLE . $title ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="icon" type="image/png" href="../img/favicon.png">

<style>
body {
    padding-top: 100px; /* 🔥 baja el contenido */
    background: linear-gradient(135deg, #667eea, #764ba2);
    min-height: 100vh;
    font-family: 'Segoe UI', sans-serif;
}

/* Card */
.card-modern {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 12px 30px rgba(0,0,0,0.15);
}

/* Header */
.card-header {
    background: #f8f9fa;
    border-bottom: 1px solid #eee;
}

.card-header h4 {
    margin: 0;
    font-weight: 600;
}

/* Botón */
.btn-success {
    border-radius: 8px;
    font-size: 0.85rem;
}

/* Tabla */
.table thead {
    background: #f1f3f5;
}

.table-hover tbody tr:hover {
    background: rgba(0,0,0,0.03);
    transition: 0.2s;
}

/* Links */
.link-item {
    color: #0d6efd;
    text-decoration: none;
    font-weight: 500;
}

.link-item:hover {
    color: #6610f2;
    text-decoration: underline;
}

/* Mensaje */
.text-info {
    background: #e7f3ff;
    padding: 10px;
    border-radius: 8px;
}
</style>

</head>

<body>

<header>
    <?php include('../partials/menu.php'); ?>
</header>

<div class="container">

    <div class="card card-modern">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h4><?= $title ?></h4>

            <a href="<?= ADD_ESPECIALIDAD; ?>" class="btn btn-success btn-sm">
                + Nueva Especialidad
            </a>
        </div>

        <div class="card-body">

            <?php include('../partials/mensajes.php'); ?>

            <?php if(!empty($especialidades)): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Especialidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($especialidades as $esp): ?>
                                <tr>
                                    <td><?= htmlspecialchars($esp['id']); ?></td>
                                    <td>
                                        <a class="link-item"
                                           href="<?= SHOW_ESPECIALIDAD . $esp['id']; ?>">
                                            <?= htmlspecialchars($esp['nombre']); ?>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-info mb-0 text-center">
                    No hay especialidades registradas
                </p>
            <?php endif; ?>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php else: ?>
<?php header('Location: ' . LOGIN); ?>
<?php endif; ?>
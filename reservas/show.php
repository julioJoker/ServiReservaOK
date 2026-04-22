<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require('../class/rutas.php');
require('../class/config.php');
require('../class/session.php');
require('../class/reservaModel.php');

$session = new Session();

$reserva = null;

if (isset($_GET['reserva'])) {
    $id = (int) $_GET['reserva'];
    $reservaModel = new ReservaModel();
    $reserva = $reservaModel->getReservaId($id);
}

$title = 'Detalle de Reserva';
?>

<?php if(isset($_SESSION['autenticado'])): ?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?= TITLE . $title ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    min-height:100vh;
    background: radial-gradient(circle at top, #1e293b, #0f172a);
    color:#e5e7eb;
    padding-top:90px;
    font-family: system-ui, sans-serif;
}

/* CARD PRINCIPAL */
.card-glass{
    background: rgba(255,255,255,0.06);
    backdrop-filter: blur(16px);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 18px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.4);
}

/* HEADER */
.title{
    font-size:1.5rem;
    font-weight:700;
}

/* TABLE STYLE */
.table{
    color:#e5e7eb;
    margin:0;
}

.table th{
    width:40%;
    color:#93c5fd;
    font-weight:600;
}

.table td{
    color:#f1f5f9;
}

/* BADGES */
.badge-active{
    background:#22c55e;
    padding:6px 10px;
    border-radius:8px;
}

.badge-inactive{
    background:#ef4444;
    padding:6px 10px;
    border-radius:8px;
}

/* BUTTONS */
.btn{
    border-radius:10px;
    padding:6px 14px;
    font-weight:600;
}

.btn-outline-success{
    border-color:#22c55e;
    color:#22c55e;
}

.btn-outline-success:hover{
    background:#22c55e;
    color:#0f172a;
}

/* EMPTY */
.empty{
    text-align:center;
    padding:40px;
    opacity:0.7;
}
</style>

</head>

<body>

<header>
    <?php include('../partials/menu.php'); ?>
</header>

<div class="container">

    <div class="card-glass p-4 col-md-8 mx-auto">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="title">📄 <?= $title ?></div>
            <a href="<?= RESERVAS; ?>" class="btn btn-outline-success btn-sm">
                ← Volver
            </a>
        </div>

        <?php include('../partials/mensajes.php'); ?>

        <?php if(!empty($reserva)): ?>

        <table class="table table-borderless align-middle">

            <tr>
                <th>Fecha Reserva</th>
                <td>
                    <?php
                        echo (new DateTime($reserva['fecha']))
                            ->format('d-m-Y');
                    ?>
                </td>
            </tr>

            <tr>
                <th>Horario</th>
                <td><?= htmlspecialchars($reserva['horario']); ?></td>
            </tr>

            <tr>
                <th>Estado</th>
                <td>
                    <?php if($reserva['activo'] == 1): ?>
                        <span class="badge-active">Activa</span>
                    <?php else: ?>
                        <span class="badge-inactive">Inactiva</span>
                    <?php endif; ?>
                </td>
            </tr>

            <tr>
                <th>Especialidad</th>
                <td><?= htmlspecialchars($reserva['especialidad']); ?></td>
            </tr>

            <tr>
                <th>Paciente</th>
                <td><?= htmlspecialchars($reserva['paciente']); ?></td>
            </tr>

            <tr>
                <th>Profesional</th>
                <td><?= htmlspecialchars($reserva['empleado']); ?></td>
            </tr>

            <tr>
                <th>Creación</th>
                <td>
                    <?php
                        echo (new DateTime($reserva['created_at']))
                            ->format('d-m-Y H:i:s');
                    ?>
                </td>
            </tr>

            <tr>
                <th>Última modificación</th>
                <td>
                    <?php
                        echo (new DateTime($reserva['updated_at']))
                            ->format('d-m-Y H:i:s');
                    ?>
                </td>
            </tr>

        </table>

        <div class="mt-4 d-flex gap-2">
<!-- 
            <?php /*if($_SESSION['usuario_rol'] == 'Administrador'):*/ ?>
                <a href="<?= EDIT_RESERVA . $id ?>" class="btn btn-outline-success">
                    ✏️ Editar
                </a>
            <?php/* endif;*/ ?> -->

        </div>

        <?php else: ?>

            <div class="empty">
                <h5>No hay datos de la reserva</h5>
                <p>Puede que haya sido eliminada o no exista.</p>
            </div>

        <?php endif; ?>

    </div>

</div>

</body>
</html>

<?php else: ?>
<?php header('Location: ' . LOGIN); ?>
<?php endif; ?>
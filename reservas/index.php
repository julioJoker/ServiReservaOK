<?php
    #instrucciones que nos permiten ver errores en tiempos de ejecucion
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    #llamada al archivo que contiene las rutas del sistema
    require('../class/rutas.php');
    require('../class/config.php');
    require('../class/session.php');
    require('../class/reservaModel.php');

    $session = new Session;
    $reserva = new ReservaModel;
    $reservas = $reserva->getReservas();

    //print_r($roles);exit;

    $title = 'Reservas';

?>
<?php if(isset($_SESSION['autenticado'])): ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo TITLE . $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script>
    <link rel="icon" type="image/png" href="../img/favicon.png">
</head>
<body>

<header>
    <?php include('../partials/menu.php'); ?>
</header>
<style>
    body {
        min-height: 100vh;
        background: linear-gradient(135deg, #667eea, #764ba2);
    }

    /* Tarjeta glass */
    .glass-card {
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-radius: 20px;
        border: 1px solid rgba(255,255,255,0.2);
        box-shadow: 0 8px 32px rgba(0,0,0,0.25);
    }

    /* Títulos */
    h4 {
        color: white;
        font-weight: 600;
    }

    /* Tabla moderna */
    .table {
        color: white;
    }

    .table thead {
        background: rgba(255,255,255,0.15);
    }

    .table-hover tbody tr:hover {
        background: rgba(255,255,255,0.1);
    }

    /* Botón */
    .btn-outline-success {
        border-radius: 10px;
        padding: 4px 12px;
    }
    body {
        padding-top: 90px; /* ajusta según tu navbar */
    }

    /* 📱 MODO MOBILE */
    @media (max-width: 768px) {

        .glass-card {
            border-radius: 15px;
            padding: 15px !important;
        }

        .table thead {
            display: none;
        }

        .table, 
        .table tbody, 
        .table tr, 
        .table td {
            display: block;
            width: 100%;
        }

        .table tr {
            margin-bottom: 15px;
            background: rgba(255,255,255,0.08);
            border-radius: 12px;
            padding: 12px;
        }

        .table td {
            text-align: left;
            padding: 10px;
            padding-left: 45%;
            position: relative;
            font-size: 14px;
        }

        .table td::before {
            position: absolute;
            left: 10px;
            top: 10px;
            width: 40%;
            font-weight: 600;
            color: #ccc;
            font-size: 13px;
        }

        .table td:nth-of-type(1)::before { content: "Creación"; }
        .table td:nth-of-type(2)::before { content: "Profesional"; }
        .table td:nth-of-type(3)::before { content: "Especialidad"; }
        .table td:nth-of-type(4)::before { content: "Fecha"; }
        .table td:nth-of-type(5)::before { content: "Horario"; }

        /* Header stack */
        .d-flex {
            flex-direction: column;
            align-items: stretch !important;
            gap: 10px;
        }

        .btn {
            width: 100%;
        }
    }


</style>
<div class="container mt-3 px-2">

    <div class="glass-card p-3 p-md-4 w-100 mx-auto">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4><?= $title ?></h4>
            <a href="<?= ADD_PACIENTE ?>" class="btn btn-success btn-sm">
                + Nuevo Paciente
            </a>
        </div>

        <?php include('../partials/mensajes.php'); ?>

        <?php if(!empty($reservas)): ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    
                    <thead>
                        <tr>
                            <th>Fecha Creacion</th>
                            <th>Profesional</th>
                            <th>Especialidad</th>
                            <th>Fecha</th>
                            <th>Horario</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($reservas as $reserva): ?>
                            <tr>
                                <td>
                                    <a href="<?= SHOW_RESERVA . $reserva['id']; ?>" class="text-white text-decoration-none">
                                        <?php
                                            $fecha = new DateTime($reserva['created_at']);
                                            echo $fecha->format('d-m-Y H:i');
                                        ?>
                                    </a>
                                </td>
                                <td><?= $reserva['nombreEmpleado']; ?></td>
                                <td><?= $reserva['especialidad']; ?></td>
                                <td>
                                    <?php
                                        $fecha = new DateTime($reserva['fecha']);
                                        echo $fecha->format('d-m-Y');
                                    ?>
                                </td>
                                <td><?= $reserva['horario']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>

        <?php else: ?>
            <p class="text-white text-center">No hay reservas registradas</p>
        <?php endif; ?>

    </div>

</div>

</body>
</html>
<?php else: ?>
    <?php
        header('Location: ' . LOGIN);
    ?>
<?php endif; ?>
<?php
    #instrucciones que nos permiten ver errores en tiempos de ejecucion
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    #llamada al archivo que contiene las rutas del sistema
    require('../class/rutas.php');
    require('../class/config.php');
    require('../class/session.php');
    require('../class/pacienteModel.php');
    require('../class/telefonoModel.php');
    require('../class/reservaModel.php');

    $session = new Session;

    if (isset($_GET['paciente'])) {
        $id = (int) $_GET['paciente'];

        $pacientes = new PacienteModel;
        $telefono = new TelefonoModel;
        $reserva = new ReservaModel;

        $paciente = $pacientes->getPacienteId($id);
        $type = 'Paciente';

        $telefonos = $telefono->getTelefonoIdType($id, $type);
        $reservas = $reserva->getReservaPaciente($id);

    }

    //print_r($roles);exit;

    $title = 'Pacientes';

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
</head>
<style>
body {
    background: linear-gradient(135deg, #0f172a, #1e293b);
    min-height: 100vh;
    font-family: Arial, sans-serif;
}

.container-fluid {
    margin-top: 70px;
}

.card-custom {
    background: #fff;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    margin-bottom: 20px;
}

.card-title {
    font-weight: bold;
    margin-bottom: 20px;
    color: #0f172a;
}

.table th {
    width: 40%;
    color: #374151;
}

.table td {
    color: #111827;
}

.btn {
    border-radius: 10px;
}

.btn-group-custom {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.list-group-item {
    border-radius: 8px !important;
    margin-bottom: 5px;
}

@media (max-width: 768px) {
    .btn-group-custom {
        flex-direction: column;
    }
}
</style>
<body>
    <header>
        <!-- llamada a archivo de menu -->
        <?php /*include('../partials/menu.php'); */?>
    </header>
    <div class="container-fluid">
        <div class="row">

            <!-- 🧍 PACIENTE -->
            <div class="col-lg-6">
                <div class="card-custom">

                    <h4 class="card-title">Ficha del Paciente</h4>

                    <?php include('../partials/mensajes.php'); ?>

                    <?php if(!empty($paciente)): ?>

                    <table class="table table-borderless">
                        <tr><th>RUT:</th><td><?= $paciente['rut']; ?></td></tr>
                        <tr><th>Nombre:</th><td><?= $paciente['nombre']; ?></td></tr>
                        <tr><th>Email:</th><td><?= $paciente['email']; ?></td></tr>
                        <tr><th>Dirección:</th><td><?= $paciente['direccion']; ?></td></tr>
                        <tr>
                            <th>Fecha Nacimiento:</th>
                            <td><?= (new DateTime($paciente['fecha_nacimiento']))->format('d-m-Y'); ?></td>
                        </tr>
                        <tr><th>Edad:</th><td><?= $paciente['edad']; ?> años</td></tr>
                        <tr><th>Sexo:</th><td><?= $paciente['sexo']; ?></td></tr>

                        <tr>
                            <th>Teléfonos:</th>
                            <td>
                                <?php if ($telefonos): ?>
                                    <?php foreach($telefonos as $telefono): ?>
                                        <div>
                                            <a href="<?= SHOW_TELEFONO . $telefono['id']; ?>">
                                                +56 <?= $telefono['numero']; ?>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <span class="text-muted">Sin teléfono</span>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <tr>
                            <th>Creado:</th>
                            <td><?= (new DateTime($paciente['created_at']))->format('d-m-Y H:i'); ?></td>
                        </tr>
                        <tr>
                            <th>Modificado:</th>
                            <td><?= (new DateTime($paciente['updated_at']))->format('d-m-Y H:i'); ?></td>
                        </tr>
                    </table>

                    <!-- BOTONES -->
                    <div class="btn-group-custom mt-3">
                        <?php if($_SESSION['usuario_rol'] == 'Administrador'): ?>
                            <a href="<?= EDIT_PACIENTE . $id ?>" class="btn btn-outline-success">Editar</a>
                        <?php endif; ?>

                        <a href="<?= ADD_TEL_PAC . $id; ?>" class="btn btn-outline-secondary">Teléfono</a>
                        <a href="<?= ADD_RESERVA . $id ?>" class="btn btn-outline-primary">Reservar</a>
                        <a href="<?= PACIENTES; ?>" class="btn btn-outline-dark">Volver</a>
                    </div>

                    <?php else: ?>
                        <p class="text-info">No hay datos</p>
                    <?php endif; ?>

                </div>
            </div>

            <!-- 📅 RESERVAS -->
            <div class="col-lg-6">
                <div class="card-custom">

                    <h4 class="card-title">Horas Reservadas</h4>

                    <?php if(!empty($reservas)): ?>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Creación</th>
                                    <th>Especialidad</th>
                                    <th>Fecha</th>
                                    <th>Horario</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($reservas as $reserva): ?>
                                <tr>
                                    <td>
                                        <a href="<?= SHOW_RESERVA . $reserva['id']; ?>">
                                            <?= (new DateTime($reserva['created_at']))->format('d-m-Y H:i'); ?>
                                        </a>
                                    </td>
                                    <td><?= $reserva['especialidad']; ?></td>
                                    <td><?= (new DateTime($reserva['fecha']))->format('d-m-Y'); ?></td>
                                    <td><?= $reserva['horario']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php else: ?>
                        <p class="text-muted">No hay reservas registradas</p>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>

</body>
</html>
<?php else: ?>
    <?php
        header('Location: ' . LOGIN);
    ?>
<?php endif; ?>
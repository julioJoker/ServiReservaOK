<?php
    #instrucciones que nos permiten ver errores en tiempos de ejecucion
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    #llamada al archivo que contiene las rutas del sistema
    require('../class/rutas.php');
    require('../class/config.php');
    require('../class/session.php');
    require('../class/pacienteModel.php');

    $session = new Session;
    $paciente = new PacienteModel;
    //$pacientes = $paciente->getPacientes();
    if (isset($_GET['buscar']) && $_GET['buscar'] != '') {
        $buscar = trim($_GET['buscar']);
        $pacientes = $paciente->buscarPacientes($buscar);
    } else {
        $pacientes = $paciente->getPacientes();
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
    <link rel="icon" type="image/png" href="../img/favicon.png">
</head>
<style>
    body {
        background: #7a85a0;
        color: #e2e8f0;
         padding-top: 90px;
    }

    .container-fluid {
        padding-top: 30px;
    }

    h4 {
        color: #f1f5f9;
        margin-bottom: 20px;
    }

    .table {
        color: #e2e8f0;
        background: #1e293b;
        border-radius: 10px;
        overflow: hidden;
    }

    .table thead {
        background: #0b1220;
    }

    .table tbody tr {
        border-color: #334155;
    }

    .table-hover tbody tr:hover {
        background: #334155;
        color: #fff;
    }

    .table th {
        border-bottom: 1px solid #334155 !important;
        color: #93c5fd;
    }

    .table td {
        border-top: 1px solid #334155;
    }

    a {
        color: #38bdf8;
        text-decoration: none;
    }

    a:hover {
        color: #60a5fa;
        text-decoration: underline;
    }

    .btn-outline-success {
        border-color: #22c55e;
        color: #22c55e;
    }

    .btn-outline-success:hover {
        background: #22c55e;
        color: #0f172a;
    }

    .text-info {
        color: #38bdf8 !important;
    }

    .card-like {
        background: #1e293b;
        padding: 20px;
        border-radius: 12px;
        border: 1px solid #334155;
    }

    .input-group input{
        background:#1e293b;
        color:#fff;
        border:1px solid #334155;
    }

    .input-group input::placeholder{
        color:#94a3b8;
    }
</style>
<body>
    <header>
        <!-- llamada a archivo de menu -->
        <?php include('../partials/menu.php'); ?>
    </header>
    <div class="container-fluid">
        <div class="col-md-6 offset-md-3">
            <h4><?php echo $title; ?> <a href="<?php echo ADD_PACIENTE; ?>" class="btn btn-outline-success btn-sm">Nuevo Paciente</a> </h4>

            <?php include('../partials/mensajes.php'); ?>

            <?php if(!empty($pacientes)): ?>
                <form method="GET" class="mb-3">
                    <div class="input-group">

                        <input 
                            type="text" 
                            name="buscar" 
                            class="form-control" 
                            placeholder="🔍 Buscar por nombre o RUT..."
                            value="<?= $_GET['buscar'] ?? '' ?>"
                        >

                        <button class="btn btn-outline-info" type="submit">
                            Buscar
                        </button>

                        <?php if (!empty($_GET['buscar'])): ?>
                            <a href="index.php" class="btn btn-outline-secondary">
                                ❌ Limpiar
                            </a>
                        <?php endif; ?>

                    </div>
                </form>
                <table class="table table-hover">
                    <tr>
                        <th>RUT</th>
                        <th>Nombre</th>
                        <th>Previsión</th>
                    </tr>
                    <?php foreach($pacientes as $paciente): ?>
                        <tr>
                            <td>
                                <a href="<?php echo SHOW_PACIENTE . $paciente['id']; ?>">
                                    <?php echo $paciente['rut']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo SHOW_PACIENTE . $paciente['id']; ?>">
                                    <?php echo $paciente['nombre']; ?>
                                </a>
                            </td>
                            <td>
                                <?php
                                    if ($paciente['fonasa'] == 1) {
                                        echo 'Fonasa';
                                    } elseif ($paciente['fonasa'] == 2) {
                                        echo 'Isapre';
                                    } else {
                                        echo 'Particular';
                                    }
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p class="text-info">No hay pacientes registrados</p>
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
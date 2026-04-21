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

    if (isset($_GET['reserva'])) {
        $id = (int) $_GET['reserva'];

        $reservas = new ReservaModel;

        $reserva = $reservas->getReservaId($id);

    }

    //print_r($roles);exit;

    $title = 'Reserva';

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
<body>
    <header>
        <!-- llamada a archivo de menu -->
        <?php include('../partials/menu.php'); ?>
    </header>
    <div class="container-fluid">
        <div class="col-md-6 offset-md-3">
            <h4><?php echo $title; ?> </h4>

            <?php include('../partials/mensajes.php'); ?>

            <?php if(!empty($reserva)): ?>
                <table class="table table-hover">
                    <table class="table table-hover">
                    <tr>
                       <th>Fecha Reserva:</th>
                       <td>
                            <?php
                                $fecha_reserva = new DateTime($reserva['fecha']);
                                echo $fecha_reserva->format('d-m-Y');
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Horario:</th>
                        <td><?php echo $reserva['horario']; ?></td>
                    </tr>
                    <tr>
                        <th>Activo:</th>
                        <td>
                            <?php
                                if ($reserva['activo'] == 1) {
                                    echo 'Si';
                                }else {
                                    echo 'No';
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Especialidad:</th>
                        <td><?php echo $reserva['especialidad']; ?></td>
                    </tr>
                    <tr>
                        <th>Paciente:</th>
                        <td><?php echo $reserva['paciente']; ?></td>
                    </tr>
                    <tr>
                        <th>Empleado:</th>
                        <td><?php echo $reserva['empleado']; ?></td>
                    </tr>

                    <tr>
                        <th>Fecha Creación:</th>
                        <td>
                            <?php
                                $creado = new DateTime($reserva['created_at']);
                                echo $creado->format('d-m-Y H:i:s');
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Fecha Modificación:</th>
                        <td>
                            <?php
                                $modificado = new DateTime($reserva['updated_at']);
                                echo $modificado->format('d-m-Y H:i:s');
                            ?>
                        </td>
                    </tr>
                </table>
                <p>
                    <?php if($_SESSION['usuario_rol'] == 'Administrador'): ?>
                        <a href="<?php echo EDIT_RESERVA . $id ?>" class="btn btn-outline-success">Editar</a>
                    <?php endif; ?>
                    <a href="<?php echo BASE_URL; ?>" class="btn btn-outline-success">Volver</a>
            <?php else: ?>
                <p class="text-info">No hay datos</p>
            <?php endif; ?>
        </div>

    </div>

</body>
</html>
<?php else: ?>
    <?php
        header('Location: ' . LOGIN);
    ?>
<?php endif; ?>fgdfgdfgdfgdfgdgfdgdfgdffdgdfgdf
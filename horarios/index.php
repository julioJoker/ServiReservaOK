<?php
    #instrucciones que nos permiten ver errores en tiempos de ejecucion
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    session_start();

    #llamada al archivo que contiene las rutas del sistema
    require('../class/rutas.php');
    require('../class/config.php');
    require('../class/horarioModel.php');

    $horario = new HorarioModel;
    $horarios = $horario->getHorarios();

    //print_r('hola');exit;

    $title = 'Horarios';

    

?>

<?php if(isset($_SESSION['error'])): ?>
    <div class="alert alert-danger">
        <?php echo $_SESSION['error']; ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <?php echo $_SESSION['success']; ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['autenticado']) && $_SESSION['usuario_rol'] == 'Administrador'): ?>
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
        min-height: 100vh;
        background: linear-gradient(135deg, #43cea2, #185a9d);
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

    /* Título */
    h4 {
        color: white;
        font-weight: 600;
    }

    /* Tabla */
    .table {
        color: white;
    }

    .table thead {
        background: rgba(255,255,255,0.15);
    }

    .table-hover tbody tr:hover {
        background: rgba(255,255,255,0.1);
    }

    /* Links */
    .table a {
        color: #fff;
        text-decoration: none;
    }

    .table a:hover {
        text-decoration: underline;
    }

    /* Botón */
    .btn-outline-success {
        border-radius: 10px;
        border-color: #fff;
        color: #fff;
    }

    .btn-outline-success:hover {
        background: #fff;
        color: #185a9d;
    }
    body {
        padding-top: 80px; /* ajusta según altura del navbar */
    }
</style>
<body>
    <header>
        <!-- llamada a archivo de menu -->
        <?php include('../partials/menu.php'); ?>
    </header>
    <div class="container-fluid">
        <div class="col-md-6 offset-md-3">
            <h4><?php echo $title ?> <a href="<?php echo ADD_HORARIO; ?>" class="btn btn-outline-success btn-sm">Nuevo Horario</a> </h4>

            <?php include('../partials/mensajes.php'); ?>

            <?php if(!empty($horarios)): ?>
                <table class="table table-hover">
                    <tr>
                        <th>Id</th>
                        <th>Horario</th>
                        <th>Acciones</th>
                    </tr>
                    <?php $horarioModel = new HorarioModel(); ?>
                    <?php foreach($horarios as $horario): ?>
                        <tr>
                            <td><?php echo $horario['id']; ?></td>
                            <td>
                                <a href="<?php echo SHOW_HORARIO . $horario['id']; ?>">
                                    <?php echo $horario['horario']; ?>
                                </a>

                            </td>
                            <td>
                                <?php if($horarioModel->tieneReservas($horario['id'])): ?>

                                    <!-- Botón bloqueado -->
                                    <button class="btn btn-secondary btn-sm" disabled title="Horario en uso">
                                        🔒 Ocupado
                                    </button>

                                <?php else: ?>

                                    <!-- Formulario eliminar -->
                                    <form action="delete.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $horario['id']; ?>">
                                        <button 
                                            type="submit" 
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('¿Estás seguro de eliminar este horario?');">
                                            🗑 Eliminar
                                        </button>
                                    </form>

                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p class="text-info">No hay horarios registrados</p>
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
<?php
    #instrucciones que nos permiten ver errores en tiempos de ejecucion
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    #llamada al archivo que contiene las rutas del sistema
    require('../class/rutas.php');
    require('../class/config.php');
    require('../class/session.php');
    require('../class/telefonoModel.php');
    require('../class/empleadoModel.php');
    require('../class/pacienteModel.php');

    $session = new Session;

    if (isset($_GET['telefono'])) {
         $id = (int) $_GET['telefono'];

        $telefonos = new TelefonoModel;
        $empleados = new EmpleadoModel;
        $pacientes = new PacienteModel;

        $telefono = $telefonos->getTelefonoId($id);

        //print_r($telefono);exit;

        $id_usuario = $telefono['telefonoable_id'];
        $type = $telefono['telefonoable_type'];

        if ($type == 'Empleado') {
            $usuario = $empleados->getEmpleadoId($id_usuario);
        }else {
            $usuario = $pacientes->getPacienteId($id_usuario);
        }
    }


    $title = 'Telefono';

?>
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
    <script src="../js/funciones.js"></script>
</head>
<body>
    <header>
        <!-- llamada a archivo de menu -->
        <?php include('../partials/menu.php'); ?>
    </header>
    <div class="container-fluid">
        <div class="col-md-6 offset-md-3">
            <h4><?php echo $title ?> </h4>

            <?php include('../partials/mensajes.php'); ?>

            <?php if(!empty($telefono)): ?>
                <table class="table table-hover">
                   <tr>
                       <th>Número:</th>
                       <td>+56 <?php echo $telefono['numero']; ?></td>
                   </tr>
                   <tr>
                       <th>Entidad:</th>
                       <td><?php echo $telefono['telefonoable_type']; ?></td>
                   </tr>
                   <tr>
                       <th>Usuario:</th>
                       <td><?php echo $usuario['nombre'] ?></td>
                   </tr>
                </table>
                <p>
                    <a href="<?php echo EDIT_TELEFONO . $id ?>" class="btn btn-outline-success">Editar</a>

                    <?php if($type == 'Empleado'): ?>
                        <a href="<?php echo SHOW_EMPLEADO . $id_usuario; ?>" class="btn btn-outline-primary">Volver</a>
                    <?php else: ?>
                        <a href="<?php echo SHOW_PACIENTE . $id_usuario; ?>" class="btn btn-outline-primary">Volver</a>
                    <?php endif; ?>

                    <form name="form" action="<?php echo DEL_TELEFONO; ?>" method="post">
                        <input type="hidden" name="telefono" value="<?php echo $id?>">
                        <input type="hidden" name="confirm" value="1">
                        <button type="button" onclick="eliminarTelefono();" class="btn btn-outline-warning">Eliminar</button>
                    </form>
                </p>
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
<?php endif; ?>
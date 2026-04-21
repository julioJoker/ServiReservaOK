<?php
    #instrucciones que nos permiten ver errores en tiempos de ejecucion
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    #llamada al archivo que contiene las rutas del sistema
    require('../class/rutas.php');
    require('../class/config.php');
    require('../class/session.php');
    require('../class/rolModel.php');

    $session = new Session;

    if (isset($_GET['rol'])) {
         $id = (int) $_GET['rol'];

        $rol = new RolModel;
        #verificar que hay un rol con el id del rol enviado desde index
        $rol = $rol->getRolId($id);
    }


    $title = 'Rol';

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

            <?php if(!empty($rol)): ?>
                <table class="table table-hover">
                   <tr>
                       <th>Id:</th>
                       <td><?php echo $rol['id']; ?></td>
                   </tr>
                   <tr>
                       <th>Rol:</th>
                       <td><?php echo $rol['nombre']; ?></td>
                   </tr>
                </table>
                <p>
                    <a href="<?php echo EDIT_ROL . $id ?>" class="btn btn-outline-success">Editar</a>
                    <a href="<?php echo ROLES; ?>" class="btn btn-outline-primary">Volver</a>

                    <form name="form" action="<?php echo DEL_ROL; ?>" method="post">
                        <input type="hidden" name="rol" value="<?php echo $id?>">
                        <input type="hidden" name="confirm" value="1">
                        <button type="button" onclick="eliminarRol();" class="btn btn-outline-warning">Eliminar</button>
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
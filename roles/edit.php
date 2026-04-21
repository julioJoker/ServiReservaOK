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

        $roles = new RolModel;
        #verificar que hay un rol con el id del rol enviado desde index
        $rol = $roles->getRolId($id);

        if (isset($_POST['confirm']) && $_POST['confirm'] == 1) {
            $nombre = trim(strip_tags($_POST['nombre']));

            if (!$nombre) {
                $msg = 'Ingrese el nombre del rol';
            }else{
                #editar el rol enviado
                $row = $roles->updateRol($id, $nombre);

                if ($row) {
                    $_SESSION['success'] = 'El rol se ha modificado correctamente';
                    header('Location: ' . SHOW_ROL . $id);
                }
            }
        }
    }



    //print_r($rol);exit;

    $title = 'Editar Rol';

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

            <?php if(isset($msg)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $msg; ?>
                </div>
            <?php endif; ?>

            <?php if(!empty($rol)): ?>
                <form name="form" action="" method="post">
                    <div class="row g-3 align-items-center">
                        <div class="col-auto">
                            <label for="rol" class="col-form-label">Rol<span class="text-danger">*</span>  </label>
                        </div>
                        <div class="col-auto">
                            <input type="text" name="nombre" value="<?php echo $rol['nombre']; ?>" id="" class="form-control" aria-describedby="rolHelpInline">
                        </div>
                        <div class="col-auto">
                            <span id="rolHelpInline" class="form-text text-danger">
                            Escriba un rol
                            </span>
                        </div>
                        <div class="">
                            <input type="hidden" name="confirm" value="1">
                            <button type="button" onclick="validaForm();" class="btn btn-outline-success">Editar</button>
                            <a href="<?php echo SHOW_ROL . $id; ?>" class="btn btn-outline-primary">Volver</a>
                        </div>
                    </div>

                </form>
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
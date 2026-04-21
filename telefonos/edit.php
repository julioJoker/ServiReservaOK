<?php
    #instrucciones que nos permiten ver errores en tiempos de ejecucion
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    #llamada al archivo que contiene las rutas del sistema
    require('../class/rutas.php');
    require('../class/config.php');
    require('../class/session.php');
    require('../class/telefonoModel.php');

    $session = new Session;


    if (isset($_GET['telefono'])) {
         $id = (int) $_GET['telefono'];

        $telefonos = new TelefonoModel;
        #verificar que hay un rol con el id del rol enviado desde index
        $telefono = $telefonos->getTelefonoId($id);
        $type = $telefono['telefonoable_type'];

        if (isset($_POST['confirm']) && $_POST['confirm'] == 1) {
            $numero = filter_var($_POST['numero'], FILTER_VALIDATE_INT);

            if (strlen($numero) < 9 || strlen($numero) > 9) {
                $msg = 'El número de teléfono debe tener 9 digitos';
            }else{
                $tel = $telefonos->getTelefonoNumero($numero);

                if ($tel) {
                    $msg = 'El teléfono ingresado ya existe... intente con otro';
                }else{
                    $tel = $telefonos->editTelefono($id, $numero);

                    if ($tel) {
                        $_SESSION['success'] = 'El teléfono se ha modificdo correctamente';
                        if ($type == 'Empleado') {
                            header('Location: ' . SHOW_EMPLEADO . $telefono['telefonoable_id']);
                        }else{
                            #vista paciente id
                        }
                    }
                }
            }
        }
    }



    //print_r($rol);exit;

    $title = 'Editar Teléfono';

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

            <?php if(!empty($telefono)): ?>
                <form name="form" action="" method="post">
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono<span class="text-danger">*</span>  </label>
                        <input type="number" name="numero" value="<?php echo $telefono['numero']; ?>" class="form-control" aria-describedby="empleadoHelpInline">
                        <div id="empleadoHelp" class="form-text text-danger">Ingrese el teléfono del Empleado con 9 dígitos</div>
                    </div>
                    <div class="mb-3">
                        <input type="hidden" name="confirm" value="1">
                        <button type="submit" class="btn btn-outline-success">Editar</button>
                        <?php if($telefono['telefonoable_type'] == 'Empleado'): ?>
                            <a href="<?php echo SHOW_EMPLEADO . $telefono['telefonoable_id']; ?>" class="btn btn-outline-primary">Volver</a>
                        <?php else: ?>
                            Vista paciente id
                        <?php endif; ?>
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
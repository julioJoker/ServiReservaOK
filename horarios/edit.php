<?php
    #instrucciones que nos permiten ver errores en tiempos de ejecucion
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    session_start();

    #llamada al archivo que contiene las rutas del sistema
    require('../class/rutas.php');
    require('../class/config.php');
    require('../class/horarioModel.php');

    //print_r('hola');

    if (isset($_GET['horario'])) {
        $id = (int) $_GET['horario'];

        $horarios = new HorarioModel;

        $horario = $horarios->getHorarioId($id);

        if (isset($_POST['confirm']) && $_POST['confirm'] == 1) {

        //print_r($_POST);exit;

            $horario = trim(strip_tags($_POST['horario'])); //sanitizacion basica

            if (!$horario) {
                $msg = 'Ingrese el horario';
            }else{

                $res = $horarios->editHorario($id, $horario);

                //print_r($res);exit;

                if ($res) {
                    $_SESSION['success'] = 'El horario se ha modificado correctamente';
                    header('Location: ' . SHOW_HORARIO . $id);
                }
            }

            //print_r($nombre);
        }

    }



    //print_r($roles);exit;

    $title = 'Editar Horario';

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

            <?php if($horario): ?>
                <form name="form" action="" method="post">
                    <div class="mb-3">
                    <label for="horario" class="form-label">Horario<span class="text-danger">*</span>  </label>
                    <input type="text" name="horario" value="<?php echo $horario['horario']; ?>" class="form-control" aria-describedby="empleadoHelpInline">
                        <div id="empleadoHelp" class="form-text text-danger">Ingrese el horario</div>
                </div>
                <div class="mb-3">
                    <input type="hidden" name="confirm" value="1">
                    <button type="submit" class="btn btn-outline-success">Editar</button>
                    <a href="<?php echo SHOW_HORARIO . $id; ?>" class="btn btn-outline-primary">Volver</a>
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
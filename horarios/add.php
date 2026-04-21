<?php
    #instrucciones que nos permiten ver errores en tiempos de ejecucion
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    session_start();

    #llamada al archivo que contiene las rutas del sistema
    require('../class/rutas.php');
    require('../class/config.php');
    require('../class/horarioModel.php');

    $horarios = new HorarioModel;

    if (isset($_POST['confirm']) && $_POST['confirm'] == 1) {

        //print_r($_POST);exit;

        $horario = trim(strip_tags($_POST['horario'])); //sanitizacion basica

        //print_r($nombre);exit;

        if (!$horario) {
            $msg = 'Ingrese el horario';
        }else{

            $res = $horarios->getHorarioHorario($horario);

            if (!empty($res)) {
                $msg = 'El horario ingresado ya existe... intente con otro';
            }else {

                $res = $horarios->addHorario($horario);

                if (!empty($res)) {
                    $_SESSION['success'] = 'El horario se ha registrado correctamente';
                    header('Location: ' . HORARIOS);
                }
            }
        }

        //print_r($nombre);
    }

    //print_r($roles);exit;

    $title = 'Nuevo Horario';

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

<style>
body {
    padding-top: 80px; /* 🔥 evita que el navbar lo tape */
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea, #764ba2);
}
</style>
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

            <form name="form" action="" method="post">
                <div class="mb-3">
                    <label for="horario" class="form-label">Horario<span class="text-danger">*</span>  </label>
                    <input type="text" name="horario" value="<?php if(isset($_POST['horario'])) echo $_POST['horario']; ?>" class="form-control" aria-describedby="empleadoHelpInline">
                        <div class="form-text text-white">Ingrese el horario</div>
                </div>
                <div class="mb-3">
                    <input type="hidden" name="confirm" value="1">

                    <button type="submit" class="btn btn-success">
                        Guardar
                    </button>

                    <a href="<?php echo HORARIOS; ?>" class="btn btn-primary">
                        Volver
                    </a>
                </div>

            </form>
        </div>

    </div>

</body>
</html>
<?php else: ?>
    <?php
        header('Location: ' . LOGIN);
    ?>
<?php endif; ?>
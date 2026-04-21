<?php
    #instrucciones que nos permiten ver errores en tiempos de ejecucion
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    session_start();

    #llamada al archivo que contiene las rutas del sistema
    require('../class/rutas.php');
    require('../class/config.php');
    require('../class/especialidadModel.php');

    //print_r('hola');

    if (isset($_GET['especialidad'])) {
        $id = (int) $_GET['especialidad'];

        $especialidades = new EspecialidadModel;

        $especialidad = $especialidades->getEspecialidadId($id);

        if (isset($_POST['confirm']) && $_POST['confirm'] == 1) {

        //print_r($_POST);exit;

            $nombre = trim(strip_tags($_POST['nombre'])); //sanitizacion basica

            //print_r($nombre);exit;

            if (strlen($nombre) < 4) {
                $msg = 'El nombre de la especialidad debe tener al menos 3 caracteres';
            }else{
                #verificar que la especialidad ingresada no existe
                $res = $especialidades->updateEspecialidad($id, $nombre);

                //print_r($res);exit;

                if ($res) {
                    $_SESSION['success'] = 'La especialidad se ha modificado correctamente';
                    header('Location: ' . SHOW_ESPECIALIDAD . $id);
                }
            }

            //print_r($nombre);
        }

    }



    //print_r($roles);exit;

    $title = 'Editar Especialidad';

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

            <?php if($especialidad): ?>
                <form name="form" action="" method="post">
                    <div class="row g-3 align-items-center">
                        <div class="col-auto">
                            <label for="especialidad" class="col-form-label">Especialidad<span class="text-danger">*</span>  </label>
                        </div>
                        <div class="col-auto">
                            <input type="text" name="nombre" value="<?php echo $especialidad['nombre']; ?>" id="" class="form-contespecialidad" aria-describedby="especialidadHelpInline">
                        </div>
                        <div class="col-auto">
                            <span id="especialidadHelpInline" class="form-text text-danger">
                            Escriba una especialidad
                            </span>
                        </div>
                        <div class="">
                            <input type="hidden" name="confirm" value="1">
                            <button type="button" onclick="validaForm();" class="btn btn-outline-success">Editar</button>
                            <a href="<?php echo SHOW_ESPECIALIDAD . $id; ?>" class="btn btn-outline-primary">Volver</a>
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
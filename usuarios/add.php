<?php
    #instrucciones que nos permiten ver errores en tiempos de ejecucion
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    #llamada al archivo que contiene las rutas del sistema
    require('../class/rutas.php');
    require('../class/config.php');
    require('../class/session.php');
    require('../class/empleadoModel.php');
    require('../class/usuarioModel.php');

    $session = new Session;

    $empleados = new EmpleadoModel;
    $usuarios = new UsuarioModel;

    $title = 'Nueva Cuenta';

    if (isset($_GET['empleado'])) {
        $id_empleado = (int) $_GET['empleado'];

        $empleado = $empleados->getEmpleadoId($id_empleado);

        if (isset($_POST['confirm']) && $_POST['confirm'] == 1) {

            $clave = trim(strip_tags($_POST['clave'])); //sanitizacion basica
            $reclave = trim(strip_tags($_POST['reclave']));

            if (empty($clave) || strlen($clave) < 8) {
                $msg = 'Ingrese el password de la cuenta con al menos 8 caracteres';
            }elseif ($reclave != $clave) {
                $msg = 'Los passwords ingresados no coinciden';
            }else{
                #verificar que el empleado ingresado no tenga una cuenta
                $res = $usuarios->getUsuarioEmpleado($id_empleado);

                if ($res) {
                    $msg = 'Este empleado ya tiene una cuenta... intente con otro';
                }else {
                    #ingresar el rol
                    $usuario = $usuarios->addUsuario($clave, $id_empleado);

                    if ($usuario) {
                        $_SESSION['success'] = 'La cuenta del empleado se ha registrado correctamente';
                        header('Location: ' . SHOW_EMPLEADO . $id_empleado);
                    }
                }
            }

            //print_r($nombre);
        }

    }


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

    /* ===== FONDO ===== */
    body {
        background: linear-gradient(135deg, #0f172a, #1e293b);
        font-family: system-ui, sans-serif;
        color: #e5e7eb;
    }

    /* ===== CARD FORM ===== */
    .form-box {
        max-width: 450px;
        margin: 80px auto;
        background: #ffffff;
        color: #1e293b;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.4);
    }

    /* ===== TITULO ===== */
    .form-box h4 {
        text-align: center;
        font-weight: 600;
        margin-bottom: 10px;
    }

    /* SUBTEXTO */
    .form-box .subtitle {
        text-align: center;
        font-size: 0.9rem;
        color: #64748b;
        margin-bottom: 20px;
    }

    /* INPUTS */
    .form-control {
        border-radius: 10px;
        padding: 10px;
    }

    .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 0.15rem rgba(37,99,235,0.2);
    }

    /* BOTONES */
    .btn-success {
        background: #2563eb;
        border: none;
        width: 100%;
        border-radius: 10px;
    }

    .btn-success:hover {
        background: #1d4ed8;
    }

    /* BOTÓN VOLVER */
    .btn-outline-primary {
        width: 100%;
        margin-top: 10px;
        border-radius: 10px;
    }

    /* ALERT */
    .alert {
        border-radius: 10px;
    }

    /* EMPLEADO BOX */
    .empleado-box {
        background: #f1f5f9;
        padding: 10px;
        border-radius: 10px;
        margin-bottom: 15px;
        font-weight: 500;
    }

</style>
<body>
    <header>
        <!-- llamada a archivo de menu -->
        <?php include('../partials/menu.php'); ?>
    </header>
    <div class="form-box">

        <h4>👤 <?php echo $title; ?></h4>
        <div class="subtitle">Crear cuenta de acceso</div>

        <?php if(isset($msg)): ?>
            <div class="alert alert-danger">
                <?php echo $msg; ?>
            </div>
        <?php endif; ?>

        <?php if($empleado): ?>

            <div class="empleado-box">
                Empleado: <?php echo $empleado['nombre']; ?>
            </div>

            <form method="post">

                <div class="mb-3">
                    <label class="form-label">Password *</label>
                    <input type="password" name="clave" class="form-control"
                        oncopy="return false" onpaste="return false"
                        placeholder="Ingrese contraseña">
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirmar Password *</label>
                    <input type="password" name="reclave" class="form-control"
                        oncopy="return false" onpaste="return false"
                        placeholder="Repita la contraseña">
                </div>

                <input type="hidden" name="confirm" value="1">

                <button type="submit" class="btn btn-success">
                    Crear cuenta
                </button>

                <a href="<?php echo SHOW_EMPLEADO . $id_empleado; ?>" class="btn btn-outline-primary">
                    Volver
                </a>

            </form>

        <?php else: ?>

            <div class="alert alert-info text-center">
                La cuenta no pudo ser creada
            </div>

        <?php endif; ?>

    </div>
</body>
</html>
<?php else: ?>
    <?php
        header('Location: ' . LOGIN);
    ?>
<?php endif; ?>
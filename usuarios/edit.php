<?php
    #instrucciones que nos permiten ver errores en tiempos de ejecucion
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    #llamada al archivo que contiene las rutas del sistema
    require('../class/rutas.php');
    require('../class/config.php');
    require('../class/session.php');
    require('../class/usuarioModel.php');

    $session = new Session;

    $usuarios = new UsuarioModel;

    $title = 'Editar Usuario';

    if (isset($_GET['usuario'])) {
        $id = (int) $_GET['usuario'];

        $usuario = $usuarios->getUsuarioId($id);

        if (isset($_POST['confirm']) && $_POST['confirm'] == 1) {

            $activo = filter_var($_POST['activo'], FILTER_VALIDATE_INT);

            if (!$activo) {
                $msg = 'Seleccione un estado para el empleado';
            }else{
                $usu = $usuarios->editUsuario($id, $activo);

                if ($usu) {
                    $_SESSION['success'] = 'El usuario se ha modificado correctamente';
                    header('Location: ' . SHOW_EMPLEADO . $usuario['empleado_id']);
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
<body>
    <header>
        <!-- llamada a archivo de menu -->
        <?php include('../partials/menu.php'); ?>
    </header>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        /* ===== FONDO ===== */
        body{
            min-height:100vh;
            margin:0;
            font-family: 'Segoe UI', sans-serif;
            background: radial-gradient(circle at top, #0f172a, #020617);
            color:#e5e7eb;
        }

        /* CONTENEDOR */
        .wrapper{
            display:flex;
            justify-content:center;
            align-items:center;
            min-height:90vh;
        }

        /* CARD MODERNA */
        .card-modern{
            width:100%;
            max-width:500px;
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(14px);
            border:1px solid rgba(255,255,255,0.1);
            border-radius:20px;
            padding:30px;
            box-shadow:0 20px 50px rgba(0,0,0,0.6);
        }

        /* TITULO */
        .card-modern h4{
            font-weight:700;
            margin-bottom:10px;
        }

        /* INPUT */
        .form-control{
            background: rgba(255,255,255,0.08);
            border:1px solid rgba(255,255,255,0.15);
            color:#fff;
            border-radius:12px;
        }

        .form-control:focus{
            background: rgba(255,255,255,0.1);
            color:#fff;
            border-color:#38bdf8;
            box-shadow:0 0 0 0.2rem rgba(56,189,248,0.25);
        }

        /* BOTONES */
        .btn-modern{
            border-radius:12px;
            padding:10px 18px;
            font-weight:600;
            transition:0.2s;
        }

        .btn-success{
            background: linear-gradient(135deg, #22c55e, #4ade80);
            border:none;
        }

        .btn-success:hover{
            transform:translateY(-2px);
            box-shadow:0 10px 25px rgba(34,197,94,0.3);
        }

        .btn-secondary{
            background: rgba(255,255,255,0.1);
            border:none;
            color:#e5e7eb;
        }

        .btn-secondary:hover{
            background: rgba(255,255,255,0.2);
        }

        /* ALERTA */
        .alert{
            border-radius:12px;
        }

        /* TEXTO */
        small, .form-text{
            color:#94a3b8 !important;
        }

        select.form-control{
            background-color: rgba(255,255,255,0.08);
            color: #ffffff;
        }

        /* 🔥 SOLUCIÓN CLAVE */
        select.form-control option{
            color: #000;          /* texto negro */
            background: #fff;     /* fondo blanco */
        }

    </style>
    <div class="wrapper">

        <div class="card-modern">

            <h4>✏️ <?= $title; ?></h4>

            <?php if(isset($msg)): ?>
                <div class="alert alert-danger">
                    <?= $msg; ?>
                </div>
            <?php endif; ?>

            <?php if($usuario): ?>
                <form method="post">

                    <div class="mb-3">
                        <label class="form-label">
                            👤 <strong>Empleado:</strong> <?= $usuario['empleado']; ?>
                        </label>
                    </div>

                    <div class="mb-3">

                        <div class="mb-2">
                            <small>Estado actual:</small><br>
                            <strong>
                                <?= $usuario['activo'] == 1 ? '🟢 Activo' : '🔴 Inactivo'; ?>
                            </strong>
                        </div>
                        <select name="activo" class="form-control">

                            <option value="">Seleccione...</option>
                            <option value="1">Activar</option>
                            <option value="2">Desactivar</option>

                        </select>

                        <small>Seleccione el estado del empleado</small>
                    </div>

                    <input type="hidden" name="confirm" value="1">

                    <div class="d-flex justify-content-between mt-4">

                        <button type="submit" class="btn btn-success btn-modern">
                             Guardar cambios
                        </button>

                        <a href="<?= SHOW_EMPLEADO . $usuario['empleado_id']; ?>" 
                        class="btn btn-secondary btn-modern">
                            ⬅ Volver
                        </a>

                    </div>

                </form>

            <?php else: ?>
                <div class="alert alert-info">
                    El usuario no pudo ser modificado
                </div>
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
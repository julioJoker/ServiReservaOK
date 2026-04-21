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
    require('../class/usuarioModel.php');

    #crear un objeto de la clase RolModel
    $session = new Session;
    $telefonos = new TelefonoModel;
    $empleados = new EmpleadoModel;
    $usuarios = new UsuarioModel;

    if (isset($_GET['empleado'])) {
        $id_empleado = (int) $_GET['empleado'];

        $empleado = $empleados->getEmpleadoId($id_empleado);
        $usuario = $usuarios->getUsuarioEmpleado($id_empleado);

        if (isset($_POST['confirm']) && $_POST['confirm'] == 1) {
            $numero = filter_var($_POST['numero'], FILTER_VALIDATE_INT);

            if (strlen($numero) < 9 || strlen($numero) > 9) {
                $msg = 'El teléfono debe tener 9 dígitos';
            }else{
                $telefono = $telefonos->getTelefonoNumero($numero);

                if ($telefono) {
                    $msg = 'El teléfono ingresado ya existe... intente con otro';
                }else{
                    $type = 'Empleado';
                    $telefono = $telefonos->addTelefono($numero, $id_empleado, $type);

                    if ($telefono) {
                        $_SESSION['success'] = 'El teléfono se ha registrado correctamente';
                        header('Location: ' . SHOW_EMPLEADO . $id_empleado);
                    }
                }
            }
        }
    }

    $title = 'Nuevo Telefono';



?>
<?php if(isset($_SESSION['autenticado']) && $_SESSION['usuario_rol'] == 'Administrador' || $_SESSION['usuario_id'] == $usuario['id']): ?>
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
<style>
body {
    background: #0f172a;
    color: #e5e7eb;
    padding-top: 80px;
}

/* Card */
.card-custom {
    background: #1e293b;
    border-radius: 16px;
    border: 1px solid #334155;
    box-shadow: 0 10px 25px rgba(0,0,0,0.4);
}

/* Inputs */
.form-control {
    background: #020617;
    border: 1px solid #334155;
    color: #e5e7eb;
    border-radius: 10px;
}

.form-control:focus {
    background: #020617;
    color: #fff;
    border-color: #38bdf8;
    box-shadow: 0 0 0 0.2rem rgba(56,189,248,0.2);
}

/* Labels */
.form-label {
    color: #cbd5f5;
    font-size: 0.85rem;
}

/* Botones */
.btn {
    border-radius: 10px;
}

.btn-success {
    background: linear-gradient(45deg, #22c55e, #16a34a);
    border: none;
}

.btn-success:hover {
    opacity: 0.9;
}

/* Header */
.title-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Box empleado */
.user-box {
    background: rgba(148,163,184,0.08);
    border: 1px solid #334155;
    border-radius: 12px;
    padding: 10px 15px;
    margin-bottom: 15px;
}
</style>

<div class="container py-4">

    <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-4">

            <div class="card card-custom p-4">

                <!-- Header -->
                <div class="title-bar mb-3">
                    <h4 class="mb-0"><?php echo $title; ?></h4>

                    <a href="<?php echo SHOW_EMPLEADO . $id_empleado; ?>" 
                       class="btn btn-outline-secondary btn-sm">
                        ← Volver
                    </a>
                </div>

                <p class="text-danger small">Campos obligatorios *</p>

                <?php if(isset($msg)): ?>
                    <div class="alert alert-danger">
                        <?php echo $msg; ?>
                    </div>
                <?php endif; ?>

                <?php if($empleado): ?>

                <!-- Empleado -->
                <div class="user-box">
                    <small class="text-secondary">Empleado</small>
                    <div class="fw-semibold"><?php echo $empleado['nombre']; ?></div>
                </div>

                <form method="post">

                    <div class="mb-3">
                        <label class="form-label">Teléfono *</label>

                        <div class="input-group">
                            <span class="input-group-text bg-dark text-light border-secondary">
                                +56
                            </span>

                            <input type="number"
                                   name="numero"
                                   value="<?php if(isset($_POST['numero'])) echo $_POST['numero']; ?>"
                                   class="form-control"
                                   placeholder="912345678">
                        </div>

                        <div class="form-text text-danger">
                            Debe tener exactamente 9 dígitos
                        </div>
                    </div>

                    <!-- BOTONES -->
                    <div class="d-flex gap-2 mt-3">
                        <input type="hidden" name="confirm" value="1">

                        <button type="submit" class="btn btn-success btn-sm">
                            Guardar
                        </button>

                        <a href="<?php echo SHOW_EMPLEADO . $id_empleado; ?>" 
                           class="btn btn-outline-secondary btn-sm">
                            Cancelar
                        </a>
                    </div>

                </form>

                <?php else: ?>
                    <div class="alert alert-info text-center">
                        No se pudo agregar el teléfono
                    </div>
                <?php endif; ?>

            </div>

        </div>
    </div>

</div>
</body>
</html>
<?php else: ?>
    <?php
        header('Location: ' . LOGIN);
    ?>
<?php endif; ?>
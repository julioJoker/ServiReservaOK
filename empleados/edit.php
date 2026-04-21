<?php
    #instrucciones que nos permiten ver errores en tiempos de ejecucion
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    #llamada al archivo que contiene las rutas del sistema
    require('../class/rutas.php');
    require('../class/config.php');
    require('../class/session.php');
    require('../class/empleadoModel.php');
    require('../class/rolModel.php');
    require('../class/especialidadModel.php');

    $session = new Session;

    if (isset($_GET['empleado'])) {
        $id = (int) $_GET['empleado'];

        $empleados = new EmpleadoModel;
        $rol = new RolModel;
        $especialidad = new EspecialidadModel;

        $empleado = $empleados->getEmpleadoId($id);
        $roles = $rol->getRoles();
        $especialidades = $especialidad->getEspecialidades();

        if (isset($_POST['confirm']) && $_POST['confirm'] == 1) {
            //print_r($_POST);exit;
            $rut = trim(strip_tags($_POST['rut']));
            $nombre = trim(strip_tags($_POST['nombre']));
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $fecha_nacimiento = trim(strip_tags($_POST['fecha_nacimiento']));
            $rol = filter_var($_POST['rol'], FILTER_VALIDATE_INT);
            $especialidad = filter_var($_POST['especialidad'], FILTER_VALIDATE_INT);

            if (strlen($rut) < 9 || strlen($rut) > 10) {
                $msg = 'Ingrese el RUT del empleado';
            }elseif (strlen($nombre) < 4) {
                $msg = 'El nombre debe tener al menos 4 caracteres';
            }elseif (!$email) {
                $msg = 'Ingrese un email válido';
            }elseif (!$fecha_nacimiento) {
                $msg = 'Ingrese la fecha de nacimiento del empleado';
            }elseif (!$rol) {
                $msg = 'Seleccione el rol del empleado';
            }elseif (!$especialidad) {
                $msg = 'Seleccione la especialidad del empleado';
            }else{
                $emp = $empleados->editEmpleado($id, $rut, $nombre, $email, $fecha_nacimiento, $rol, $especialidad);

                if ($emp) {
                    $_SESSION['success'] = 'El empleado se ha modificado correctamente';
                    header('Location: ' . SHOW_EMPLEADO . $id);
                }
            }
        }

        //print_r($empleado);exit;
    }

    //print_r($roles);exit;

    $title = 'Editar Empleado';

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
.form-control, .form-select {
    background: #020617;
    border: 1px solid #334155;
    color: #e5e7eb;
    border-radius: 10px;
}

.form-control:focus, .form-select:focus {
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

/* Text help */
.form-text {
    font-size: 0.75rem;
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
</style>

<div class="container py-4">

    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">

            <div class="card card-custom p-4">

                <!-- Header -->
                <div class="title-bar mb-3">
                    <h4 class="mb-0"><?php echo $title; ?></h4>

                    <a href="<?php echo SHOW_EMPLEADO . $id; ?>" class="btn btn-outline-secondary btn-sm">
                        ← Volver
                    </a>
                </div>

                <?php if(isset($msg)): ?>
                    <div class="alert alert-danger">
                        <?php echo $msg; ?>
                    </div>
                <?php endif; ?>

                <p class="text-danger small">Campos obligatorios *</p>

                <?php if($empleado): ?>

                <form method="post">

                    <div class="row g-3">

                        <!-- RUT -->
                        <div class="col-md-6">
                            <label class="form-label">RUT *</label>
                            <input type="text" name="rut" value="<?php echo $empleado['rut']; ?>" class="form-control">
                        </div>

                        <!-- Nombre -->
                        <div class="col-md-6">
                            <label class="form-label">Nombre *</label>
                            <input type="text" name="nombre" value="<?php echo $empleado['nombre']; ?>" class="form-control">
                        </div>

                        <!-- Email -->
                        <div class="col-12">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" value="<?php echo $empleado['email']; ?>" class="form-control">
                        </div>

                        <!-- Fecha -->
                        <div class="col-md-6">
                            <label class="form-label">Fecha nacimiento *</label>
                            <input type="date" name="fecha_nacimiento" value="<?php echo $empleado['fecha_nacimiento']; ?>" class="form-control">
                        </div>

                        <!-- Rol -->
                        <div class="col-md-6">
                            <label class="form-label">Rol *</label>
                            <select name="rol" class="form-select">
                                <option value="<?php echo $empleado['rol_id']; ?>">
                                    <?php echo $empleado['rol']; ?>
                                </option>
                                <option value="">Seleccione...</option>
                                <?php foreach($roles as $rol): ?>
                                    <option value="<?php echo $rol['id']; ?>">
                                        <?php echo $rol['nombre']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Especialidad -->
                        <div class="col-12">
                            <label class="form-label">Especialidad *</label>
                            <select name="especialidad" class="form-select">
                                <option value="<?php echo $empleado['especialidad_id']; ?>">
                                    <?php echo $empleado['especialidad']; ?>
                                </option>
                                <option value="">Seleccione...</option>
                                <?php foreach($especialidades as $esp): ?>
                                    <option value="<?php echo $esp['id']; ?>">
                                        <?php echo $esp['nombre']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                    </div>

                    <!-- BOTONES -->
                    <div class="mt-4 d-flex flex-wrap gap-2">
                        <input type="hidden" name="confirm" value="1">

                        <button type="submit" class="btn btn-success btn-sm">
                            Guardar cambios
                        </button>

                        <a href="<?php echo SHOW_EMPLEADO . $id; ?>" class="btn btn-outline-secondary btn-sm">
                            Cancelar
                        </a>
                    </div>

                </form>

                <?php else: ?>
                    <div class="alert alert-info text-center">
                        No hay datos
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
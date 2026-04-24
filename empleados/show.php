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
    require('../class/telefonoModel.php');

    $session = new Session;

    if (isset($_GET['empleado'])) {
        $id = (int) $_GET['empleado'];

        $empleados = new EmpleadoModel;
        $usuarios = new UsuarioModel;
        $telefono = new TelefonoModel;

        $empleado = $empleados->getEmpleadoId($id);
        $usuario = $usuarios->getUsuarioEmpleado($id);
        $type = 'Empleado';

        $telefonos = $telefono->getTelefonoIdType($id, $type);

        if ($usuario) {
            $usu = $usuarios->getUsuarioId($usuario['id']);
        }


        //print_r($usu);exit;
    }

    //print_r($roles);exit;

    $title = 'Funcionarios';

?>
<?php if(isset($_SESSION['autenticado']) && ($_SESSION['usuario_rol'] == 'Administrador' || ($_SESSION['usuario_rol']) == 'Supervisor') || $_SESSION['usuario_id'] == $usuario['id']): ?>

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

/* Labels */
.label {
    font-size: 0.75rem;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Valores */
.value {
    font-size: 0.95rem;
    font-weight: 500;
    color: #e5e7eb;
}

/* Divider */
.divider {
    border-bottom: 1px solid #334155;
    margin: 10px 0;
}

/* Badge teléfonos */
.phone-badge {
    background: rgba(148,163,184,0.1);
    border: 1px solid #334155;
    border-radius: 999px;
    padding: 6px 12px;
    font-size: 0.8rem;
    color: #e5e7eb;
    text-decoration: none;
}

/* Botones */
.btn {
    border-radius: 10px;
}

.title-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
</style>

<body>
    <header>
        <!-- llamada a archivo de menu -->
        <?php /* include('../partials/menu.php');*/ ?>
    </header>


    <div class="container py-4">

        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">

                <div class="card shadow-sm">
                    <div class="card-body">

                    <h4 class="mb-3 text-black"><?php echo $title; ?></h4>

                        <?php include('../partials/mensajes.php'); ?>

                        <?php if(!empty($empleado)): ?>

                            <div class="table-responsive">
                                <table class="table table-sm align-middle">

                                    <tbody>
                                        <tr>
                                            <th class="w-50">RUT:</th>
                                            <td><?php echo $empleado['rut']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Nombre:</th>
                                            <td><?php echo $empleado['nombre']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Email:</th>
                                            <td class="text-break"><?php echo $empleado['email']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Fecha de nacimiento:</th>
                                            <td>
                                                <?php
                                                    $fecha_nac = new DateTime($empleado['fecha_nacimiento']);
                                                    echo $fecha_nac->format('d-m-Y');
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Rol:</th>
                                            <td><?php echo $empleado['rol']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Especialidad:</th>
                                            <td><?php echo $empleado['especialidad']; ?></td>
                                        </tr>

                                        <?php if($usuario): ?>
                                        <tr>
                                            <th>Activo:</th>
                                            <td>
                                                <span class="badge bg-<?php echo ($usu['activo'] == 1) ? 'success' : 'secondary'; ?>">
                                                    <?php echo ($usu['activo'] == 1) ? 'Sí' : 'No'; ?>
                                                </span>

                                                <?php if($_SESSION['usuario_rol'] == 'Administrador'): ?>
                                                    <a href="<?php echo EDIT_USUARIO . $usu['id']; ?>" class="ms-2 small">
                                                        Modificar
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endif; ?>

                                        <tr>
                                            <th>Teléfonos:</th>
                                            <td>
                                                <?php if ($telefonos): ?>
                                                    <div class="list-group list-group-flush">
                                                        <?php foreach($telefonos as $telefono): ?>
                                                            <a href="<?php echo SHOW_TELEFONO . $telefono['id']; ?>"
                                                            class="list-group-item list-group-item-action py-1">
                                                                +56 <?php echo $telefono['numero']; ?>
                                                            </a>
                                                        <?php endforeach; ?>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted">Sin teléfono</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Fecha Creación:</th>
                                            <td>
                                                <?php
                                                    $creado = new DateTime($empleado['created_at']);
                                                    echo $creado->format('d-m-Y H:i');
                                                ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Fecha Modificación:</th>
                                            <td>
                                                <?php
                                                    $modificado = new DateTime($empleado['updated_at']);
                                                    echo $modificado->format('d-m-Y H:i');
                                                ?>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                            <!-- BOTONES -->
                            <div class="d-flex flex-wrap gap-2 mt-3">

                                <?php if($_SESSION['usuario_rol'] == 'Administrador'): ?>
                                    <a href="<?php echo EDIT_EMPLEADO . $id ?>" class="btn btn-success btn-sm">
                                        Editar
                                    </a>
                                <?php endif; ?>

                                <?php if(!$usuario): ?>
                                    <a href="<?php echo ADD_USUARIO . $id; ?>" class="btn btn-primary btn-sm">
                                        Crear Cuenta
                                    </a>
                                <?php else: ?>
                                    <a href="<?php echo EDIT_PASSWORD . $usuario['id']; ?>" class="btn btn-warning btn-sm">
                                        Cambiar Password
                                    </a>
                                <?php endif; ?>

                                <a href="<?php echo ADD_TEL_EMPL . $id; ?>" class="btn btn-info btn-sm">
                                    Agregar Teléfono
                                </a>

                                <a href="<?php echo EMPLEADOS; ?>" class="btn btn-secondary btn-sm">
                                    Volver
                                </a>

                            </div>

                        <?php else: ?>
                            <p class="text-info">No hay datos</p>
                        <?php endif; ?>

                    </div>
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
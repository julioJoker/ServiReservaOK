<?php
    #instrucciones que nos permiten ver errores en tiempos de ejecucion
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    #llamada al archivo que contiene las rutas del sistema
    require('../class/rutas.php');
    require('../class/config.php');
    require('../class/session.php');
    require('../class/horarioModel.php');
    require('../class/especialidadModel.php');
    require('../class/pacienteModel.php');
    require('../class/reservaModel.php');
    require('../class/empleadoModel.php');
    //require('../class/reservaModel.php');

    $session = new Session;
    $pacientes = new PacienteModel;
    $horario = new HorarioModel;
    $especialidad = new EspecialidadModel;
    $reservas = new ReservaModel;
    $nomEmpl = new EmpleadoModel;

    

    if (isset($_GET['paciente'])) {
        $id_paciente = (int) $_GET['paciente'];
       
       
        
        $paciente = $pacientes->getPacienteId($id_paciente);
        $especialidades = $especialidad->getEspecialidades();
        $nombreEmpleado = $nomEmpl->getEspecialidadesSelect();
        $horarios = $horario->getHorarios();
        
        
        if (isset($_POST['confirm']) && $_POST['confirm'] == 1) {
            $fecha = trim(strip_tags($_POST['fecha']));
            $esp = filter_var($_POST['especialidad'], FILTER_VALIDATE_INT);
            $nombreProfecional = trim(strip_tags($_POST['nomEmpl'])); 
            $hor = filter_var($_POST['horario'], FILTER_VALIDATE_INT);
           
         
            
            if (!$fecha) {
                $msg = 'Ingrese una fecha para la reserva';
            }elseif (!$esp) {
                $msg = 'Seleccione una especialidad';
            }elseif (!$hor) {
                $msg = 'Seleccione un horario';
            }else {

                $res = $reservas->getReservaPacienteEspecialidadHorario($esp, $id_paciente, $hor);

                if ($res) {
                    $msg = 'El paciente ya tiene reserva con la especialidad y horario ingresados';
                }else{
                    $res = $reservas->addReserva($fecha, $esp, $id_paciente, $_SESSION['usuario_id'], $hor, $nombreProfecional);
                    
                    if ($res) {
                        $_SESSION['success'] = 'La reserva se ha realizado correctamente';
                        header('Location: ' . BASE_URL);
                    }
                }
            }


        }
    }

    //print_r($roles);exit;

    $title = 'Nueva Reserva';

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
        background: linear-gradient(135deg, #0f172a, #1e293b);
        min-height: 100vh;
        font-family: Arial, sans-serif;
    }

    .container-fluid {
        margin-top: 80px;
    }

    .card-form {
        background: #ffffff;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.25);
    }

    h4 {
        text-align: center;
        margin-bottom: 25px;
        font-weight: bold;
        color: #0f172a;
    }

    .form-label {
        font-weight: 600;
        color: #1f2937;
    }

    .form-control {
        border-radius: 10px;
        padding: 10px;
    }

    .btn {
        border-radius: 10px;
        padding: 10px 20px;
    }

    .btn-outline-success {
        width: 48%;
    }

    .btn-outline-primary {
        width: 48%;
    }

    .btn-group-custom {
        display: flex;
        justify-content: space-between;
        gap: 10px;
    }

    .alert {
        border-radius: 10px;
    }

    @media (max-width: 768px) {
        .card-form {
            padding: 20px;
        }

        .btn-group-custom {
            flex-direction: column;
        }

        .btn-outline-success,
        .btn-outline-primary {
            width: 100%;
        }
    }
</style>
<body>
    <header>
        <!-- llamada a archivo de menu -->
        <?php /*include('../partials/menu.php');*/ ?>
    </header>
<div class="container-fluid">
    <div class="col-md-6 offset-md-3">

        <div class="card-form">

            <h4><?= $title ?></h4>

            <?php if(isset($msg)): ?>
                <div class="alert alert-danger">
                    <?= $msg; ?>
                </div>
            <?php endif; ?>

            <?php if($paciente): ?>

            <form name="form" action="" method="post">

                <div class="mb-3">
                    <label class="form-label">Fecha *</label>
                    <input type="date" name="fecha"
                        value="<?= $_POST['fecha'] ?? '' ?>"
                        class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Especialidad *</label>
                    <select name="especialidad" class="form-control">
                        <option value="">Seleccione...</option>
                        <?php foreach($especialidades as $especialidad): ?>
                            <option value="<?= $especialidad['id']; ?>">
                                <?= $especialidad['nombre']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Profesional *</label>
                    <select name="nomEmpl" class="form-control">
                        <option value="">Seleccione...</option>
                        <?php foreach($nombreEmpleado as $nomEmpl): ?>
                            <option value="<?= $nomEmpl['nombre']; ?>">
                                <?= $nomEmpl['nombre']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Horario *</label>
                    <select name="horario" class="form-control">
                        <option value="">Seleccione...</option>
                        <?php foreach($horarios as $horario): ?>
                            <option value="<?= $horario['id']; ?>">
                                <?= $horario['horario']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <input type="hidden" name="confirm" value="1">

                <div class="btn-group-custom mt-4">
                    <button type="submit" class="btn btn-outline-success">
                        Guardar
                    </button>

                    <a href="<?= RESERVAS; ?>" class="btn btn-outline-primary">
                        Volver
                    </a>
                </div>

            </form>

            <?php else: ?>
                <p class="text-danger text-center">
                    La reserva no pudo ser realizada
                </p>
            <?php endif; ?>

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
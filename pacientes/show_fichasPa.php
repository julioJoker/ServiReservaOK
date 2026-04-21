<?php
    #instrucciones que nos permiten ver errores en tiempos de ejecucion
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    #llamada al archivo que contiene las rutas del sistema
    require('../class/rutas.php');
    require('../class/config.php');
    require('../class/session.php');
    require('../class/pacienteModel.php');
    require('../class/telefonoModel.php');
    require('../class/reservaModel.php');
    require('../class/empleadoModel.php');


    $session = new Session;

    if (isset($_GET['paciente'])) {
        $id = (int) $_GET['paciente'];

        $pacientes = new PacienteModel;
        $telefono = new TelefonoModel;
        $reserva = new ReservaModel;
        $nombreProfeciona = new EmpleadoModel;

        

        $paciente = $pacientes->getPacienteId($id);
        $type = 'Paciente';
        $rutPaciente = $paciente['rut'];
        $telefonos = $telefono->getTelefonoIdType($id, $type);
        $reservas = $reserva->getFichasPaciente($rutPaciente);
        $nombreProfecionas = $nombreProfeciona->getEmpleadoId($id);

    }

    //print_r($id);exit;

    $title = 'Pacientes';

?>
<?php if(isset($_SESSION['autenticado'])): ?>

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
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <h4><?php echo $title; ?> </h4>

                    <?php include('../partials/mensajes.php'); ?>

                    <?php if(!empty($paciente)): ?>
                        
                       <table>
                        <tr>
                            <th>RUT:</th>
                            <td><?php echo $paciente['rut']; ?></td>
                        </tr>
                        <tr>
                            <th>Nombre:</th>
                            <td><?php echo $paciente['nombre']; ?></td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td><?php echo $paciente['email']; ?></td>
                        </tr>
                       
                        <tr>
                            <th>Edad:</th>
                            <td><?php echo $paciente['edad']; ?> años</td>
                        </tr>
                        
                                    </table>
                        <table class="table table-hover">
                            <table class="table table-hover">
                        </table>
                        <p>
                            <a href="<?php echo PACIENTES; ?>" class="btn btn-outline-primary">Volver</a>
                        </p>
                        <p>
                            <a href="<?php echo ADD_RESERVA . $id ?>" class="btn btn-outline-primary">Reservar Hora</a>
                        </p>
                        <!-- <p>
                            <a href="<?php/*echo ADD_FICHAPACIEN . $id*/ ?>" class="btn btn-outline-primary">Crear Fichas Medicas paciente</a>
                        </p> -->
                    <?php else: ?>
                        <p class="text-info">No hay datos</p>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <h3>Fichas  Creadas</h3>
                    <?php if(!empty($reservas)): ?>
                    <table class="table table-hover">
                        <tr>
                            
                            <th>N Ficha</th>
                            <th>Profesional</th>
                            <th>Especialidad</th>
                            <th>Fecha Atencion</th>
                            <th>Horario</th>
                        </tr>
                       
                            <tr>
                                <td>
                                    <a href="<?php echo SHOW_FICHAPACIEN . $reservas['nombre_profecional']; ?>">
                                        <?php
                                           // $fecha_creacion = new DateTime($reserva['created_at']);
                                            //echo $fecha_creacion->format('d-m-Y H:i:s');
                                           
                                            echo $reservas['nombre_profecional']; 
                                        ?>
                                    </a>

                                </td>
                                <td>
                                    <?php  echo $nombreProfecionas['nombre']; ?>
                                </td>
                                
                                <td>
                                <?php  echo $nombreProfecionas['rol']; ?>
                                </td>

                                <td>
                                </td>
                            </tr>
                        
                    </table>
                <?php else: ?>
                    <p class="text-info">No hay reservas registradas</p>
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
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
        $id_ficha = $id;
        $pacientes = new PacienteModel;
        $Fichapacientes = new ReservaModel;
        $telefono = new TelefonoModel;
        $reserva = new ReservaModel;
        $nombreProfeciona = new EmpleadoModel;

        $paciente = $pacientes->getPacienteId($id);
        $reservas = $reserva->getReservaPaciente($id);
        $nombreProfecionas = $nombreProfeciona->getEmpleadoId($id);

        
        if (isset($_POST['confirm']) && $_POST['confirm'] == 1) {
        $nombre_profe = trim(strip_tags($nombreProfecionas['nombre'])); //sanitizacion basica
        $especialidad_nom = $nombreProfecionas['rol'];
        $nombre_paciente = trim(strip_tags($paciente['nombre']));
        $rutPaciente = $paciente['rut'];
        $peso =  trim(strip_tags($_POST['peso']));
        $altura = trim(strip_tags($_POST['altura']));
        $data_sintomas = trim(strip_tags($_POST['dataSintoma']));
        $data_observacion =  trim(strip_tags($_POST['dataObservacion']));
        $data_tratamiento = trim(strip_tags($_POST['dataTratamiento']));
        $edad =$paciente['edad'];
        $rol_id = 2;
        $especialidad_id2 = 3;
        $created_at = '2021-10-30 12:53:37';
        $edad_ficha ='0000-00-00 00:00:00';
        
        if (strlen($rutPaciente) < 9 || strlen($rutPaciente) > 10) {
            $msg = 'Ingrese un RUT de al menos 9 caracteres';
        }
        else{

            $res = $Fichapacientes->getAddFichaPaciente($id_ficha,$nombre_profe,$especialidad_nom ,$nombre_paciente,$rutPaciente,$peso, $altura,$data_sintomas, $data_observacion ,$data_tratamiento );
                
                            if ($res) {
                    $_SESSION['success'] = 'Ficha del paciente se ha registrado correctamente';
                    header('Location: ' . PACIENTES);
                }
        }
        echo($edad);
        
    }}

    //print_r($roles);exit;

    $title = 'Ficha Pacientes';

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
                    <h4><?php echo $title; ?></h4>
                    <p class="text-danger">Campos obligatorios *</p>
                    <?php if(isset($msg)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $msg; ?>
                    </div>
                    <?php endif; ?>
                        <form name="form" action="" method="post">
                            <div>
                                <tr>
                                    <th>Profesional: </th>
                                    <td><?php  echo $nombreProfecionas['nombre']; ?></td>
                                </tr>
                            </div>
                            <div>    
                                <tr>
                                    <th>Especialidad: </th>
                                    <td><?php  echo $nombreProfecionas['rol']; ?></td>
                                </tr>
                            </div>    
                            
                            <div>    
                                <tr>
                                    <th>Nombre Paciente:</th>
                                    <td><?php echo $paciente['nombre']; ?></td>
                                </tr>
                            </div>

                            <div>
                                <tr>
                                    <th>RUT Paciente:</th>
                                    <td><?php echo $paciente['rut']; ?></td>
                                </tr>
                            </div>
                            <div>
                                <tr>
                                    <th>Edad Paciente :</th>
                                    <td><?php echo $paciente['edad']; ?> años</td>
                                </tr>
                            </div>    

                            <div class="x-small">
                                <label for="peso" style=" font-size: 90%" class="form-label">Peso<span class="text-danger" style=" font-size: 30%">*</span>  </label>
                                <input type="text" name="peso" value="<?php if(isset($_POST['peso'])) echo $_POST['peso']; ?>" class="form-control" aria-describedby="empleadoHelpInline">
                                <div id="empleadoHelp" class="form-text text-danger" style=" font-size: 50%">Debe Ingresar Peso </div>
                            </div>
                            <div class="mb-3">
                                <label for="altura" style=" font-size: 90%"  class="form-label">Altura<span class="text-danger" style=" font-size: 30%" >*</span>  </label>
                                <input type="text" name="altura" value="<?php if(isset($_POST['altura'])) echo $_POST['altura']; ?>" class="form-control" aria-describedby="empleadoHelpInline">
                                <div id="empleadoHelp" class="form-text text-danger" style=" font-size: 35%">Debe Ingresar Altura </div>
                            </div>
                            <div>
                                <p>
                                    <label for="dataSintoma">Sintomas:</label>
                                </p>
                                <textarea id="dataSintoma" name="dataSintoma" rows="20" cols="115"></textarea>
                            </div>
                            <div>
                                <p>
                                    <label for="dataObservacion">Observacion:</label>
                                </p>
                                <textarea id="dataObservacion" name="dataObservacion" rows="20" cols="115"></textarea>
                            </div>
                            <div>
                                <p>
                                    <label for="dataTratamiento">Tratamiento:</label>
                                </p>
                                <textarea id="dataTratamiento" name="dataTratamiento" rows="20" cols="115"></textarea>
                            </div>
                            <p>
                                <div class="mb-3">
                                    <input type="hidden" name="confirm" value="1">
                                    <button type="submit" class="btn btn-outline-success">Guardar</button>
                                    <a href="<?php echo PACIENTES; ?>" class="btn btn-outline-primary">Volver</a>
                                </div>
                            </p>
                        </form>
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
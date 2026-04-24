<?php
    #instrucciones que nos permiten ver errores en tiempos de ejecucion
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    #llamada al archivo que contiene las rutas del sistema
    require('../class/rutas.php');
    require('../class/config.php');
    require('../class/session.php');
    require('../class/reservaModel.php');


    $session = new Session;

    if (isset($_GET['paciente'])) {
        $id = (int) $_GET['paciente'];

        $fichaPaciente = new ReservaModel;
        $ficha = $fichaPaciente->getFichaPaciente($id);

    }

    //print_r($roles);exit;

    $title = 'Ficha Medica ';
    

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
        <div class="col-md-6 offset-md-3">
            <h4><?php echo $title; ?> </h4>

            <?php include('../partials/mensajes.php'); ?>

            <?php if(!empty($ficha)): ?>
                <div>
                    <tr>
                        <th>Profesional:</th>
                        <td><?php echo $ficha['nombre_profecional']; ?></td>
                    </tr>
                    <div>    
                    <tr>
                        <th>Especialidad:</th>
                        <td><?php echo $ficha['Especialidad_ficha']; ?></td>
                    </tr>
                <table class="table table-hover">

                     
                    <table class="table table-hover">
                    
                    <tr>
                        <th>Nombre:</th>
                        <td><?php echo $ficha['nombre_paciente']; ?></td>
                    </tr>
                    <tr>
                        <th>Rut:</th>
                        <td><?php echo $ficha['rut']; ?></td>
                    </tr>
                   
                    <tr>
                        <th>Edad:</th>
                        <td><?php echo $ficha['peso']; ?></td>
                    </tr>
                    <tr>
                        <th>Sexo:</th>
                        <td><?php echo $ficha['altura']; ?></td>
                    </tr>
                    <tr>
                        <th>Peso:</th>
                        <td><?php echo $ficha['peso']; ?></td>
                    </tr>
                    <tr>
                        <th>Altura:</th>
                        <td><?php echo $ficha['altura']; ?></td>
                    </tr>
                    <div>
                        <th>Sintomas:</th>
                        <td><?php $texto =  $ficha['data_sintomas']; echo wordwrap($texto, 50, "<br>"); ?></td>
                     </div>
                     <div>
                        <tr>
                          <th>Observaciones:</th>
                          <td><?php $texto =  $ficha['data_observacion']; echo wordwrap($texto, 50, "<br>"); ?></td>
                        </tr>
                        </div>
                     <div>
                        <th>Tratamiento:</th>
                        <td><?php $texto =  $ficha['data_tratamiento']; echo wordwrap($texto, 50, "<br>"); ?></td>
                     </div>

                </table>
                <p>
                    <?php if($_SESSION['usuario_rol'] == 'Administrador'): ?>
                        <a href="<?php echo EDIT_RESERVA . $id ?>" class="btn btn-outline-success">Editar</a>
                    <?php endif; ?>
                    <a href="<?php echo SHOW_FICHASPACIEN . $id ; ?>" class="btn btn-outline-success">Volver</a>
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
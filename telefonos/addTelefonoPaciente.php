<?php
    #instrucciones que nos permiten ver errores en tiempos de ejecucion
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    #llamada al archivo que contiene las rutas del sistema
    require('../class/rutas.php');
    require('../class/config.php');
    require('../class/session.php');
    require('../class/telefonoModel.php');
    require('../class/pacienteModel.php');


    #crear un objeto de la clase RolModel
    $session = new Session;
    $telefonos = new TelefonoModel;
    $pacientes = new PacienteModel;

    if (isset($_GET['paciente'])) {
        $id_paciente = (int) $_GET['paciente'];

        $paciente = $pacientes->getPacienteId($id_paciente);

        if (isset($_POST['confirm']) && $_POST['confirm'] == 1) {
            $numero = filter_var($_POST['numero'], FILTER_VALIDATE_INT);

            if (strlen($numero) < 9 || strlen($numero) > 9) {
                $msg = 'El teléfono debe tener 9 dígitos';
            }else{
                $telefono = $telefonos->getTelefonoNumero($numero);

                if ($telefono == 133) {
                    $msg = 'No atendemos a los Pacos, gracias, cierre por fuera ';
                }else{
                    $type = 'Paciente';
                    $telefono = $telefonos->addTelefono($numero, $id_paciente, $type);

                    if ($telefono) {
                        $_SESSION['success'] = 'El teléfono se ha registrado correctamente';
                        header('Location: ' . SHOW_PACIENTE . $id_paciente);
                    }
                }
            }
        }
    }

    $title = 'Nuevo Telefono';



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
        font-weight: bold;
        margin-bottom: 20px;
        color: #0f172a;
    }

    .form-label {
        font-weight: 600;
    }

    .form-control {
        border-radius: 10px;
        padding: 12px;
    }

    .input-group-text {
        border-radius: 10px 0 0 10px;
        background: #e5e7eb;
        font-weight: bold;
    }

    .btn {
        border-radius: 10px;
        padding: 10px;
    }

    .btn-group-custom {
        display: flex;
        gap: 10px;
    }

    .alert {
        border-radius: 10px;
    }

    /* 📱 MOBILE */
    @media (max-width: 768px) {
        .card-form {
            padding: 20px;
        }

        .btn-group-custom {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }
</style>
<body>
    <header>
        <!-- llamada a archivo de menu -->
        <?php /*include('../partials/menu.php'); */?>
    </header>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 col-11">

                <div class="card-form">

                    <h4><?= $title; ?></h4>

                    <p class="text-danger text-center">Campos obligatorios *</p>

                    <?php if(isset($msg)): ?>
                        <div class="alert alert-danger text-center">
                            <?= $msg; ?>
                        </div>
                    <?php endif; ?>

                    <?php if($paciente): ?>

                    <form name="form" action="" method="post">

                        <div class="mb-3">
                            <label class="form-label">
                                Teléfono <span class="text-danger">*</span>
                            </label>

                            <!-- input con prefijo -->
                            <div class="input-group">
                                <span class="input-group-text">+56</span>
                                <input 
                                    type="number" 
                                    name="numero"
                                    value="<?= $_POST['numero'] ?? '' ?>"
                                    class="form-control"
                                    placeholder="912345678"
                                >
                            </div>

                            <div class="form-text text-muted">
                                Ingrese 9 dígitos sin el +56
                            </div>
                        </div>

                        <input type="hidden" name="confirm" value="1">

                        <div class="btn-group-custom mt-4">
                            <button type="submit" class="btn btn-outline-success">
                                Guardar
                            </button>

                            <a href="<?= SHOW_PACIENTE . $id_paciente; ?>" class="btn btn-outline-primary">
                                Volver
                            </a>
                        </div>

                    </form>

                    <?php else: ?>
                        <p class="text-danger text-center">
                            No se pudo agregar el teléfono
                        </p>
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
    <?php
        #instrucciones que nos permiten ver errores en tiempos de ejecucion
        error_reporting(E_ALL);
        ini_set('display_errors', '1');
        #llamada al archivo que contiene las rutas del sistema
        require('../class/rutas.php');
        require('../class/config.php');
        require('../class/session.php');
        require('../class/pacienteModel.php');

        $session = new Session;

        if (isset($_GET['paciente'])) {
            $id = (int) $_GET['paciente'];

            $pacientes = new PacienteModel;

            $paciente = $pacientes->getPacienteId($id);

            if (isset($_POST['confirm']) && $_POST['confirm'] == 1) {

                $nombre = trim(strip_tags($_POST['nombre']));
                $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
                $direccion = trim(strip_tags($_POST['dirección']));
                $fonasa = filter_var($_POST['fonasa'], FILTER_VALIDATE_INT);
                $sexo = filter_var($_POST['sexo']);

                if (!$nombre) {
                    $msg = 'Ingrese el nombre del paciente';
                }elseif (!$email) {
                    $msg = 'Ingrese un email válido';
                }elseif (!$direccion) {
                    $msg = 'Ingrese un direccion válido';
                }elseif (!$fonasa) {
                    $msg = 'Seleccione la prevision de salud del paciente';
                }else{
                    $pac = $pacientes->editPaciente($id, $nombre,$sexo, $email,$direccion , $fonasa);

                    if ($pac) {
                        $_SESSION['success'] = 'El paciente se ha modificado correctamente';
                        header('Location: ' . SHOW_PACIENTE . $id);
                    }
                }
            }

        }

        $title = 'Editar Paciente';

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
            background: #fff;
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

                        <form method="post">

                            <!-- NOMBRE -->
                            <div class="mb-3">
                                <label class="form-label">Nombre *</label>
                                <input type="text" name="nombre"
                                    value="<?= $paciente['nombre']; ?>"
                                    class="form-control">
                            </div>

                            <!-- SEXO -->
                            <div class="mb-3">
                                <label class="form-label">Sexo *</label>
                                <select name="sexo" class="form-control">
                                    <?php
                                        $sexos = ['Femenino','Masculino','Transgénero','Agénero','Otro'];
                                        foreach($sexos as $s):
                                    ?>
                                        <option value="<?= $s; ?>" <?= $paciente['sexo'] == $s ? 'selected' : '' ?>>
                                            <?= $s; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- EMAIL -->
                            <div class="mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" name="email"
                                    value="<?= $paciente['email']; ?>"
                                    class="form-control">
                            </div>

                            <!-- DIRECCION -->
                            <div class="mb-3">
                                <label class="form-label">Dirección *</label>
                                <input type="text" name="dirección"
                                    value="<?= $paciente['dirección']; ?>"
                                    class="form-control">
                            </div>

                            <!-- FONASA -->
                            <div class="mb-3">
                                <label class="form-label">Previsión *</label>
                                <select name="fonasa" class="form-control">
                                    <option value="">Seleccione...</option>
                                    <option value="1" <?= $paciente['fonasa'] == 1 ? 'selected' : '' ?>>Fonasa</option>
                                    <option value="2" <?= $paciente['fonasa'] == 2 ? 'selected' : '' ?>>Isapre</option>
                                </select>
                            </div>

                            <input type="hidden" name="confirm" value="1">

                            <!-- BOTONES -->
                            <div class="btn-group-custom mt-4">
                                <button type="submit" class="btn btn-outline-success">
                                    Guardar Cambios
                                </button>

                                <a href="<?= SHOW_PACIENTE . $id; ?>" class="btn btn-outline-primary">
                                    Volver
                                </a>
                            </div>

                        </form>

                        <?php else: ?>
                            <p class="text-info text-center">No hay datos</p>
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
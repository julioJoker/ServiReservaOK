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

    $session = new Session;

    if (isset($_GET['paciente'])) {
        $id = (int) $_GET['paciente'];

        $pacientes = new PacienteModel;
        $telefono = new TelefonoModel;
        $reserva = new ReservaModel;

        $paciente = $pacientes->getPacienteId($id);
        $type = 'Paciente';

        $telefonos = $telefono->getTelefonoIdType($id, $type);
        $reservas = $reserva->getReservaPaciente($id);


        $ficha = new PacienteModel;
        $fichas = $ficha->getFichasPaciente($id);

    }

    //print_r($roles);exit;

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
<style>
    /* ===== FONDO ===== */
    body {
        background: #758494;
        font-family: system-ui, sans-serif;
        color: #1e293b;
    }

    /* ===== CONTENEDOR ===== */
    .container-fluid {
        margin-top: 80px;
        max-width: 1200px;
    }

    /* ===== CARD ===== */
    .card-custom {
        background: #f0eded;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        margin-bottom: 20px;
        transition: 0.2s;
    }

    .card-custom:hover {
        transform: translateY(-2px);
    }

    /* ===== TITULO ===== */
    .card-title {
        font-weight: 600;
        margin-bottom: 15px;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* ===== TABLA INFO ===== */
    .table-borderless th {
        width: 40%;
        color: #64748b;
        font-weight: 500;
    }

    .table-borderless td {
        color: #0f172a;
        font-weight: 500;
    }

    /* ===== LINKS ===== */
    a {
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    /* ===== BOTONES ===== */
    .btn {
        border-radius: 10px;
        font-size: 0.9rem;
    }

    /* Grupo botones */
    .btn-group-custom {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    /* Botones mejorados */
    .btn-outline-success {
        border-color: #22c55e;
        color: #16a34a;
    }

    .btn-outline-success:hover {
        background: #22c55e;
        color: white;
    }

    .btn-outline-primary:hover {
        background: #2563eb;
        color: white;
    }

    .btn-outline-secondary:hover {
        background: #64748b;
        color: white;
    }

    .btn-outline-dark:hover {
        background: #0f172a;
        color: white;
    }

    /* ===== TELÉFONOS ===== */
    .telefono-item {
        padding: 4px 0;
    }

    /* ===== TABLA RESERVAS ===== */
    .table {
        border-radius: 12px;
        overflow: hidden;
    }

    .table thead {
        background: #f8fafc;
        color: #64748b;
        font-size: 0.85rem;
        text-transform: uppercase;
    }

    .table tbody tr:hover {
        background: #f1f5f9;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {

        .container-fluid {
            padding: 10px;
        }

        .card-custom {
            padding: 15px;
        }

        .btn-group-custom {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }

        /* Tabla tipo bloque en móvil */
        .table-borderless tr {
            display: block;
            margin-bottom: 10px;
        }

        .table-borderless th,
        .table-borderless td {
            display: block;
            width: 100%;
        }

        .table-borderless th {
            font-size: 0.8rem;
            margin-bottom: 2px;
        }
    }
</style>
<!-- MODAL FICHA -->
<div class="modal fade" id="modalFicha" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Detalle de Ficha</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body" id="contenidoFicha">
        Cargando...
      </div>

    </div>
  </div>
</div>
<body>
    <header>
        <!-- llamada a archivo de menu -->
        <?php /*include('../partials/menu.php'); */?>
    </header>
    <div class="container-fluid">
        <div class="row">

            <!-- 🧍 PACIENTE -->
            <div class="col-lg-6">
                <div class="card-custom">

                    <h4 class="card-title">Ficha del Paciente</h4>

                    <?php include('../partials/mensajes.php'); ?>

                    <?php if(!empty($paciente)): ?>

                    <table class="table table-borderless">
                        <tr><th>RUT:</th><td><?= $paciente['rut']; ?></td></tr>
                        <tr><th>Nombre:</th><td><?= $paciente['nombre']; ?></td></tr>
                        <tr><th>Email:</th><td><?= $paciente['email']; ?></td></tr>
                        <tr><th>Dirección:</th><td><?= $paciente['direccion']; ?></td></tr>
                        <tr>
                            <th>Fecha Nacimiento:</th>
                            <td><?= (new DateTime($paciente['fecha_nacimiento']))->format('d-m-Y'); ?></td>
                        </tr>
                        <tr><th>Edad:</th><td><?= $paciente['edad']; ?> años</td></tr>
                        <tr><th>Sexo:</th><td><?= $paciente['sexo']; ?></td></tr>

                        <tr>
                            <th>Teléfonos:</th>
                            <td>
                                <?php if ($telefonos): ?>
                                    <?php foreach($telefonos as $telefono): ?>
                                        <div>
                                            <a href="<?= SHOW_TELEFONO . $telefono['id']; ?>">
                                                +56 <?= $telefono['numero']; ?>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <span class="text-muted">Sin teléfono</span>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <tr>
                            <th>Creado:</th>
                            <td><?= (new DateTime($paciente['created_at']))->format('d-m-Y H:i'); ?></td>
                        </tr>
                        <tr>
                            <th>Modificado:</th>
                            <td><?= (new DateTime($paciente['updated_at']))->format('d-m-Y H:i'); ?></td>
                        </tr>
                    </table>

                    <!-- BOTONES -->
                    <div class="btn-group-custom mt-3">
                        <?php if($_SESSION['usuario_rol'] == 'Administrador'): ?>
                            <a href="<?= EDIT_PACIENTE . $id ?>" class="btn btn-outline-success">Editar</a>
                        <?php endif; ?>

                        <a href="<?= ADD_TEL_PAC . $id; ?>" class="btn btn-outline-secondary">Teléfono</a>
                        <a href="<?= ADD_RESERVA . $id ?>" class="btn btn-outline-primary">Reservar</a>
                        <a href="<?= PACIENTES; ?>" class="btn btn-outline-dark">Volver</a>
                        <a href="<?= ADD_FICHAPACIEN ?>?paciente=<?= $id ?>" class="btn btn-outline-dark">Agregar Ficha</a>

                    </div>

                    <?php else: ?>
                        <p class="text-info">No hay datos</p>
                    <?php endif; ?>

                </div>
            </div>


            <!-- 📅 RESERVAS -->
            <div class="col-lg-6">
                <div class="card-custom">

                    <h4 class="card-title">Horas Reservadas</h4>

                    <?php if(!empty($reservas)): ?>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Creación</th>
                                    <th>Especialidad</th>
                                    <th>Fecha</th>
                                    <th>Horario</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($reservas as $reserva): ?>
                                <tr>
                                    <td>
                                        <a href="<?= SHOW_RESERVA . $reserva['id']; ?>">
                                            <?= (new DateTime($reserva['created_at']))->format('d-m-Y H:i'); ?>
                                        </a>
                                    </td>
                                    <td><?= $reserva['especialidad']; ?></td>
                                    <td><?= (new DateTime($reserva['fecha']))->format('d-m-Y'); ?></td>
                                    <td><?= $reserva['horario']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php else: ?>
                        <p class="text-muted">No hay reservas registradas</p>
                    <?php endif; ?>

                </div>
            </div>

            <!-- 📄 FICHAS -->
            <div class="col-lg-6">
                <div class="card-custom">

                    <h4 class="card-title">Fichas del Paciente</h4>

                    <?php if(!empty($fichas)): ?>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Creación</th>
                                    <th>Profesional</th>
                                    <th>Especialidad</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($fichas as $f): ?>
                                <tr>
                                    <td><?= (new DateTime($f['created_at']))->format('d-m-Y H:i'); ?></td>
                                    <td><?= $f['nombre_profe']; ?></td>
                                    <td><?= $f['especialidad']; ?></td>
                                    <td>
                                        <a class="btn btn-sm btn-primary"
                                        href="<?= VER_FICHA ?>?paciente=<?= (int)$f['paciente_id']; ?>">
                                            Ver ficha
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php else: ?>
                        <p class="text-muted">No hay fichas registradas</p>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>




</body>
</html>

<script>
window.addEventListener("DOMContentLoaded", () => {

    window.verFicha = function(id) {

        console.log("Abriendo ficha:", id);

        fetch("<?= SHOW_FICHA ?>")
            .then(res => res.text())
            .then(data => {

                document.getElementById('contenidoFicha').innerHTML = data;

                const modal = new bootstrap.Modal(
                    document.getElementById('modalFicha')
                );

                modal.show();
            })
            .catch(err => {
                console.error(err);
                document.getElementById('contenidoFicha').innerHTML =
                    "<p class='text-danger'>Error al cargar ficha</p>";
            });
    };

});
</script>
<?php else: ?>
    <?php
        header('Location: ' . LOGIN);
    ?>
<?php endif; ?>


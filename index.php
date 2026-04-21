<?php
// 🔥 IMPORTANTE: NO DEBE HABER NADA ANTES DE ESTO (ni espacios)

// Errores
error_reporting(E_ALL);
ini_set('display_errors', '1');

// ⚠️ La sesión debe iniciar antes de cualquier salida
require_once 'class/session.php';

// Configuración y rutas
require_once 'class/rutas.php';
require_once 'class/config.php';

// Iniciar sesión de forma segura (por si no se hizo dentro de session.php)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Header (después de includes, pero antes de cualquier HTML)
header('Content-Type: text/html; charset=UTF-8');

// Instancia de sesión
$session = new Session();

// Validación de login
if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
    header('Location: ' . LOGIN);
    exit;
}

$title = 'Panel de Control';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= TITLE . $title ?></title>

    <link href="bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="icon" type="image/png" href="img/favicon.png">

    <style>
        body{
            min-height:100vh;
            margin:0;
            font-family: 'Segoe UI', sans-serif;
            color:#e5e7eb;
            background: radial-gradient(circle at top, #0f172a, #020617);
        }

        .hero{
            padding:70px 20px 30px;
            text-align:center;
        }

        .hero h1{
            font-size:2.5rem;
            font-weight:800;
        }

        .hero p{
            color:#94a3b8;
        }

        .dashboard{
            margin-top:30px;
        }

        .card-modern{
            background: rgba(255,255,255,0.05);
            border:1px solid rgba(255,255,255,0.1);
            backdrop-filter: blur(12px);
            border-radius:20px;
            padding:25px;
            text-align:center;
            transition:0.3s;
            cursor:pointer;
        }

        .card-modern:hover{
            transform:translateY(-6px);
            box-shadow:0 20px 50px rgba(0,0,0,0.6);
        }

        .icon{
            font-size:40px;
            margin-bottom:10px;
        }

        .card-modern h5{
            font-weight:700;
            margin-bottom:5px;
        }

        .card-modern p{
            font-size:0.9rem;
            color:#94a3b8;
        }

        .modal-content{
            border-radius:16px;
            background:#0f172a;
            color:#e5e7eb;
        }
    </style>
</head>

<body>

<header>
    <?php include 'partials/mensajes.php'; ?>
</header>

<!-- MODAL LOADING -->
<div class="modal fade" id="loadingModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-4">
            <div class="spinner-border text-info mx-auto mb-3"></div>
            <h5 class="fw-bold">Cargando sistema</h5>
            <small>Preparando módulo de reservas médicas...</small>
        </div>
    </div>
</div>

<!-- HERO -->
<div class="hero">
    <h1>Sistema de Reservas</h1>
    <p>Gestin de citas medicas, pacientes y profesionales</p>
</div>

<div class="container dashboard">
    <div class="row g-4">

        <div class="col-md-3 col-6">
            <div class="card-modern btn-go" data-url="<?= RESERVAS ?>">
                <div class="icon">
                  <i class="bi bi-calendar"></i>
                </div>
                <h5>Reservas</h5>
                <p>Ver y gestionar citas</p>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="card-modern btn-go" data-url="pacientes/">
                <div class="icon">
                 <i class="bi bi-person-lines-fill fs-1"></i>
                </div>
                <h5>Pacientes</h5>
                <p>Administrar pacientes</p>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="card-modern btn-go" data-url="empleados/">
                <div class="icon">
                    <i class="bi bi-person-vcard"></i>
                </div>
                <h5>Profesionales</h5>
                <p>Gestionar medicos</p>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="card-modern btn-go" data-url="horarios/">
                <div class="icon">
                  <i class="bi bi-clock"></i>
                </div>
                <h5>Horarios</h5>
                <p>Configurar disponibilidad</p>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.querySelectorAll('.btn-go').forEach(btn => {
    btn.addEventListener('click', function() {
        const url = this.dataset.url;

        const modal = new bootstrap.Modal(document.getElementById('loadingModal'));
        modal.show();

        setTimeout(() => {
            window.location.href = url;
        }, 1200);
    });
});
</script>

</body>
</html>
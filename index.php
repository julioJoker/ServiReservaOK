<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
header('Content-Type: text/html; charset=UTF-8');
require_once 'class/rutas.php';
require_once 'class/config.php';
require_once 'class/session.php';

$session = new Session();

// ✅ VALIDAR SESIÓN
if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
    header('Location: ' . LOGIN); // usa tu ruta de login
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

<style>

/* ===== BASE ===== */
body{
    min-height:100vh;
    margin:0;
    font-family: system-ui, sans-serif;
    color:#e5e7eb;
    background: radial-gradient(circle at top, #0f172a, #020617);
}

/* HEADER HERO */
.hero{
    padding:80px 20px 40px;
    text-align:center;
}

/* TITULO PRINCIPAL */
.hero h1{
    font-size:2.2rem;
    font-weight:800;
    margin-bottom:10px;
    color:#ffffff;
}

.hero p{
    color:#94a3b8;
    font-size:1rem;
}

/* CARD PRINCIPAL */
.glass-card{
    background: rgba(255,255,255,0.06);
    backdrop-filter: blur(14px);
    border:1px solid rgba(255,255,255,0.1);
    border-radius:18px;
    box-shadow:0 20px 60px rgba(0,0,0,0.5);
    padding:25px;
}

/* BOTON PRINCIPAL */
.btn-main{
    display:block;
    width:100%;
    padding:18px;
    font-size:1.1rem;
    font-weight:700;
    border-radius:14px;
    text-align:center;
    text-decoration:none;
    color:#0f172a;
    background: linear-gradient(135deg, #38bdf8, #60a5fa);
    transition:0.25s ease;
    box-shadow:0 10px 30px rgba(56,189,248,0.25);
}

.btn-main:hover{
    transform:translateY(-3px);
    box-shadow:0 15px 40px rgba(56,189,248,0.35);
    color:#0f172a;
}

/* MODAL */
.modal-content{
    border-radius:16px;
    background:#0f172a;
    color:#e5e7eb;
}

.spinner-border{
    width:3rem;
    height:3rem;
}

small{
    color:#94a3b8;
}

</style>
<link rel="icon" type="image/png" href="img/favicon.png">
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
    <h1> Sistema de Reservas Oftalmologicas</h1>
    <p>Gestion de citas medicas, pacientes y profesionales en un solo lugar</p>
</div>

<!-- CONTENIDO -->
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="glass-card">

                <a href="#" 
                   data-url="<?= RESERVAS ?>" 
                   class="btn-main btn-reserva">

                    Ver y Gestionar Reservas
                </a>

            </div>

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.querySelectorAll('.btn-reserva').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();

        const url = this.getAttribute('data-url');

        const modal = new bootstrap.Modal(document.getElementById('loadingModal'));
        modal.show();

        setTimeout(() => {
            window.location.href = url;
        }, 1500);
    });
});
</script>

</body>
</html>
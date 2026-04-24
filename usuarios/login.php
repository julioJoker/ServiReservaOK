<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../class/rutas.php';
require_once '../class/config.php';
require_once '../class/session.php';
require_once '../class/usuarioModel.php';

$session = new Session();
$usuarios = new UsuarioModel();

$title = 'Acceso al Sistema';

if (isset($_POST['confirm']) && $_POST['confirm'] == 1) {

    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $clave = trim($_POST['clave'] ?? '');

    if (!$email) {
        $msg = 'Ingrese un correo v谩lido';
    } elseif (!$clave) {
        $msg = 'Ingrese su contrase帽a';
    } else {

        $usuario = $usuarios->getUsuarioEmailClave($email, $clave);

        if (!$usuario) {
            $msg = 'Credenciales incorrectas';
        } else {

            $session->login(
                $usuario['id'],
                $usuario['empleado_id'],
                $usuario['empleado'],
                $usuario['rol']
            );

            header('Location: ' . BASE_URL);
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/png" href="../img/favicon.png">
<title><?= TITLE . $title ?></title>

<link href="../bootstrap.min.css" rel="stylesheet">

<style>

    /* ===== FONDO ===== */
    body{
        margin:0;
        min-height:100vh;
        display:flex;
        justify-content:center;
        align-items:center;
        font-family: system-ui, sans-serif;
        background: radial-gradient(circle at top, #0f172a, #020617);
        color:#e5e7eb;
    }

    /* CARD LOGIN */
    .login-box{
        width:100%;
        max-width:420px;
        padding:40px 30px;
        border-radius:20px;
        background: rgba(255,255,255,0.06);
        backdrop-filter: blur(18px);
        border:1px solid rgba(255,255,255,0.1);
        box-shadow:0 20px 60px rgba(0,0,0,0.6);
        text-align:center;
    }

    /* LOGO / TITULO */
    .brand{
        font-family: "Courier New", monospace;
        font-size:2rem;
        font-weight:700;
        margin-bottom:5px;
    }

    .subtitle{
        color:#94a3b8;
        font-size:0.9rem;
        margin-bottom:25px;
    }

    /* INPUTS */
    .form-control{
        background:#0b1220;
        border:1px solid #334155;
        color:#e5e7eb;
        border-radius:12px;
        padding:12px;
        margin-bottom:15px;
    }

    .form-control:focus{
        border-color:#38bdf8;
        box-shadow:0 0 0 0.2rem rgba(56,189,248,0.2);
    }

    /* BOT脫N */
    .btn-login{
        width:100%;
        padding:12px;
        border-radius:12px;
        font-weight:700;
        border:none;
        background: linear-gradient(135deg, #38bdf8, #60a5fa);
        color:#0f172a;
        transition:0.2s ease;
    }

    .btn-login:hover{
        transform:translateY(-2px);
        box-shadow:0 10px 30px rgba(56,189,248,0.3);
    }

    /* CANCEL */
    .btn-cancel{
        display:block;
        margin-top:12px;
        color:#94a3b8;
        text-decoration:none;
        font-size:0.9rem;
    }

    .btn-cancel:hover{
        color:#e5e7eb;
    }

    /* ALERT */
    .alert{
        border-radius:12px;
        font-size:0.9rem;
    }
    /* LOGO */
    .logo-fixed{
        position: fixed;
        top: 20px;
        left: 20px;
        width: 80px;
        height: auto;
        z-index: 1000;

        border-radius: 16px;
        background: rgba(255,255,255,0.08);
        padding: 8px;
        backdrop-filter: blur(10px);

        box-shadow: 0 10px 30px rgba(0,0,0,0.4);
    }
</style>

</head>

<body>

    <img src="../img/logo-servimed.png" alt="ServiMed Logo" class="logo-fixed">

    <div class="login-box">

        <div class="brand">Servi-MED</div>
        <div class="subtitle">Sistema de reservas</div>

        <?php if(isset($msg)): ?>
            <div class="alert alert-danger">
                <?= $msg ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">

            <input type="email"
                name="email"
                class="form-control"
                placeholder="Correo electrónico"
                required>

            <input type="password"
                name="clave"
                class="form-control"
                placeholder="Contraseña"
                required>

            <input type="hidden" name="confirm" value="1">

            <button type="submit" class="btn-login">
                Ingresar al sistema
            </button>

        </form>

    </div>

</body>
</html>
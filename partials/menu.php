<style>
/* Navbar glass moderna */
.navbar-glass {
    background: rgba(255, 255, 255, 0.15) !important;
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(255,255,255,0.2);
}

/* Texto navbar */
.navbar-glass .navbar-brand,
.navbar-glass .nav-link {
    color: white !important;
    font-weight: 500;
}

/* Hover */
.navbar-glass .nav-link:hover {
    color: #e0e0e0 !important;
}

/* Dropdown */
.dropdown-menu {
    background: rgba(255,255,255,0.9);
    border-radius: 12px;
    border: none;
    backdrop-filter: blur(10px);
}

/* Botón hamburguesa blanco */
.navbar-toggler {
    border-color: rgba(255,255,255,0.5);
}

.navbar-toggler-icon {
    filter: invert(1);
}

/* ===== MEJORAS RESPONSIVE ===== */

/* Evita que el navbar sea muy alto en móvil */
@media (max-width: 991.98px) {
    .navbar-glass {
        padding: 0.6rem 1rem;
    }

    /* Fondo del menú desplegado (IMPORTANTE en móvil) */
    .navbar-collapse {
        background: rgba(0, 0, 0, 0.35);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-radius: 12px;
        padding: 12px;
        margin-top: 10px;
    }

    /* Links más cómodos en touch */
    .navbar-glass .nav-link {
        padding: 10px 12px;
        border-radius: 8px;
    }

    .navbar-glass .nav-link:active {
        background: rgba(255, 255, 255, 0.1);
    }

    /* Dropdown más legible en móvil */
    .dropdown-menu {
        position: static !important;
        float: none;
        width: 100%;
        margin-top: 8px;
    }

    /* Separación de usuario/login */
    .navbar-nav {
        gap: 4px;
    }
}

/* Evita overflow horizontal raro */
body {
    overflow-x: hidden;
}

/* Mejora toque del botón hamburguesa */
.navbar-toggler {
    padding: 6px 10px;
    border-radius: 8px;
}
</style>
<nav class="navbar navbar-expand-lg navbar-glass fixed-top">
    <div class="container-fluid">

        <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>">
            Servimed
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link active" href="<?= RESERVAS ?>">Inicio</a>
                </li>

                <?php if(isset($_SESSION['autenticado']) && 
                    ($_SESSION['usuario_rol'] == 'Administrador' || $_SESSION['usuario_rol'] == 'Supervisor')): ?>

<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle fw-semibold" href="#" data-bs-toggle="dropdown">
        Administrar
    </a>

    <ul class="dropdown-menu dropdown-glass shadow-lg border-0 mt-2">
        
        <li><a class="dropdown-item" href="<?= HORARIOS ?>">🕒 Horarios</a></li>
        <li><hr class="dropdown-divider"></li>

        <li><a class="dropdown-item" href="<?= ROLES ?>">👥 Roles</a></li>
        <li><a class="dropdown-item" href="<?= ESPECIALIDADES ?>">🏥 Especialidades</a></li>
        
        <li><hr class="dropdown-divider"></li>

        <li><a class="dropdown-item" href="<?= EMPLEADOS ?>">👨‍⚕️ Empleados</a></li>
        <li><a class="dropdown-item" href="<?= PACIENTES ?>">🧑 Pacientes</a></li>

    </ul>
</li>

                <?php endif; ?>

            </ul>

            <ul class="navbar-nav">

                <?php if(!isset($_SESSION['autenticado'])): ?>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= LOGIN ?>">Iniciar Sesión</a>
                    </li>

                <?php else: ?>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <?= $_SESSION['usuario_nombre'] ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="<?= SHOW_EMPLEADO . $_SESSION['usuario_empleado']; ?>">
                                    Mi Perfil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="<?= LOGOUT ?>">
                                    Cerrar Sesión
                                </a>
                            </li>
                        </ul>
                    </li>

                <?php endif; ?>

            </ul>

        </div>
    </div>
</nav>
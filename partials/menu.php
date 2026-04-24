<style>

    /* ===== NAVBAR GLASS MODERNA ===== */
    .navbar-glass {
        background: rgba(15, 23, 42, 0.75) !important;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    /* ===== TEXTO NAVBAR ===== */
    .navbar-glass .navbar-brand,
    .navbar-glass .nav-link {
        color: white !important;
        font-weight: 500;
        transition: 0.2s;
    }

    /* Hover links */
    .navbar-glass .nav-link:hover {
        color: #93c5fd !important;
    }

    /* ===== DROPDOWN ===== */
    .dropdown-menu {
        background: rgba(255,255,255,0.95);
        border-radius: 14px;
        border: none;
        backdrop-filter: blur(12px);
        padding: 8px;
    }

    /* Items */
    .dropdown-item {
        border-radius: 8px;
        padding: 10px 12px;
        transition: all 0.2s ease;
        font-size: 0.9rem;
    }

    /* Hover items */
    .dropdown-item:hover {
        background: #f1f5f9;
        transform: translateX(3px);
    }

    /* ===== ICONOS ===== */
    .dropdown-item i {
        font-size: 1rem;
        width: 22px;
        text-align: center;
        opacity: 0.75;
        transition: 0.2s;
    }

    .dropdown-item:hover i {
        opacity: 1;
        transform: scale(1.1);
    }

    /* ===== BOTÓN HAMBURGUESA ===== */
    .navbar-toggler {
        border-color: rgba(255,255,255,0.5);
        padding: 6px 10px;
        border-radius: 8px;
    }

    .navbar-toggler-icon {
        filter: invert(1);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 991.98px) {

        .navbar-glass {
            padding: 0.6rem 1rem;
        }

        /* Fondo menú móvil */
        .navbar-collapse {
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 12px;
            padding: 12px;
            margin-top: 10px;
        }

        /* Links táctiles */
        .navbar-glass .nav-link {
            padding: 12px;
            border-radius: 8px;
        }

        .navbar-glass .nav-link:active {
            background: rgba(255,255,255,0.1);
        }

        /* Dropdown como lista */
        .dropdown-menu {
            position: static !important;
            width: 100%;
            margin-top: 8px;
            background: rgba(255,255,255,0.08);
            color: white;
        }

        .dropdown-item {
            color: white;
        }

        .dropdown-item:hover {
            background: rgba(255,255,255,0.15);
            transform: none;
        }

        .navbar-nav {
            gap: 4px;
        }
    }

    /* Evita scroll lateral */
    body {
        overflow-x: hidden;
    }

    /* Botón hamburguesa personalizado */
.custom-toggler {
    border: none;
    background: transparent;
}

/* Contenedor de líneas */
.toggler-icon {
    display: inline-block;
    width: 24px;
    height: 2px;
    background-color: white;
    position: relative;
    transition: 0.3s;
}

/* Línea arriba */
.toggler-icon::before,
.toggler-icon::after {
    content: "";
    position: absolute;
    width: 24px;
    height: 2px;
    background-color: white;
    left: 0;
    transition: 0.3s;
}

.toggler-icon::before {
    top: -7px;
}

.toggler-icon::after {
    top: 7px;
}

</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<nav class="navbar navbar-expand-lg navbar-glass fixed-top">
    <div class="container-fluid">

        <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>">
            Servimed
        </a>

        <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link active" href="<?= RESERVAS ?>">Inicio</a>
                </li>

                <?php if(isset($_SESSION['autenticado']) && 
                    ($_SESSION['usuario_rol'] == 'Administrador' || $_SESSION['usuario_rol'] == 'Supervisor')): ?>

            <li class="nav-item dropdown">

                <a class="nav-link dropdown-toggle fw-semibold d-flex align-items-center gap-2"
                href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-gear"></i> Administrar
                </a>

                <ul class="dropdown-menu dropdown-glass shadow-lg border-0 mt-2 p-2">

                    <li class="dropdown-title">Gestión</li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2" href="<?= HORARIOS ?>">
                            <i class="bi bi-clock"></i> Horarios
                        </a>
                    </li>

                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2" href="<?= ROLES ?>">
                            <i class="bi bi-people"></i> Roles
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2" href="<?= ESPECIALIDADES ?>">
                            <i class="bi bi-hospital"></i> Especialidades
                        </a>
                    </li>

                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2" href="<?= EMPLEADOS ?>">
                            <i class="bi bi-person-badge"></i> Funcionarios
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2" href="<?= PACIENTES ?>">
                            <i class="bi bi-person"></i> Pacientes
                        </a>
                    </li>

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
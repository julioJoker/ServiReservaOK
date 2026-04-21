<?php
#define rutas a traves constantes
define('BASE_URL','http://localhost/servimedreserva/');
define('PARAM', false);

#definicion de rutas de roles
define('ROLES', BASE_URL . 'roles/');
define('ADD_ROL', ROLES . 'add.php');
define('SHOW_ROL', ROLES . 'show.php?rol=' . PARAM);
define('EDIT_ROL', ROLES . 'edit.php?rol=' . PARAM);
define('DEL_ROL', ROLES . 'delete.php');

#definicion de rutas de especialidades
define('ESPECIALIDADES', BASE_URL . 'especialidades/');
define('ADD_ESPECIALIDAD', ESPECIALIDADES . 'add.php');
define('SHOW_ESPECIALIDAD', ESPECIALIDADES . 'show.php?especialidad=' . PARAM);
define('EDIT_ESPECIALIDAD', ESPECIALIDADES . 'edit.php?especialidad=' . PARAM);

#definicion de rutas de empleados
define('EMPLEADOS', BASE_URL . 'empleados/');
define('ADD_EMPLEADO', EMPLEADOS . 'add.php');
define('SHOW_EMPLEADO', EMPLEADOS . 'show.php?empleado=' . PARAM);
define('EDIT_EMPLEADO', EMPLEADOS . 'edit.php?empleado=' . PARAM);

#ruta de usuarios
define('USUARIOS', BASE_URL . 'usuarios/');
define('ADD_USUARIO', USUARIOS . 'add.php?empleado=' . PARAM);
define('EDIT_PASSWORD', USUARIOS . 'editPassword.php?usuario=' . PARAM);
define('EDIT_USUARIO', USUARIOS . 'edit.php?usuario=' . PARAM);
define('LOGIN', USUARIOS . 'login.php');
define('LOGOUT', USUARIOS . 'logout.php');

#rutas telefonos
define('TELEFONOS', BASE_URL . 'telefonos/');
define('ADD_TEL_EMPL', TELEFONOS . 'addTelefonoEmpleado.php?empleado=' . PARAM);
define('ADD_TEL_PAC', TELEFONOS . 'addTelefonoPaciente.php?paciente=' . PARAM);
define('SHOW_TELEFONO', TELEFONOS . 'show.php?telefono=' . PARAM);
define('EDIT_TELEFONO', TELEFONOS . 'edit.php?telefono=' . PARAM);
define('DEL_TELEFONO', TELEFONOS . 'delete.php');

#rutas de pacientes
define('PACIENTES', BASE_URL . 'pacientes/');
define('ADD_PACIENTE', PACIENTES . 'add.php');
define('SHOW_PACIENTE', PACIENTES . 'show.php?paciente=' . PARAM);
define('EDIT_PACIENTE', PACIENTES . 'edit.php?paciente=' . PARAM);
define('SHOW_FICHASPACIEN', PACIENTES . 'show_fichasPa.php?paciente=' . PARAM);
define('ADD_FICHAPACIEN', PACIENTES . 'addFichaP.php?paciente=' . PARAM);
define('SHOW_FICHAPACIEN', PACIENTES . 'showFichaP.php?paciente=' . PARAM);

#rutas de horarios
define('HORARIOS', BASE_URL . 'horarios/');
define('ADD_HORARIO', HORARIOS . 'add.php');
define('SHOW_HORARIO', HORARIOS . 'show.php?horario=' . PARAM);
define('EDIT_HORARIO', HORARIOS . 'edit.php?horario=' . PARAM);

#rutas reservas
define('RESERVAS', BASE_URL . 'reservas/');
define('ADD_RESERVA', RESERVAS . 'add.php?paciente=' . PARAM);
define('SHOW_RESERVA', RESERVAS . 'show.php?reserva=' . PARAM);
define('EDIT_RESERVA', RESERVAS . 'edit.php?reserva=' . PARAM);

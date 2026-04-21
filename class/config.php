<?php

define('APP_NAME', 'SERVIMED');

/* =========================
   CONFIGURACIÓN GENERAL
========================= */
define('APP_ENV', 'development'); // production | development
define('APP_DEBUG', true);

/* =========================
   TITULOS DINÁMICOS
========================= */
define('APP_TITLE_DEFAULT', 'Sistema de Reservas');
define('TITLE', APP_NAME . ' | ' . APP_TITLE_DEFAULT);

/* =========================
   SEGURIDAD
========================= */
define('HASH_KEY','61847e199fda861j471329a024');
define('SESSION_TIME', 600); // 10 minutos en segundos

/* =========================
   ZONA HORARIA
========================= */
date_default_timezone_set('America/Santiago');

/* =========================
   FORMATO FECHAS
========================= */
define('DATE_FORMAT', 'd-m-Y');
define('DATETIME_FORMAT', 'd-m-Y H:i');

/* =========================
   CONFIG RESERVAS
========================= */
define('RESERVA_INTERVALO', 30); // minutos
define('HORA_INICIO', '08:00');
define('HORA_FIN', '20:00');

/* =========================
   MENSAJES DEL SISTEMA
========================= */
define('MSG_SUCCESS', 'Operación realizada correctamente');
define('MSG_ERROR', 'Ha ocurrido un error');
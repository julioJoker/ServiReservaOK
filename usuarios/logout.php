<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require('../class/rutas.php');
require('../class/config.php');
require('../class/session.php');
require('../class/usuarioModel.php');

$session = new Session();

$session->logout();

header('Location: ' . LOGIN);
exit;
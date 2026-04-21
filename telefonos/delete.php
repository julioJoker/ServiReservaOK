<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require('../class/config.php');
require('../class/rutas.php');
require('../class/session.php');
require('../class/telefonoModel.php');

$session = new Session;

if (isset($_SESSION['autenticado']) && $_SESSION['usuario_rol'] == 'Administrador') {
    # code...


    if (isset($_POST['confirm']) && $_POST['confirm'] == 1) {
        $id = (int) $_POST['telefono'];

        //print_r($id);exit;

        #verificar que hay un rol con el id recibido
        $telefonos = new TelefonoModel;
        $telefono = $telefonos->getTelefonoId($id);

        if ($telefono) {
            #eliminar el rol
            $row = $telefonos->deleteTelefono($id);

            if ($row) {
                $_SESSION['success'] = 'El teléfono se ha eliminado correctamente';
                if ($telefono['telefonoable_type'] == 'Empleado') {
                    header('Location: ' . SHOW_EMPLEADO . $telefono['telefonoable_id']);
                }else{
                    #vista paciente id
                }

            }else {
                $_SESSION['danger'] = 'El teléfono no se ha podido eliminar... intente mas tarde';
                if ($telefono['telefonoable_type'] == 'Empleado') {
                    header('Location: ' . SHOW_EMPLEADO . $telefono['telefonoable_id']);
                }else{
                    #vista paciente id
                }
            }
        }else{
            $_SESSION['danger'] = 'El teléfono no está registrado';
            if ($telefono['telefonoable_type'] == 'Empleado') {
                header('Location: ' . SHOW_EMPLEADO . $telefono['telefonoable_id']);
            }else{
                #vista paciente id
            }
        }
    }
}else {
    header('Location: ' . LOGIN);
}
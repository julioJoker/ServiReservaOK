<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require('../class/config.php');
require('../class/rutas.php');
require('../class/session.php');
require('../class/rolModel.php');

$session = new Session;

if (isset($_SESSION['autenticado']) && $_SESSION['usuario_rol'] == 'Administrador') {
    # code...


    if (isset($_POST['confirm']) && $_POST['confirm'] == 1) {
        $id = (int) $_POST['rol'];

        //print_r($id);exit;

        #verificar que hay un rol con el id recibido
        $roles = new RolModel;
        $rol = $roles->getRolId($id);

        if ($rol) {
            #eliminar el rol
            $row = $roles->deleteRol($id);

            if ($row) {
                $_SESSION['success'] = 'El rol se ha eliminado correctamente';
                header('Location: ' . ROLES);
            }else {
                $_SESSION['danger'] = 'El rol no se ha podido eliminar... intente mas tarde';
                header('Location: ' . SHOW_ROL . $id);
            }
        }else{
            $_SESSION['danger'] = 'El rol no está registrado';
            header('Location: ' . ROLES);
        }
    }
}else {
    header('Location: ' . LOGIN);
}
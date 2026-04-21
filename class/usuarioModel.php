<?php

require_once('model.php');
require_once('Hash.php');
require_once('config.php');

class UsuarioModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getUsuarioId($id)
    {
        $usu = $this->_db->prepare("SELECT u.id, u.activo, u.empleado_id, u.created_at, u.updated_at, e.nombre as empleado FROM usuarios u INNER JOIN empleados e ON u.empleado_id = e.id WHERE u.id = ?");
         $usu->bindParam(1, $id);
        $usu->execute();

        return $usu->fetch();
    }

    public function getUsuarioEmpleado($empleado)
    {
        $usu = $this->_db->prepare("SELECT id FROM usuarios WHERE empleado_id = ?");
        $usu->bindParam(1, $empleado);
        $usu->execute();

        return $usu->fetch();
    }

    public function getUsuarioEmailClave($email, $clave)
    {
        //print_r($email);exit;

        $usu = $this->_db->prepare("SELECT u.id, u.empleado_id, e.nombre as empleado, r.nombre as rol FROM usuarios u INNER JOIN empleados e ON u.empleado_id = e.id INNER JOIN roles r ON r.id = e.rol_id WHERE e.email = ? AND clave = ? AND u.activo = 1");
        $usu->bindParam(1, $email);
        $usu->bindParam(2, $clave);
        $usu->execute();

        return $usu->fetch();
    }

    public function addUsuario($clave, $empleado)
    {

        $usu = $this->_db->prepare("INSERT INTO usuarios(clave, activo, empleado_id, created_at, updated_at) VALUES(?, 1, ?, now(), now())");
        $usu->bindParam(1, $clave);
        $usu->bindParam(2, $empleado);
        $usu->execute();

        $row = $usu->rowCount();

        return $row;
    }

    public function editPassword($id, $clave)
    {

        $usu = $this->_db->prepare("UPDATE usuarios SET clave = ?, updated_at = now() WHERE id = ?");
        $usu->bindParam(1, $clave);
        $usu->bindParam(2, $id);
        $usu->execute();

        $row = $usu->rowCount();

        return $row;
    }

    public function editUsuario($id, $activo)
    {
        $usu = $this->_db->prepare("UPDATE usuarios SET activo = ?, updated_at = now() WHERE id = ?");
        $usu->bindParam(1, $activo);
        $usu->bindParam(2, $id);
        $usu->execute();

        $row = $usu->rowCount();

        return $row;
    }

}

<?php
#llamada a la clase model
require_once('model.php');

class RolModel extends Model
{
    #la funcion de esta clase sera trabajar directamente con la tabla roles

    #constructor
    public function __construct()
    {
        parent::__construct();
    }

    #metodo que recupera todos los roles
    public function getRoles()
    {
        $rol = $this->_db->query("SELECT id, nombre FROM roles ORDER BY nombre");

        return $rol->fetchall();
    }

    #metodo consulta por un rol a traves de su id
    public function getRolId($id)
    {
        $rol = $this->_db->prepare("SELECT id, nombre FROM roles WHERE id = ?");
        $rol->bindParam(1, $id);
        $rol->execute();

        return $rol->fetch();
    }

    #metodo que consulta por el nombre de un rol
    public function getRolNombre($nombre)
    {
        $rol = $this->_db->prepare("SELECT id FROM roles WHERE nombre = ?");
        $rol->bindParam(1, $nombre);
        $rol->execute();

        return $rol->fetch();
    }

    #metodo para registrar un rol
    public function setRol($nombre)
    {
        $rol = $this->_db->prepare("INSERT INTO roles(nombre) VALUES(?)");
        $rol->bindParam(1, $nombre);
        $rol->execute();

        #rescatamos el numero de filas afectadas por la consulta
        $row = $rol->rowCount();
        return $row;
    }

    #metodo para editar un rol
    public function updateRol($id, $nombre)
    {
        $rol = $this->_db->prepare("UPDATE roles SET nombre = ? WHERE id = ?");
        $rol->bindParam(1, $nombre);
        $rol->bindParam(2, $id);
        $rol->execute();

        #rescatamos el numero de filas afectadas por la consulta
        $row = $rol->rowCount();
        return $row;
    }

    #metodo para eliminar un rol
    public function deleteRol($id)
    {
        $rol = $this->_db->prepare("DELETE FROM roles WHERE id = ?");
        $rol->bindParam(1, $id);
        $rol->execute();

        $row = $rol->rowCount();
        return $row;
    }
}


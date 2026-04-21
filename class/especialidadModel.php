<?php
#llamada a la clase model
require_once('model.php');

class EspecialidadModel extends Model
{
    #la funcion de esta clase sera trabajar directamente con la tabla especialidades

    #constructor
    public function __construct()
    {
        parent::__construct();
    }

    #metodo que recupera todos las especialidades
    public function getEspecialidades()
    {
        $esp = $this->_db->query("SELECT id, nombre FROM especialidades ORDER BY nombre");

        return $esp->fetchall();
    }

    #metodo consulta por una especialidad a traves de su id
    public function getEspecialidadId($id)
    {
        $esp = $this->_db->prepare("SELECT id, nombre FROM especialidades WHERE id = ?");
        $esp->bindParam(1, $id);
        $esp->execute();

        return $esp->fetch();
    }

    #metodo que consulta por el nombre de una especialidad
    public function getEspecialidadNombre($nombre)
    {
        $esp = $this->_db->prepare("SELECT id FROM especialidades WHERE nombre = ?");
        $esp->bindParam(1, $nombre);
        $esp->execute();

        return $esp->fetch();
    }

    #metodo para registrar una especialidad
    public function setEspecialidad($nombre)
    {
        $esp = $this->_db->prepare("INSERT INTO especialidades(nombre) VALUES(?)");
        $esp->bindParam(1, $nombre);
        $esp->execute();

        #rescatamos el numero de filas afectadas por la consulta
        $row = $esp->rowCount();
        return $row;
    }

    #metodo para editar una especialidad
    public function updateEspecialidad($id, $nombre)
    {
        $esp = $this->_db->prepare("UPDATE especialidades SET nombre = ? WHERE id = ?");
        $esp->bindParam(1, $nombre);
        $esp->bindParam(2, $id);
        $esp->execute();

        #rescatamos el numero de filas afectadas por la consulta
        $row = $esp->rowCount();
        return $row;
    }
}


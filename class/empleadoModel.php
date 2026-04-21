<?php

require_once('model.php');

class EmpleadoModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getEmpleados()
    {
        $emp = $this->_db->query("SELECT e.id, e.nombre, r.nombre as rol, es.nombre as especialidad FROM empleados e INNER JOIN roles r ON r.id = e.rol_id INNER JOIN especialidades es ON e.especialidad_id = es.id ORDER BY e.nombre");

        return $emp->fetchall();
    }
    
    public function getEmpleadosFicha($id)
    {
        
        $emp = $this->_db->query("SELECT e.id, e.nombre, r.nombre as rol, es.nombre as especialidad FROM empleados e INNER JOIN roles r ON r.id = e.rol_id INNER JOIN especialidades es ON e.especialidad_id = es.id WHERE  es.id = ?");
        $emp->bindParam(1, $id);
        $emp->execute();
        return $emp->fetch();
    }

    public function getEmpleadoId($id)
    {
        $emp = $this->_db->prepare("SELECT e.id, e.rut, e.nombre, e.email, e.fecha_nacimiento, e.rol_id, e.especialidad_id, e.created_at, e.updated_at, r.nombre as rol, es.nombre as especialidad FROM empleados e INNER JOIN roles r ON r.id = e.rol_id INNER JOIN especialidades es ON e.especialidad_id = es.id WHERE e.id = ?");
        $emp->bindParam(1, $id);
        $emp->execute();

        return $emp->fetch();
    }
   

    public function getEmpleadoRutEmail($rut, $email)
    {
        $emp = $this->_db->prepare("SELECT id FROM empleados WHERE rut = ? OR email = ?");
        $emp->bindParam(1, $rut);
        $emp->bindParam(2, $email);
        $emp->execute();

        return $emp->fetch();
    }

    public function addEmpleado($rut, $nombre, $email, $fecha_nacimiento, $rol, $especialidad)
    {
        $emp = $this->_db->prepare("INSERT INTO empleados(rut, nombre, email, fecha_nacimiento, rol_id, especialidad_id, created_at, updated_at) VALUES(?, ?, ?, ?, ?, ?, now(), now())");
        $emp->bindParam(1, $rut);
        $emp->bindParam(2, $nombre);
        $emp->bindParam(3, $email);
        $emp->bindParam(4, $fecha_nacimiento);
        $emp->bindParam(5, $rol);
        $emp->bindParam(6, $especialidad);
        $emp->execute();

        $row = $emp->rowCount();

        return $row;
    }

     #metodo que recupera todos los profecionales
     public function getEspecialidadesSelect()
     {
         $esp = $this->_db->query("SELECT id, nombre FROM empleados  ORDER BY nombre");

         return $esp->fetchall();
     }

    public function editEmpleado($id, $rut, $nombre, $email, $fecha_nacimiento, $rol, $especialidad)
    {
        //print_r($especialidad);
        $emp = $this->_db->prepare("UPDATE empleados SET rut = ?, nombre = ?, email = ?, fecha_nacimiento = ?, rol_id = ?, especialidad_id = ?, updated_at = now() WHERE id = ?");
        $emp->bindParam(1, $rut);
        $emp->bindParam(2, $nombre);
        $emp->bindParam(3, $email);
        $emp->bindParam(4, $fecha_nacimiento);
        $emp->bindParam(5, $rol);
        $emp->bindParam(6, $especialidad);
        $emp->bindParam(7, $id);
        $emp->execute();

        $row = $emp->rowCount();

        return $row;
    }
}

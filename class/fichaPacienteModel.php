<?php
require_once('model.php');

class PacienteModel2 extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getPacientes()
    {
        $pac = $this->_db->query("SELECT id, rut, nombre, fonasa FROM pacientes ORDER BY id DESC");

        return $pac->fetchall();
    }

    public function getPacienteId($id)
    {
        $pac = $this->_db->prepare("SELECT id, rut, nombre, email,dirección, fecha_nacimiento, timestampdiff(year, fecha_nacimiento, curdate()) as edad, fonasa, created_at, updated_at FROM pacientes WHERE id = ?");
        $pac->bindParam(1, $id);
        $pac->execute();

        return $pac->fetch();
    }

    
    public function getPacienteRut($rut)
    {
        $pac = $this->_db->prepare("SELECT id, rut, nombre FROM pacientes WHERE rut = ?");
        $pac->bindParam(1, $rut);
        $pac->execute();

        return $pac->fetch();
    }

    public function addPaciente($rut, $nombre, $email, $fecha_nacimiento, $fonasa)
    {
        $pac = $this->_db->prepare("INSERT INTO pacientes(rut, nombre, email, fecha_nacimiento, fonasa, created_at, updated_at) VALUES(?, ?, ?, ?, ?, now(), now() )");
        $pac->bindParam(1, $rut);
        $pac->bindParam(2, $nombre);
        $pac->bindParam(3, $email);
        $pac->bindParam(4, $fecha_nacimiento);
        $pac->bindParam(5, $fonasa);
        $pac->execute();

        $row = $pac->rowCount();
        return $row;
    }

    public function editPaciente($id, $nombre, $email, $direccion,$fonasa)
    {
        $pac = $this->_db->prepare("UPDATE pacientes SET nombre = ?, email = ?,dirección = ?, fonasa = ? WHERE id = ?");
        
        $pac->bindParam(1, $nombre);
        $pac->bindParam(2, $email);
        $pac->bindParam(3, $direccion);
        $pac->bindParam(4, $fonasa);
        $pac->bindParam(5, $id);
        $pac->execute();

        $row = $pac->rowCount();
        return $row;
    }
}

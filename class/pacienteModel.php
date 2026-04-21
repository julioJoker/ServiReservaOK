<?php
require_once('model.php');

class PacienteModel extends Model
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
        $pac = $this->_db->prepare("SELECT id, rut, nombre,sexo,direccion, email, fecha_nacimiento, timestampdiff(year, fecha_nacimiento, curdate()) as edad, fonasa, created_at, updated_at FROM pacientes WHERE id = ?");
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

public function addPaciente($rut, $nombre, $email, $fecha_nacimiento, $fonasa, $sexo, $direccion)
{
    $sql = "INSERT INTO pacientes 
        (rut, nombre, email, direccion, fecha_nacimiento, fonasa, sexo, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

    $pac = $this->_db->prepare($sql);

    $pac->bindParam(1, $rut);
    $pac->bindParam(2, $nombre);
    $pac->bindParam(3, $email);
    $pac->bindParam(4, $direccion);
    $pac->bindParam(5, $fecha_nacimiento);
    $pac->bindParam(6, $fonasa);
    $pac->bindParam(7, $sexo);

    $pac->execute();

    return $pac->rowCount();
}

//     public function addPaciente($rut, $nombre, $email, $fecha_nacimiento, $fonasa, $sexo, $direccion)
// {
//     $pac = $this->_db->prepare("
//         INSERT INTO pacientes
//         (rut, nombre, email, direccion, fecha_nacimiento, fonasa, sexo, created_at, updated_at)
//         VALUES (?, ?, ?, ?, ?, ?, ?, now(), now())
//     ");

//     $pac->bindParam(1, $rut);
//     $pac->bindParam(2, $nombre);
//     $pac->bindParam(3, $email);
//     $pac->bindParam(4, $direccion);
//     $pac->bindParam(5, $fecha_nacimiento);
//     $pac->bindParam(6, $fonasa);
//     $pac->bindParam(7, $sexo);

//     $pac->execute();

//     return $pac->rowCount();
// }

    public function editPaciente($id, $nombre,$sexo, $email, $direccion,$fonasa)
    {
        $pac = $this->_db->prepare("UPDATE pacientes SET nombre = ?,sexo = ?, email = ?,direccion = ?, fonasa = ? WHERE id = ?");
        
        $pac->bindParam(1, $nombre);
        $pac->bindParam(2, $sexo);
        $pac->bindParam(3, $email);
        $pac->bindParam(4, $direccion);
        $pac->bindParam(5, $fonasa);
        $pac->bindParam(6, $id);
        $pac->execute();

        $row = $pac->rowCount();
        return $row;
    }


    public function buscarPacientes($texto){
        $sql = "SELECT * FROM pacientes 
                WHERE nombre LIKE :texto 
                OR rut LIKE :texto
                ORDER BY nombre ASC";

        $stmt = $this->_db->prepare($sql);
        $stmt->execute([
            ':texto' => '%' . $texto . '%'
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

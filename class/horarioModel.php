<?php
#llamada a la clase model
require_once('model.php');

class HorarioModel extends Model
{
    #constructor
    public function __construct()
    {
        parent::__construct();
    }

    public function getHorarios()
    {
        $hor = $this->_db->query("SELECT id, horario FROM horarios ORDER BY horario");

        return $hor->fetchall();
    }

    public function getHorarioId($id)
    {
        $hor = $this->_db->prepare("SELECT id, horario FROM horarios WHERE id = ?");
        $hor->bindParam(1, $id);
        $hor->execute();

        return $hor->fetch();
    }

    public function getHorarioHorario($horario)
    {
        $hor = $this->_db->prepare("SELECT id FROM horarios WHERE horario = ?");
        $hor->bindParam(1, $horario);
        $hor->execute();

        return $hor->fetch();
    }

    public function addHorario($horario)
    {
        $hor = $this->_db->prepare("INSERT INTO horarios(horario) VALUES(?)");
        $hor->bindParam(1, $horario);
        $hor->execute();

        #rescatamos el numero de filas afectadas por la consulta
        $row = $hor->rowCount();
        return $row;
    }

    public function editHorario($id, $horario)
    {
        $hor = $this->_db->prepare("UPDATE horarios SET horario = ? WHERE id = ?");
        $hor->bindParam(1, $horario);
        $hor->bindParam(2, $id);
        $hor->execute();

        #rescatamos el numero de filas afectadas por la consulta
        $row = $hor->rowCount();
        return $row;
    }

    public function deleteHorario($id){
        $hor = $this->_db->prepare("DELETE FROM horarios WHERE id = ?");
        $hor->bindParam(1, $id, PDO::PARAM_INT);
        $hor->execute();

        return $hor->rowCount(); // opcional
    }

    public function tieneReservas($id){
        $sql = "SELECT COUNT(*) as total FROM reservas WHERE horario_id = ?";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        $result = $stmt->fetch();
        return $result['total'] > 0;
    }

}


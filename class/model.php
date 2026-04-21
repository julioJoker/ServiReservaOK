<?php
#llamada al archivo de conexion de la base de datos
require('conexion.php');

class Model
{
    protected $_db;

    public function __construct()
    {
        #creacion de una instancia de la clase conexion
        $this->_db = new Conexion; #colaboracion de objetos
    }
}

<?php
class Conexao{
    private $host= "localhost";
    private $database= 'registro_ponto';
    private $user= "root";
    private $senha= '';

    function __construct(){

    }
    function setDB(){
        $con= mysqli_connect($this-> host, $this->user, $this->senha, $this->database);
        mysqli_set_charset($con, "UTF8");
        if(mysqli_connect_errno()){
            echo "Erro ao tentar se conectar". mysqli_connect_errno();
        }
        return $con;
    }

}
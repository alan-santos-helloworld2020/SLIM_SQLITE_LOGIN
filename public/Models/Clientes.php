<?php
namespace Clientes;

class Clientes{

    private $email;
    private $password;
    private $database = array();

    public function getEmail(){
        return $this->email;
    }
    public function setEmail($email){
        $this->email = $email;
    }
    public function getPassword(){
        return $this->password;
    }
    public function setPassword($password){
        $this->password = $password;
    }
    public function getDatabase(){
        return $this->database;
    }
    public function setDatabase($dados){
        array_push($this->database,$dados);
    }

}
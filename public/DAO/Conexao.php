<?php

class Conexao{

    public function conectar()
    {
      try {
        $conn = new \PDO("sqlite:Database/database.sqlite",'', '', array(
            \PDO::ATTR_EMULATE_PREPARES => false,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ));
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
        echo "Connected successfully";
      } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
      }
    }


}
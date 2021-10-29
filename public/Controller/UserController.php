<?php

use Clientes\Clientes;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


require __DIR__ . '/../DAO/Conexao.php';
require __DIR__ . '/../Models/Clientes.php';


$db = new Conexao();
$cl = new Clientes();

final class UserController{

    public function salvar(Request $request, Response $response, $args) {

        global $cl, $db;
        $body = $request->getParsedBody();
        $cl->setEmail($body["email"]);
        $cl->setPassword($body["password"]);
        
        try {
            $cnx = $db->conectar();
            $sql = "INSERT INTO users(email,password) VALUES (:email,:password)";
            $pstm = $cnx->prepare($sql);
            $pstm->bindParam(":email", $cl->getEmail());
            $pstm->bindParam(":password", $cl->getPassword());
            $pstm->execute();
            $dados = ["email" => $cl->getEmail(), "password" => $cl->getPassword()];
            $response->getBody()->write(json_encode($dados));
            $cnx=null;
        } catch (PDOException $ex) {
            $erro = array("Message"=>$ex->getMessage());

            $response->getBody()->write(json_encode(["Erro"=>$erro]));
        }
    
        return $response
        ->withHeader("Content-Type","application/json")
        ->withStatus(201);
    }

    public  function usuarios(Request $request, Response $response, $args) {
        global $db;
        $sql = "SELECT * FROM users";
        try {
            $cnx = $db->conectar();
            $pstm=$cnx->query($sql);
            $result = $pstm->fetchAll(PDO::FETCH_OBJ);
            $cnx=null; 
            $response->getBody()->write(json_encode($result,JSON_UNESCAPED_SLASHES));
            
        } catch (PDOException $ex) {
            $response->getBody()->write(json_encode(["Erro"=>$ex]));
        }
    
        return $response
        ->withHeader("Content-Type","application/json")
        ->withStatus(200);
    }

    public function pesquisar(Request $request, Response $response, $args) {
        global $db;
        $id = $args["id"];
        $sql = "SELECT * FROM users WHERE id=:id";
        try {
            $cnx = $db->conectar();
            $pstm=$cnx->prepare($sql);
            $pstm->execute([':id' => $id]);
            $result = $pstm->fetchAll(PDO::FETCH_OBJ);
            $cnx=null; 
            $response->getBody()->write(json_encode($result,JSON_UNESCAPED_SLASHES));
            
        } catch (PDOException $ex) {
            $response->getBody()->write(json_encode(["Erro"=>$ex]));
        }
    
        return $response
        ->withHeader("Content-Type","application/json")
        ->withStatus(200);
    }

    public function deletar(Request $request, Response $response, $args) {
        global $db;
        $id = $args["id"];
        $sql = "DELETE FROM users WHERE id=:id";
        try {
            $cnx = $db->conectar();
            $pstm=$cnx->prepare($sql);
            $pstm->bindParam(":id",$id);
            $pstm->execute();
            $cnx=null; 
            $response->getBody()->write(json_encode(["Msg"=>TRUE],JSON_UNESCAPED_SLASHES));
            
        } catch (PDOException $ex) {
            $erro = array("Message"=>$ex->getMessage());
            $response->getBody()->write(json_encode(["Erro"=>$erro]));
        }
    
        return $response
        ->withHeader("Content-Type","application/json")
        ->withStatus(200);
    }

}
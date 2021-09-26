<?php
class Model{
    var $sql, $pdo, $statement;


    function __construct()
    {
        try {

            $this->pdo = new PDO(
            'mysql:host='.HOST.';port='.PORT.'dbname='.DBNAME,
            USERNAME,PASSWORD,
            [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]
        );
        $this->pdo->query('set names utf8');

    } catch (PDOException $e) {
            //throw $th;
            exit($e->getMessage());
        }
    }

    function setQuery($sql){
        $this->sql = $sql;
        return $this;
    }


    /**
     * return 1 object
     */
    function loadRow($params = []){
        // echo $this->sql;
        try {

            $this->statement = $this->pdo->prepare($this->sql);
            $this->statement->execute($params);
            //return 1 object
            return $this->statement->fetch(PDO::FETCH_OBJ);

        } catch (PDOException $e) {
            exit($e->getFile());
        }
    }


    
    /**
     * return many object
     */
    function loadRows($params = []){
        try {

            $this->statement = $this->pdo->prepare($this->sql);
            $this->statement->execute($params);
            //return object
            return $this->statement->fetchAll(PDO::FETCH_OBJ);

        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }


    /**
     * save to db
     */
    function save($params=[]){
        try {
            $this->statement = $this->pdo->prepare($this->sql);
            return $this->statement->execute($params);

        } catch (PDOException $e) {
            exit($e->getMessage());
            
        }
    }

    /**
     * disconnet to db
     */
    function disconnet(){
        $this->pdo = null;
        $this->statement = null;
    }
}
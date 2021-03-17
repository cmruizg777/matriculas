<?php
error_reporting (5);

class CMySQL extends PDO {
    private $Database;
    private $Connect;
    private $sQuery;
    private $Query;
    var $Row;
    private $NRows;
    private $usuario;
    private $pass;
    function __construct($SQuery, $db, $server,$parametros)
    {
        $hostname_MyDBSql = $server;
        $database_MyDBSql = $db;
        $username_MyDBSql = "root";
        $password_MyDBSql = "xxxx44";
        $this->Database=$database_MyDBSql;
        $this->usuario=$username_MyDBSql;
        $this->pass= $password_MyDBSql;

        parent::__construct("mysql:host=$hostname_MyDBSql;dbname=".$this->Database,$this->usuario,$this->pass);
        if (strlen(trim($SQuery))>0){
            $this->Query=$this->prepare($SQuery);
            //foreach($parametros as $campo=>$dato)
            // $this->Query->bindParam($campo,$dato);
           $queries = explode('?', $SQuery);
            $str = '';
            $counter = 0;
            foreach ($queries as $query){
                $str.= $query."'".$parametros[$counter]."'";
                $counter++;
            }
            //print_r($str);
            $this->Query->execute($parametros);
            $this->Row=$this->Query->fetch();
        }
        return $this->Row;
    }
    function GetLastId(){
        return  $this->lastInsertId();
    }
    function GetRow(){
        $this->Row=$this->Query->fetch();
        return $this->Row;
    }
    function GetNRows(){
        if(!is_null($this->Query))
            return $this->Query->rowCount();
    }
    function SetQuery($SQuery,$parametros){
        if (strlen(trim($SQuery))>0){
            $this->Query=$this->prepare($SQuery);
            $this->Query->execute($parametros);
            $this->Row=$this->Query->fetch();
        }
        return $this->Row;
    }
    function GetNFields(){
        if(!is_null($this->Query))
            return $this->Query->columnCount();
    }


}

class CMySQL1 extends PDO  {
    private $Database;
    private $Connect;
    private $sQuery;
    private $Query;
    var $Row;
    private $NRows;
    private $usuario;
    private $pass;
    private $connection;
    function __construct($conn,$SQuery,  $parametros)
    {
        /*$hostname_MyDBSql = "localhost";
        $database_MyDBSql = "telecom";
        $username_MyDBSql = "root";
        $password_MyDBSql = "sdkj1598";
         $this->Database=$database_MyDBSql;
         $this->usuario=$username_MyDBSql;
         $this->pass= $password_MyDBSql;
         parent::__construct("mysql:host=$hostname_MyDBSql;dbname=".$this->Database,$this->usuario,$this->pass);*/
        $connection=$conn;
        if (strlen(trim($SQuery))>0){
            $this->Query=$connection->prepare($SQuery);
            //foreach($parametros as $campo=>$dato)
            // $this->Query->bindParam($campo,$dato);
            $test = $this->Query->execute($parametros);
            $queries = explode('?', $SQuery);
            $str = '';
            $counter = 0;
            foreach ($queries as $query){
                $str.= $query."'".$parametros[$counter]."'";
                $counter++;
            }
            //print_r($str);
            $this->Row=$this->Query->fetch();
        }
        return $this->Row;
    }


    function GetLastId(){
        return  $this->lastInsertId();
    }
    function GetRow(){
        $this->Row=$this->Query->fetch();
        return $this->Row;
    }
    function GetNRows(){
        if(!is_null($this->Query))
            return $this->Query->rowCount();
    }
    function SetQuery($con,$SQuery,$parametros){
        if (strlen(trim($SQuery))>0){
            $this->Query=$con->prepare($SQuery);
            $this->Query->execute($parametros);
            $this->Row=$this->Query->fetch();
        }
        return $this->Row;
    }
    function GetNFields(){
        if(!is_null($this->Query))
            return $this->Query->columnCount();
    }


}


function getDatabaseConnection() {
    $hostname_MyDBSql = "186.4.154.145";
    $database_MyDBSql = "bdduevalleamanecer";
    $username_MyDBSql = "root";
    $password_MyDBSql = "xxxx44";
    try {

        $dsn = "mysql:host=$hostname_MyDBSql;dbname=$database_MyDBSql";
        $dbLink = new PDO($dsn, $username_MyDBSql, $password_MyDBSql);
        return $dbLink;

    }

    catch (PDOException $e) {

        die($e->getMessage());

    }

}

function getDatabaseConnection1($db,$server) {
    $hostname_MyDBSql = $server;
    $database_MyDBSql = $db;
    $username_MyDBSql = "root";
    $password_MyDBSql = "xxxx44";
    try {

        $dsn = "mysql:host=$hostname_MyDBSql;dbname=$database_MyDBSql";
        $dbLink = new PDO($dsn, $username_MyDBSql, $password_MyDBSql);
        return $dbLink;

    }

    catch (PDOException $e) {

        die($e->getMessage());

    }

}

?>
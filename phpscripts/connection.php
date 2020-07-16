<?php

 class Connection
 {
    private $dbcon;
    private $dbhost; //Datenbankhost
    private $dbname; //Datenbankname
    private $dbuser; //Datenbankuser
    private $dbpass; //Datenbank Passwort
    
    public function __construct()
    {
        $url = $_SERVER['HTTP_HOST'];
        
       

        if($url == 'localhost')
        {
            //Integration
            $this->dbhost = 'localhost';
            $this->dbname = 'revive'; //Ersetzten durch Datenbank name
            $this->dbuser = 'root';
            $this->dbpass = '';
        }
        else
        {
            //Produktiv
            $this->dbhost = 'localhost:3306';
            $this->dbname = 'revive'; //Ersetzten durch Datenbank name
            $this->dbuser = 'revive_db';
            $this->dbpass = 'kRdk^959';
        }
        
        
        try 
        {
            $this->dbcon = new PDO("mysql:host=$this->dbhost;dbname=$this->dbname","$this->dbuser", "$this->dbpass");
        } 
        catch(PDOException $e)
        {
            die('Keine Verbindung zur Datenbank möglich: ' . $e->getMessage());
        }
    
    }
    
    public function getDBO()
    {
        return $this->dbcon;
    }
    
    public function sqlexec($query)
    {
        if(isset($query) && $query != '')
        {
        $sql = $this->dbcon->prepare($query);
        $sql->execute();
        $data = $sql->fetchAll();
        
        return $data;
        }
        
        echo 'Fehler';
        
        return false;
    }

 }
?>
<?php
    class db{
        // Properties
        private $dbhost = '206.189.75.65';
        private $dbuser = 'besypztfkc';
        private $dbpass = 'c9qDpcYmyx';
        private $dbname = 'besypztfkc';

        // Connect
        public function connect(){
            $mysql_connect_str = "mysql:host=$this->dbhost;dbname=$this->dbname";
            $dbConnection = new PDO($mysql_connect_str, $this->dbuser, $this->dbpass);
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $dbConnection;
        }
    }
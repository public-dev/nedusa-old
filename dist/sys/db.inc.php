<?php

class Database
{
        private $host = "127.0.0.1";
        private $user = "nedsusat";
        private $pwd = "01010000 01101110";
        private $name = "nedusat";

        protected $conn;

        protected function connect()
        {
                $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->name;
                $pdo = new PDO($dsn, $this->user, $this->pwd);
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                return $pdo;
        }
}
?>
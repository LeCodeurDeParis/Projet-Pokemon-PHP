<?php

  abstract class Bdd{
    private $co = null;
   
    protected function __construct() {
      if($this->co == null){
        $this->connect();
      }
    }

    protected function getConnection():PDO
    {
      return $this->co;
    }
   
    public function connect():void
    {
      $this->co = new PDO(
        'mysql:host='. $_ENV['db_host'] .';dbname='. $_ENV['db_name'],
        $_ENV['db_user'],
        $_ENV['db_pwd']
      );
    }

    public function disconnect():void
    {
      $this->co = null;
      unset($this->co);
    }
  }

?>
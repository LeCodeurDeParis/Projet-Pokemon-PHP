<?php

  // Déclaration de la classe abstraite Bdd
  abstract class Bdd {
    // Propriété pour la connexion PDO
    private $co = null;
   
    // Constructeur de la classe
    protected function __construct() {
      // Vérifier si la connexion est nulle et se connecter si nécessaire
      if ($this->co == null) {
        $this->connect();
      }
    }

    // Méthode pour obtenir la connexion PDO
    protected function getConnection(): PDO {
      return $this->co;
    }
   
    // Méthode pour établir la connexion à la base de données
    public function connect(): void {
      // Créer une nouvelle instance de PDO avec les informations de connexion
      $this->co = new PDO(
        'mysql:host=' . $_ENV['db_host'] . ';dbname=' . $_ENV['db_name'],
        $_ENV['db_user'],
        $_ENV['db_pwd']
      );
    }

    // Méthode pour déconnecter de la base de données
    public function disconnect(): void {
      // Détruire la connexion PDO
      $this->co = null;
      unset($this->co);
    }
  }

?>
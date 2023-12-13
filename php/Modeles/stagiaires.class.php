<?php
include_once "database.class.php";

class Stagiaire
{

  // object properties
  public $id_membre;
  public $nom_membre;
  public $login_membre;


  // Création de la liste des Stagiaires
  public function lire()
  {

    $pdo = Database::connect();
    $sql = "SELECT * from membres";
    $reponse = $pdo->prepare($sql);
    $reponse->execute();
    Database::disconnect();

    // On retourne le résultat
    return $reponse;
  }

  // Lecture d'une seule fiche Stagiaire
  public function lire_un_seul_stagiaire($id)
  {
    $this->id_membre = $id;
    $pdo = Database::connect();
    $sql = "SELECT * from membres WHERE id_membre = :id_membre";
    $reponse = $pdo->prepare($sql);
    $this->id_membre = htmlspecialchars(strip_tags($this->id_membre));
    $reponse->bindParam(':id_membre', $this->id_membre);
    $reponse->execute();
    Database::disconnect();
    $result = $reponse->rowCount();
    if ($result == 0) return false;
    else return $reponse->fetch(PDO::FETCH_ASSOC);
  }

  // Création d'une fiche Stagiaire
  public function creer()
  {

    $pdo = Database::connect();
    $sql = "INSERT INTO membres(nom_membre, login_membre) VALUES (:nom_membre, :login_membre)";
    $reponse = $pdo->prepare($sql);

    $this->nom_membre = htmlspecialchars(strip_tags($this->nom_membre));
    $this->login_membre = htmlspecialchars(strip_tags($this->login_membre));

    $reponse->bindParam(':nom_membre',  $this->nom_membre);
    $reponse->bindParam(':login_membre', $this->login_membre);
    // Exécution de la requête
    if ($reponse->execute()) {
      return true;
    }
    Database::disconnect();
    return false;
  }


  // Modifier une fiche Stagiaire
  public function modifier()
  {

    $pdo = Database::connect();
    $sql = "UPDATE membres SET nom_membre = :nom_membre , login_membre = :login_membre WHERE id_membre = :id_membre";
    $reponse = $pdo->prepare($sql);

    // On sécurise les données
    $this->nom_membre = htmlspecialchars(strip_tags($this->nom_membre));
    $this->login_membre = htmlspecialchars(strip_tags($this->login_membre));
    $this->id_membre = htmlspecialchars(strip_tags($this->id_membre));

    // On attache les variables
    $reponse->bindParam(':nom_membre', $this->nom_membre);
    $reponse->bindParam(':login_membre', $this->login_membre);
    $reponse->bindParam(':id_membre', $this->id_membre);

    // Exécution de la requête
    if ($reponse->execute()) {
      return true;
    }
    Database::disconnect();
    return false;
  }


  // Supprimer une fiche Stagiaire
  public function supprimer()
  {

    $pdo = Database::connect();
    $sql = "DELETE FROM membres WHERE id_membre = :id_membre";
    $reponse = $pdo->prepare($sql);

    // On sécurise les données
    $this->id_membre = htmlspecialchars(strip_tags($this->id_membre));

    // On attache l'id_membre
    $reponse->bindParam(":id_membre", $this->id_membre);

    // On exécute la requête
    if ($reponse->execute()) {
      return true;
    }
    Database::disconnect();
    return false;
  }
}

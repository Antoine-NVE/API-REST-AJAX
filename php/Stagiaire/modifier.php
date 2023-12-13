<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// On vérifie la méthode
if($_SERVER['REQUEST_METHOD'] == 'PUT'){

    // On inclut les fichiers de connexion à la Bdd et d'accès aux données
    include_once '../Modeles/database.class.php';
    include_once '../Modeles/stagiaires.class.php';

    // On instancie un objet Stagiaire
    $stagiaire = new Stagiaire();

    // On récupère les informations envoyées
    $donnees = json_decode(file_get_contents("php://input"));
    
    if(!empty($donnees->nom_membre) && !empty($donnees->login_membre) && !empty($donnees->id_membre)){
        // Ici on a reçu les données
        // On hydrate notre objet
        $stagiaire->id_membre = $donnees->id_membre;
        $stagiaire->nom_membre = $donnees->nom_membre;
        $stagiaire->login_membre = $donnees->login_membre;
        
        if($stagiaire->modifier()){
            // Ici la modification a fonctionné
            // On envoie un code 200
            http_response_code(200);
            echo json_encode(["message" => "La modification a été effectuée"]);
        }else{
            // Ici la modification n'a pas fonctionné
            // On envoie un code 503
            http_response_code(503);
            echo json_encode(["message" => "La modification n'a pas été effectuée"]);         
        }
    }
}else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// On vérifie que la méthode utilisée est correcte
if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
    
     // On inclut les fichiers de connexion à la Bdd et d'accès aux données
     include_once '../Modeles/database.class.php';
     include_once '../Modeles/stagiaires.class.php';
 
     // On instancie un objet Stagiaire
     $stagiaire = new Stagiaire();

    // On récupère l'id_membre du Stagiaire
    $donnees = json_decode(file_get_contents("php://input"));

    if(!empty($donnees->id_membre)){

        $stagiaire->id_membre = $donnees->id_membre;

        if($stagiaire->supprimer()){
            // Ici la suppression a fonctionné
            // On envoie un code 200
            http_response_code(200);
            echo json_encode(["message" => "La suppression a été effectuée"]);
        }else{
            // Ici la suppression n'a pas fonctionné
            // On envoie un code 503
            http_response_code(503);
            echo json_encode(["message" => "La suppression n'a pas été effectuée"]);         
        }
    }
}else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// On vérifie que la méthode utilisée est correcte
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    // On inclut les fichiers de connexion à la Bdd et d'accès aux données
    include_once '../Modeles/database.class.php';
    include_once '../Modeles/stagiaires.class.php';

    // On instancie un objet Stagiaire
    $stagiaire = new Stagiaire();

   
    if(!empty($_GET["id_membre"])){ 
        
        $id_membre = $_GET["id_membre"];
        $stagiaire->id_membre = $id_membre;

        $stag = [];
        $stag = $stagiaire->lire_un_seul_stagiaire($stagiaire->id_membre);

        
        if(!$stag){
            // 404 Not found
            http_response_code(404);
            echo json_encode(array("message" => "Le Stagiaire n'existe pas."));

        }else{
            $monstag = [   
                "id_membre" => $stag["id_membre"],
                "nom_membre" => $stag["nom_membre"],
                "login_membre" => $stag["login_membre"]
            ];
    
             // On envoie le code réponse 200 OK
             http_response_code(200);
             // On encode en json et on envoie
             echo json_encode($monstag, JSON_UNESCAPED_UNICODE);

        }
  
    }else{

        // 404 Not found
        http_response_code(404);
        echo json_encode(array("message" => "Le Stagiaire n'existe pas."));

    }
  
}else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
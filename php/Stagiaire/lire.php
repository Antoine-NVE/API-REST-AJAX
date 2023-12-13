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
    // On récupère les données
    $stmt = $stagiaire->lire();

    // On vérifie si on a au moins 1 stagiaire
    if($stmt->rowCount() > 0){
        // On initialise un tableau
        $tableauStagiaires = [];
        
        // On parcourt les stagiaires
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            
            extract($row);

            $stag = [
                "id_membre" => $id_membre,
                "nom_membre" => $nom_membre,
                "login_membre" => $login_membre
                
            ];

            $tableauStagiaires[] = $stag;
        }

        // On envoie le code réponse 200 OK
        http_response_code(200);
        // On encode en json et on envoie
        echo json_encode($tableauStagiaires, JSON_UNESCAPED_UNICODE);
    }

}else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}

?>
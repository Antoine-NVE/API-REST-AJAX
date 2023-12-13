// Variables
const prenom = document.getElementById("prenom"); // Prénom membre
const messagePrenom = document.getElementById("message_prenom"); // Message d'erreur prénom
const nom = document.getElementById("nom"); // Nom membre
const messageNom = document.getElementById("message_nom"); // Message d'erreur nom
const ajouter = document.getElementById("ajouter"); // Bouton "Ajouter"
const annuler = document.getElementById("annuler");
const retour = document.getElementById("retour"); // Bouton "Retour"
let affichageErreurs = false; // Décide de si l'on affiche ou non les erreurs

// Fonction qui teste le prénom
function testPrenom() {
  if (prenom.value === "") {
    messagePrenom.innerHTML = "Veuillez saisir un prénom";
    return false;
  } else if (prenom.value.length < 3) {
    messagePrenom.innerHTML = "Veuillez saisir un prénom valide";
    return false;
  } else {
    messagePrenom.innerHTML = "";
    return true;
  }
}

// Fonction qui teste le nom
function testNom() {
  if (nom.value === "") {
    messageNom.innerHTML = "Veuillez saisir un nom";
    return false;
  } else if (nom.value.length < 3) {
    messageNom.innerHTML = "Veuillez saisir un nom valide";
    return false;
  } else {
    messageNom.innerHTML = "";
    return true;
  }
}

// Détecte l'input du prénom
prenom.addEventListener("input", () => {
  // Formate la value
  prenom.value =
    prenom.value.charAt(0).toUpperCase() +
    prenom.value.slice(1, prenom.value.length).toLowerCase();

  // Si les messages doivent être affichés, on teste le prénom
  if (affichageErreurs) {
    testPrenom();
  }
});

// Détecte l'input du nom
nom.addEventListener("input", () => {
  // Formate la value
  nom.value = nom.value.toUpperCase();

  // Si les messages doivent être affichés, on teste le nom
  if (affichageErreurs) {
    testNom();
  }
});

// Clic du bouton "Ajouter"
ajouter.addEventListener("click", (e) => {
  e.preventDefault();

  // S'il n'y a pas eu de retour d'erreurs
  if (testPrenom() && testNom()) {
    // On ajoute le membre
    fetch("./php/Stagiaire/creer.php", {
      method: "POST",
      headers: {
        "Content-type": "application/json; charset=UTF-8",
      },
      body: JSON.stringify({
        login_membre: prenom.value,
        nom_membre: nom.value,
      }),
    })
      .then(() => (window.location = "./index.html"))
      .catch((error) => alert("Erreur : " + error));
  }

  // Sinon
  else {
    // On teste
    testPrenom();
    testNom();

    // On affiche
    affichageErreurs = true;
  }
});

// Clic du bouton "Annuler"
annuler.addEventListener("click", () => {
  // Supprime les messages d'erreur
  messagePrenom.innerHTML = "";
  messageNom.innerHTML = "";
  affichageErreurs = false;
});

// Clic du bouton "Retour"
retour.addEventListener("click", (e) => {
  e.preventDefault();

  // On est renvoyé sur la page d'accueil
  window.location = "./index.html";
});

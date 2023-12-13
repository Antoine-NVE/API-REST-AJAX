// Variables
const tbody = document.getElementById("tbody"); // Body du tableau
const ajouter = document.getElementById("ajouter"); // Bouton "Ajouter un membre"

// Affiche le tableau de membres
fetch("./php/Stagiaire/lire.php")
  .then((response) => response.json())
  .then((response) => {
    response.forEach((element) => {
      tbody.innerHTML += `
        <tr>
          <td>${element.id_membre}</td>
          <td><a class="modifier" id="modifier${element.id_membre}">${element.login_membre}</a></td>
          <td>${element.nom_membre}</td>
          <td><a class="supprimer" id="supprimer${element.id_membre}">Supprimer</a></td>
        </tr>
      `;
    });

    // Variables
    const modifier = document.getElementsByClassName("modifier"); // Boutons "Modifier" (qui sont les prénoms)
    const supprimer = document.getElementsByClassName("supprimer"); // Boutons "Supprimer"

    // Gère le clic des boutons "modifier"
    for (i = 0; i < modifier.length; i++) {
      const modifierId = document.getElementById(modifier[i].id);
      modifierId.addEventListener("click", () => {
        // Envoie sur la page de modification
        window.location =
          "./update.html?id=" + modifierId.id.split("modifier")[1];
      });
    }

    // Gère le clic des boutons "supprimer"
    for (i = 0; i < supprimer.length; i++) {
      const supprimerId = document.getElementById(supprimer[i].id);
      supprimerId.addEventListener("click", () => {
        // Fenêtre de confirmation
        if (confirm("Supprimer ce membre ?")) {
          // Supprime le membre grâce à l'API
          fetch("./php/Stagiaire/supprimer.php", {
            method: "DELETE",
            headers: {
              "Content-type": "application/json; charset=UTF-8",
            },
            body: JSON.stringify({
              id_membre: supprimerId.id.split("supprimer")[1],
            }),
          })
            .then(() => (window.location = "index.html"))
            .catch((error) => alert("Erreur : " + error));
        }
      });
    }
  })

  .catch((error) => alert("Erreur : " + error));

// Redirige vers le formulaire d'insertion
ajouter.addEventListener("click", () => {
  window.location = "./insert.html";
});

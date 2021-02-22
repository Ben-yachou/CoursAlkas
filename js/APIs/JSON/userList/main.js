//récupération des données stockées dans notre fichier MOCK_DATA.json
const users = data;

//on attend que le Document soit entièrement chargé
document.addEventListener("DOMContentLoaded", () => {
    const userSearch = document.getElementById("userSearch");

    //a chaque caractère entré dans le champ de recherche
    userSearch.addEventListener("keyup", () => {
        //on récupère notre recherche qu'on transforme en minuscule pour faciliter la comparaison
        const searchTerm = userSearch.value.toLowerCase();
        //on met en place un tableau pour récupérer les résultats
        let searchResults = [];

        //pour chaque utilisateur
        users.forEach((user) => {
            //on récupère le nom complet en minuscule pour faciliter la comparaison
            const fullName = `${user.first_name} ${user.last_name}`.toLowerCase();

            //on vérifie que nos paramètres de recherches soient satisfaits
            if (fullName.includes(searchTerm)) {
                //si c'est le cas, on rajoute l'utilisateur dans notre tableau
                searchResults.push(user);
            }
        });
        //a la fin on affiche nos résultats
        displayUsers(searchResults);
    });

    displayUsers(users);
});

function displayUsers(userList) {
    const userContainer = document.getElementById("userContainer");
    //pour vider le userContainer on peut définir son innerHTML comme une chaine vide
    userContainer.innerHTML = "";
    //pour chaque user dans notre tableau de users
    userList.forEach((user) => {
        //création d'un élément div
        const userCard = document.createElement("div");
        //création d'un élément h2
        const userTitle = document.createElement("h2");
        //textContent permet de modifier le contenu textuel de l'élément
        userTitle.textContent = `${user.first_name} ${user.last_name}`;

        const userImage = document.createElement("img");
        userImage.src = user.avatar;
        userImage.alt = `${user.first_name}'s avatar`;

        //appendChild permet d'ajouter un élément dans un autre
        userCard.appendChild(userTitle);
        userCard.appendChild(userImage);
        //ici par exemple on ajoute notre userCard au body
        userContainer.appendChild(userCard);
    });
}

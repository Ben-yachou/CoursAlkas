document.addEventListener("DOMContentLoaded", () => {
    //handle form changes
    const filterContainer = document.getElementById("filters");
    const nationality = document.getElementById("nat");
    const maleBox = document.getElementById("male");
    const femaleBox = document.getElementById("female");

    filterContainer.addEventListener("change", () => {
        let parameter = "";

        if (maleBox.checked && !femaleBox.checked) {
            parameter += "&gender=male";
        }

        if (!maleBox.checked && femaleBox.checked) {
            parameter += "&gender=female";
        }
        if (
            (maleBox.checked && femaleBox.checked) ||
            (!maleBox.checked && !femaleBox.checked)
        ) {
            parameter = "";
        }
        parameter += "&nat=" + nationality.value;

        getUsers(parameter).then((data) => {
            //handle the data here
            displayUsers(data.results);

            //gestion du champ de recherche
            const userSearch = document.getElementById("search");
            // a chaque ecriture dans le champ
            userSearch.addEventListener("keyup", () => {
                //array.filter permet d'effectuer un tri sur les données d'un tableau, basé sur un prédicat sous la forme d'une fonction
                //ici on demande de ne garder, pour chaque user, que ceux dont le nom complet contient notre valeur de recherche
                let searchResults = data.results.filter((user) =>
                    `${user.name.first} ${user.name.last}`
                        .toLowerCase()
                        .includes(userSearch.value.toLowerCase())
                );

                displayUsers(searchResults);
            });
        });
    });

    //request to the api
    getUsers("").then((data) => {
        //handle the data here
        displayUsers(data.results);

        //gestion du champ de recherche
        const userSearch = document.getElementById("search");
        // a chaque ecriture dans le champ
        userSearch.addEventListener("keyup", () => {
            //array.filter permet d'effectuer un tri sur les données d'un tableau, basé sur un prédicat sous la forme d'une fonction
            //ici on demande de ne garder, pour chaque user, que ceux dont le nom complet contient notre valeur de recherche
            let searchResults = data.results.filter((user) =>
                `${user.name.first} ${user.name.last}`
                    .toLowerCase()
                    .includes(userSearch.value.toLowerCase())
            );

            displayUsers(searchResults);
        });
    });
});

function displayUsers(users) {
    const userContainer = document.getElementById("users");
    userContainer.innerHTML = "";
    users.forEach((user) => {
        const userContainer = document.getElementById("users");

        const userDiv = document.createElement("div");
        userDiv.textContent = `${user.name.first} ${user.name.last} ${user.nat} ${user.gender}`;
        userContainer.appendChild(userDiv);
    });
}

function getUsers(parameters) {
    return fetch("https://randomuser.me/api/?results=20" + parameters).then(
        (response) => {
            return response.json();
        }
    );
}

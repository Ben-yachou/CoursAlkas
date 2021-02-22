function additionnerPairs(listeNombres) { //DEBUT
    let resultat = 0;
    let i = 0;
    while (i < listeNombres.length) { //TANTQUE
        let nombre = listeNombres[i];
        if (nombre % 2 == 0) { //SI
            resultat = resultat + nombre;
        } //FINSI
        i = i + 1;
    } //FINTANTQUE
    return resultat;
} //FIN

let liste = [1, 9, 4, 1, 5, 4, 3, 6, 9, 10];
console.log(liste);
console.log(additionnerPairs(liste));
window.alert(additionnerPairs(liste));
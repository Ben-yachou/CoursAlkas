//la boucle while permet de préciser une condition d'exécution 
//sous la forme d'une condition booléenne
//et répétera du code tant que cette condition est vraie
let i = 1;
while ( i <= 100) {
    console.log("Tour de while ", i);
    i++; //i = i+1;
}   

//la boucle for permet d'effectuer une itération
//on précise les bornes inférieures et supérieures de notre boucle
//ainsi que le pas avec lequel nous allons faire progresser l'itération
//comme pour le while, le traitement a l'intérieur s'exécute 
//jusqu'a ce que la condition soit invalidée
// for (declaration du compteur; condition ; incrementation) {}
for (let i = 1; i <= 100; i++){
    if (i%2 === 0){
        console.log(i, "pair");
    } else {
        console.log(i, "impair");
    }
}
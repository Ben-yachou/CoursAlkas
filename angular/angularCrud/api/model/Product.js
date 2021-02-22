//ici on crée le schéma (l'entité) de notre classe Produit
//qui nous servira a stocker nos Produits dans notre bdd

//on récupère mongoose
const mongoose = require('mongoose');
//puis on récupère ce qui va nous servir à faire notre entité
const Schema = mongoose.Schema;

//On définit notre entité et ses propriétés

let Product = new Schema({
    //on définit les propriétés
    productName: {
        type: String
    },
    productDescription: {
        type: String
    },
    productPrice: {
        type: Number
    }
}, {
    collection: 'Product' 
    //on définit le nom de l'entité au niveau de mongo
});

//on va rendre disponible notre entité dans notre application
//pour pouvoir l'utiliser dans notre serveur
module.exports = mongoose.model('Product', Product);
//on demande a mongoose de génerer un Modèle nommé Product
//a partir de notre variable Product définie ici
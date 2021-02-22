//IMPORTATION DES MODULES NODES
//on charge express qui va nous servir a gérer le serveur d'api
const express = require('express');
//on charge bodyParser qui permettra la lecture des corps de requête HTTP
const bodyParser = require('body-parser');
//cors permettra l'utilisation de requêtes sur des ports différents
const cors = require('cors');
//mongoose est l'ORM permettant de gérer mongodb
const mongoose = require('mongoose');
//permet de gérer les chemins/dossiers du serveur
const path = require('path');

//on récupère nos routes Express
const productRoutes = require('./routes/product.route');
//on appelle express pour génerer notre application de serveur
const app = express();
app.use(bodyParser.json()); //on indique a express d'utiliser le module bodyParser
app.use(cors()); //on indique a express d'utiliser les en tête CORS
app.use('/products', productRoutes); //on indique à express d'utiliser nos routes
                                    //et de placer la racine de l'api sur /products
//on prépare le port de comunication de notre serveur
let port = 4000; 

//on met en place l'ORM mongoose pour lui permettre de se connecter à mongodb
const dbConfig = require('./db');
mongoose.Promise = global.Promise;
//on lance la connexion a mongodb via mongoose
//et on dicte les instructions à exécuter en cas de succès ou d'erreur
//useNewUrlParser:true est une option du connecteur mongodb
//permettant d'utiliser la dernière technologie de connexion en date
mongoose.connect(dbConfig.DB, {useNewUrlParser: true}).then(
    //si tout se passe bien
    () => { console.log('Database connected'); },
    //en cas d'erreur
    err => { console.error(`Database error ${err}`);}
);


//on met en place notre serveur en faisant écouter express sur le port 4000
const server = app.listen(port, () => {
    console.log(`Server started on port ${port}`);
});
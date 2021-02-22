//ici on définit quelles seront les routes sur lesquelles
//notre serveur servira des données

//on récupère express
const express = require("express");
//on initialise express
const app = express();
//on récupère le Routeur contenu dans express
const productRoutes = express.Router();

//On récupère le model Product
let Product = require("../model/Product");

//on définit nos routes
//en premier, la route http GET renvoyant tous les produits
//en cas de récéption d'une requête HTTP GET sur /
productRoutes.route("/").get((req, res) => {
  //on exécute une fonction avec comme paramètres
  //la requête HTTP reçue, et la réponse que le serveur renverra
  //dans cette fonction on demande à récupérer les Products en bdd
  //Product.find() renvoie tous les objets de type Product contenus dans la base
  Product.find((err, products) => {
    //en cas d'erreur
    if (err) {
      console.error(`Error retrieving products : ${err}`);
    }
    //si on a bien reçu les products depuis la bdd
    else {
      //on renvoie une réponse à la requête HTTP sous forme de json
      res.json(products);
    }
  });
});

//on crée une route permettant l'ajout de données
//la requête est donc une requête HTTP POST
productRoutes.route("/add").post((req, res) => {
  //en cas de requete post sur /add
  //on récupère le contenu de la requête POST pour créer notre product
  let product = new Product(req.body);
  //ensuite on enregistre le produit nouvellement créé dans la bdd
  product
    .save()
    .then(
      //then définit l'action si tout se passe bien
      //si tout se passe bien on envoie une réponse OK 200 avec le product ajouté
      product => {
        res.status(200).send(product);
      }
    )
    .catch(
      //catch définit l'action si une erreur est survenue
      err => {
        //si une erreur est survenue on envoie une réponse erreur 400 avec un message
        //contenant l'erreur
        res.status(400).send(`Unable to save to database : ${err}`);
      }
    );
});

productRoutes.route("/edit/:id").get((req, res) => {
  //on récupère l'id du product à récup
  let id = req.params.id;
  //on cherche le product en bdd
  Product.findById(id, (err, product) => {
    //si une erreur survient
    if (err) {
      //on envoie un message d'erreur en console
      console.error(`Product ${id} not found : ${err}`);
      //et on envoie une reponse 404 (not found)
      res.status(404).send(`Product ${id} not found : ${err}`);
    } else {
      //sinon on envoie le produit
      res.status(200).send(product);
    }
  });
});

productRoutes.route("/update/:id").put((req, res) => {
  let id = req.params.id;
  Product.findById(id, (err, product) => {
    //si une erreur survient
    if (err) {
      //on envoie un message d'erreur en console
      console.error(`Product ${id} not found : ${err}`);
      //et on envoie une reponse 404 (not found)
      res.status(404).send(`Product ${id} not found : ${err}`);
    } else {
      //on applique les changements à l'objet product
      product.productName = req.body.productName;
      product.productDescription = req.body.productDescription;
      product.productPrice = req.body.productPrice;
      //on sauvegarde les changements dans la bdd
      product
        .save()
        .then(
          //then définit l'action si tout se passe bien
          //si tout se passe bien on envoie une réponse OK 200 avec le product ajouté
          product => {
            res.status(200).send(product);
          }
        )
        .catch(
          //catch définit l'action si une erreur est survenue
          err => {
            //si une erreur est survenue on envoie une réponse erreur 400 avec un message
            //contenant l'erreur
            res.status(400).send(`Unable to save to database : ${err}`);
          }
        );
    }
  });
});

productRoutes.route('/delete/:id').delete((req, res) => {
  let id = req.params.id;
  Product.findByIdAndRemove(id, (err, product) => {
    if (err) {
      res.status(400).send(`Error removing product ${id} : ${err}`);
    } else {
      //on renvoie un message d'erreur sous forme de json
      res.status(200).json({message: `Product ${id} successfully removed`});
    }
  });
});



//on rend disponible nos routes aux autres modules du serveur
module.exports = productRoutes;
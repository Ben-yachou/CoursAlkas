<?php
include('includes/bdd.php');
//on vérifie que notre formulaire ait bien été rempli
if (
    isset($_POST['username']) &&
    isset($_POST['email']) &&
    isset($_POST['password']) &&
    isset($_POST['password_repeat'])
) {
    //si le mot de passe est assez long
    if (mb_strlen($_POST['password']) > 7) {
        //on vérifie que la confirmation de mot de passe soit correcte
        if ($_POST['password'] == $_POST['password_repeat']) {
            //on vérifie que l'email envoyé soit bien au format email
            //filter_var permet de valider le format d'une chaine de caractères
            //ici on utilise le filtre FILTER_VALIDATE_EMAIL pour vérifier que la chaine soit au format email
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $error = "Vous devez utiliser une adresse mail valide";
            } else {
                //on récupère nos données et on les stocke dans des variables
                $username = $_POST['username'];
                $email = $_POST['email'];
                //on hache le mot de passe à l'aide de la fonction password_hash() de PHP
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

                $pdo = bddConnect();
                $resultat = createUser($pdo, $username, $email, $password, time());
                if ($resultat == -1){ // la fonction createUser() renvoie -1 en cas de duplicata
                    $error = "Un utilisateur existe déjà avec ce pseud ou email";
                } elseif ($resultat == 0){
                    die('Erreur base de données');
                }
            }
        } else {
            $error = "Les mots de passes doivent être identiques";
        }
    } else {
        $error = "Erreur, mot de passe trop court, 8 caractères minimum";
    }
} else {
    $error = "Erreur, formulaire incomplet.";
}

if (isset($error)) {
    //si une erreur existe alors on renvoie sur la page d'inscription
    //avec un message d'erreur
    header('Location: signUp.php?error=' . $error);
} else {
    //sinon on envoie l'utilisateur vers le formulaire de connexion
    header('Location: signIn.php');
}

<!--Un formulaire en html se définit a l'aide de la balise form -->
<!-- on peut définir la cible d'un formulaire et son type de requête -->
<!-- en précisant method="post" on indique la volonté d'utiliser une requête
http POST, donc qui a pour but d'envoyer des données -->
<!-- action="page.php" permet de définir quel script sera appelé
pour effectuer le traitement du formulaire 
si aucune cible n'est définie dans action alors la page se recharge
et la cible est la page actuelle -->
<form method="post" action="resultat.php">

    <!-- un champ input définit un champ d'entrée de données dans le formulaire
l'id est juste l'id de l'élément, le name est le nom du champ dans le formulaire
et le type est le type de données entrante -->

    <!-- label définit une étiquette pour un champ input, en désignant
un id de champ à l'aide de "for" on indique a quel champ cette étiquette 
est attachée -->
    <label for="pseudo"> Pseudo </label>
    <input id="pseudo" name="pseudo" type="text">

    <!-- textarea définit une zone de texte -->
    <textarea name="message">
</textarea>

    <!-- select définit une liste déroulante -->
    <select name="liste">
        <!-- chaque option de cette liste est définie par une balise option -->
        <!-- entre les balises option /option se trouvent le texte affiché dans la liste
et la valeur de cette option se trouve dans un attribut value 
c'est la valeur de l'attribut value qui est envoyée via le formulaire-->
        <option value="option1"> Fraise </option>
        <option value="option2"> Banane</option>
        <option value="option3"> Poire</option>
        <option value="option4"> Pomme</option>
        <option value="option5"> Ananas</option>
    </select>

    <!-- un input de type checkbox définit une case à cocher -->
    <!-- la case a cocher enverra si elle est cochée ou pas au moment
    de l'envoi du formulaire -->
    <p>

    <label for="check">Cochez</label>
    <input type="checkbox" name="check" id="check">
</p>
    <!-- un input de type radio définit un groupe de boutons radio -->
    <!-- on donne le même le nom aux différents input radio 
    faisant partie du même groupe -->
    <p>
    <label for="oui"> Oui </label>
    <input type="radio" name="choix" value="oui">
    <label for="non"> Non </label>
    <input type="radio" name="choix" value="non">
    <label for="pe"> Peut-être </label>
    <!-- pour cocher une case par défaut on rajoute l'attribut checked -->
    <input type="radio" name="choix" value="pe" checked="checked">
</p>
    <!-- input file permet d'envoyer des fichiers depuis le client -->
    <input type="file" name="photo">
    <!-- input de type submit permet de valider et envoyer le formulaire -->
    <!-- sa value est le texte qui s'affiche sur le bouton d'envoi -->
    <input type="submit" value="Envoyer">
</form>
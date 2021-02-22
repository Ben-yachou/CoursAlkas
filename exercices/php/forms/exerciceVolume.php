<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <title>Calcul</title>
</head>

<body>
    <form action="resultatCalcul.php" method="POST">
        <label for="rayon">Rayon de la base du cone</label>
        <input type="number" name="rayon">
        <label for="hauteur">Hauteur de l'arrête du cone</label>
        <input type="number" name="hauteur">

        <label for="arrondir">Arrondir</label>
        <input type="checkbox" name="arrondir">

        <input type="submit" value="Calculer">
    </form>
</body>

</html>
<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <title>Calcul</title>
</head>

<body>
    <form action="resultatCalculatrice.php" method="POST">
        <input type="number" name="op1">

        <select name="calcul">
            <option value="mul">×</option>
            <option value="div">÷</option>
            <option value="add">+</option>
            <option value="sous">-</option>
        </select>

        <input type="number" name="op2">

        <input type="submit" value="Calculer">
    </form>
</body>

</html>
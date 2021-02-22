<?php
include("appart.php");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Filtre apparts</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
</head>

<body>
    <h1>Coucou mes apparts</h1>
    <form action="" method="post">
        <label for="min_rent">
            Loyer Minimum
        </label>
        <input type="number" id="min_rent" name="min_rent">
        <label for="max_rent">
            Loyer Maximum
        </label>
        <input type="number" id="max_rent" name="max_rent">

        <label for="min_surface">
            Surface Minimale
        </label>
        <input type="number" id="min_surface" name="min_surface">
        <label for="max_surface">
            Surface Maximale
        </label>
        <input type="number" id="max_surface" name="max_surface">

        <label for="city">
            Ville
        </label>
        <input type="text" id="city" name="city">
        <label for="zipcode">
            Code Postal
        </label>
        <input type="text" id="zipcode" name="zipcode">

        Nb Pièces :
        <label for="room_1">1</label>
        <input type="checkbox" name="room_1" id="room_1">
        <label for="room_2">2</label>
        <input type="checkbox" name="room_2" id="room_2">
        <label for="room_3">3</label>
        <input type="checkbox" name="room_3" id="room_3">
        <label for="room_4">4</label>
        <input type="checkbox" name="room_4" id="room_4">
        <label for="room_5">5</label>
        <input type="checkbox" name="room_5" id="room_5">
        <label for="room_6">6</label>
        <input type="checkbox" name="room_6" id="room_6">
        <label for="room_7">7</label>
        <input type="checkbox" name="room_7" id="room_7">
        <label for="room_8">8</label>
        <input type="checkbox" name="room_8" id="room_8">
        <label for="room_9">9</label>
        <input type="checkbox" name="room_9" id="room_9">
        <label for="room_10">10</label>
        <input type="checkbox" name="room_10" id="room_10">

        <select name="orderby" id="orderby">
            <option value="rent">rent</option>
            <option value="surface">surface</option>
            <option value="rooms">rooms</option>
            <option value="city">city</option>
            <option value="address">address</option>
            <option value="zip">zip</option>
        </select>
        <input type="submit" value="Rechercher">
    </form>

    <?php
    if (isset($data)) {
        foreach ($data as $row) {
            echo sprintf("
            <div> 
                <p>
                    Loyer : %s
                </p>
                <p>
                    Surface : %s
                </p>
                <p>
                    Nombre de pièces : %s
                </p>
                <p>
                    Adresse : %s
                </p>
                <p>
                    Code Postal : %s
                </p>
                <hr>
            </div>
            ", $row['rent'], $row['surface'], $row['rooms'], $row['address'], $row['zip']);
        }
    }
    ?>
</body>

</html>
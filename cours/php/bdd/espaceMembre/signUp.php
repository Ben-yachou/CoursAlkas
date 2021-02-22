<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Inscription</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>

</head>

<body>
    <form action="signUp_process.php" method="post">
        <label for="username">
            Username
            <input type="text" name="username" id="username" required>
        </label>
        <label for="email">
            E-Mail
            <input type="email" name="email" id="email" required>
        </label>

        <label for="password">
            Password
            <input type="password" name="password" id="password" required>
        </label>

        <label for="password_repeat">
            Repeat password
            <input type="password" name="password_repeat" id ="password_repeat" required>
        </label>
        <input type="submit" value="Sign Up">
    </form>
    <?php
        if (isset($_GET['error'])){
            echo $_GET['error'];
        }
    ?>
</body>

</html>
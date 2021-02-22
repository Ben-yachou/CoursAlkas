<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Connexion</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>

</head>
<body>
    <form action="signIn_process.php" method="post">
        <label for="user">
           Username or Email
            <input type="text" name="user" id="user" required>
        </label>

        <label for="password">
            Password
            <input type="password" name="password" id ="password" required>
        </label>
        <input type="submit" value="Sign In">
    </form>
</body>

</html>
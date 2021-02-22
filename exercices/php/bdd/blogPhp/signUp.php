<?php
include('includes/bdd.php');
include('includes/head.php');
?>
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
        <input type="password" name="password_repeat" id="password_repeat" required>
    </label>
    <input type="submit" value="Sign Up">
    <?php
        if (isset($_GET['error'])){
            echo $_GET['error'];
        }
    ?>
</form>
<?php
include('includes/foot.php');
?>
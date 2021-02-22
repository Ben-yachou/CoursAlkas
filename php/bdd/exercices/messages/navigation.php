<nav>
    <ul>
        <?php
        if (isset($_SESSION['userid'])) {
        ?>
            <li><a href="index.php">envoyer message</a></li>
            <li><a href="signout.php">deconnexion</a></li>
        <?php
        } else {
        ?>
            <li><a href="signup_form.php">inscription</a></li>
            <li><a href="signin_form.php">connexion</a></li>
        <?php
        }
        ?>
    </ul>
</nav>
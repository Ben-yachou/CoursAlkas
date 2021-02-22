<?php
include('includes/head.php');
?>

<body>
    <form action="signIn_process.php" method="post">
        <label for="user">
            Username or Email
            <input type="text" name="user" id="user" required>
        </label>

        <label for="password">
            Password
            <input type="password" name="password" id="password" required>
        </label>
        <input type="submit" value="Sign In">
    </form>
</body>

<?php
if (isset($_GET['error'])){
    echo $_GET['error'];
}
include('includes/foot.php');
?>
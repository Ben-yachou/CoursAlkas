<?php
$pageTitle = 'Ecrire Article';
include('includes/head.php');
?>
<form action="articlePost.php" method="POST">
    <label for="title">
        Titre
        <input type="text" name="title">
    </label>
    <label for="content">
        Content
        <textarea name="content"></textarea>
    </label>
    <input type="submit" value="Poster">
</form>

<?php
include('includes/foot.php');
?>
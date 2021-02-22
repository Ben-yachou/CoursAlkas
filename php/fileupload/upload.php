<?php
var_dump($_FILES);

$upload_dir = "./uploads/";
$file_extension = pathinfo($_FILES['userfile']['name'])['extension'];
$file_name = md5(uniqid(rand()) . $_FILES['userfile']['name']);
move_uploaded_file($_FILES['userfile']['tmp_name'], $upload_dir . $file_name . "." .  $file_extension);

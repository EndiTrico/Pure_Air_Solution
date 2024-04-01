<?php 

$password = "krenari";

$hash = password_hash($password, PASSWORD_BCRYPT);

echo $hash;
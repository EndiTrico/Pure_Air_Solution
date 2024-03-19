<?php 

$password = "endi";

$hash = password_hash($password, PASSWORD_BCRYPT);

echo $hash;
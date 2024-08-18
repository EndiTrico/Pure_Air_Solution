<?php
  $conn = mysqli_connect($servername, $username, $password, $dbname) or die ("Error connecting to mysql!");
	mysqli_select_db($conn, $dbname) or die ("The database does not exist!");


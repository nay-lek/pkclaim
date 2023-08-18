<?php
	$hostname = "localhost";
	$username = "sa";
	$password = "sa";
	$dbname = "hos";
	

	//$dbname = "hos";
	//$port = "3306";
	//$Conn = mysql_connect($hostname,$username,$password) or die("Can't conncet database");
				//mysql_select_db($dbname,$Conn) or die("Can't connect table");




					try {
						$conn = new mysqli($hostname, $username, $password, $dbname);
						$conn->set_charset("utf8");
					}catch (Exception $e){
						$error = $e->getMessage();
						echo $error;
					}

//==


				//mysql_query("SET NAMES UTF8");





?>
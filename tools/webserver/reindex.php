<?php

require("dbconnect.php");
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
}

$ins='SET @a = 0;';
if (    !$db->query($ins))
	{
		echo "nok";
	}
else{
	echo "ok";
	}

$ins='UPDATE address SET addressID = (@a := @a +1);';
if (    !$db->query($ins))
	{
		echo "nok";
	}
else{
	echo "ok";
	}

$ins='ALTER TABLE address  AUTO_INCREMENT = 1;';
if (    !$db->query($ins))
	{
		echo "nok";
	}
else{
	echo "ok";
	}

$ins='SET @a = 0;';
if (    !$db->query($ins))
	{
		echo "nok";
	}
else{
	echo "ok";
	}


$ins='UPDATE calllist SET ID = (@a := @a +1);';
if (    !$db->query($ins))
	{
		echo "nok";
	}
else{
	echo "ok";
	}

$ins='ALTER TABLE calllist AUTO_INCREMENT = 1;';
if (    !$db->query($ins))
	{
		echo "nok";
	}
else{
	echo "ok";
	}

require("dbdisconnect.php");
header ('location:index.html');
?>
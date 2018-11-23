<?php
/** Input one Number to address without Company, name or other stuff.
*/
require("dbconnect.php");
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
}

$ins='update address set '.$_GET["ptype"].'=\''.urlencode($_GET["number"]).'\' where addressID='.$_GET["addressID"];

if (    !$db->query($ins))
	{
		echo "nok";
	}
else{
	echo "ok";
	}
require("dbdisconnect.php");

?>
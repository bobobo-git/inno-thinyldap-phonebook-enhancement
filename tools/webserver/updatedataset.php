<?php
/** Input one Number to address without Company, name or other stuff.
*/
require("dbconnect.php");
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
}

/*
http://192.168.1.52:8080/updatedataset.php?ptype=home"&number=+463321321&addressID=17

update address set home=+463321321 where addressID=17 


$_GET["ptype"]=home&$_GET["number"]=+491622123321&$_GET["company"]=hubert%20müller&$_GET["lastname"]=asdasd&$_GET["firstname"]=eerrr
*/

$ins='update address set '.$_GET["ptype"].'=\''.urlencode($_GET["number"]).'\' where addressID='.$_GET["addressID"];

//values ('+491622123321'.'emil'.'hugo'.'franz');

if (    !$db->query($ins))
	{
		echo "nok";
	}
else{
	echo "ok";
	}
require("dbdisconnect.php");

?>
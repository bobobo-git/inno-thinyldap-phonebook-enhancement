<?php
/** Input one Number to address without Company, name or other stuff.
*/
require("dbconnect.php");
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
}

/*
$_GET["ptype"]=home&$_GET["number"]=+491622123321&$_GET["company"]=hubert%20müller&$_GET["lastname"]=asdasd&$_GET["firstname"]=eerrr
*/


$ins='insert into calllist (timestamp,extension,caller)
      Values(\''.urlencode($_GET["ts"]).'\',\''
                .urlencode($_GET["ext"])
				.'\',\''.urlencode($_GET["no"]).'\');';
//values ('+491622123321'.'emil'.'hugo'.'franz');
//echo $ins;
if (    !$db->query($ins))
	{
		echo "nok";
		echo " ". $ins;
	}
else{
	echo "ok";
	}
require("dbdisconnect.php");

?>
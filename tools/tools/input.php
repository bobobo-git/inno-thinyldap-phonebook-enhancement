<?php
/** Input one Number to address without Company, name or other stuff.
*/
require("dbconnect.php");

$ins='insert into address ('.$_GET["nt"].') values(\''.urlencode($_GET["no"]).'\');';
//echo ins;
//echo '<br>hier beachen dass ein + Zeichen in einLeerzeichen konvertiert wird (RFC 3986)<br>deshalb urlencode für die Nummer;';


if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
}
//echo 'connected';

if (    !$db->query($ins)) {
//    echo "Table insertion failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
else{
require("dbdisconnect.php");
	header("Location: editor.php?username=addressmaster&select=address&where%5B0%5D%5Bcol%5D=company&where%5B0%5D%5Bop%5D=&where%5B0%5D%5Bval%5D=&where%5B01%5D%5Bcol%5D=&where%5B01%5D%5Bop%5D=&where%5B01%5D%5Bval%5D=&order%5B1%5D=company&limit=50);");	
};
?>
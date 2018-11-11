<?php
/** Input one Number to address without Company, name or other stuff.
*/


$ins='insert into address ('.$_GET["nt"].') values(\''.urlencode($_GET["no"]).'\');';
//echo ins;
//echo '<br>hier beachen dass ein + Zeichen in einLeerzeichen konvertiert wird (RFC 3986)<br>deshalb urlencode für die Nummer;';

$mysqli = new mysqli("127.0.0.1", "addressmaster", "", "phonebook_innovaphone");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
//echo 'connected';

if (    !$mysqli->query($ins)) {
//    echo "Table insertion failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
else{
	header("Location: editor.php?username=addressmaster&select=address&where%5B0%5D%5Bcol%5D=company&where%5B0%5D%5Bop%5D=&where%5B0%5D%5Bval%5D=&where%5B01%5D%5Bcol%5D=&where%5B01%5D%5Bop%5D=&where%5B01%5D%5Bval%5D=&order%5B1%5D=company&limit=50);");	
};
?>
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

$company=$_GET["company"];
$lastname=$_GET["lastname"];
$firstname=$_GET["firstname"];
$showlast=$_GET["showlast"];
echo $showlast;
//echo "auaha";
//echo $company;
//echo '<br>';
//echo $lastname;
//echo '<br>';
//echo $firstname;
//echo '<br>';
if ($showlast==1){
	$ins='insert into address ('.$_GET["ptype"].') values (\''.$_GET["number"].'\');';
}else{
	$ins='insert into address ('.$_GET["ptype"].',company,lastname,firstname) values (\''.urlencode($_GET["number"]).'\',\''.urlencode($_GET["company"]).'\',\''.urlencode($_GET["lastname"]).'\',\''.urlencode($_GET["firstname"]).'\');';

}
//values ('+491622123321'.'emil'.'hugo'.'franz');
//echo $ins;
if (!$db->query($ins)){
	echo "nok";
	echo " ". $ins;
}else{
	if ($showlast==1){
	$queryi="Select max(addressid) as 'c' from address;";
	echo $queryi;
	if($resultm = $db->query($queryi)){
		if($resultm->num_rows) {
			while($row = mysqli_fetch_object($resultm)){
				echo $row->c;
				$hh="http://192.168.1.52:8080/editor.php?username=addresseditor&edit=address&where%5BaddressId%5D=".$row->c;
				echo $hh;
				header('Location: '.$hh.'');
			}
		}
	}

}

	echo "ok";
}
require("dbdisconnect.php");

?>
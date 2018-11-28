<?php

$no = urlencode($_GET['no']);
require("dbconnect.php");

if($db->connect_errno) {
    die('error');
}
$query="select addressid,company,firstname,lastname,phone,mobile,home from phonebook_innovaphone.address;";
if($result = $db->query($query)){
    if($result->num_rows) {
        while($row = mysqli_fetch_object($result)){
			echo 'Insert into address (addressid,company,firstname,lastname,phone,mobile,home) values (\'';
          echo $row->addressid.'\',\'';
		  echo str_replace("'","''",$row->company).'\',\'';
		  echo str_replace("'","''",$row->firstname).'\',\'';
		  echo str_replace("'","''",$row->lastname).'\',\'';
		  echo str_replace("'","''",$row->phone).'\',\'';
		  echo str_replace("'","''",$row->mobile).'\',\'';
		  echo str_replace("'","''",$row->home).'\'';
		  echo ');'."\n";
        }
    }
}
$result->close();
require("dbdisconnect.php");
?>

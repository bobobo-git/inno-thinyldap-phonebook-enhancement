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
		  echo $row->company.'\',\'';
		  echo $row->firstname.'\',\'';
		  echo $row->lastname.'\',\'';
		  echo $row->phone.'\',\'';
		  echo $row->mobile.'\',\'';
		  echo $row->home.'\'';
		  echo ');'."\n";
        }
    }
}
$result->close();
require("dbdisconnect.php");
?>

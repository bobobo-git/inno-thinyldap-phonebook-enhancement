<?php

$no = urlencode($_GET['no']);
require("dbconnect.php");

if($db->connect_errno) {
    die('error');
}
$query="select count(*) as 'c' from phonebook_innovaphone.address where '".$no."' in (phone,mobile,home);";
if($result = $db->query($query)){
    if($result->num_rows) {
        $rows = $result->fetch_object()->c  ;
        //$count=print_r($rows);
		$count= $rows;
    }
}
if ($count==0){
	header("location: input.php?nt=phone&no=".$no);
	echo "neuer eitrag";
}else{
	echo "schon da";
}
require("dbdisconnect.php");
?>

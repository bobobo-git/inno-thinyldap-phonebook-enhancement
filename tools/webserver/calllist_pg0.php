<!DOCTYPE html>
<html lang="de" dir="ltr">  <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="robots" content="noindex">

    <meta name="generator"
    content="HTML Tidy for HTML5 (experimental) for Windows https://github.com/w3c/tidy-html5/tree/c63cc39" />
    <title>Call Liste</title>

    <STYLE>
<?php
require ('defs.php');	

//if (ini_set("memory_limit",-1)=="false"){
//	echo "nö";
//	exit;
//}
echo "
body {
	background: #F4FFF4;
	font-family: sans-serif;
	font-size:14px;
}
";


 ?>
</STYLE> 

  </head>
  
  <body>

  <div class="inh">
<?php
/*
mysql anbindung
*/
//require("dbconnect.php");
//if ($db->connect_errno) {
//    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
//}
/*
pg anbindung
*/
$host = '127.0.0.1';
$port = '5432';
$database = 'innovaphone-reporting';
$user = 'postgres';
$password = 'postgres';



$connectString = 'host='.$host.' port='.$port.' dbname='.$database.' user='.$user.' password='. $password;

$link = pg_connect ($connectString);
if (!$link){
	die('Error: Could not connect: ' . pg_last_error());
}
if (!isset($_POST["t"])) $_POST["t"]=0;
//$query = 'select cp.cdrp_call_flow , c.local_stamp from cdr_properties cp, cdrs c where cp.cdr_id=c.id and date(c.local_stamp)=date(current_date)-'.$_POST["t"].' order by c.local_stamp desc , cdr_id desc';
$query = 'select cp.cdrp_call_flow , c.local_stamp from cdr_properties cp, cdrs c where cp.cdr_id=c.id  and date(c.local_stamp)>=date(current_date)-33 order by c.local_stamp desc , cdr_id desc';


$result = pg_query($query);

$i = 0;
if ($_POST["t"]==0){
	// nur für Auswahl heute Seitenrefresh
echo '<script language=javascript>
 Timer=setTimeout("location.reload();", 60000);
</script>';
}
echo '<body>';


echo '<p><a href="index.html">zur Übersicht</a>';
if ($_POST["t"]==0){
	echo '<small style="padding-left:50px;">refresh alle 60 Sekunden</small>';
}
echo '<p>';
//echo $_POST['t'];
if ($_POST['t']==0) {}
echo '<form action="calllist_pg0.php" method="POST">';
      
echo'
    <button type="submit" >Abfragen</button>';
	//<button type="reset">Abbrechen</button>
echo '</form>';

//{{to,21,vertrieb,Vertrieb},{setup-to,0073217948,,Dirr Barbara Ostertag GmbH },{scf,24,michael.palz,},{alert-from,0073217948,,Dirr Barbara Ostertag GmbH },{conn-from,0073217948,,Dirr Barbara Ostertag GmbH },{disc-to,,,},{rel-from,0073217948,,}}
echo '<table>';
echo '<tr><th>Wann</th><th>intern</th><th></th><th>extern</th><th>name</th></tr>';


while ($row = pg_fetch_row($result)) 
{
	
	$count = count($row);
	//echo $count."count";
	$y = 0;
	while ($y < $count)
	{
		//echo "<br>".$y;
		$c_row = current($row);
		//echo $c_row."<br>";
		if ($y==0){
			$line=split(',',$c_row);
		
			if ($line[0]=='{{from'){
				$dir='<span style="color:red"> → </span>';
			}elseif($line[0]=='{{to'){
				$dir='<span style="color:green"> ← </span>';
			}

			$nummer=$line[5];
			if (substr($nummer,0,3)=="000")	{
				$nummer="+".substr($nummer,3);
			}
			elseif (substr($nummer,0,2)=="00"){
				$nummer="+49".substr($nummer,2);
			}elseif (substr($nummer,0,1)=="0"){
				$nummer="+49731".substr($nummer,1);
			}
$iname=str_Replace('}','',$line[3]);
$oname=str_Replace('}','',$line[7]);

			//echo " ". str_Replace('}','',$line[3]).$dir.$nummer.' '.$line[6]." ".str_replace('}','',$line[7]);
		}
		if ($y==1){
			$wann=$c_row;
		}
		next($row);
		$y = $y + 1;
	}
	if (strlen($line[5])>3){
		$out.= "<tr><td>$wann</td><td>$iname</td><td>$dir</td><td>$nummer</td><td>$oname</td></tr>";
	}
	//echo "<br>";
	$i = $i + 1;
}
pg_free_result($result);
$out.= '</table>';
echo $out;
ob_flush();
flush();

//echo '</table>';
echo $default;
/*Datenbank abhÃ¤ngen*/

//require("dbdisconnect.php");
//echo ini_get ("memory_limit");

?>
</div>

</body>
</html>

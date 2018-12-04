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
}";
/*
table,th,td{
	border: solid #ccc;
	border-width: thin;
	
	border-collapse: collapse;
	
}

";
*/

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
//$query = "select cp.cdrp_call_flow , ' dura:',cp.alert_duration,' durc:',cp.conn_duration,' ts:',c.local_stamp from cdr_properties cp, cdrs c where cp.cdr_id=c.id and date(c.local_stamp)=date(current_date)-".$_POST["t"]." order by local_stamp , cdr_id";
$query="SELECT c.cn, c.cdr_e164, c.cdr_h323, c.cdr_dir, cp.cdrp_call_flow, cp.alert_duration, cp.conn_duration, c.local_stamp FROM cdrs c, cdr_properties cp WHERE (c.id = cp.cdr_id) and date(c.local_stamp)=date(current_date)-".$_POST["t"]."ORDER BY c.local_stamp DESC;";
//echo $query;

$result = pg_query($query);

$i = 0;
if ($_POST["t"]==22){
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

echo '<form action="calllist_pg2.php" method="POST">
    <label>Tage:
    <select name="t" size="1">';
if ($_POST['t']==0)  $sel0="selected";
if ($_POST['t']==1)  $sel1="selected";
if ($_POST['t']==2)  $sel2="selected";
if ($_POST['t']==3)  $sel3="selected";
echo "    <option $sel0 value=0> heute </option>";
echo "    <option $sel1 value=1> gestern </option>";
echo "    <option $sel2 value=2> vorgestern </option>";

for ($i = 3; $i <= 356; $i++) {
	if ($_POST["t"]==$i){
		echo "<option selected value=$i> vor $i Tagen </option>";
	}else{
		echo "<option value=$i> vor $i Tagen </option>";
	}
}

      
echo'    </select>
  </label>
    <button type="submit" >Abfragen</button>';
	//<button type="reset">Abbrechen</button>
echo '</form>';

echo "<table>";
echo "<tr><th>Wann</th><th>Intern</th><th>Richtung</th><th>Extern</th><th>Dauer</th><th>Alarmdauer</th></tr>";
while ($row = pg_fetch_row($result)) {
	$count = count($row);
	//echo $count."count";
		$cn=$row[0];
		$cdr_e162=$row[1];
		$cdr_h323=$row[2];
		$cdr_dir=$row[3];
		$cdr_flow=$row[4];
		$calldur=$row[5];
		$alertdur=$row[6];
		$lts=$row[7];
		$flow=split(',',$cdr_flow);
		if (substr_count($cdr_flow,"forwarded")==0){
			$calltonr=$flow[9];
			if ($calltonr=="") $calltonr="undef";
			$calltoln=$flow[11];
			if ($calltoln=="") $calltonr="undef";
		}else{
			$calltonr="→".$flow[21];
			if ($calltonr=="") $calltonr="undef";
			$calltoln=$flow[23];
			if ($calltoln=="") $calltonr="undef";
		}
		$callto=str_replace('}','',$calltonr.", ".$calltoln);
			
		if ($cdr_dir=="from") {
			
			$cdr_dir="von";
			$cdr_dirr='<span style="color:red"> → </span>';
		}
		if ($cdr_dir=="to") {
			$cdr_dir="an";
			$cdr_dirr='<span style="color:green"> ← </span>';
		}
		
		echo "<tr><td>$lts</td><td>$cdr_dir $cn ($cdr_e162) $cdr_h323</td><td>$cdr_dirr</td><td>$callto</td><td>$calldur</td><td>$alertdur</td></tr>";
		//echo "<tr><td>$cdr_flow</td></tr>";
		
		
}	
	
echo "</table>";

pg_free_result($result);



//echo '</table>';
echo $default;
/*Datenbank abhÃ¤ngen*/

//require("dbdisconnect.php");
//echo ini_get ("memory_limit");

?>
</div>

</body>
</html>

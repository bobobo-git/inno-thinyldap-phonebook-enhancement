<!DOCTYPE html>
<html lang="de" dir="ltr">  <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="robots" content="noindex">

    <meta name="generator"
    content="HTML Tidy for HTML5 (experimental) for Windows https://github.com/w3c/tidy-html5/tree/c63cc39" />
    <title>Call Liste</title>

    
<?php
require ('defs.php');	

//if (ini_set("memory_limit",-1)=="false"){
//	echo "nö";
//	exit;
//}
echo "
<style>
body {
	background: #F4FFF4;
	
	font-family: sans-serif;
	font-size:14px;
}
.t,.tt{
	background:#fff;
	border: solid #ccc;
	border-width: thin;
	border-collapse: collapse;
	
}
.tt{vertical-align: top;
font-size:90%;}

}
</style>	";


 ?>

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
//echo '<body>';


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

echo "<table class='t'>";
echo "<tr><th class='t'>Wann</th><th class='t'>Intern</th><th class='t'><img src='dir.jpg'></th><th class='t'><img src='state.jpg'>Extern</th><th class='t'>Dauer</th><th class='t'>Alert</th></tr>";
while ($row = pg_fetch_row($result)) {
	$count = count($row);
	$show=1;
	$done=0;
	$extern="";
	$zzz="";
	//echo $count."count";
		$cn=$row[0];
		$cdr_e162=$row[1];
		$cdr_h323=$row[2];
		$cdr_dir=$row[3];
		$cdr_flow=$row[4];
		$calldur=$row[6];
		
		$alertdur=$row[5];
		//if (($calldur==0)or ($alertdur==0)) $show=0;
		
		if (($alertdur==0)or($calldur==0)) $show=0;
		if (($calldur==0) and ($alertdur==0)) $show=1;
		if (substr_count($cdr_flow,"cf-from")>0) $show=0;
		$lts=$row[7];
		$flow=split(',',$cdr_flow);
		unset($p1);
		unset($p2);

		$flow=split("},{",$cdr_flow);
		for ($i=1;$i <= count($flow); $i++){
			$test=split(',',$flow[$i]);
			
			if (substr($test[1],0,3)=="000")	{
				$test[1]="+".substr($test[1],3);
			}
			elseif (substr($test[1],0,2)=="00"){
				$test[1]="+49".substr($test[1],2);
			}elseif (substr($test[1],0,1)=="0"){
				$test[1]="+49731".substr($test[1],1);
			}
            
			switch ($test[0]){

				case "setup-from":
				case "setup-to":
			   
			   if ($test[1]!="+49731"){
				   $extern="<tr><td><img src='setup.jpg'></td><td>$test[1]</td><td>$test[3]</td></tr>";
			   }else{$show=0;}
				
				//if ($test[3]=="") $show=0;
				break;

				case "alert-to":
				case "alert-from":
				//$extern.="<tr><td><img src='alert.jpg'></td><td>$test[1]</td><td>$test[3]</td></tr>";
				$extern.="<tr><td><img src='alert.jpg'></td><td>$test[1]</td><td>$test[3]</td></tr>";
				break;

				case "conn-to":
				case "conn-from":
				$extern.="<tr><td><img src='conn.jpg'></td><td>$test[1]</td><td>$test[3]</td></tr>";
				break;

				case "transfer-from":
				$extern.="<tr><td><img src='cf.jpg'></td><td>$test[1]</td><td>$test[3]</td></tr>";
				$done=1;
				break;

				case "transfer-to":
				$extern.="<tr><td><img src='cf.jpg'></td><td>$test[1]</td><td>$test[3]</td></tr>";
				$done=1;
				break;

				case"connected":
				if ($done==0){
				$extern.="<tr><td>$zzz<img src='conn.jpg'></td><td>$test[1]</td><td>$test[3]</td></tr>";
				}
				break;
			}
		}

		
		$callto=$extern;
			
		if ($cdr_dir=="from") {
			
			$cdr_dir="von";
			$cdr_dirr='<span style="color:red"> → </span>';
		}
		if ($cdr_dir=="to") {
			$cdr_dir="an";
			$cdr_dirr='<span style="color:green"> ← </span>';
		}
		if ($show==1){
//		echo "<tr><td class='tt'>$lts</td><td class='tt'>$cdr_dir $cn ($cdr_e162) $cdr_h323</td><td class='tt'>$cdr_dirr</td><td class='tt'><table>$callto</table></td><td class='tt'>$calldur</td><td class='tt'>$alertdur</td></tr>";
		echo "<tr><td class='tt'>$lts</td><td class='tt'>$cn ($cdr_e162) $cdr_h323</td><td class='tt'>$cdr_dirr</td><td class='tt'><table>$callto</table></td><td class='tt'>$calldur</td><td class='tt'>$alertdur</td></tr>";
		//echo "<tr><td>$cdr_flow</td></tr>";
		
		}
		
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

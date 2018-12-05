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
$query = 'select cp.cdrp_call_flow , cp.alert_duration,cp.conn_duration,c.local_stamp,cp.cdr_id,cp.cdrp_conf from cdr_properties cp, cdrs c where cp.cdr_id=c.id and date(c.local_stamp)=date(current_date)-'.$_POST["t"].' order by local_stamp, cdr_id';

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

echo '<form action="calllist_pg1.php" method="POST">
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

//{{to,21,vertrieb,Vertrieb},{setup-to,0073217948,,Dirr Barbara Ostertag GmbH },{scf,24,michael.palz,},{alert-from,0073217948,,Dirr Barbara Ostertag GmbH },{conn-from,0073217948,,Dirr Barbara Ostertag GmbH },{disc-to,,,},{rel-from,0073217948,,}}
echo '<table>';
//echo '<tr><th>Wann</th><th>typ</th><th>typ2</th><th>intern</th><th>internnum</th><th>dir</th><th>extern</th><th>name</th><th>alert</th><th>dur</th></tr>';
echo '<tr><th>Wann</th><th>Mitarbeiter</th><th>NST</th><th>dir</th><th>Conn</th><th>Extern</th><th>Extern Name</th><th>Signal</th><th>Dauer</th></tr>';
//{{from,10,gabriele.may,Gabriele May},{setup-from,0073487370,,},{alert-to,0073487370,,},{conn-to,0073487370,,},{rel-from,0073487370,,}}

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
			if ($nummer){
				if (substr($nummer,0,3)=="000")	{
					$nummer="+".substr($nummer,3);
				}
				elseif (substr($nummer,0,2)=="00"){
					$nummer="+49".substr($nummer,2);
				}elseif (substr($nummer,0,1)=="0"){
					$nummer="+49731".substr($nummer,1);
				}
			}
			$nummercon=$line[13];
			$inummer=$line[1];

			$iname=str_Replace('}','',$line[3]);
			$typ=str_Replace('}','',$line[4]);
			$oname=str_Replace('}','',$line[7]);
			$typ2=str_Replace('}','',$line[8]);
			$typ2n=str_Replace('}','',$line[9]);
			$typ2nn=str_Replace('}','',$line[10]);
			$tt=$line[16];
			$ttnum=$line[17];
			$ttnam=$line[19];

			//echo " ". str_Replace('}','',$line[3]).$dir.$nummer.' '.$line[6]." ".str_replace('}','',$line[7]);
		}
		if ($y==1) $dur=$c_row;
		if ($y==2) $bil=$c_row;
		if ($y==3) $wann=$c_row;
		if ($y==4) $cdrid=$c_row;
		if ($y==5) $cdrpconf=$c_row;
		
		
		next($row);
		$y = $y + 1;
	}
	if ($cdrpconfold == $cdrpconf){
		//$hmm =" Ruf v v";
		//$nummer="";
		$nummercon="";
		$trstyle='';
		$dir.="♪";
	}else{
		$trstyle='style="border-top:solid #ccc;"';
		//$hmm =" Ruf neu";
	}

	$out.="<tr><td $trstyle>$wann </td><td $trstyle>$iname</td><td $trstyle>$inummer</td><td $trstyle>$dir $hmm </td><td $trstyle>$nummercon</td><td $trstyle>$nummer</td><td $trstyle>$oname $tt $ttnum $ttnam</td><td $trstyle>$dur</td><td $trstyle>$bil</td></tr>";

$cdrpconfold=$cdrpconf;
	
/*	
$makeout=0;
switch ($typ2){
	Case "{conn-from":
	Case "{alert-from":
	Case "{alert-to":
	Case "sfc": 
	case "forwarded":
	$makeout=1; 
	break;
}
	
	
if ($makeout>0){
		$out.="<tr><td>$wann</td><td>$typ</td><td>$typ2</td><td>$iname</td><td>$inummer</td><td>$dir</td><td>$nummer</td><td>$oname</td><td>$dur</td><td>$bil</td></tr>";
        $makeout=0;
}		//$out.= "<tr><td>$wann</td><td>$iname</td><td>$dir</td><td>$nummer</td><td>$oname</td></tr>";
if ($makeout<1){
		$out.="<tr><td style='color:red;'>$wann</td><td>$typ</td><td>$typ2</td><td>$iname</td><td>$inummer</td><td>$dir</td><td>$nummer</td><td>$oname</td><td>$dur</td><td>$bil</td></tr>";
        $makeout=0;
}		//$out.= "<tr><td>$wann</td><td>$iname</td><td>$dir</td><td>$nummer</td><td>$oname</td></tr>";
*/
	//}
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

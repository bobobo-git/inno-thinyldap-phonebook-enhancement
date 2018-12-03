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
//	echo "n�";
//	exit;
//}
echo "
body {
	background: #F4FFF4;
	font-family: sans-serif;
	font-size:14px;
}
table,th,td{
	background: #EEEEFF;
	border: thin solid #00CC33;
   border-collapse: collapse;
}
tr,td{
	height: 20px;
}
td{
	background: #FEFEFF;
	border: thin solid #00CC33;
}
 .inh{
	 width: 500px;
	 margin-left:20px;
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
require("dbconnect.php");
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
}
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
$query = 'select cp.cdrp_call_flow , c.local_stamp from cdr_properties cp, cdrs c where cp.cdr_id=c.id and date(c.local_stamp)=date(current_date)-'.$_POST["t"].' order by c.local_stamp desc';


$result = pg_query($query);

$i = 0;
echo '<html><body>';
echo '<p><a href="index.html">&Uuml;bersicht</a></p>';
//echo $_POST['t'];
if ($_POST['t']==0) {}
echo '<form action="calllist.php" method="POST">
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


echo '<table><tr>';
echo '<th>Intern</th><th>extern</th><th>Wann</th>';

$default="<h3>Es konnten keine unbekannten Nummern gefunden werden</h3>";
while ($row = pg_fetch_row($result)) 
{
	
	$count = count($row);
	//echo $count."count";
	$y = 0;
	while ($y < $count)
	{
		//echo $y;
		$c_row = current($row);
		//echo $c_row;
		if ($y==0){
			//echo $y."-". $c_row."<br>";
			$seppi=explode(",",$c_row);
			$iname=explode("}",$seppi[3])[0];
			$nummer=$seppi[5];
			$oname=trim(trim($seppi[7],"}"));

			if (substr($nummer,0,3)=="000")	{
				$nummer="+".substr($nummer,3);
			}
			elseif (substr($nummer,0,2)=="00"){
				$nummer="+49".substr($nummer,2);
			}elseif (substr($nummer,0,1)=="0"){
				$nummer="+49731".substr($nummer,1);
			}
			$it=0;

			if (strlen($nummer)>7){
				$queryinsthere="select count(*) as 'c' from address where '$nummer' in (phone,mobile,home);";
				//echo $queryinsthere;
				if($resultm = $db->query($queryinsthere)){
					if($resultm->num_rows) {
						while($rowi = mysqli_fetch_object($resultm)){
							if ($rowi->c==1){
								$it=1;
							}
						}
					}
				}
				$resultm->close();
			}
            
			$link=$webserver."/inputdataset.php?ptype=phone&number=".urlencode($nummer)."&showlast=1";
			/*$link="http://192.168.1.52:8080/editor.php?username=addresseditor&select=address&where%5B0%5D%5Bcol%5D=&where%5B0%5D%5Bop%5D=&where%5B0%5D%5Bval%5D=".urlencode($nummer)."&where%5B01%5D%5Bcol%5D=&where%5B01%5D%5Bop%5D=&where%5B01%5D%5Bval%5D=&limit=50";
			*/
			
			if ((strlen($nummer)<8)or ($oname) or ($nummer=="+49731") or ($it==1)){
			} else {
				unset($default); //default ausgabe klschen
				echo "<tr><td>$iname </td><td><a target='edt' href='$link'>$nummer</a></td>";
			}
			
		}else{
			//echo $y."-". $c_row."<br>";
			if ((strlen($nummer)<8)or ($oname) or ($nummer=="+49731") or ($it==1)){
			} else {
				echo '<td>' . $c_row . '</td></tr>';
			}
		}
		next($row);
		$y = $y + 1;
	}
	//echo '</tr>';
	$i = $i + 1;
}
pg_free_result($result);

echo '</table>';
echo $default;
/*Datenbank abhängen*/

require("dbdisconnect.php");
//echo ini_get ("memory_limit");

?>
</div>
</body>
</html>

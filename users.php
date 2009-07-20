<?php
require_once('config.inc.php');
session_start();
mysql_connect($dbhost, $dbuser, $dbpass);
@mysql_select_db($db) or die("Unable to select database");
?>

<strong>Current users:</strong>
<?php
$twominutesago = strtotime('-2 minutes');
$twominutesago = date( 'Y-m-d H:i:s', $twominutesago );

$query = "SELECT user, ip FROM chatusers WHERE last_seen > \"$twominutesago\" ORDER BY user DESC LIMIT 10";
$result = mysql_query($query);                                                                                     
mysql_close();                                                                                                     
$num=mysql_numrows($result);                                                                                       
$i=0;                                                                                                              
while($i < $num) {                                                                                                 
        $user=mysql_result($result,$i,"user");                                                                     
        $ip=mysql_result($result,$i,"ip");
	if ($_COOKIE['username'] == "brandon") {                                                                     
?> 
<a href="http://www.maxmind.com/app/locate_ip?ips=<?=$ip?>"><?=$user?></a>&nbsp;
	<? } else { ?>
<?=$user?>&nbsp;
	<? } ?>
<?php                                                                                                              
        $i++;                                                                                                      
}
?>

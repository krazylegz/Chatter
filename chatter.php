<?php
require_once('config.inc.php');
session_start();

mysql_connect($dbhost, $dbuser, $dbpass);
@mysql_select_db($db) or die("Unable to select database");

$query = "SELECT * FROM chat WHERE ip_address not in (select ip from chatbans) ORDER BY id DESC LIMIT 100";
$result = mysql_query($query);

$phpdate = time(now);
$date = date( 'Y-m-d H:i:s', $phpdate );

$user = mysql_escape_string($_COOKIE['username']);
$ip = $_SERVER['REMOTE_ADDR'];

$query = "REPLACE INTO chatusers VALUES (\"$user\", \"$ip\", \"$date\");";
$test = mysql_query($query);

mysql_close();
?>

<?php
$num=mysql_numrows($result);

$i=0;
while($i < $num) {
	$message=stripslashes(mysql_result($result,$i,"message"));
	$mysqltimestamp=mysql_result($result,$i,"mytimestamp");
	$timestamp = strtotime( $mysqltimestamp );
	$timestamp = date( 'h:i', $timestamp );
	$user=mysql_result($result,$i,"user");

	if (isset($_COOKIE['username']) && (strncasecmp($_COOKIE['username'], $message, strlen($_COOKIE['username'])) == 0)) {
		$message = "<strong>$message</strong>";
	}
	if (preg_match("/^http/", $message)) {
		$message = "<a target='_blank' href='" . $message . "'>$message</a>";
	}	
	if (preg_match("/^\/me/", $message)) {
		$message = preg_replace("/\/me/", "<strong>* $user</strong>", $message);
	}

	$avatar = "/home/brandon/public_html/teawiki/chat/avatars/" . $user . ".jpg";
	if (!file_exists($avatar)) {
		$avatar = "/chat/avatars/Zhen+Qu.jpg";
	} else {
		$avatar = "/chat/avatars/" . $user . ".jpg";
	}
?>

<div id="message<?=$i?>" style="padding: .5em; background: #EEEEEE; margin-bottom: .2em; padding-bottom: .9em;">
  <img  style="border: solid 1px black; vertical-align: middle; float: left;" src="<?=$avatar?>" height=40 width=40>
  <span class="water oldbook" style="padding-left: .5em; font-size: .8em;"><?=$user?> - <?=$timestamp?></span><br/>
  <span style="padding-left: .5em;"><?=$message?></span>
</div>

<?php
	$i++;
}
?>


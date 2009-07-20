<?php
require_once('config.inc.php');
session_start();
?>
<?php
mysql_connect($dbhost, $dbuser, $dbpass);
@mysql_select_db($db) or die("Unable to select database");

if (!strlen($_COOKIE['username']) && !strlen($_POST['username'])) {
?>
<form method="post">
Username: <input type="textbox" name="username" id="username">
<input type="submit" value="Go!">
</form>
<?php
	die();
}

if (strlen($_POST['username']) && !strlen($_COOKIE['username'])) {
	$phpdate = time(now);
	$date = date( 'Y-m-d H:i:s', $phpdate );
	$ip = strip_tags(strip_tags(mysql_escape_string($_SERVER['REMOTE_ADDR'])));
	if (($_POST['username'] == "brandon") && ($ip != "68.83.29.174")) {
		die ("You're not Brandon!");
	}
	
	setcookie("username", strip_tags(mysql_escape_string($_POST['username'])), time()+28800);

	$message = "New User: " . mysql_escape_string($_POST['username']);
	$query = "INSERT INTO chat VALUES ('', \"wikiCHAt\", \"$message\", \"$date\", \"$ip\");";
	$test = mysql_query($query);
	echo "Username " . $_POST['username'];
} 
?>
<html>
  <head>
    <title>wikiCHAt</title>
	<META http-equiv="refresh" content="600,URL=http://wikicha.com/chat/">

    <link  href="/chat/css/reset.css" rel="stylesheet" type="text/css">
    <link  href="/chat/css/grid.css" rel="stylesheet" type="text/css">
    <link  href="/chat/css/type.css" rel="stylesheet"  type="text/css">
    <link rel="stylesheet" href="/chat/css/plugins/gadgets.css" type="text/css" media="screen, projection">
    <!--[if IE]><link  href="css/ie.css" type="text/css" rel="stylesheet"><![endif]-->
    <style>
	.main {width: 70%;}
	h1 {margin-top: 8px;}
	h4 {margin-top: 8px;}
    </style>

    <script type="text/javascript" src="jquery.js"></script>
    <script type="text/javascript">
 	$(document).ready(function(){
		$("div#chatbox").load("chatter.php", {time: new Date().getTime() });
		$("div#userbox").load("users.php", {time: new Date().getTime() });
	});

	var refreshId = setInterval(function()
	{
		$("div#chatbox").load("chatter.php", {time: new Date().getTime() });
	}, 10000);

	var refreshId = setInterval(function()
	{
		$("div#userbox").load("users.php", {time: new Date().getTime() });
	}, 30000);

    </script>
  </head>

<?php
if (strlen($_POST['message'])) {

	$message = strip_tags(mysql_escape_string($_POST['message']));
	$user = strip_tags(mysql_escape_string($_COOKIE['username']));
	$phpdate = time(now);
	$date = date( 'Y-m-d H:i:s', $phpdate );
	$ip = strip_tags(mysql_escape_string($_SERVER['REMOTE_ADDR']));
	$query = "INSERT INTO chat VALUES ('', \"$user\", \"$message\", \"$date\", \"$ip\");";
	$test = mysql_query($query);

	if (preg_match("/[dD]20/", $message)) {
		// Roll Some Dice!
		$message = "D20 for $user: " . rand(1,20);
		$query = "INSERT INTO chat VALUES ('', \"wikiCHAt\", \"$message\", \"$date\", \"$ip\");";
		$test = mysql_query($query);
	}
}

$query = "SELECT * FROM chat ORDER BY id DESC LIMIT 100";
$result = mysql_query($query);

mysql_close();

?>

<body style="" onload="document.chatform.message.focus()">

<div id="container" class="main">
<div class="dl20"><a href="http://wikicha.com/chat"><h1>wiki<span class="beer">CHA</span>t</h1></a></div>
<div class="dr20" style="text-align: right"><h4><span class="caramel">Tea</span> <span class="and">&amp;</span> <span class="caramel">Tomfoolery</span></h4></div>
<br class="clear"/>

<!--<div id="chatbox" style="border: solid 1px #999999; height: 70%; width: 50%; overflow: auto">-->

<div id="fluid" class="fluid">
  <form method=post name="chatform">
  <span class="b">Message:</span> <input type="textbox" id="message" name="message"/><input type="submit" name="Post" value="Post">
  </form>
  <br class="clear"/>

  <div id="chatbox" style="border: solid 1px #999999; height: 40em; overflow: auto;"></div>
</div>

<br class="clear"/>
<div id="userbox" class="dl120"></div>
<br class="clear"/>
<div id="links">
  <a href="http://wikicha.com" target="_blank">WikiCHA</a><br/>
  <a href="http://teadrunk.org" target="_blank">TeaDrunk Forum</a>
</div>
<br class="clear"/>


</div>
</body>
</html>

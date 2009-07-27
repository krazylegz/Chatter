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
	
	setcookie("username", strip_tags(mysql_escape_string($_POST['username'])), time()+604800);

	$message = "New User: " . mysql_escape_string($_POST['username']);
	$query = "INSERT INTO chat VALUES ('', \"wikiCHAt\", \"$message\", \"$date\", \"$ip\");";
	$test = mysql_query($query);
} 
print("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>wikiCHAt</title>
    <meta http-equiv="refresh" content="600,URL=http://wikicha.com/chat/"/>
    <link href="/chat/css/reset.css" rel="stylesheet" type="text/css"/>
    <link  href="/chat/css/grid.css" rel="stylesheet" type="text/css"/>
    <link  href="/chat/css/type.css" rel="stylesheet"  type="text/css"/>
    <link rel="stylesheet" href="/chat/css/plugins/gadgets.css" type="text/css" media="screen, projection"/>
    <!--[if IE]><link  href="css/ie.css" type="text/css" rel="stylesheet"/><![endif]-->
    <style type="text/css">
	.main {width: 70%;}
	h1 {margin-top: 8px;}
	h4 {margin-top: 8px;}
	img {
		border: 1px solid black;
		vertical-align: middle;
		height: 40px;
		width: 40px;
	}		
	#userbox img {
		margin-bottom: 0.3em;
	}
	#chatbox img {
		float: left;
	}
	.messagediv {
		padding: .5em; 
		background: #EEEEEE; 
		margin-bottom: .2em; 
		padding-bottom: .9em;
	}
	.messagespan {
		padding-left: .5em; font-size: .8em;
	}
    </style>

    <script src="http://www.google.com/jsapi" type="text/javascript"></script>
    <script type="text/javascript">
	google.load("jquery", "1.3.2");
    </script>
    <script type="text/javascript">
 	$(document).ready(function(){
		$("div#chatbox").load("chatter.php", {time: new Date().getTime() });
		$("div#userbox").load("users.php", {time: new Date().getTime() });
		$("#message").focus();
    		$('input[@type=submit]').click(function() {
      			$("#message").focus();
    		});
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

<body>

<div id="container" class="main" style="width: 80%;">

<div class="dl20"><h1><a href="http://wikicha.com/chat">wiki<span class="beer">CHA</span>t</a></h1></div>
<div class="dr20" style="text-align: right">
  <h4><span class="caramel">Tea</span> <span class="and">&amp;</span> <span class="caramel">Tomfoolery</span></h4>
</div>
<br class="clear"/>

  <form action="/chat/index.php" method="post" id="chatform" name="chatform">
  <p>
    <span class="b">Message:</span>
    <input type="text" id="message" name="message"/>
    <input type="submit" name="Post" value="Post"/>
  </p>
  </form>

  <div id="chatbox" class="dl55" style="width: 80%; border: solid 1px #999999; height: 40em; overflow: auto;"></div>
  <div id="userbox" class="dr15" style="width: 150px; vertical-align: top;" valign="top"></div>

<div id="links" class="dr15" style="font-weight: bold; width: 150px; vertical-align: top; padding-top: 1em;">
  <h3>Links:</h3>	
  <a href="http://wikicha.com" target="_blank">WikiCHA</a><br/>
  <a href="http://teadrunk.org" target="_blank">TeaDrunk Forum</a>
</div>

<br class="clear"/>


</div>

</body>
</html>

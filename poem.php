<?php
# Select random quotes from past chat logs to form funny poems.
require_once('config.inc.php');
session_start();
mysql_connect($dbhost, $dbuser, $dbpass);
@mysql_select_db($db) or die("Unable to select database");
?>

<html>
  <head>
    <title>wikiCHAt</title>

    <link  href="/chat/css/reset.css" rel="stylesheet" type="text/css">
    <link  href="/chat/css/grid.css" rel="stylesheet" type="text/css">
    <link  href="/chat/css/type.css" rel="stylesheet"  type="text/css">
    <link rel="stylesheet" href="/chat/css/plugins/gadgets.css" type="text/css" media="screen, projection">
    <!--[if IE]><link  href="css/ie.css" type="text/css" rel="stylesheet"><![endif]-->
    <style>
        .main {width: 70%;}
        h1 {margin-top: 8px;}                                                           h4 {margin-top: 8px;}
    </style>
</head>
<body>
<div id="container" class="main">                                                                                                       
<div class="dl20"><a href="http://wikicha.com/chat"><h1>wiki<span class="beer">CHA</span>t <span class="water">Poems</span></h1></a></div>

<?php
$query = "SELECT * FROM `chat` where user not like 'wikiCHAt' and length(message) > 20 AND message NOT LIKE \"%http:%\" order by rand() limit 5";
$result = mysql_query($query);                                                                                     
                                                                                                                   
mysql_close();                                                                                                     
?>                                                                                                                 
                                                                                                                   
<div id="poem" class="fluid" style="padding-top: 5em;">
<?php                                                                                                              
$num=mysql_numrows($result);                                                                                       
                                                                                                                   
$i=0;                                                                                                              
while($i < $num) {
	$message=mysql_result($result,$i,"message");
	$ip=mysql_result($result,$i,"ip_address");                                                                     
?>          

<?=stripslashes($message);?> - <br/>
<?php                                                                                                              
        $i++;                                                                                                      
}
?>
</div>

</div>

</body>
</html>

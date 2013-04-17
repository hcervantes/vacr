<?php

include("auth/include/classes/session.php");
?>
<!DOCTYPE html>

<!-- Auto Generated with Sencha Architect -->
<!-- Modifications to this file will be overwritten. -->
<html>
<head>
	<?php 
    // Check if logged in already
	echo 'var loggedIn; isMember, isAgent, isMater, isAdmin;';
	
	if (($session->logged_in) && ($session->isMember())){
      	echo 'isMember = true;';
		echo 'loggedIn = true;';

} elseif (($session->logged_in) && ($session->isAgent())) {
  		echo 'isAgent = true;';
		echo 'loggedIn = true;';
} elseif (($session->logged_in) && ($session->isMaster())) {
  		echo 'isMaster = true;';
		echo 'loggedIn = true;';
} elseif (($session->logged_in) && ($session->isAdmin())) {
  		echo 'isAdmin = true;';
		echo 'loggedIn = true;';
} else {
	echo 'loggedIn=false;'; 
	echo 'isMember=false;';
	echo 'isAgent=false;';
	echo 'isMater=false;';
	echo 'isAdmin=false;';
}
	
     ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>vacr</title>
    <script src="http://extjs.cachefly.net/ext-4.1.1-gpl/ext-all.js"></script>
    <link rel="stylesheet" href="http://extjs.cachefly.net/ext-4.1.1-gpl/resources/css/ext-all.css">
    <link rel="stylesheet" href="resources/css/data-view.css">
    <script type="text/javascript" src="app.js"></script>
    
</head>
<body></body>
</html>
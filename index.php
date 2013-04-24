<?php

include ("auth/include/classes/session.php");
?>
<!DOCTYPE html>

<!-- Auto Generated with Sencha Architect -->
<!-- Modifications to this file will be overwritten. -->
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>vacr</title>
		<script src="http://extjs.cachefly.net/ext-4.1.1-gpl/ext-all.js"></script>
		<link rel="stylesheet" href="http://extjs.cachefly.net/ext-4.1.1-gpl/resources/css/ext-all.css">
		<link rel="stylesheet" href="resources/css/data-view.css">
		<script src="session.js"></script>
		<script type="text/javascript" src="app.js"></script>
		<script type="text/javascript"><?php
		
		// On read
		echo 'Ext.onReady(function() {';
		// Get User Account 
		echo 'var userAccount';
		$loggedIn = array('isLoggedIn' => $session->logged_in,
		'isMember' => $session->isMember(),
		'isAgent' => $session->isAgent(),
		'isMaster' => $session->isMaster(),
		'isAdmin' => $session->isAdmin(),
		'userName' => $_SESSION['username'],
		'session' => $_SESSION,
		'sessionID' => session_id()
		);
		echo 'userAccount = ' . json_encode(array('userAccount' => $loggedIn)) . ';';
		if(!$session->logged_in){
			
			App.loginWin.show();
		} elseif ($session->isAdmin()) {
			Ext.getCmp("adminPanel").show();
		}
		//echo 'App.checkUserLoggedIn();';
		// Close out the onReady
		echo '});';
?></script>

	</head>

	<body></body>
</html>
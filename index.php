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
		
		echo 'var userAccount;
		';
		// Get User Account 
		
		$loggedIn = array('isLoggedIn' => $session->logged_in,
		'isMember' => $session->isMember(),
		'isAgent' => $session->isAgent(),
		'isMaster' => $session->isMaster(),
		'isAdmin' => $session->isAdmin(),
		'userName' => $_SESSION['username'],
		'session' => $_SESSION,
		'sessionID' => session_id()
		);
		echo 'userAccount = ' . json_encode($loggedIn) . '
		;';
		// On read
		echo 'Ext.onReady(function() {
			 ';
		
		/*
		if(!$session->logged_in){			
			echo 'App.loginWin.show();';
		} else{}
		if ($session->isAdmin()) {
			echo 'Ext.getCmp("adminPanel").show();
			';
		
			//echo 'Ext.getCmp("headerContainer").setHTML("Welcome ' . $_SESSION['username'] . '!")';
			echo 'alert("Welcome ' . $_SESSION['username'] . '!");
			';
		}
		 *
		 */
		//echo 'App.checkUserLoggedIn();';
		// Close out the onReady
		echo '});
		';
?></script>

	</head>

	<body></body>
</html>
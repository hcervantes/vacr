<?php

function getInputParms() {
	$result = NULL;
	if (function_exists('json_decode')) {
		$jsonData = json_decode(trim(file_get_contents('php://input')), true);
		$result = $jsonData['data'][0];
	}
	return $result;
}

//database parameters
$user = 'hcervant_hmc';
$pw = 'edwin1998';
$db = 'hcervant_db';
$table = 'PICTURES';

//make database connection
$connection = mysql_connect("localhost", $user, $pw) or die("Could not connect: " . mysql_error());
mysql_select_db($db) or die("Could not select database");

deleteCharacteristics();

function deleteCharacteristics() {
	$jsonData = getInputParms();

	//print_r($jsonData);

	if (is_array($jsonData)) {
		$sql = 'DELETE FROM PICTURES WHERE ID=' . $jsonData['ID'];
		$result = mysql_query($sql);
		if($result > 0) // Delete related rows
		{			
			$return = array('success' => TRUE, 'message' => 'Image deleted' );
		}
		else {
			$return  = array('success' => FALSE, 'message' => 'Unable to delete any rows.' );
		}
		
	
	}
	else {
		$return = array('success' => FALSE, 'message' => 'Unable to delete row.');
	}
		
	$return = json_encode($return);
	echo $return;
}

?>

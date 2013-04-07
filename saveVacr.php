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
$table = 'aircraft';

//make database connection
$connection = mysql_connect("localhost", $user, $pw) or die("Could not connect: " . mysql_error());
mysql_select_db($db) or die("Could not select database");

saveProduct();

function saveProduct() {
	$jsonData = getInputParms();

	//print_r($jsonData);

	if (is_array($jsonData)) {
		if ($jsonData['ID'] > 0 || $jsonData['ID'] != "") {
			$ID = $jsonData['ID'];
			$sql = 'UPDATE AIRCRAFT SET NAME = "' . $jsonData['NAME'] . '",MODELNO = "' . $jsonData['MODELNO'] . '"';
			$sql .= ' WHERE ID = ' . $jsonData['ID'];
			//echo $sql;
			$result = mysql_query($sql);
			// result set
		} else {
			$sql = 'INSERT INTO AIRCRAFT (NAME, MODELNO) VALUES ("' . $jsonData['NAME'] . '","' . $jsonData['MODELNO'] . '")';
			//echo $sql;
			$result = mysql_query($sql);
			// result set
			$ID = mysql_insert_ID();
		}
	}

	$data = getAircraft($ID);
	// already encoded
	// check if a valid row was returned
	if ($data != null) {
		$return = array('success' => TRUE, 'data' => $data // this should be be data returned from new/updated record in table
		);
	} else {
		$return = array('success' => FALSE, 'msg' => 'Row not found to update.');
	}

	$return = json_encode($return);
	echo $return;
}

function getAircraft($ID) {
	$sql = 'SELECT * FROM AIRCRAFT WHERE ID = ' . $ID;

	$result = mysql_query($sql);
	// result set
	if (!isset($result) || $result == null) {
		return null;
	}
	while ($rec = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$arr[] = $rec;
	};

	return $arr;
	//encode the data in json format
}
?>

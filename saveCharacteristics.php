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
$table = 'characteristics';

//make database connection
$connection = mysql_connect("localhost", $user, $pw) or die("Could not connect: " . mysql_error());
mysql_select_db($db) or die("Could not select database");

saveProduct();

function saveProduct() {
	$jsonData = getInputParms();
	$acID = -1;
	
	//print_r($jsonData);

	if (is_array($jsonData)) {
		$acID = $jsonData['AIRCRAFT_ID'];
		if (isset($jsonData['ID']) && $jsonData['ID'] > 0 && $jsonData['ID'] != "") {
			$ID = $jsonData['ID'];
			$sql = 'UPDATE CHARACTERISTICS SET DESCRIPTION = "' . $jsonData['DESCRIPTION'] ;
			$sql .= ' WHERE ID = ' . $ID;
			//echo $sql;
			$result = mysql_query($sql);
			// result set
		} else {
			$sql = 'INSERT INTO CHARACTERISTICS (DESCRIPTION, AIRCRAFT_ID) VALUES ("' . $jsonData['DESCRIPTION'] . '", ' . $acID. ')';
			//echo $sql;
			$result = mysql_query($sql);
			// result set
			$ID = mysql_insert_ID();
		}
	}
	if(!isset($ID)){
		echo json_encode( array('success' => FALSE, 'msg' => 'Row ID not passed in.'));
		exit;
	}
	$data = getCharac($ID);
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

function getCharac($ID) {
	$sql = 'SELECT * FROM CHARACTERISTICS WHERE ID = ' . $ID;

	$result = mysql_query($sql);
	// result set
	if (!isset($result) || $result == null) {
		return null;
	}
	$arr = null;
	while ($rec = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$arr[] = $rec;
	};

	return $arr;
	//encode the data in json format
}
?>

<?php

//database parameters
$user = 'hcervant_hmc';
$pw = 'edwin1998';
$db = 'hcervant_db';
$table = 'characteristics';

//make database connection
$connection = mysql_connect("localhost", $user, $pw) or die("Could not connect: " . mysql_error());
mysql_select_db($db) or die("Could not select database");
$jsonData = getInputParms();
if (isset($jsonData['ID'])) {
	if ($jsonData['ID'] > 0 || $jsonData['ID'] != "") {
		listCharacs($jsonData['ID']);
	}

} else {
	listCharacs(null);
}

function listCharacs($ID) {
	$table = 'CHARACTERISTICS';
	$sql = 'SELECT * FROM ' . $table;
	if ($ID != null) {
		$sql .= ' WHERE ID = ' . $ID;
	}
	$result = mysql_query($sql) or die(mysql_error());

	while ($rec = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$arr[] = $rec;
	};
	if (!isset($arr))
		$arr[] = NULL;
	$rows = count($arr);
	$data = json_encode($arr);
	//encode the data in json format

	echo '({"total":"' . $rows . '","data":' . $data . '})';
}

function getInputParms() {
	$result = NULL;
	if (function_exists('json_decode')) {
		$jsonData = json_decode(trim(file_get_contents('php://input')), true);
		$result = $jsonData['data'][0];
	}
	return $result;
}
?>
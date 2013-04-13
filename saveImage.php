<?php

$allowedExts = array("gif", "jpeg", "jpg", "png");
$maxSize = 2560000;
$fileName = $_FILES["file"]["name"];
$fileNameArray = explode(".", $fileName);
$extension =  strtolower(end($fileNameArray));
$acID = isset($_POST['aircraftID']) ? $_POST['aircraftID'] : FALSE;

// must pass in aircraftID
if ($acID == false) {
	$err = "Return Code: " . $_FILES["file"]["error"];
	$return = array('success' => false, 'errors' => array('portOfLoading' => 'mustprovide an existing aircraftID'));
	return $return;
}

if ((($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/png")) && in_array($extension, $allowedExts)) {
	if ($_FILES["file"]["error"] > 0) {
		$err = "Return Code: " . $_FILES["file"]["error"];
		$return = array('success' => false, 'errors' => array('portOfLoading' => $err));
	} else {
		// Check the size
		if (($_FILES["file"]["size"] > $maxSize)) {
			$return = array('success' => false, 'errors' => array('portOfLoading' => 'Max file size is ' . ($maxSize / 1024) . 'KB'));
		} else {
			$uniqName = uniqid() . "." . $extension;
			// move the file to images folder
			$tempFile = $_FILES["file"]["tmp_name"];
			move_uploaded_file($tempFile, "images/" . $uniqName);
			if (file_exists($tempFile)) {
				unlink($tempFile);
			}
			//database parameters
			$user = 'hcervant_hmc';
			$pw = 'edwin1998';
			$db = 'hcervant_db';
			$table = 'characteristics';

			//make database connection
			$connection = mysql_connect("localhost", $user, $pw) or die("Could not connect: " . mysql_error());
			mysql_select_db($db) or die("Could not select database");

			$sql = 'INSERT INTO PICTURES (IMAGEPATH, AIRCRAFT_ID) VALUES ("' . $uniqName . '", ' . $acID . ')';
			//echo $sql;
			$result = mysql_query($sql);
			// result set
			$ID = mysql_insert_ID();
			if ($result) {
				$msg = "Uploaded successfully " . $_FILES["file"]["name"] . " (" . $uniqName . ") (" . ($_FILES["file"]["size"] / 1024) . " kB";
				$return = array('success' => true, 'message' => $msg, 'newID' => $ID, 'fileName' => $uniqName);
			} else {
				$msg = "Upload unsuccessfull " . $ID;
				$return = array('success' => false, 'errors' => array('portOfLoading' => $msg));

			}
		}

	}
} else {
	$return = array('success' => false, 'errors' => array('portOfLoading' => 'File type must be "gif", "jpeg", "jpg", or "png"'));
}

$return = json_encode($return);
echo $return;

//
// Methods
//

function saveImage($acID) {

	//print_r($jsonData);

	if (is_array($jsonData)) {
		$acID = $jsonData['AIRCRAFT_ID'];
		if (isset($jsonData['ID']) && $jsonData['ID'] > 0 && $jsonData['ID'] != "") {
			$ID = $jsonData['ID'];
			$sql = 'UPDATE CHARACTERISTICS SET DESCRIPTION = "' . $jsonData['DESCRIPTION'];
			$sql .= ' WHERE ID = ' . $ID;
			//echo $sql;
			$result = mysql_query($sql);
			// result set
		} else {
			$sql = 'INSERT INTO CHARACTERISTICS (DESCRIPTION, AIRCRAFT_ID) VALUES ("' . $jsonData['DESCRIPTION'] . '", ' . $acID . ')';
			//echo $sql;
			$result = mysql_query($sql);
			// result set
			$ID = mysql_insert_ID();
		}
	}
	if (!isset($ID)) {
		echo json_encode(array('success' => false, 'msg' => 'Row ID not passed in.'));
		exit ;
	}
	$data = getImage($ID);
	// already encoded
	// check if a valid row was returned
	if ($data != null) {
		$return = array('success' => true, 'data' => $data // this should be be data returned from new/updated record in table
		);
	} else {
		$return = array('success' => false, 'msg' => 'Row not found to update.');
	}

	$return = json_encode($return);
	echo $return;
}

function getImage($ID) {
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
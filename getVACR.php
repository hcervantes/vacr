<?php

/* connect to the db */

$link = mysql_connect('localhost', 'hcervant_hmc', 'edwin1998') or die('Cannot connect to the DB b/c bad user/passwd');
mysql_select_db('hcervant_db', $link) or die('Cannot select the DB');

/* grab the posts from the db */
$query = 'SELECT A.ID, A.NAME, A.MODELNO, C.ID AS CID, C.DESCRIPTION, P.ID AS PID, P.IMAGEPATH 
	FROM hcervant_db.AIRCRAFT AS A
	LEFT JOIN CHARACTERISTICS AS C  ON C.AIRCRAFT_ID = A.ID
	LEFT JOIN PICTURES AS P ON P.AIRCRAFT_ID = A.ID;';
//$rows = mysql_fetch_rows($query);
$rows = mysql_query($query, $link) or die('Errant query:  ' . $query);
// Real stuff
$items = array();
$index = -1;
if (mysql_num_rows($rows)) {
	while ($row = mysql_fetch_assoc($rows)) {
		$item = null;
		$id = $row['ID'];
		
		if(count($items) > 0)
		{
			for($i=0; $i< count($items); $i++) {
		   if($items[$i]['ID'] == $id) 
		   {
		   	$item = $items[$i];
			
			$index = $i;
			break;
		   }
		}
		}
		if ($item == null)
		{
			$index = count($items); // Increase the index counter
			$item = array(
				'ID' => $id, 
				'NAME' => $row['NAME'], 
				'MODELNO' => $row['MODELNO'], 
				'DESCRIPTIONS' => array(), 
				'PICTURES' => array()
			);
		}
		// Check for setting of description array
		$desc = array('DESCRIPTION' =>$row['DESCRIPTION']);
		if (!in_array($desc, $item['DESCRIPTIONS'])) {
			$item['DESCRIPTIONS'][] = array('DESCRIPTION' =>$row['DESCRIPTION']);
		}
		$imgpath = array('PICTURE' => $row['IMAGEPATH']);

		if (!in_array($imgpath, $item['PICTURES'])) {
			$item['PICTURES'][] = array('PICTURE' => $row['IMAGEPATH']);
		}
		
		$items[$index] = $item;
	}
}

header('Content-type: application/json');
$data = json_encode($items, JSON_NUMERIC_CHECK);
echo '({"total":"' . ($index + 1) . '","data":' . $data . '})';


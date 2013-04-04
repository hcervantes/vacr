<?php

/* connect to the db */

$link = mysql_connect('localhost', 'hcervant_hmc', 'edwin1998') or die('Cannot connect to the DB b/c bad user/passwd');
mysql_select_db('hcervant_db', $link) or die('Cannot select the DB');

/* grab the posts from the db */
$query = 'SELECT A.ID, A.NAME, A.MODELNO, C.DESCRIPTION, P.IMAGEPATH 
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
		   if($items[$i]['id'] == $id) 
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
				'id' => $id, 
				'name' => $row['NAME'], 
				'modelno' => $row['MODELNO'], 
				'descriptions' => array(), 
				'pictures' => array()
			);
		}
		// Check for setting of description array
		$desc = array('description' =>$row['DESCRIPTION']);
		if (!in_array($desc, $item['descriptions'])) {
			$item['descriptions'][] = array('description' =>$row['DESCRIPTION']);
		}
		$imgpath = array('picture' => $row['IMAGEPATH']);

		if (!in_array($imgpath, $item['pictures'])) {
			$item['pictures'][] = array('picture' => $row['IMAGEPATH']);
		}
		
		$items[$index] = $item;
	}
}

header('Content-type: application/json');
echo json_encode(array('vacr' => $items), JSON_NUMERIC_CHECK);

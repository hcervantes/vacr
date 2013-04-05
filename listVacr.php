<?php   

//database parameters
$user='hcervantes_hmc'; 
$pw='edwin1998';
$db='hcervant_db';
$table='aircraft';
   
//make database connection
$connection = mysql_connect("localhost", $user, $pw) or
   die("Could not connect: " . mysql_error());
mysql_select_db($db) or die("Could not select database");

listProducts();
    
function listProducts() 
{
	$table='aircraft';
    $sql = 'SELECT * FROM '. $table;
    $result = mysql_query($sql) or die (mysql_error());
    
    while($rec = mysql_fetch_array($result, MYSQL_ASSOC)){
        $arr[] = $rec;
    };
	if(!isset($arr))
		$arr[] = 0;
    $rows = count($arr); 
    $data = json_encode($arr);  //encode the data in json format
      
    echo '({"total":"' . $rows . '","data":' . $data . '})';
}

?>
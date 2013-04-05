<?php   

function getInputParms()
{
    $result = NULL;
    if(function_exists('json_decode')) {
        $jsonData = json_decode(trim(file_get_contents('php://input')), true);
        $result = $jsonData['data'][0];
    }
    return $result;
}

//database parameters
$user='hcervantes_hmc'; 
$pw='edwin1998';
$db='hcervant_db';
$table='aircraft';
   
//make database connection
$connection = mysql_connect("localhost", $user, $pw) or
   die("Could not connect: " . mysql_error());
mysql_select_db($db) or die("Could not select database");

saveProduct();
    
function saveProduct() 
{
    $jsonData = getInputParms();

//print_r($jsonData);

    if (is_array($jsonData)) {

        if ($jsonData['id'] > 0) {
            $id = $jsonData['id'];

            $sql  = 'UPDATE aircraft SET name = "'.$jsonData['name'].'",modelno = '.$jsonData['modelno'];
            $sql .= ' WHERE idProduct = '.$jsonData['id'];
            $result = mysql_query($sql); // result set
        } else {
            $sql  = 'INSERT INTO products (name, modelno) VALUES ("'.$jsonData['name'].'",'.$jsonData['modelno'].')';
            $result = mysql_query($sql); // result set
            $id = mysql_insert_id();
        }
    }    

    $data = getProduct($id); // already encoded

    $return = array(
        'success' => TRUE,
        'data' => $data // this should be be data returned from new/updated record in table
    );
      
    $return = json_encode($return);
    echo $return;  
}


function getProduct($id)
{
    $sql = 'SELECT * FROM aircraft WHERE id = '.$id;
    
    $result = mysql_query($sql); // result set
    
    while($rec = mysql_fetch_array($result, MYSQL_ASSOC)){
        $arr[] = $rec;
    };

    return $arr;  //encode the data in json format
}

?>

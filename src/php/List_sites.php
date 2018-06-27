<?php
/**
 * Created by PhpStorm.
 * User: vladimiranokhin
 * Date: 29.05.18
 * Time: 17:58
 */
global $mysqli;
if (!headers_sent()) {
    header('Access-Control-Allow-Origin: *');
}
function query_find_field($table_name, $search_by_field, $search_value, $return_field){
    global $mysqli;
    if ((gettype($search_value) == "integer") || (gettype($search_value) == "double")) {
        $query = "SELECT * FROM ".$table_name." WHERE " . $search_by_field . " = ".$search_value.";";
    } else {
        $query = "SELECT * FROM ".$table_name." WHERE " . $search_by_field . " = '".$search_value."';";
    }
    $res = $mysqli->query($query);
    if ($res != FALSE) { $row = $res->fetch_assoc(); return $row[$return_field];} else {return NULL;}
}

$mysqli = new mysqli("localhost:3306", "vladimiranokhin", "vladimir2071654", "SiteCollection");

$list_sites = array (array ());

$query = "SELECT * FROM seller_sites WHERE id_site_status < '99' ORDER BY site_name;";
$res = $mysqli->query($query);
$res->data_seek(0);

$i=0;
while ($row = $res->fetch_assoc()) {

    $list_sites[$i]['id'] = $row['id'];
    $list_sites[$i]['site_name'] = $row['site_name'];
    $status = query_find_field('site_status','id',$row['id_site_status'],'status_name');
    if ($status==NULL){$status="";};
    $list_sites[$i]['status'] = $status;
    $i++;
}

$json_string = json_encode($list_sites);

echo $json_string;




?>
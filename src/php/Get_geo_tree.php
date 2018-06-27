<?php
/**
 * Created by PhpStorm.
 * User: vladimiranokhin
 * Date: 22.06.18
 * Time: 14:26
 */
global $mysqli;

if (!headers_sent()) {
    header('Access-Control-Allow-Origin: *');
}

$mysqli = new mysqli("localhost:3306", "vladimiranokhin", "vladimir2071654", "SiteCollection");

$answer = array ();

$value = 0;

$query = "SELECT geo_tree.*, geo_elements.geo_name, geo_elements.table_name FROM geo_tree JOIN geo_elements ON geo_tree.id_geo_element=geo_elements.id ORDER BY id_parent;";
$res = $mysqli->query($query);

if ($res !== FALSE) {

    $res->data_seek(0);

    while ($row = $res->fetch_assoc()) {
        if ($row['id_options']!=0) {
           $query1 ="SELECT * FROM ".$row['table_name']." WHERE id=".$row['id_option']." ;";
           $res1 = $mysqli->query($query1);
           if ($row1 = $res->fetch_assoc()) { $answer[$value]['id_option']=$row['id_option']; $answer[$value]['name_option']=$row1['name'];}
              else {$answer[$value]['id_option']=0; $answer[$value]['name_option']="";}
        }
        $answer[$value]['id'] = $row['id'];
        $answer[$value]['id_geo_element'] = $row['id_geo_element'];
        $answer[$value]['id_parent'] = $row['id_parent'];
        $answer[$value]['table_name'] = $row['table_name'];
        $answer[$value]['geo_name'] = $row['geo_name'];
        $value++;
    }
}

$json_string = json_encode($answer);

echo $json_string;

?>
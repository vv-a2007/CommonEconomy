<?php
/**
 * Created by PhpStorm.
 * User: vladimiranokhin
 * Date: 14.06.18
 * Time: 16:52
 */
global $mysqli;
if (!headers_sent()) {
    header('Access-Control-Allow-Origin: *');
}
$mysqli = new mysqli("localhost:3306", "vladimiranokhin", "vladimir2071654", "SiteCollection");

$answer = array ();
$region = array ();

$_GET['Content-Type'] = "application/json";

$filter_id = $_GET['filter_id'];
$filter_table = $_GET['filter_table'];

$query = "SELECT * FROM regions WHERE (id_parent=".$filter_id." AND  parent_table=".$filter_table.") ORDER BY name";
$res = $mysqli->query($query);

if ($res !== FALSE) {

    $res->data_seek(0);

    $value = 0;
    $region['text'] = "";
    $region['id_item'] = 0;
    $region['value'] = "";
  //  $value++;
    $answer[] = $region;

    while ($row = $res->fetch_assoc()){

        $region['text'] = $row['name'];
        $region['id_item'] = $row['id'];
        $region['value'] = $row['name'];
        // $value++;
        $answer[] = $region;


    }} else {
    $answer[] = "";

}

$json_string = json_encode($answer);

echo $json_string;

?>
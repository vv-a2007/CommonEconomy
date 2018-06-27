<?php
/**
 * Created by PhpStorm.
 * User: vladimiranokhin
 * Date: 15.06.18
 * Time: 17:33
 */

global $mysqli;

if (!headers_sent()) {
    header('Access-Control-Allow-Origin: *');
}
$mysqli = new mysqli("localhost:3306", "vladimiranokhin", "vladimir2071654", "SiteCollection");

$answer = array ();
$area = array ();

$_GET['Content-Type'] = "application/json";

$city_id = $_GET['filter_id'];

$query = "SELECT * FROM areas WHERE id_city=".$city_id." ORDER BY area_name";
$res = $mysqli->query($query);

if ($res !== FALSE) {

    $res->data_seek(0);

    $value = 0;
    $area['text'] ="";
    $area['id_item'] = 0;
    $area['value'] = "";
    //$value++;
    $answer[] = $area;

    while ($row = $res->fetch_assoc()){

        $area['text'] = $row['area_name'];
        $area['id_item'] = $row['id'];
        $area['value'] = $row['area_name'];
        //$value++;
        $answer[] = $area;


    }} else {
    $answer[] = "";

}

$json_string = json_encode($answer);

echo $json_string;

?>
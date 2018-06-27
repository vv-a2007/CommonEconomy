<?php
/**
 * Created by PhpStorm.
 * User: vladimiranokhin
 * Date: 15.06.18
 * Time: 15:23
 */

global $mysqli;

if (!headers_sent()) {
    header('Access-Control-Allow-Origin: *');
}

$mysqli = new mysqli("localhost:3306", "vladimiranokhin", "vladimir2071654", "SiteCollection");

$answer = array ();
$city = array ();

$_GET['Content-Type'] = "application/json";

$region_id = $_GET['filter_id'];

$query = "SELECT * FROM cities  WHERE id_region = ".$region_id." ORDER BY city_name";
$res = $mysqli->query($query);

if ($res !== FALSE) {

    $res->data_seek(0);

    $value = 0;
    $city['text'] ="";
    $city['id_item'] = 0;
    $city['value'] = "";
    //$value++;
    $answer[] = $city;

    while ($row = $res->fetch_assoc()){

        $city['text'] = $row['city_name'];
        $city['id_item'] = $row['id'];
        $city['value'] = $row['city_name'];
        //$value++;
        $answer[] = $city;


    }} else {
    $answer[] = "";

}

$json_string = json_encode($answer);

echo $json_string;

?>
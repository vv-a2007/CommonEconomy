<?php
/**
 * Created by PhpStorm.
 * User: vladimiranokhin
 * Date: 01.06.18
 * Time: 14:46
 */
global $mysqli;
if (!headers_sent()) {
    header('Access-Control-Allow-Origin: *');
}

$mysqli = new mysqli("localhost:3306", "vladimiranokhin", "vladimir2071654", "SiteCollection");

$answer = array ();
$region = array ();


$query = "SELECT * FROM regions  ORDER BY region_name";
$res = $mysqli->query($query);

if ($res !== FALSE) {

    $res->data_seek(0);

    $value = 0;
    $region['text'] = "";
    $region['id_country'] = 0;
    $region['id_region'] = 0;
    $region['value'] = $value; $value++;
    $answer[] = $region;

    while ($row = $res->fetch_assoc()){

        $region['text'] = $row['region_name'];
        $region['id_country'] = $row['id_country'];
        $region['id_region'] = $row['id'];
        $region['value'] = $value; $value++;
        $answer[] = $region;


    }} else {
    $answer[] = "";

}

$json_string = json_encode($answer);

echo $json_string;

?>
<?php
/**
 * Created by PhpStorm.
 * User: vladimiranokhin
 * Date: 04.06.18
 * Time: 14:41
 */
global $mysqli;
if (!headers_sent()) {
    header('Access-Control-Allow-Origin: *');
}

$mysqli = new mysqli("localhost:3306", "vladimiranokhin", "vladimir2071654", "SiteCollection");

$answer = array ();
$city = array ();

$query = "SELECT * FROM cities  ORDER BY city_name";
$res = $mysqli->query($query);

if ($res !== FALSE) {

    $res->data_seek(0);

    $value = 0;
    $city['text'] ="";
    $city['id_city'] = 0;
    $city['id_country'] = 0;
    $city['id_region'] = 0;
    $city['value'] = $value; $value++;
    $answer[] = $city;

    while ($row = $res->fetch_assoc()){

        $city['text'] = $row['city_name'];
        $city['id_city'] = $row['id'];
        $city['id_country'] = $row['id_country'];
        $city['id_region'] = $row['id_region'];
        $city['value'] = $value; $value++;
        $answer[] = $city;


    }} else {
    $answer[] = "";

}

$json_string = json_encode($answer);

echo $json_string;

?>
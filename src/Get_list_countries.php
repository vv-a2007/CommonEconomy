<?php
/**
 * Created by PhpStorm.
 * User: vladimiranokhin
 * Date: 31.05.18
 * Time: 14:22
 */
global $mysqli;

$mysqli = new mysqli("localhost:3306", "vladimiranokhin", "vladimir2071654", "SiteCollection");

$answer = array ();
$country = array ();

$query = "SELECT * FROM countries ORDER BY country_name";
$res = $mysqli->query($query);

if ($res !== FALSE) {

$res->data_seek(0);

// $value = 0;
$country['text'] = "";
$country['id_item'] = 0;
$country['value'] = "";
// $value++;
$answer[] = $country;

while ($row = $res->fetch_assoc()){

$country['text'] = $row['country_name'];
$country['id_item'] = $row['id'];
//$country['value'] = $value;
    $country['value'] = $row['country_name'];
// $value++;

$answer[] = $country;


}} else {
$answer[] = "";

}

$json_string = json_encode($answer);

echo $json_string;

?>
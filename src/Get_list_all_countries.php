<?php
/**
 * Created by PhpStorm.
 * User: vladimiranokhin
 * Date: 18.06.18
 * Time: 13:53
 */
global $mysqli;

$mysqli = new mysqli("localhost:3306", "vladimiranokhin", "vladimir2071654", "SiteCollection");

$answer = array ();
$country = array ();

$query = "SELECT * FROM countries ORDER BY country_name";
$res = $mysqli->query($query);

if ($res !== FALSE) {

    $res->data_seek(0);

    $value = 0;
    $country['text'] = "";
    $country['id_country'] = 0;
    $country['value'] = 0;
    $value++;
    $answer[] = $country;

    while ($row = $res->fetch_assoc()){

        $country['text'] = $row['country_name'];
        $country['id_country'] = $row['id'];
        $country['value'] = $value;
        $value++;

        $answer[] = $country;


    }} else {
    $answer[] = "";

}

$json_string = json_encode($answer);

echo $json_string;

?>
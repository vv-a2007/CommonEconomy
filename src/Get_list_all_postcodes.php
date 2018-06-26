<?php
/**
 * Created by PhpStorm.
 * User: vladimiranokhin
 * Date: 05.06.18
 * Time: 14:57
 */
global $mysqli;

$mysqli = new mysqli("localhost:3306", "vladimiranokhin", "vladimir2071654", "SiteCollection");

$answer = array ();
$postcode = array ();

$_GET['Content-Type'] = "application/json";

$query = "SELECT * FROM postcodes ORDER BY postcode";
$res = $mysqli->query($query);

if ($res !== FALSE) {

    $res->data_seek(0);

    $value = 0;
    $postcode['text'] ="";
    $postcode['id_postcode'] = 0;
    $postcode['id_country'] = 0;
    $postcode['id_region'] = 0;
    $postcode['value'] = $value; $value++;
    $answer[] = $postcode;

    while ($row = $res->fetch_assoc()){

        $postcode['text'] = $row['postcode'];
        $postcode['id_postcode'] = $row['id'];
        $postcode['id_country'] = $row['id_country'];
        $postcode['id_region'] = $row['id_region'];
        $postcode['value'] = $value; $value++;
        $answer[] = $postcode;


    }} else {
    $answer[] = "";

}

$json_string = json_encode($answer);

echo $json_string;

?>
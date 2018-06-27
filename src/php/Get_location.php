<?php
/**
 * Created by PhpStorm.
 * User: vladimiranokhin
 * Date: 31.05.18
 * Time: 13:38
 */
global $mysqli;
if (!headers_sent()) {
    header('Access-Control-Allow-Origin: *');
}
$mysqli = new mysqli("localhost:3306", "vladimiranokhin", "vladimir2071654", "SiteCollection");

$answer = array ();

$query = "SELECT * FROM locations WHERE id=".$_GET['id'].";";
$res = $mysqli->query($query);

if ($res !== FALSE) {

    $res->data_seek(0);
    $row = $res->fetch_assoc();

    $answer['id'] = $row['id'];
    $answer['id_country'] = $row['id_country'];
    $answer['id_region'] = $row['id_region'];
    $answer['id_city'] = $row['id_city'];
    $answer['id_area'] = $row['id_area'];
    $answer['id_postcode'] = $row['id_postcode'];
    $answer['address'] = $row['address'];

} else {

    $answer['id'] = null;
    $answer['id_country'] = null;
    $answer['id_region'] = null;
    $answer['id_city'] = null;
    $answer['id_area'] = null;
    $answer['id_postcode'] = null;
    $answer['address'] = "";

}

$json_string = json_encode($answer);

echo $json_string;

?>
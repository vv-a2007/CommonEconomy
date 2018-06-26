<?php
/**
 * Created by PhpStorm.
 * User: vladimiranokhin
 * Date: 15.06.18
 * Time: 19:03
 */
global $mysqli;

$mysqli = new mysqli("localhost:3306", "vladimiranokhin", "vladimir2071654", "SiteCollection");

$answer = array ();
$postcode = array ();

$_GET['Content-Type'] = "application/json";
$region_id = $_GET['filter_id'];


$query = "SELECT * FROM postcodes WHERE id_region=".$region_id." ORDER BY postcode";
$res = $mysqli->query($query);

if ($res !== FALSE) {

    $res->data_seek(0);

    $value = 0;
    $postcode['text'] ="";
    $postcode['id_item'] = 0;
    $postcode['value'] = "";
    //$value++;
    $answer[] = $postcode;

    while ($row = $res->fetch_assoc()){

        $postcode['text'] = $row['postcode'];
        $postcode['id_item'] = $row['id'];
        $postcode['value'] = $row['postcode'];
        //$value++;
        $answer[] = $postcode;


    }} else {
    $answer[] = "";

}

$json_string = json_encode($answer);

echo $json_string;

?>
<?php
/**
 * Created by PhpStorm.
 * User: vladimiranokhin
 * Date: 05.06.18
 * Time: 13:35
 */
global $mysqli;

$mysqli = new mysqli("localhost:3306", "vladimiranokhin", "vladimir2071654", "SiteCollection");

$answer = array ();
$area = array ();

$query = "SELECT * FROM areas ORDER BY area_name";
$res = $mysqli->query($query);

if ($res !== FALSE) {

    $res->data_seek(0);

    $value = 0;
    $area['text'] ="";
    $area['id_area'] = 0;
    $area['id_country'] = 0;
    $area['id_region'] = 0;
    $area['id_city'] = 0;
    $area['value'] = $value; $value++;
    $answer[] = $area;

    while ($row = $res->fetch_assoc()){

        $area['text'] = $row['area_name'];
        $area['id_area'] = $row['id'];
        $area['id_country'] = $row['id_country'];
        $area['id_region'] = $row['id_region'];
        $area['id_city'] = $row['id_city'];
        $area['value'] = $value; $value++;
        $answer[] = $area;


    }} else {
    $answer[] = "";

}

$json_string = json_encode($answer);

echo $json_string;

?>
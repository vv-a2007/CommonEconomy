<?php
/**
 * Created by PhpStorm.
 * User: vladimiranokhin
 * Date: 22.06.18
 * Time: 14:26
 */
global $mysqli;

if (!headers_sent()) {
    header('Access-Control-Allow-Origin: *');
}

$mysqli = new mysqli("localhost:3306", "vladimiranokhin", "vladimir2071654", "SiteCollection");

$answer = array ();

$value = 0;

$query = "SELECT * FROM geo_elements ORDER BY geo_name";
$res = $mysqli->query($query);

if ($res !== FALSE) {

    $res->data_seek(0);

    while ($row = $res->fetch_assoc()) {
        $answer[$value]['id'] = $row['id'];
        $answer[$value]['geo_name'] = $row['geo_name'];
        $answer[$value]['table_name'] = $row['table_name'];

        $value++;
    }
}

$json_string = json_encode($answer);

echo $json_string;

?>
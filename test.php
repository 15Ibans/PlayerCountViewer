<?php

$raw_json = file_get_contents("./2020-12-26.json");
$data = json_decode($raw_json, false);

// $servers = array();

// foreach ($data as $server => $server_data) {
//     $json_str = "[";
//     foreach ($server_data as $time => $count) {
//         $json_str .= $count . ",";
//     }
//     $json_str .= "]";
//     $servers[$server] = $json_str;
// }

// print_r($servers);

?>
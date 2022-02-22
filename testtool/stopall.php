<?php

$serverUrl = 'http://127.0.0.1:4444';
$sessions = file_get_contents($serverUrl.'/sessions');
printf("%s\n", $sessions);

// $sessions = json_decode($sessions, true);
// if (isset($sessions['value'])) {
// 	foreach ($sessions['value'] as $row) {
// 		print_r($row);
// 	}
// }
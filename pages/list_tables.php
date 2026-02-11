<?php
require_once(__DIR__ . '/../includes/load.php');
$result = $db->query("SHOW TABLES");
while ($row = $result->fetch_array()) {
    echo $row[0] . "\n";
}
?>


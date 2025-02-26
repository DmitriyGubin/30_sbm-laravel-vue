<?php
require_once 'connection.php';

/**чистка**/
$link -> query("TRUNCATE TABLE avtos");

$link -> query("DELETE FROM details");
$link -> query("ALTER TABLE details AUTO_INCREMENT = 1");//сброс первичного ключа

$link -> query("DELETE FROM orders");
$link -> query("ALTER TABLE orders AUTO_INCREMENT = 1");

$link -> query("TRUNCATE TABLE providers");
$link -> query("TRUNCATE TABLE provider_orders");
$link -> query("TRUNCATE TABLE provider_teches");
$link -> query("TRUNCATE TABLE statistics_orders");

$link -> query("DELETE FROM users");
$link -> query("ALTER TABLE users AUTO_INCREMENT = 1");
/**чистка**/

echo '777';
?>













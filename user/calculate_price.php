<?php 
require_once('../storage/db.php');
require_once('../storage/price_db.php');
$price = "";
if(isset($_GET['carSize']) && isset($_GET['package']) && isset($_GET['bookingTime'])) {
    $price = get_price_by_sizes_packages_id($mysqli, $_GET['carSize'], $_GET['package']);
}

echo json_encode($price);
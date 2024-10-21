<?php
function get_all_car_types($mysqli) {
    $sql = "select * from car_type";
    $result = $mysqli->query($sql);
    return $result;
}
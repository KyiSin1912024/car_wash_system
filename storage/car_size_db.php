<?php
function get_all_car_sizes($mysqli) {
    $sql = "select * from car_size";
    $sizes = $mysqli->query($sql);
    return $sizes;
}

function get_size_by_name($mysqli,$name) {
    $sql = "select * from car_size where car_size_name = '$name'";
    $size = $mysqli->query($sql);
    return $size->fetch_assoc();
}

function get_size_by_id($mysqli,$id) {
    $sql = "select * from car_size where car_size_id = $id";
    $size = $mysqli->query($sql);
    return $size->fetch_assoc();
}

function save_size($mysqli, $name, $description) {
    $sql = "INSERT INTO `car_size`(`car_size_name`, `description`) VALUES ('$name', '$description')";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

function update_size($mysqli, $size_id, $name, $description) {
    $sql = "UPDATE car_size SET car_size_name = '$name', description = '$description' WHERE car_size_id = $size_id";
    $result = $mysqli->query($sql);
    return $result;
}

function delete_size($mysqli, $size_id) {
    $sql = "DELETE FROM car_size WHERE car_size_id = $size_id";
    $result = $mysqli->query($sql);
    return $result;
}

function get_size_by_name_not_self($mysqli,$name,$package_id) {
    $sql = "select * from package where package_name = '$name' and package_id != $package_id";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}
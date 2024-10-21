<?php
function get_all_prices($mysqli) {
    $sql = "select * from package";
    $packages = $mysqli->query($sql);
    return $packages;
}

function get_all_price_with_sizes_packages($mysqli) {
    $sql = "select * from car_size inner join price on car_size.car_size_id = price.car_size_id inner join package on price.package_id = package.package_id";
    $prices = $mysqli->query($sql);
    return $prices;
}

function get_price_by_sizes_packages_id($mysqli, $sizes_id, $package_id) {
    $sql = "select * from `price` where `car_size_id` = $sizes_id and `package_id` = $package_id";
    $result = $mysqli->query($sql);
    if($result) return $result->fetch_assoc();
}

function get_price_by_package_id($mysqli, $package_id) {
    $sql = "select * from `price` where `package_id` = $package_id";
    $result = $mysqli->query($sql);
    if($result) return $result;
}

function save_price($mysqli, $package_id, $size_id, $price) {
    $sql = "insert into price(car_size_id, package_id, price) values ($size_id, $package_id, $price)";
    $result = $mysqli->query($sql);
    return $result;
}
function get_price_by_id($mysqli,$id) {
    $sql = "select * from price where price_id = $id";
    $price = $mysqli->query($sql);
    return $price->fetch_assoc();
}

function  update_price($mysqli, $size_id, $package_id, $price, $price_id) {
    $sql = "UPDATE price SET car_size_id = $size_id, package_id = $package_id, price = $price WHERE price_id = $price_id";
    $result = $mysqli->query($sql);
    return $result;
}

function delete_price($mysqli, $price_id) {
    $sql = "DELETE FROM price WHERE price_id = $price_id";
    $result = $mysqli->query($sql);
    return $result;
}

function delete_price_by_package_id($mysqli, $package_id) {
    $prices = get_price_by_package_id($mysqli, $package_id);
    while($price = $prices->fetch_assoc()) {
        $price_id = $price['price_id'];
        $sql1 = "delete from reservation where price_id = $price_id";
        $result = $mysqli->query($sql1);
        if($result == false) return $result;
    }
    $sql = "delete from price where package_id = $package_id";
    $result = $mysqli->query($sql);
    return $result;
}

function delete_price_by_size_id($mysqli, $size_id) {
    $sql = "delete from price where car_size_id = $size_id";
    $result = $mysqli->query($sql);
    return $result;
}
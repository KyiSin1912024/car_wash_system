<?php
function get_all_packages($mysqli) {
    $sql = "select * from package";
    $packages = $mysqli->query($sql);
    return $packages;
}

function get_all_packages_plans($mysqli) {
    $sql = "select * from package inner join package_plan on package.package_id = package_plan.package_id inner join plan on package_plan.plan_id = plan.plan_id";
    $package_plans = $mysqli->query($sql);
    return $package_plans;
}

function get_package_by_name($mysqli,$name) {
    $sql = "select * from package where package_name = '$name'";
    $package = $mysqli->query($sql);
    return $package->fetch_assoc();
}

function get_package_by_name_not_self($mysqli,$name,$package_id) {
    $sql = "select * from package where package_name = '$name' and package_id != $package_id";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function get_package_by_id($mysqli,$id) {
    $sql = "select * from package where package_id = $id";
    $package = $mysqli->query($sql);
    return $package->fetch_assoc();
}

function get_all_plans_by_package($mysqli, $package_id) {
    $sql = "select * from package_plan inner join plan on package_plan.plan_id = plan.plan_id where package_plan.package_id = $package_id";
    $packages = $mysqli->query($sql);
    return $packages;
}

function save_package($mysqli, $name) {
    $sql = "INSERT INTO `package`(`package_name`) VALUES ('$name')";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

function update_package($mysqli, $package_id, $name) {
    $sql = "UPDATE package SET package_name = '$name' WHERE package_id = $package_id";
    $result = $mysqli->query($sql);
    return $result;
}

function delete_package($mysqli, $package_id) {
    $sql = "DELETE FROM package WHERE package_id = $package_id";
    $result = $mysqli->query($sql);
    return $result;
}

function get_package_count($mysqli) {
    $sql = "select count(*) as package_count from package";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}
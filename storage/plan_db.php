<?php
function get_all_plans($mysqli) {
    $sql = "select * from plan";
    $plans = $mysqli->query($sql);
    return $plans;
}

function get_plan_by_name($mysqli,$name) {
    $sql = "select * from plan where plan_name = '$name'";
    $plan = $mysqli->query($sql);
    return $plan->fetch_assoc();
}

function save_plan($mysqli, $name) {
    $sql = "INSERT INTO `plan`(`plan_name`) VALUES ('$name')";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

function get_plan_by_id($mysqli,$id) {
    $sql = "select * from plan where plan_id = $id";
    $plan = $mysqli->query($sql);
    return $plan->fetch_assoc();
}

function  update_plan($mysqli, $plan_id, $name) {
    $sql = "UPDATE plan SET plan_name = '$name' WHERE plan_id = $plan_id";
    $result = $mysqli->query($sql);
    return $result;
}

function delete_plan($mysqli, $plan_id) {
    $sql = "DELETE FROM plan WHERE plan_id = $plan_id";
    $result = $mysqli->query($sql);
    return $result;
}

function get_plan_by_name_not_self($mysqli,$name,$package_id) {
    $sql = "select * from package where package_name = '$name' and package_id != $package_id";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}
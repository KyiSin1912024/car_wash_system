<?php
function save_package_plan($mysqli, $plans, $package_id) {
    foreach ($plans as $plan) {
        $sql = "insert into package_plan(plan_id,package_id) values($plan, $package_id)";
        $result = $mysqli->query($sql);
        if(!$result) return false;
    }
    return true;
}

function update_package_plan($mysqli, $plans, $package_id) {
    foreach ($plans as $plan) {
        $sql = "update package_plan set plan_id = $plan where package_id = $package_id";
        $result = $mysqli->query($sql);
        if(!$result) return false;
    }
    return true;
}

function get_all_plans_by_package_plan_id($mysqli, $package_id, $plan_id) {
    $sql = "select * from package_plan where package_id = $package_id and plan_id = $plan_id";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function delete_plans_by_package($mysqli, $package_id) {
    $sql = "delete from package_plan where package_id = $package_id";
    $result = $mysqli->query($sql);
    return $result;
}
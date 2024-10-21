<?php
function get_all_schedules($mysqli) {
    $sql = "select * from schedule";
    $packages = $mysqli->query($sql);
    return $packages;
}

function get_time_by_name($mysqli,$name) {
    $sql = "select * from schedule where schedule_hour = '$name'";
    $room = $mysqli->query($sql);
    return $room->fetch_assoc();
}

function save_time($mysqli, $name) {
    $sql = "INSERT INTO `schedule`(`schedule_hour`) VALUES ('$name')";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

function get_time_by_id($mysqli,$id) {
    $sql = "select * from schedule where schedule_id = $id";
    $plan = $mysqli->query($sql);
    return $plan->fetch_assoc();
}

function  update_time($mysqli, $time_id, $name) {
    $sql = "UPDATE schedule SET schedule_hour = '$name' WHERE schedule_id = $time_id";
    $result = $mysqli->query($sql);
    return $result;
}

function delete_time($mysqli, $schedule_id) {
    $sql = "DELETE FROM schedule WHERE schedule_id = $schedule_id";
    $result = $mysqli->query($sql);
    return $result;
}

function get_time_by_name_not_self($mysqli,$name,$time_id) {
    $sql = "select * from schedule where schedule_hour = '$name' and schedule_id != $time_id";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}
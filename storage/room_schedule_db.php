<?php

function get_room_schedule_by_schedule_id($mysqli, $schedule_id) {
    $sql = "select * from `room_schedule` where `schedule_id` = $schedule_id and `room_schedule_id` not in (select `room_schedule_id` from `reservation` where `reservation_date` = CURRENT_DATE)";
    $result = $mysqli->query($sql);
    if($result) return $result->fetch_assoc();
}

function save_room_schedule($mysqli, $schedule_id) {
    $rooms = get_all_rooms($mysqli);
    while($room = $rooms->fetch_assoc()) {
        $sql = "INSERT INTO room_schedule(room_id, schedule_id) VALUES ($room[room_id], $schedule_id)";
        $result = $mysqli->query($sql);
        if(!$result) return false;
    }
    return true;
}

function delete_room_schedule($mysqli, $time_id) {
    $sql = "delete from room_schedule where schedule_id = $time_id";
    if($mysqli->query($sql)) return true;
    return false;
}
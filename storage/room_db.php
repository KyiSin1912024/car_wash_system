<?php 
function get_all_rooms($mysqli) {
    $sql = "select * from room";
    $rooms = $mysqli->query($sql);
    return $rooms;
}

function get_room_by_name($mysqli,$name) {
    $sql = "select * from room where room_no = '$name'";
    $room = $mysqli->query($sql);
    return $room->fetch_assoc();
}

function get_room_by_id($mysqli,$id) {
    $sql = "select * from room where room_id = $id";
    $room = $mysqli->query($sql);
    return $room->fetch_assoc();
}

function save_room($mysqli, $name) {
    $sql = "INSERT INTO `room`(`room_no`) VALUES ('$name')";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

function  update_room($mysqli, $room_id, $name) {
    $sql = "UPDATE room SET room_no = '$name' WHERE room_id = $room_id";
    $result = $mysqli->query($sql);
    return $result;
}

function delete_room($mysqli, $room_id) {
    $sql = "DELETE FROM room WHERE room_id = $room_id";
    $result = $mysqli->query($sql);
    return $result;
}

function get_room_by_name_not_self($mysqli,$name,$room_id) {
    $sql = "select * from room where room_no = '$name' and room_id != $room_id";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}
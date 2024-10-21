<?php
function save_booking($mysqli, $user_id, $price_id, $car_type_id, $room_schedule_id, $price, $payment_method, $pay_ss) {
    $sql = "insert into `reservation`(`user_id`,`price_id`,`car_type_id`,`room_schedule_id`,`total_amount`,`payment_method`, `payment_evidence`) values ($user_id, $price_id, $car_type_id, $room_schedule_id, $price, '$payment_method', '$pay_ss')";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

function get_all_bookings($mysqli) {
    $sql = "select * from reservation inner join users on reservation.user_id = users.user_id inner join price on reservation.price_id = price.price_id inner join package on price.package_id = package.package_id inner join car_size on price.car_size_id = car_size.car_size_id inner join car_type on reservation.car_type_id = car_type.car_type_id inner join room_schedule on reservation.room_schedule_id = room_schedule.room_schedule_id inner join schedule on room_schedule.schedule_id = schedule.schedule_id";
    $result = $mysqli->query($sql);
    return $result;
}

function get_total_amount($mysqli) {
    $sql = "SELECT SUM(total_amount) as total_amount from reservation";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function get_booking_times($mysqli) {  
    $sql = "select count(*) as time_count from schedule;";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function get_reservation_count_today($mysqli) {
    $sql = "select count(*) as booking_count from reservation where reservation_date = CURRENT_DATE";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}
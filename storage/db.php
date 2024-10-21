<?php
$mysqli = new mysqli("localhost", "root", "");

//check connection error
if ($mysqli->connect_error) {
    echo "Connection Error.";
}

//create database
function create_db($mysqli)
{
    $sql = "create database IF NOT EXISTS vehicle_washing";
    if ($mysqli->query($sql)) return true;
    return false;
}

function select_db($mysqli)
{
    if ($mysqli->select_db("vehicle_washing")) return true;
    return false;
}

function create_tables($mysqli)
{
    $sql = "CREATE TABLE IF NOT EXISTS users (
        user_id BIGINT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        ph_no VARCHAR(20) NOT NULL,
        password VARCHAR(255) NOT NULL,
        image VARCHAR(255) NOT NULL,
        is_admin BOOLEAN DEFAULT FALSE,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
      )";
    if (!$mysqli->query($sql)) return false;

    $sql = "CREATE TABLE IF NOT EXISTS car_type (
        car_type_id BIGINT PRIMARY KEY AUTO_INCREMENT,
        car_type_name VARCHAR(255) NOT NULL
      )";
    if (!$mysqli->query($sql)) return false;

    $sql = "CREATE TABLE IF NOT EXISTS car_size (
        car_size_id BIGINT PRIMARY KEY AUTO_INCREMENT,
        car_size_name VARCHAR(255) NOT NULL
      )";
    if (!$mysqli->query($sql)) return false;

    $sql = "CREATE TABLE IF NOT EXISTS package (
        package_id BIGINT PRIMARY KEY AUTO_INCREMENT,
        package_name VARCHAR(255) NOT NULL UNIQUE
      )";
    if (!$mysqli->query($sql)) return false;

    $sql = "CREATE TABLE IF NOT EXISTS price (
        price_id BIGINT PRIMARY KEY AUTO_INCREMENT,
        car_size_id BIGINT NOT NULL,
        package_id BIGINT NOT NULL,
        price DECIMAL(5,2) NOT NULL,
        FOREIGN KEY (car_size_id) REFERENCES car_size(car_size_id),
        FOREIGN KEY (package_id) REFERENCES package(package_id)
      )";
    if (!$mysqli->query($sql)) return false;

    $sql = "CREATE TABLE IF NOT EXISTS plan (
        plan_id BIGINT PRIMARY KEY AUTO_INCREMENT,
        plan_name VARCHAR(255) NOT NULL,
        updated_at DATE DEFAULT CURRENT_DATE,
        deleted_at DATE NULL
      )";
    if (!$mysqli->query($sql)) return false;

    $sql = "CREATE TABLE IF NOT EXISTS package_plan (
        pk_plan_id BIGINT PRIMARY KEY AUTO_INCREMENT,
        plan_id BIGINT NOT NULL,
        package_id BIGINT NOT NULL,
        FOREIGN KEY (plan_id) REFERENCES plan(plan_id),
        FOREIGN KEY (package_id) REFERENCES package(package_id)
      )";
    if (!$mysqli->query($sql)) return false;

    $sql = "CREATE TABLE IF NOT EXISTS room (
        room_id BIGINT PRIMARY KEY AUTO_INCREMENT,
        room_no VARCHAR(255) NOT NULL
    )";
    if (!$mysqli->query($sql)) return false;

    $sql = "CREATE TABLE IF NOT EXISTS schedule (
        schedule_id BIGINT PRIMARY KEY AUTO_INCREMENT,
        schedule_hour VARCHAR(45) NOT NULL
    )";
    if (!$mysqli->query($sql)) return false;

    $sql = "CREATE TABLE IF NOT EXISTS room_schedule (
        room_schedule_id BIGINT PRIMARY KEY AUTO_INCREMENT,
        room_id BIGINT NOT NULL,
        schedule_id BIGINT NOT NULL,
        FOREIGN KEY (room_id) REFERENCES room(room_id),
        FOREIGN KEY (schedule_id) REFERENCES schedule(schedule_id)      
      )";
    if (!$mysqli->query($sql)) return false;

    $sql = "CREATE TABLE IF NOT EXISTS discount_type (
        dc_type_id BIGINT PRIMARY KEY AUTO_INCREMENT,
        dc_type_name VARCHAR(255) NOT NULL,
        updated_at DATE DEFAULT CURRENT_DATE,
        deleted_at DATE NULL
    )";
    if (!$mysqli->query($sql)) return false;

    $sql = "CREATE TABLE IF NOT EXISTS reservation (
      reservation_id BIGINT PRIMARY KEY AUTO_INCREMENT,
      user_id BIGINT NOT NULL,
      price_id BIGINT NOT NULL,
      car_type_id BIGINT NOT NULL,
      room_schedule_id BIGINT NOT NULL,
      dc_type_id BIGINT NULL,
      total_amount DECIMAL(8,2) NOT NULL,
      reservation_date DATE DEFAULT CURRENT_DATE,
      payment_method VARCHAR(60) NOT NULL,
      payment_evidence VARCHAR(255) NOT NULL,
      FOREIGN KEY (user_id) REFERENCES users(user_id),
      FOREIGN KEY (price_id) REFERENCES price(price_id),
      FOREIGN KEY (car_type_id) REFERENCES car_type(car_type_id),
      FOREIGN KEY (room_schedule_id) REFERENCES room_schedule(room_schedule_id),
      FOREIGN KEY (dc_type_id) REFERENCES discount_type(dc_type_id)
    )";
    if (!$mysqli->query($sql)) return false;

    return true;
}

create_db($mysqli);
select_db($mysqli);
create_tables($mysqli);

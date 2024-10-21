<?php
function save_user($mysqli, $user_name, $email, $phone, $password)
{
    $sql = "INSERT INTO `users`(`name`,`email`,`ph_no`,`password`) VALUES ('$user_name','$email','$phone','$password')";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

function save_admin($mysqli, $user_name, $email, $phone, $password, $image)
{
    $sql = "INSERT INTO `users`(`name`,`email`,`ph_no`,`password`,`image`,`is_admin`) VALUES ('$user_name','$email','$phone','$password','$image',true)";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

function get_all_customers($mysqli)
{
    $sql = "SELECT * FROM `users` where is_admin = false";
    $result = $mysqli->query($sql);
    return $result;
}

function get_customer_count($mysqli)
{
    $sql = "SELECT COUNT(*) AS customer_count FROM `users` where is_admin = false";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function get_all_admins($mysqli)
{
    $sql = "SELECT * FROM `users` where is_admin = true";
    $result = $mysqli->query($sql);
    return $result;
}

function get_user_by_id($mysqli, $c_id)
{
    $sql = "SELECT * FROM `users` WHERE `user_id`=$c_id";
    $result = $mysqli->query($sql);
    if ($result)  return $result->fetch_assoc();
}

function get_user_by_email($mysqli, $email)
{
    $sql = "SELECT * FROM `users` WHERE `email`='$email'";
    $result = $mysqli->query($sql);
    if ($result) return $result->fetch_assoc();
}

function update_user($mysqli, $c_id, $c_name, $email, $phone, $image = null)
{
    $sql = "UPDATE `users` SET `name`='$c_name', `email`='$email',`ph_no`='$phone',`image` = '$image' WHERE `user_id`=$c_id";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

function delete_user($mysqli, $id)
{
    $sql = "DELETE FROM `users`  WHERE `user_id`=$id";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

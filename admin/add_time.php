<?php
require_once("../includes/config.php");
$time = $msg = "";
$time_err = $invalid_err = "";
$validate = true;
$success = $invalid = false;
if(isset($_POST["register"])) {
    $time = $_POST["time"];
    if($time == "") {
        $validate = false;
        $time_err = "Time must not be blank.";
    } 
    $time_db = get_time_by_name($mysqli,$time);
    if($time_db) {
        $validate = false;
        $time_err = "This time is already existed.";
    }    
    if($validate) {
        $result = save_time($mysqli, $time);
        if($result) {
            $status = save_room_schedule($mysqli, $mysqli->insert_id);
            if($status) {
                $msg = "Successfully added a time!";
                header("Location:./time_list.php?msg=$msg");
            } else $invalid_msg = "Fail to add schedules in room.";
        } else {
            $invalid_msg = "Fail to add a time!";
        }
    }
}
require_once("./layout/header.php"); ?>
<div class="col-auto pagetitle my-4">
        <h1>Add time</h1>
    </div><!-- End Page Title -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-7">
            <div class="card bg-light p-4">
                <form method="post">
                    <?php
                        if ($msg) echo '<div class="alert alert-danger" style="font-size:14px;">Admin Registeration Successful!</div>';
                    ?>
                    <div class="row mb-3">
                        <div class="col">
                            <label>Time</label>
                        </div>
                        <div class="col">
                            <input type="text" name="time" class="form-control" value="<?php echo $time ?>">
                            <small class="text-danger"><?php echo $time_err ?></small>
                        </div>
                    </div>
                    
                    <div class="row mt-2">
                        <div class="col">
                            <button class="btn btn-secondary w-100" type="submit" name="register"> Register </button>                           
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
 
<?php require_once("./layout/footer.php") ?>
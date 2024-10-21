<?php
require_once("../includes/config.php");

$time = $msg = $time_id = "";
$time_err = $invalid_err = "";
$validate = true;
$success = $invalid = false;

if(isset($_GET['time_id'])) $time_id = $_GET['time_id'];
$time = get_time_by_id($mysqli, $time_id);

if(isset($_POST["update"])) {
    $name = $_POST["name"];

    if($name == "") {
        $validate = false;
        $time_err = "time name must not be blank.";
    } 
    $time_name = get_time_by_name_not_self($mysqli,$name, $time_id);
    if($time_name) {
        $validate = false;
        $time_err = "This time is already existed.";
    }    
    if($validate) {
        $result = update_time($mysqli, $time_id, $name);
        if($result) {
            $msg = "Successfully updated the time!";
            header("Location:./time_list.php?msg=$msg");
            
        } else {
            $invalid_msg = "Fail to update the time!";
        }
    }
}
require_once("./layout/header.php"); ?>
<div class="col-auto pagetitle my-4">
        <h1>Update time</h1>
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
                            <label>Time Name</label>
                        </div>
                        <div class="col">
                            <input type="text" name="name" class="form-control" value="<?php echo $time['schedule_hour'] ?>">
                            <small class="text-danger"><?php echo $time_err ?></small>
                        </div>
                    </div>
                    
                    <div class="row mt-2">
                        <div class="col">
                            <button class="btn btn-secondary w-100" type="submit" name="update"> Update </button>                           
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
 
<?php require_once("./layout/footer.php") ?>
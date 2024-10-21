<?php
require_once("../includes/config.php");

$name = $msg = $room_id = "";
$name_err = $invalid_err = "";
$validate = true;
$success = $invalid = false;

if(isset($_GET['room_id'])) $room_id = $_GET['room_id'];
$room = get_room_by_id($mysqli, $room_id);

if(isset($_POST["update"])) {
    $name = $_POST["name"];

    if($name == "") {
        $validate = false;
        $name_err = "room name must not be blank.";
    } 
    $room_name = get_room_by_name_not_self($mysqli,$name, $room_id);
    if($room_name) {
        $validate = false;
        $name_err = "This room is already existed.";
    }    
    if($validate) {
        $result = update_room($mysqli, $room_id, $name);
        if($result) {
            $msg = "Successfully updated the room!";
            header("Location:./room_list.php?msg=$msg");
            
        } else {
            $invalid_msg = "Fail to update the room!";
        }
    }
}
require_once("./layout/header.php"); ?>
<div class="col-auto pagetitle my-4">
        <h1>Update Room</h1>
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
                            <label>Room Name</label>
                        </div>
                        <div class="col">
                            <input type="text" name="name" class="form-control" value="<?php echo $room['room_no'] ?>">
                            <small class="text-danger"><?php echo $name_err ?></small>
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
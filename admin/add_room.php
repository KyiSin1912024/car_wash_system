<?php
require_once("../includes/config.php");
$name = $msg = "";
$name_err = $invalid_err = "";
$validate = true;
$success = $invalid = false;
if(isset($_POST["register"])) {
    $name = $_POST["name"];

    if($name == "") {
        $validate = false;
        $name_err = "Room name must not be blank.";
    } 
    $room = get_room_by_name($mysqli,$name);
    if($room) {
        $validate = false;
        $name_err = "This room name is already existed.";
    }    
    if($validate) {
        $result = save_room($mysqli, $name);
        if($result) {
            $msg = "Successfully added a room!";
            header("Location:./room_list.php?msg=$msg");
            
        } else {
            $invalid_msg = "Fail to add a room!";
        }
    }
}
require_once("./layout/header.php"); ?>
<div class="col-auto pagetitle my-4">
        <h1>Add room</h1>
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
                            <input type="text" name="name" class="form-control" value="<?php echo $name ?>">
                            <small class="text-danger"><?php echo $name_err ?></small>
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
<?php
require_once("../includes/config.php");

$name = $description = $msg = $size_id = "";
$name_err = $description_err = $invalid_err = "";
$validate = true;
$success = $invalid = false;

if(isset($_GET['size_id'])) $size_id = $_GET['size_id'];
$size = get_size_by_id($mysqli, $size_id);

if(isset($_POST["update"])) {
    $name = $_POST["name"];
    $description = $_POST["description"];

    if($name == "") {
        $validate = false;
        $name_err = "size name must not be blank.";
    } 
    if($description == "") {
        $validate = false;
        $description_err = "Description must not be blank.";
    }
    $size_name = get_size_by_name_not_self($mysqli,$name, $size_id);
    if($size_name) {
        $validate = false;
        $name_err = "This size is already existed.";
    }    
    if($validate) {
        $result = update_size($mysqli, $size_id, $name, $description);
        if($result) {
            $msg = "Successfully updated the size!";
            header("Location:./size_list.php?msg=$msg");
            
        } else {
            $invalid_msg = "Fail to update the size!";
        }
    }
}
require_once("./layout/header.php"); ?>
<div class="col-auto pagetitle my-4">
        <h1>Update size</h1>
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
                            <label>Size Name</label>
                        </div>
                        <div class="col">
                            <input type="text" name="name" class="form-control" value="<?php echo $size['car_size_name'] ?>">
                            <small class="text-danger"><?php echo $name_err ?></small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label>Description</label>
                        </div>
                        <div class="col">
                            <input type="text" name="description" class="form-control" value="<?php echo $size['description'] ?>">
                            <small class="text-danger"><?php echo $description_err ?></small>
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
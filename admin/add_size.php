<?php
require_once("../includes/config.php");
$name = $description = $msg = "";
$name_err = $description_err = $invalid_err = "";
$validate = true;
$success = $invalid = false;
if(isset($_POST["register"])) {
    $name = $_POST["name"];
    $description = $_POST["description"];
    if($name == "") {
        $validate = false;
        $name_err = "Size name must not be blank.";
    } 
    if($description == "") {
        $validate = false;
        $description_err = "Description must not be blank.";
    }
    $size = get_size_by_name($mysqli,$name);
    if($size) {
        $validate = false;
        $name_err = "This size is already existed.";
    }    
    if($validate) {
        $result = save_size($mysqli, $name, $description);
        if($result) {            
            $msg = "Successfully added a size!";
            header("Location:./size_list.php?msg=$msg");            
        } else {
            $invalid_msg = "Fail to add a size!";
        }
    }
}
require_once("./layout/header.php"); ?>
<div class="col-auto pagetitle my-4">
        <h1>Add Vehicle Size</h1>
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
                            <input type="text" name="name" class="form-control" value="<?php echo $name ?>">
                            <small class="text-danger"><?php echo $name_err ?></small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label>Description</label>
                        </div>
                        <div class="col">
                            <input type="text" name="description" class="form-control" value="<?php echo $description ?>">
                            <small class="text-danger"><?php echo $description_err ?></small>
                        </div>
                    </div>
                    
                    <div class="row mt-2">
                        <div class="col">
                            <button class="btn btn-secondary w-100" type="submit" name="register"> Add </button>                           
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
 
<?php require_once("./layout/footer.php") ?>
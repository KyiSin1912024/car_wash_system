<?php
require_once("../includes/config.php");

$name = $msg = $plan_id = "";
$name_err = $invalid_err = "";
$validate = true;
$success = $invalid = false;

if(isset($_GET['plan_id'])) $plan_id = $_GET['plan_id'];
$plan = get_plan_by_id($mysqli, $plan_id);

if(isset($_POST["update"])) {
    $name = $_POST["name"];

    if($name == "") {
        $validate = false;
        $name_err = "Plan name must not be blank.";
    } 
    $plan_name = get_plan_by_name($mysqli,$name);
    if($plan_name) {
        $validate = false;
        $name_err = "This plan is already existed.";
    }    
    if($validate) {
        $result = update_plan($mysqli, $plan_id, $name);
        if($result) {
            $msg = "Successfully updated the plan!";
            header("Location:./plan_list.php?msg=$msg");
            
        } else {
            $invalid_msg = "Fail to update the plan!";
        }
    }
}
require_once("./layout/header.php"); ?>
<div class="col-auto pagetitle my-4">
        <h1>Update Plan</h1>
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
                            <label>Plan Name</label>
                        </div>
                        <div class="col">
                            <input type="text" name="name" class="form-control" value="<?php echo $plan['plan_name'] ?>">
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
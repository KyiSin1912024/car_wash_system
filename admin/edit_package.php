<?php
require_once("../includes/config.php");

$name = $plans = $msg = $package_id = "";
$name_err = $invalid_err = $plan_err = "";
$validate = true;
$success = $invalid = false;

if(isset($_GET['package_id'])) $package_id = $_GET['package_id'];
$package = get_package_by_id($mysqli, $package_id);

if(isset($_POST["update"])) {
    $name = $_POST["name"];
    if(isset($_POST["plans"])) $plans = $_POST["plans"];
    if($name == "") {
        $validate = false;
        $name_err = "Package name must not be blank.";
    } 
    if($plans == "") {
        $validate = false;
        $plan_err = "Plan must not be blank.";
    }
    $package_name = get_package_by_name_not_self($mysqli,$name,$package_id);
    if($package_name) {
        $validate = false;
        $name_err = "This package is already existed.";
    }    
    if($validate) {
        $result = update_package($mysqli, $package_id, $name);
        if($result) {
            $status = delete_plans_by_package($mysqli, $package_id);
            $result = save_package_plan($mysqli, $plans, $package_id);
            if($result) {
            $msg = "Successfully updated the package!";
            header("Location:./package_list.php?msg=$msg");
            } else {
                $invalid_msg = "Fail to update the plans in the package!";
            }
        } else {
            $invalid_msg = "Fail to update the package!";
        }
    }
}
require_once("./layout/header.php"); ?>
<div class="col-auto pagetitle my-4">
        <h1>Update Package</h1>
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
                        <div class="col-3">
                            <label>Package Name</label>
                        </div>
                        <div class="col">
                            <input type="text" name="name" class="form-control" value="<?php echo $package['package_name'] ?>">
                            <small class="text-danger"><?php echo $name_err ?></small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">
                            <label>Choose Plans</label>
                        </div>
                        <div class="col">
                        <select class="form-control" name="plans[]" placeholder="Example placeholder" multiple id="mySelect2">
                            <?php
                                $plans = get_all_plans($mysqli);
                                while($plan = $plans->fetch_assoc()) { 
                                    $old_plan = get_all_plans_by_package_plan_id($mysqli, $package['package_id'], $plan['plan_id']);
                                ?>                                    
                                    <option value="<?php echo $plan['plan_id'] ?>" <?php if($old_plan && $old_plan['plan_id'] == $plan['plan_id']) echo 'selected' ?>><?php echo $plan['plan_name'] ?></option>
                            <?php } ?>
                        </select>
                            <small class="text-danger"><?php echo $plan_err ?></small>
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
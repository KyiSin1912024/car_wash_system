<?php
require_once("../includes/config.php");
$name = $plans = $msg = "";
$name_err = $plan_err = $invalid_err = "";
$validate = true;
$success = $invalid = false;
if(isset($_POST["register"])) {
    $name = $_POST["name"];
    if(isset($_POST["plans"]))
    $plans = $_POST["plans"];
    if($name == "") {
        $validate = false;
        $name_err = "Package name must not be blank.";
    } 
    if($plans == "") {
        $validate = false;
        $plan_err = "Plan must not be blank.";
    }
    $package = get_package_by_name($mysqli,$name);
    if($package) {
        $validate = false;
        $name_err = "This package is already existed.";
    }    
    if($validate) {
        $result = save_package($mysqli, $name);
        if($result) {
            $result = save_package_plan($mysqli, $plans, $mysqli->insert_id);
            if($result) {
            $msg = "Successfully added a package!";
            header("Location:./package_list.php?msg=$msg");
            } else {
                $invalid_msg = "Fail to add plans in package.";
            }            
        } else {
            $invalid_msg = "Fail to add a package!";
        }
    }
}
require_once("./layout/header.php"); ?>
<div class="col-auto pagetitle my-4">
        <h1>Add Package</h1>
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
                            <label>Package Name</label>
                        </div>
                        <div class="col">
                            <input type="text" name="name" class="form-control" value="<?php echo $name ?>">
                            <small class="text-danger"><?php echo $name_err ?></small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label>Choose Plans</label>
                        </div>
                        <div class="col">
                        <select class="form-control" name="plans[]" placeholder="Example placeholder" multiple id="mySelect2">
                            <?php
                                $plans = get_all_plans($mysqli);
                                while($plan = $plans->fetch_assoc()) { ?>
                                    <option value="<?php echo $plan['plan_id'] ?>"><?php echo $plan['plan_name'] ?></option>
                            <?php } ?>
                        </select>
                            <small class="text-danger"><?php echo $plan_err ?></small>
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
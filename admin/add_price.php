<?php
require_once("../includes/config.php");
$price = $package_id = $size_id = $msg = "";
$price_err = $package_err = $size_err = $invalid_err = "";
$validate = true;
$success = $invalid = false;
if(isset($_POST["register"])) {
    $package_id = $_POST["package"];
    $size_id = $_POST["size"];
    $price = $_POST["price"];

    if($package_id == "00") {
        $validate = false;
        $package_err = "Package must not be blank.";
    }
    if($size_id == "00") {
        $validate = false;
        $size_err = "Size must not be blank.";
    }
    if($price == "") {
        $validate = false;
        $price_err = "Price must not be blank.";
    }   
    if($validate) {
        $result = save_price($mysqli, $package_id, $size_id, $price);
        if($result) {
            $msg = "Successfully set a price!";
            header("Location:./price_list.php?msg=$msg");
            
        } else {
            $invalid_msg = "Fail to add a plan!";
        }
    }
}
require_once("./layout/header.php"); ?>
<div class="col-auto pagetitle my-4">
        <h1>Add Price With Related Package and Size</h1>
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
                            <select name="package" class="form-control">
                                <option value="00">Choose Package</option>  
                                <?php $packages = get_all_packages($mysqli);
                                while($package = $packages->fetch_assoc()) { ?>
                                <option value="<?php echo $package['package_id'] ?>"><?php echo $package['package_name'] ?></option>
                                <?php } ?>
                            </select>
                            <small class="text-danger"><?php echo $package_err ?></small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label>Size</label>
                        </div>
                        <div class="col">
                            <select name="size" class="form-control">
                                <option value="00">Choose Size</option>  
                                <?php $sizes = get_all_car_sizes($mysqli);
                                while($size = $sizes->fetch_assoc()) { ?>
                                <option value="<?php echo $size['car_size_id'] ?>"><?php echo $size['car_size_name'] ?></option>
                                <?php } ?>
                            </select>
                            <small class="text-danger"><?php echo $size_err ?></small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label>Price</label>
                        </div>
                        <div class="col">
                            <input type="number" name="price" class="form-control" value="<?php echo $price ?>"> MMK
                            <small class="text-danger"><?php echo $price_err ?></small>
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
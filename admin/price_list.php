<?php
    require_once("../includes/config.php");
    $prices = get_all_price_with_sizes_packages($mysqli);

    $success = $msg = "";
    if (isset($_GET["success"])) $success = $_GET["success"];

    if (isset(($_GET["price_id"]))) {
        $status = delete_price($mysqli, $_GET["price_id"]);
        if($status) {
            header("Location: ./price_list.php?success=Successfully deleted.");
        } else {
            $invalid = "Failed to delete.";
        }
    }

    require_once("./layout/header.php"); ?>
    <div class="row justify-content-between">
    <div class="col-auto pagetitle my-4">
        <h1>Price List</h1>
    </div><!-- End Page Title -->
    <div class="col-auto my-4">
        <a href="./add_price.php" class="custom-btn primary-btn btn-hover"><small><i class="fa-solid fa-plus"></i></small> &nbsp; Add price</a>
    </div>
    </div>
    
    <div class="">
        <?php if (isset($_GET["success"])) {  ?>
            <div class="text-success mb-3 fw-bold">
                <?php echo $success ?>
            </div>
        <?php } ?>
        <?php if (isset($_GET["msg"])) {  ?>
            <div class="text-success mb-3 fw-bold">
                <?php echo $_GET["msg"] ?>
            </div>
        <?php } ?>
        <table id="myTable" class="table table-striped table-bordered mb-3" style="width:100%">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Package name</th>
                    <th>Size</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i = 0;
                    while ($price = $prices->fetch_assoc()) {
                ?>
                        <tr>
                            <td> <?php echo ++$i; ?> </td>
                            <td> <?php echo $price['package_name'] ?></td>
                            <td> <?php echo $price['car_size_name'] ?></td>
                            <td> <?php echo $price['price'] ?></td>
                            <td class="text-center"><a href="edit_price.php?price_id=<?php echo $price['price_id'] ?>"><i class="fa-solid fa-pen-to-square text-secondary me-3"></i></a> | <a href="price_list.php?price_id=<?php echo $price['price_id'] ?>" onclick="return confirm('Are you sure want to delete?')"><i class="ms-3 fa-solid fa-trash text-danger"></i></a></td>
                        </tr>
                    <?php
                    } ?>
                </tbody>
        </table>
    </div>
    <?php require_once("./layout/footer.php"); ?>
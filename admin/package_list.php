<?php
    require_once("../includes/config.php");
    $packages = get_all_packages($mysqli);

    $success = $msg = "";
    if (isset($_GET["success"])) $success = $_GET["success"];

    if (isset(($_GET["package_id"]))) {
        $package_id = $_GET['package_id'];
        $status = delete_price_by_package_id($mysqli, $package_id);
        if ($status) $status = delete_plans_by_package($mysqli, $package_id);
        if($status) $result = delete_package($mysqli, $package_id);
        if($result) {
            header("Location: ./package_list.php?success=Successfully deleted.");
        } else {
            $invalid = "Failed to delete.";
        }
    }

    require_once("./layout/header.php"); ?>
    <div class="row justify-content-between">
    <div class="col-auto pagetitle my-4">
        <h1>Package List</h1>
    </div><!-- End Page Title -->
    <div class="col-auto my-4">
        <a href="./add_package.php" class="custom-btn primary-btn btn-hover"><small><i class="fa-solid fa-plus"></i></small> &nbsp; Add Package</a>
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
                    <th>ID</th>
                    <th>Package Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            
                <?php
                    $i = 0;
                    while ($package = $packages->fetch_assoc()) {
                ?>
                        <tr>
                            <td> <?php echo ++$i; ?> </td>
                            <td> <?php echo $package['package_name'] ?></td>
                            <td class="text-center"><a class="btn" type="button" data-bs-toggle="modal" data-bs-target="#detailModal-<?php echo $package['package_id'] ?>"><i class="fa-solid fa-file-lines me-3"></i></a> | <a href="edit_package.php?package_id=<?php echo $package['package_id'] ?>"><i class="fa-solid fa-pen-to-square text-secondary me-3"></i></a> | <a href="package_list.php?package_id=<?php echo $package['package_id'] ?>" onclick="return confirm('Are you sure want to delete? All the data related with this package will be deleted.')"><i class="ms-3 fa-solid fa-trash text-danger"></i></a></td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="detailModal-<?php echo $package['package_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Plans in <?php echo $package['package_name'] ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body d-flex justify-content-center">
                                <ul style="list-style-type:disc;">
                                    <?php 
                                        $package_plans = get_all_plans_by_package($mysqli, $package['package_id']);
                                        while($plan = $package_plans->fetch_assoc()) { ?>
                                        <li><?php echo $plan['plan_name'] ?></li>
                                        <?php }
                                    ?>
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-xs btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                            </div>
                        </div>
                        </div>
                    <?php
                    } ?>
                </tbody>
        </table>
    </div>
    <?php require_once("./layout/footer.php"); ?>
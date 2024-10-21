<?php
    require_once("../includes/config.php");
    $sizes = get_all_car_sizes($mysqli);

    $success = $msg = "";
    if (isset($_GET["success"])) $success = $_GET["success"];

    if (isset(($_GET["size_id"]))) {
        $size_id = $_GET['size_id'];
        $status = delete_price_by_size_id($mysqli, $size_id);
        if($status) $result = delete_size($mysqli, $size_id);
        if($result) {
            header("Location: ./size_list.php?success=Successfully deleted.");
        } else {
            $invalid = "Failed to delete.";
        }
    }

    require_once("./layout/header.php"); ?>
    <div class="row justify-content-between">
    <div class="col-auto pagetitle my-4">
        <h1>Vehicle Size List</h1>
    </div><!-- End Page Title -->
    <div class="col-auto my-4">
        <a href="./add_size.php" class="custom-btn primary-btn btn-hover"><small><i class="fa-solid fa-plus"></i></small> &nbsp; Add size</a>
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
                    <th>Size Name</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            
                <?php
                    $i = 0;
                    while ($size = $sizes->fetch_assoc()) {
                ?>
                        <tr>
                            <td> <?php echo ++$i; ?> </td>
                            <td> <?php echo $size['car_size_name'] ?></td>
                            <td> <?php echo $size['description'] ?></td>
                            <td class="text-center"><a href="edit_size.php?size_id=<?php echo $size['car_size_id'] ?>"><i class="fa-solid fa-pen-to-square text-secondary me-3"></i></a> | <a href="size_list.php?size_id=<?php echo $size['car_size_id'] ?>" onclick="return confirm('Are you sure want to delete? All the data related with this size will be deleted.')"><i class="ms-3 fa-solid fa-trash text-danger"></i></a></td>
                        </tr>
                    <?php
                    } ?>
                </tbody>
        </table>
    </div>
    <?php require_once("./layout/footer.php"); ?>
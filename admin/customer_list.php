<?php
    require_once("../includes/config.php");
    $customers = get_all_customers($mysqli);

    $success = "";
    if (isset($_GET["success"])) $success = $_GET["success"];

    if (isset(($_GET["customer_id"]))) {
        var_dump($_GET["customer_id"]);
        $status = delete_user($mysqli, $_GET["customer_id"]);
        if ($status) {
            header("customer: ./customer_list.php?success=customer is successfully deleted.");
        }
    }

    require_once("./layout/header.php"); ?>
    <div class="row justify-content-between">
        <div class="col-auto pagetitle my-4">
            <h1>Customer List</h1>
        </div><!-- End Page Title -->
    </div>
    
    <div class="">
        <?php if (isset($_GET["success"])) {  ?>
            <div class="text-success mb-3 fw-bold">
                <?php echo $success ?>
            </div>
        <?php } ?>
        <table id="myTable" class="table table-striped table-bordered mb-3" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Photo</th>
                    <th>Phone No.</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i = 0;
                    while ($customer = $customers->fetch_assoc()) {
                ?>
                        <tr>
                            <td> <?php echo ++$i; ?> </td>
                            <td> <?php echo $customer['name'] ?></td>
                            <td> <?php echo $customer['email'] ?></td>
                            <td> 
                            <?php  
                                if($customer['image']) { ?>
                                    <img src="../upload/<?php echo $customer['image'] ?>" style="width: 100px; height: 100px;">
                                <?php } else { ?>   
                                    <img src="./assets/images/profile/no-image.jpg" style="width: 100px; height: 100px;">
                                <?php } ?>
                            </td>
                            <td> <?php echo $customer['ph_no'] ?></td>
                        </tr>
                    <?php
                    } ?>
                </tbody>
        </table>
    </div>
    <?php require_once("./layout/footer.php"); ?>
<?php
    require_once("../includes/config.php");
    $bookings = get_all_bookings($mysqli);

    $success = "";
    if (isset($_GET["success"])) $success = $_GET["success"];

    if (isset(($_GET["booking_id"]))) {
        var_dump($_GET["booking_id"]);
        $status = delete_user($mysqli, $_GET["booking_id"]);
        if ($status) {
            header("booking: ./booking_list.php?success=booking is successfully deleted.");
        }
    }

    require_once("./layout/header.php"); ?>
    <div class="row justify-content-between">
        <div class="col-auto pagetitle my-4">
            <h1>Booking List</h1>
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
                    <th>Id</th>
                    <th>Name</th>
                    <th>Package</th>
                    <th>Vehicle size</th>
                    <th>Amount</th>
                    <th>Booking time</th>
                    <th>Booking date</th>
                    <th>Payment Method</th>
                    <th>Payment Evidence</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i = 0;
                    while ($booking = $bookings->fetch_assoc()) {
                ?>
                        <tr>
                            <td> <?php echo ++$i; ?> </td>
                            <td> <?php echo $booking['name'] ?></td>
                            <td> <?php echo $booking['package_name'] ?></td>
                            <td> <?php echo $booking['car_size_name'] ?> </td>
                            <td> <?php echo $booking['total_amount'] ?> </td>
                            <td> <?php echo $booking['schedule_hour'] ?> </td>
                            <td> <?php echo $booking['reservation_date'] ?> </td>
                            <td> <?php echo $booking['payment_method'] ?> </td>
                            <td> <img src="../upload/<?php echo $booking['payment_evidence'] ?>" style="max-width: 100%;"> </td>
                        </tr>
                    <?php
                    } ?>
                </tbody>
        </table>
    </div>
    <?php require_once("./layout/footer.php"); ?>
<?php require_once("../storage/auth_user.php"); 
require_once("../includes/config.php");
$package = get_package_count($mysqli);
$income = get_total_amount($mysqli);
$booking_times = get_booking_times($mysqli);
$customer = get_customer_count($mysqli);
$reservation = get_reservation_count_today($mysqli);
?>
<?php require_once("./layout/header.php") ?>
<!-- ========== title-wrapper start ========== -->
<div class="title-wrapper pt-30">
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="title">
                <h2>Admin Dashboard</h2>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
</div>
<!-- ========== title-wrapper end ========== -->
<div class="row">
    <div class="col-xl-3 col-lg-4 col-sm-6">
        <div class="icon-card mb-30">
            <div class="icon purple">
                  <i class="fa-solid fa-box"></i>
            </div>
            <div class="content">
                <h6 class="mb-10">Packages</h6>
                <h3 class="text-bold mb-10"><?php echo $package['package_count'] ?></h3>
            </div>
        </div>
        <!-- End Icon Cart -->
    </div>
    <!-- End Col -->
    <div class="col-xl-3 col-lg-4 col-sm-6">
        <div class="icon-card mb-30">
            <div class="icon success">
                <i class="lni lni-dollar"></i>
            </div>
            <div class="content">
                <h6 class="mb-10">Total Income</h6>
                <h3 class="text-bold mb-10"><?php echo $income['total_amount'] ?>MMK </h3>
            </div>
        </div>
        <!-- End Icon Cart -->
    </div>
    <!-- End Col -->
    <div class="col-xl-3 col-lg-4 col-sm-6">
        <div class="icon-card mb-30">
            <div class="icon primary">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div class="content">
                <h6 class="mb-10">Booking Times</h6>
                <h3 class="text-bold mb-10"><?php echo $booking_times['time_count'] ?></h3>
            </div>
        </div>
        <!-- End Icon Cart -->
    </div>
    <!-- End Col -->
    <div class="col-xl-3 col-lg-4 col-sm-6">
        <div class="icon-card mb-30">
            <div class="icon orange">
                <i class="lni lni-user"></i>
            </div>
            <div class="content">
                <h6 class="mb-10">Customers</h6>
                <h3 class="text-bold mb-10"><?php echo $customer['customer_count'] ?></h3>
            </div>
        </div>
        <!-- End Icon Cart -->
    </div>
    <!-- End Col -->
</div>
<!-- End Row -->

<div class="row">
    <div class="col-xl-3 col-lg-4 col-sm-6">
        <div class="icon-card mb-30">
            <div class="icon purple">
                <i class="fa-solid fa-lines-leaning"></i>
            </div>
            <div class="content">
                <h6 class="mb-10">Reservations (Today)</h6>
                <h3 class="text-bold mb-10"><?php echo $reservation['booking_count'] ?></h3>
            </div>
        </div>
        <!-- End Icon Cart -->
    </div>
    <!-- End Col -->
</div>
<!-- End Row -->

<?php require_once("./layout/footer.php") ?>
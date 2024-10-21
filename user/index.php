<?php //error_reporting(0);
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('../storage/auth_user.php');
require_once('../storage/db.php');
require_once('../storage/package_db.php');
require_once('../storage/price_db.php');
require_once('../storage/car_size_db.php');
require_once('../storage/schedule_db.php');
require_once('../storage/car_type_db.php');
require_once('../storage/room_schedule_db.php');
require_once('../storage/booking_db.php');

if ($user['is_admin']) {
    header("Location:../includes/error.php");
}

$car_size_id = $package_id = $time_id = $taxi_id = $car_type_id = "";
$car_size_err = $package_err = $time_err = $price_err = $payment_method_err = $pay_ss_err = "";
$validate = true;
$success = $invalid = "";
if(isset($_POST['submit'])) {
    $car_size_id = $_POST['car-size'];
    $package_id = $_POST['package'];
    $time_id = $_POST['time'];
    $price = $_POST['booking-price'];
    $payment_method = $_POST['pay_method'];
    $pay_ss = $_FILES['paymentss']['name'];
    
    if(isset($_POST['taxi'])) $taxi_id = $_POST['taxi'];
    if($car_size_id === "00") {
        $validate = false;
        $car_size_err = "Car size must not be blank.";
    } 
    if($package_id === "00") {
        $validate = false;
        $package_err = "Package must not be blank.";
    }
    if($time_id === "00") {
        $validate = false;
        $time_err = "Booking time must not be blank.";
    }
    if(empty($price)) {
        $validate = false;
        $price_err = "Price must not be blank.";
    }
    if(empty($payment_method)) {
        $validate = false;
        $payment_method_err = "Payment method must not be blank";
    }
    if(empty($pay_ss)) {
        $validate = false;
        $pay_ss_err = "Payment Evidence must not be blank";
    }
    if(empty($pay_ss_err)) {
        if (!str_contains($_FILES['paymentss']['type'], 'image/')) {
            $validate = false;
            $pay_ss_err = "Payment Evidence must not be only image.";
        }
    }
    $img = $_FILES["paymentss"]["tmp_name"];
    if($taxi_id) {
        $car_type_id = $taxi_id;
    } else {
        $car_type_id = 2;
    }
    
    if($validate) {
        $price_id = get_price_by_sizes_packages_id($mysqli, $car_size_id, $package_id);
        $room_schedule = get_room_schedule_by_schedule_id($mysqli, $time_id);
        if($room_schedule) {
            $result = save_booking($mysqli, $user['user_id'], $price_id['price_id'], $car_type_id, $room_schedule['room_schedule_id'], $price, $payment_method, $pay_ss);
            if($result) {
                try {
                    move_uploaded_file($img, "../upload/" . $pay_ss);
                    $success = "Your booking is successful.";
                echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Success!',
                        text: '$success',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                });
                </script>";
                } catch (\Throwable $th) {
                    $invalid = "Sorry, your booking failed.";
                echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Sorry, Image upload error.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
                </script>";
                }
            } else {
                $invalid = "Sorry, your booking failed.";
                echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Sorry, your booking failed.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
                </script>";
            }
        }
         else {
            $invalid = "Sorry, your booking time is unavailable today. You can try booking for other schedules.";
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Unavailable!',
                    text: '$invalid',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
            });
            </script>";
        }
    }
}
$packages = get_all_packages($mysqli);
$booking_packages = get_all_packages($mysqli);
$plans = get_all_packages_plans($mysqli);
$prices = get_all_price_with_sizes_packages($mysqli);
$car_sizes = get_all_car_sizes($mysqli);
$booking_times = get_all_schedules($mysqli);
$car_types = get_all_car_types($mysqli);
$packages_plans = [];
while ($plan = $plans->fetch_assoc()) {
    $packages_plans[$plan['package_id']][] = $plan['plan_name'];
}
?>
<?php
include_once("../includes/main_header.php");
include_once('../includes/header.php');
?>
<!-- Carousel Start -->
<div class="carousel">
    <div class="container-fluid">
        <div class="owl-carousel">
            <div class="carousel-item">
                <div class="carousel-img">
                    <img src="../img/carousel-1.jpg" alt="Image">
                </div>
                <div class="carousel-text">
                    <h3>Washing & Detailing</h3>
                    <h1>Keep your Car Newer</h1>
                </div>
            </div>
            <div class="carousel-item">
                <div class="carousel-img">
                    <img src="../img/carousel-2.jpg" alt="Image">
                </div>
                <div class="carousel-text">
                    <h3>Washing & Detailing</h3>
                    <h1>Quality service for you</h1>

                </div>
            </div>
            <div class="carousel-item">
                <div class="carousel-img">
                    <img src="../img/carousel-3.jpg" alt="Image">
                </div>
                <div class="carousel-text">
                    <h3>Washing & Detailing</h3>
                    <h1>Exterior & Interior Washing</h1>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Carousel End -->

<!-- About Start -->
<div class="about" id="about">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="about-img">
                    <img src="../img/about.jpg" alt="Image">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="section-header text-left">
                    <p>About Us</p>
                    <h2>car washing and detailing</h2>
                </div>
                <div class="about-content">
                    <p>
                    Our  car washing system combines advanced technology with eco-friendly practices to deliver a superior clean. We use high-efficiency equipment and premium products to ensure your vehicle receives a thorough, gentle wash that enhances its shine while protecting the environment. Experience the ultimate in car care with us!
                    </p>
                    <ul>
                        <li><i class="far fa-check-circle"></i>Seats washing</li>
                        <li><i class="far fa-check-circle"></i>Vacuum cleaning</li>
                        <li><i class="far fa-check-circle"></i>Exterior wet cleaning</li>
                        <li><i class="far fa-check-circle"></i>Interior cleaning</li>
                        <li><i class="far fa-check-circle"></i>Window wiping</li>
                    </ul>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<!-- About End -->


<!-- Service Start -->
<div class="service">
    <div class="container">
        <div class="section-header text-center">
            <p>What We Do?</p>
            <h2>Car Washing Services</h2>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="service-item">
                    <i class="flaticon-car-wash-1"></i>
                    <h3>Exterior wet washing</h3>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="service-item">
                    <i class="flaticon-car-wash"></i>
                    <h3>Interior washing</h3>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="service-item">
                    <i class="flaticon-vacuum-cleaner"></i>
                    <h3>Vacuum cleaning</h3>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="service-item">
                    <i class="flaticon-seat"></i>
                    <h3>Seats washing</h3>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="service-item">
                    <i class="flaticon-car-service"></i>
                    <h3>Window wiping</h3>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="service-item">
                    <i class="flaticon-car-service-2"></i>
                    <h3>Wet cleaning</h3>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="service-item">
                    <i class="flaticon-car-wash"></i>
                    <h3>Oil changing</h3>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="service-item">
                    <i class="flaticon-brush-1"></i>
                    <h3>Brake reparing</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Service End -->


<!-- Facts Start -->
<div class="facts" data-parallax="scroll" data-image-src="img/facts.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="facts-item">
                    <i class="fa fa-users"></i>
                    <div class="facts-text">
                        <h3 data-toggle="counter-up">3</h3>
                        <p>Mechiners</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="facts-item">
                    <i class="fa fa-users"></i>
                    <div class="facts-text">
                        <h3 data-toggle="counter-up">15</h3>
                        <p>Workers</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="facts-item">
                    <i class="fa fa-users"></i>
                    <div class="facts-text">
                        <h3 data-toggle="counter-up">1000</h3>
                        <p>Happy clients</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="facts-item">
                    <i class="fa fa-check"></i>
                    <div class="facts-text">
                        <h3 data-toggle="counter-up">1000</h3>
                        <p>Works completed</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Facts End -->

<!-- Package Start -->
<div class="price" id="washing-plans">
    <div class="container">
        <div class="section-header text-center">
            <p>Washing Plans</p>
            <h2>Choose Your Plan</h2>
        </div>
        <div class="row">
            <?php
            if ($packages->num_rows > 0) {
                $packages->data_seek(0);
                while ($package = $packages->fetch_assoc()) {
            ?>
                    <div class="col-md-3">
                        <div class="price-item">
                            <div class="price-header">
                                <h3><?php echo $package['package_name'] ?></h3>
                            </div>
                            <div class="price-body">
                                <ul>
                                    <?php
                                    if (isset($packages_plans[$package['package_id']])) {
                                        foreach ($packages_plans[$package['package_id']] as $planName) {
                                    ?>
                                            <li><i class="far fa-check-circle"></i><?php echo htmlspecialchars($planName); ?></li>
                                    <?php }
                                    } ?>
                                </ul>
                            </div>
                            <!-- <div class="price-footer">
                                <a class="btn btn-custom" data-toggle="modal" data-target="#myModal">Book Now</a>
                            </div> -->
                        </div>
                    </div>
            <?php }
            } ?>
        </div>
    </div>
</div>
<!-- Price End -->

<!-- Package Price Start -->
<div id="price" class="price">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="text-center">Prices</h2>            
        </div>        
        <div class="row mb-4" style="font-size:20px;">
            <div class="col">
                Normal - 4 seats and above <b>|</b>&nbsp; Medium - 6 seats and above <b>|</b>&nbsp; Large - 15 seats and above <b>|</b>&nbsp; Extra Large - 25 seats and above 
            </div>
        </div>
        <div class="row price-item">
            <?php
            while ($price = $prices->fetch_assoc()) { ?>
                <div class="col-md-3 mb-3">
                    <div class="card p-3 pb-0">
                        <div class="">
                            <div class="">
                                <h3><?php echo $price['package_name'] ?> - <?php echo $price['car_size_name'] ?></h3>
                                <span>MMK</span><strong><?php echo $price['price'] ?></strong>
                            </div>
                        </div>
                        <div class="price-footer">
                            <a href="#booking" onclick="book(<?php echo $price['car_size_id'].','.$price['package_id'].','.$price['price'] ?>)" class="btn btn-custom">Book Now</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<!-- Package Price End -->

<!-- Booking Form Start -->
<div id="booking">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="text-center">Book For Today</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4">
                    <form method="post" enctype="multipart/form-data">
                        <div class="row mb-2">
                            <div class="col">
                                <label> Car Size </label>
                            </div>
                            <div class="col">
                                <select name="car-size" id="booking_car" class="form-control">
                                    <option value="00">Select your car size.</option>
                                    <?php
                                    while ($size = $car_sizes->fetch_assoc()) { ?>
                                        <option <?php if($car_size_id == $size['car_size_id']) echo 'selected';?> value="<?php echo $size['car_size_id'] ?>"><?php echo $size['car_size_name'] ?></option>
                                    <?php } ?>
                                </select>
                                <small class="text-danger"><?php echo $car_size_err ?></small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label> Package </label>
                            </div>
                            <div class="col">
                                <select name="package" id="booking_package" class="form-control">
                                    <option value="00">Choose package.</option>
                                    <?php
                                    while ($package = $booking_packages->fetch_assoc()) { ?>
                                        <option <?php if($package_id == $package['package_id']) echo 'selected';?> value="<?php echo $package['package_id'] ?>"><?php echo $package['package_name'] ?></option>
                                    <?php } ?>
                                </select>
                                <small class="text-danger"><?php echo $package_err ?></small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label> Booking Time </label>
                            </div>
                            <div class="col">
                                <select name="time" class="form-control" id="booking_time">
                                    <option value="00">Select time.</option>
                                    <?php
                                    while ($time = $booking_times->fetch_assoc()) { ?>
                                        <option value="<?php echo $time['schedule_id'] ?>"><?php echo $time['schedule_hour'] ?></option>
                                    <?php } ?>
                                </select>
                                <small class="text-danger"><?php echo $time_err ?></small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label> Price </label>
                            </div>
                            <div class="col" id="booking-price">
                                
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <input type="checkbox" value="1" name="taxi" id="taxi" onchange="calculateForTaxi()"> Taxi ?
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button type="button" class="btn btn-primary" class="booked" name="book" data-bs-toggle="modal" data-bs-target="#exampleModal"> Book </button>
                            </div>
                        </div>
                        <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Choose Payment Method</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mb-2">
            <div class="col-5">
        <input type="radio" name="pay_method" value="Kpay"> Kpay - 09782611064<br> (Phyoe Thinzar Soe)
            </div>
            <div class="col">
        <img src="../img/kpay.jpeg" alt="kpay" style="max-width: 70%;">

            </div>
        </div>
        <div class="row mb-2">
            <div class="col-5">
        <input type="radio" name="pay_method" value="Wavepay"> Wave pay - 09782611064<br> (Phyoe Thinzar Soe)
            </div>
            <div class="col">
        <img src="../img/wavepay.jpeg" alt="wave pay" style="max-width: 70%;">

            </div>
        </div>
        <div class="row">
            <div class="col">
            <input type="radio" name="pay_method" value="KbzBanking"> KBZ banking - 01357890985462189
            </div>
        </div>
        <div class="row">
            <div class="col">
            <input type="radio" name="pay_method" value="AyaBanking"> AYA banking - 05357890985462189
            </div>
        </div>
      </div>
      <div class="modal-footer">
        Upload money transfer screenshot
        <input type="file" name="paymentss" class="form-control">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" name="submit">Submit Payment</button>
      </div>
    </div>
  </div>
</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Booking Form End -->

<script>
    const selectBox = document.getElementById('booking_car');
    const packageSelectBox =document.getElementById('booking_package');
    const timeSelectBox =document.getElementById('booking_time');
    const carTypeSelectBox =document.getElementById('car_type');
    const booking_price = document.getElementById('booking-price');
    function book(car_id,package_id,price) {        
        for (let i = 1; i < selectBox.options.length; i++) {
            var option = selectBox.options[i];
            if(option.value == car_id) {
                selectBox.selectedIndex = i;
                break;
            }
        }

        for (let i = 1; i < packageSelectBox.options.length; i++) {
            var option = packageSelectBox.options[i];
            console.log(option.value === package_id);
            if(option.value == package_id) {
                packageSelectBox.selectedIndex = i;
                break;
            }
        }

        booking_price.innerHTML = `<input type="number" class="form-control" name="booking-price" value="${price}">`;

    }
    let selectionsMade = 0;
        selectBox.addEventListener('change', updatePrice);
        packageSelectBox.addEventListener('change', updatePrice);
        timeSelectBox.addEventListener('change', updatePrice);

        function updatePrice() {
            console.log(selectionsMade);
            selectionsMade++;
            const carSize = selectBox.value;
            const package = packageSelectBox.value;
            const bookingTime = timeSelectBox.value;
            if (carSize && package) {
                
                calculatePrice(carSize, package, bookingTime);
            }
        }

        const taxi = document.getElementById('taxi');
        var initial_price;
            function calculateForTaxi() {
                var price = document.getElementById('sub-price');
                if(price) {
                if(!initial_price) initial_price = price.value;
                    console.log(price.value);
                    var origin_price = initial_price;
                    if(taxi.checked) {
                        console.log("checked");
                        var total_price = origin_price - (origin_price * 0.05);
                        price.value = total_price;
                        console.log("final"+ price.value);
                    } else {
                        console.log("unchecked");
                        price.value = origin_price;
                    }
            }
        }

        function calculatePrice(carSize, package, bookingTime) {
            const url = `calculate_price.php?carSize=${carSize}&package=${package}&bookingTime=${bookingTime}`;
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    booking_price.innerHTML = `<input type="number" id="sub-price" class="form-control" name="booking-price" value="${data.price}">`;
                    initial_price = document.getElementById('sub-price').value;
                    calculateForTaxi();
                })
                .catch(error => {
                    console.error('Error fetching price:', error);
                });
        }

        
</script>

<?php require_once('../includes/footer.php'); ?>
<!-- JavaScript Libraries -->
<script src="../lib/jquery/jquery.min.js"></script>
<script src="../lib/easing/easing.min.js"></script>
<script src="../lib/owlcarousel/owl.carousel.min.js"></script>
<script src="../lib/waypoints/waypoints.min.js"></script>
<script src="../lib/counterup/counterup.min.js"></script>
<script src="../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>

<!-- Template Javascript -->
<script src="../js/main.js"></script>
</body>

</html>
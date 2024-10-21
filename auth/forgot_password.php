<?php
require_once("../storage/user_db.php");
require_once("../storage/db.php");
if (isset($_COOKIE['user'])) {
    $user = json_decode($_COOKIE['user'], true);
    if ($user['is_admin']) {
        header("Location:../admin/index.php");
    } else {
        header("Location:../user/index.php");
    }
}

$email = $password = "";
$email_err = $password_err = "";
$validate = true;
$success = false;
$invalid = false;

if (isset($_POST['login'])) {
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);
    if ($email === "") {
        $validate = false;
        $email_err = "Email must not be blank!";
    }
    if ($password === "") {
        $validate = false;
        $password_err = "Password must not be blank!";
    }

    if ($validate) {
        $db_user = get_user_by_email($mysqli, $email);
        if ($db_user) {
            $match = password_verify($password, $db_user['password']);
            if ($match) {
                var_dump("match");
                $success = true;
                setcookie("user", json_encode($db_user), time() + 3600 * 24 * 7, '/');
                if ($db_user['is_admin']) {
                    header("Location: ../admin/index.php");
                } else {
                    header("Location: ../user/index.php");
                }
            } else {
                $invalid = true;
            }
        } else {
            $invalid = true;
        }
    }
}
?>

<?php 
include_once("../includes/main_header.php");
include_once('../includes/header.php');
?>
    <div class="container">
        <div class="form-container">
            <div class="row justify-content-center mt-5 pt-3">
                <div class="col-xs-10 col-md-10 colcol-md-8 col-lg-6">
                    <div class="card bg-light">
                        <div class="row p-4 justify-content-center">
                            <h2 class="h2 text-center auth-header">Forgot Password?</h2>
                            <?php
                        if ($invalid) { ?> <div class="alert alert-danger"><?php echo $invalid ?> </div> <?php } ?>
                    
                    <form method="post">
                                <?php
                                if ($invalid) echo '<div class="alert alert-danger">Invalid email or password!</div>';
                                ?>
                                <div class="row py-2">
                                    <div class="col-3">
                                        <label for="email">Email Address</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="email" class="form-control" id="email" placeholder="Enter your email address" name="email">
                                        <small class="text-danger"> <?php echo $email_err ?></small>
                                    </div>
                                </div>

                                <div class="row justify-content-between pt-2">
                                    <span class="float-end w-auto"><a class="text-decoration-none link-primary" href="./forgot_password.php">Forgot Password?</a></span>
                                </div>
                                <div class="row py-1">
                                    <div class="col-12">
                                        <button class="auth-btn w-100 py-2 text-white no-border" type="submit" class="btn" name="login">Sign In</button>
                                    </div>
                                </div>
                            </form>
                            <div class="row justify-content-center">
                                <span class="w-auto">If you don't have an account? <a class="text-decoration-none link-primary" href="./signup.php">Signup here.</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="../lib/easing/easing.min.js"></script>
        <script src="../lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="../lib/waypoints/waypoints.min.js"></script>
        <script src="../lib/counterup/counterup.min.js"></script>

        <!-- Template Javascript -->
        <script src="../js/main.js"></script>
</body>
</html>
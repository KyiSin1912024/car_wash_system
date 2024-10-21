<?php
require_once("../storage/db.php");
require_once("../storage/user_db.php");
if (isset($_COOKIE['user'])) {
    $user = json_decode($_COOKIE['user'], true);
    if ($user['is_admin']) {
        header("Location:../admin/index.php");
    } else {
        header("Location:../index.php");
    }
}

$u_name = $email = $phone = $password = $con_password = "";
$u_name_err = $email_err = $phone_err = $password_err = $con_password_err = "";
$validate = true;
$success = false;
$invalid = false;

if (isset($_POST['signup'])) {
    $u_name = htmlspecialchars($_POST["u_name"]);
    $email = htmlspecialchars($_POST["email"]);
    $phone = htmlspecialchars($_POST["phone"]);
    $password = htmlspecialchars($_POST["password"]);
    $con_password = htmlspecialchars($_POST["con_password"]);
    if ($u_name === "") {
        $validate = false;
        $u_name_err = "Name must not be blank!";
    }
    if ($email === "") {
        $validate = false;
        $email_err = "Email must not be blank!";
    }
    if ($phone === "") {
        $validate = false;
        $phone_err = "Phone No must not be blank!";
    }
    if ($password === "") {
        $validate = false;
        $password_err = "Password must not be blank!";
    }

    if ($con_password === "") {
        $validate = false;
        $con_password_err = "Password must not be blank!";
    }

    if ($password !==  $con_password) {
        $validate = false;
        $con_password_err = "Confirm password must be match with password!";
    }

    if ($validate) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $status = save_user($mysqli, $u_name, $email, $phone, $password_hash);
        if ($status) {
            $success = true;
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
            <div class="row justify-content-center my-5 py-2">
                <div class="col-xs-10 col-md-10 colcol-md-8 col-lg-6">
                    <div class="card bg-light">
                        <div class="row p-4 justify-content-center">
                            <h2 class="h2 text-center auth-header">Register</h2>

                            <form method="post">
                                <?php
                                    if ($success) echo '<div class="alert alert-secondary">User Registeration Done!</div>';
                                    if ($invalid) echo '<div class="alert alert-danger">Invalid Registeration!</div>';
                                ?>
                                <div class="row py-2 mt-2">
                                    <div class="col-3">
                                        <label for="name">Name </label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="name" placeholder="Enter your name" name="u_name">
                                        <small class="text-danger"> <?php echo $u_name_err ?></small>
                                    </div>
                                </div>
                                <div class="row py-2">
                                    <div class="col-3">
                                        <label for="email">Email </label>
                                    </div>
                                    <div class="col-9">
                                        <input type="email" class="form-control" id="email" placeholder="Enter your email address" name="email">
                                        <small class="text-danger"> <?php echo $email_err ?></small>
                                    </div>
                                </div>
                                <div class="row py-2">
                                    <div class="col-3">
                                        <label for="phone">Phone No </label>
                                    </div>
                                    <div class="col-9">
                                        <input type="number" class="form-control" id="phone" placeholder="Enter your phone" name="phone">
                                        <small class="text-danger"> <?php echo $phone_err ?></small>
                                    </div>
                                </div>
                                <div class="row py-2">
                                    <div class="col-3">
                                        <label for="password">Password</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="password" class="form-control" id="password" placeholder="Enter your password" name="password">
                                        <small class="text-danger"> <?php echo $password_err ?></small>
                                    </div>
                                </div>
                                <div class="row py-2">
                                    <div class="col-3">
                                        <label for="con_password">Confirm Password</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="password" class="form-control" id="con_password" placeholder="Retype password" name="con_password">
                                        <small class="text-danger"> <?php echo $con_password_err ?></small>
                                    </div>
                                </div>
                                <div class="row py-2">
                                    <div class="col-12 pt-2">
                                        <button class="auth-btn w-100 py-2 text-white no-border" type="submit" class="btn" name="signup">Sign Up</button>
                                    </div>
                                </div>
                            </form>
                            <div class="row justify-content-center">
                                <span class="w-auto">If you have already account? <a class="text-decoration-none link-primary" href="./login.php">Login here.</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>
<?php
require_once('../includes/config.php');
$user = get_user_by_id($mysqli, $user['user_id']);
$user_id = $created_at = $invalid = "";
$time_interval = "";
$validate = true;
$name_err = $email_err = $phone_err = $image_err = "";
if (isset($_GET['user_id'])) $user_id = $_GET['user_id'];
if ($user) $created_at = new DateTime($user['created_at']);
$name = $user['name'];
$email = $user['email'];
$phone = $user['ph_no'];
$image = $user['image'];

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $image = $_FILES['profile-img']['name'];
    $img = $_FILES['profile-img']['tmp_name'];

    if (empty($name)) {
        $validate = false;
        $name_err = "Name mustn't be blank.";
    }
    if (empty($email)) {
        $validate = false;
        $email_err = "Email mustn't be blank.";
    }
    if (empty($phone)) {
        $validate = false;
        $phone_err = "Phone Number mustn't be blank";
    }
    if (!empty($image)) {
        if (!str_contains($_FILES['profile-img']['type'], 'image/')) {
            $validate = false;
            $image_err = "Only image can be accepted!";
        }
    }
    if ($validate) {
        if ($image) {
            $result = update_user($mysqli, $user['user_id'], $name, $email, $phone, $image);
            if ($result) {
                try {
                    move_uploaded_file($img, "../upload/" . $image);
                } catch (\Throwable $th) {
                    $image_err = "Image upload error!";
                    $status = false;
                }
            }
        } else $result = update_user($mysqli, $user['user_id'], $name, $email, $phone);
        if ($result) {
            $update_user = get_user_by_id($mysqli, $user['user_id']);
            setcookie("user", json_encode($update_user), time() + 3600 * 24 * 7, '/');
            header('location: ./profile.php');
        } else {
            $invalid = "Fail to update profile.";
        }
    }
}

require_once('./layout/header.php');

?>
<style>
    * {
        margin: 0;
        padding: 0
    }

    .profile {
        margin-top: 7%;
    }

    .image img {
        transition: all 0.5s
    }

    .image img:hover {
        transform: scale(1.5)
    }

    .btn-img {
        height: 140px;
        width: 140px;
        border-radius: 50%;
        border: none;
        background-color: transparent;
    }

    .name {
        font-size: 22px;
        font-weight: bold
    }

    .idd {
        font-size: 14px;
        font-weight: 600
    }

    .idd1 {
        font-size: 12px
    }

    .number {
        font-size: 22px;
        font-weight: bold
    }

    .follow {
        font-size: 12px;
        font-weight: 500;
        color: #444444
    }

    .btn1 {
        height: 40px;
        width: 150px;
        border: none;
        background-color: #000;
        color: #aeaeae;
        font-size: 15px
    }

    .text span {
        font-size: 13px;
        color: #545454;
        font-weight: 500
    }

    .icons i {
        font-size: 19px
    }

    hr .new1 {
        border: 1px solid;
    }

    .join {
        font-size: 14px;
        color: #a0a0a0;
        font-weight: bold;
    }

    .date {
        background-color: #ccc
    }

    label {
        background-color: #444444;
        color: white;
        padding: 0.3rem;
        font-family: sans-serif;
        border-radius: 0.3rem;
        cursor: pointer;
        margin-top: 1rem;
    }
</style>
<div class=" profile mb-4 mb-4 p-3 row justify-content-center">
    <div class="col-6">
    <div class="card p-4">
                <?php if ($invalid) { ?> <span class="text-danger"><?php echo $invalid ?></span> <?php } ?>
                <?php if ($user_id) { ?>
                    <form method="post" enctype="multipart/form-data">
                        <div class=" image d-flex flex-column justify-content-center align-items-center">
                            <?php if ($image) { ?>
                                <button class="btn-img btn-secondary"> <img src="../upload/<?php echo $user['image'] ?>" height="100" width="100" /></button>
                            <?php } else { ?>
                                <button class="btn-img btn-secondary"> <img src="./assets/images/profile/no-image.jpg"" height="100" width="100" /></button>
                            <?php } ?>

                            <input type="file" id="actual-btn" name="profile-img" hidden />

                            <!--our custom file upload button-->
                            <label for="actual-btn">Choose File</label>
                            <small class="text-danger mb-2"><?php echo $image_err ?></small>
                            <input style="padding: 2px;" type="text" class="text-center" name="name" value="<?php echo $name ?>"></input>
                            <small class="text-danger mb-2"><?php echo $name_err ?></small>
                            <input style="padding: 2px;" type="text" class="text-center" name="email" value="<?php echo $email ?>"></input>
                            <small class="text-danger mb-2"><?php echo $email_err ?></small>
                            <input style="padding: 2px;" type="text" class="text-center" name="phone" value="<?php echo $phone ?>"></input>
                            <small class="text-danger mb-2"><?php echo $phone_err ?></small>
                            <div class=" px-2 rounded my-2 date text-center"> <span class="dd1">Joined <?php echo $created_at->format('Y-m-d') ?></span> </div>
                            <div class=" d-flex mt-2 justify-content-center">

                                <button type="submit" name="update" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                <?php } else {
                ?>
                    <div class=" image d-flex flex-column justify-content-center align-items-center">
                        <?php if ($image) { ?>
                            <button class="btn-img btn-secondary"> <img src="../upload/<?php echo $user['image'] ?>" height="100" width="100" /></button>
                        <?php } else { ?>
                            <button class="btn-img btn-secondary"> <img src="./assets/images/profile/no-image.jpg" height="100" width="100" /></button>
                        <?php } ?>
                        <span class="name mt-3"><?php echo $user['name'] ?></span>
                        <span class="idd"><?php echo $user['email'] ?></span>
                        <span class="idd1"><?php echo $user['ph_no'] ?></span>
                        <div class=" px-2 rounded my-2 date text-center"> <span class="dd1">Joined <?php echo $created_at->format('Y-m-d') ?></span> </div>
                        <div class=" mt-2"> <a href="./profile.php?user_id=<?php echo $user['user_id'] ?>" class="btn btn-primary">Edit Profile</a> </div>
                    </div>
                <?php } ?>
            </div>
    </div>
            


</div>
<?php require_once('./layout/footer.php'); ?>
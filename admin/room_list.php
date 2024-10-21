<?php
    require_once("../includes/config.php");
    $rooms = get_all_rooms($mysqli);

    $success = $msg = "";
    if (isset($_GET["success"])) $success = $_GET["success"];

    if (isset(($_GET["room_id"]))) {
        $status = delete_room($mysqli, $_GET["room_id"]);
        if($status) {
            header("Location: ./room_list.php?success=Successfully deleted.");
        } else {
            $invalid = "Failed to delete.";
        }
    }

    require_once("./layout/header.php"); ?>
    <div class="row justify-content-between">
    <div class="col-auto pagetitle my-4">
        <h1>Room List</h1>
    </div><!-- End Page Title -->
    <div class="col-auto my-4">
        <a href="./add_room.php" class="custom-btn primary-btn btn-hover"><small><i class="fa-solid fa-plus"></i></small> &nbsp; Add room</a>
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
                    <th>Room Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i = 0;
                    while ($room = $rooms->fetch_assoc()) {
                ?>
                        <tr>
                            <td> <?php echo ++$i; ?> </td>
                            <td> <?php echo $room['room_no'] ?></td>
                            <td class="text-center"><a href="edit_room.php?room_id=<?php echo $room['room_id'] ?>"><i class="fa-solid fa-pen-to-square text-secondary me-3"></i></a> | <a href="room_list.php?room_id=<?php echo $room['room_id'] ?>" onclick="return confirm('Are you sure want to delete?')"><i class="ms-3 fa-solid fa-trash text-danger"></i></a></td>
                        </tr>
                    <?php
                    } ?>
                </tbody>
        </table>
    </div>
    <?php require_once("./layout/footer.php"); ?>
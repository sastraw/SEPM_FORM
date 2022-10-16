<?php
require_once '../app/Config/config.php';
require_once '../app/Controller/registerMemberController.php';
session_start();
?>

<?php

use app\Controller\registerMemberController;

$memberController = new registerMemberController;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $store_data = $memberController->storeMember();
    die;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Header -->
    <?php require_once 'components/_header.php' ?>
</head>

<body>
    <?php require_once 'components/_navbar.php' ?>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12 col-sm-offset-1 mb-5" id="two">
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" name="save">
                    <div class="col-sm-12 form-group pt-3">
                        <h3 class="text-center pb-5">Add your data</h3>
                    </div>
                    <?php
                    if (isset($_SESSION['notification']) && $_SESSION['notification'] !== "") {
                        $element = '';
                        $element .= '<div class="alert alert-danger" role="alert">';
                        $element .= $_SESSION['notification'];
                        $element .= "</div>";
                        echo $element;
                        unset($_SESSION['notification']);
                    }

                    if (isset($_SESSION['success']) && $_SESSION['success'] !== "") {
                        $element = '';
                        $element .= '<div class="alert alert-success" role="alert">';
                        $element .= $_SESSION['success'];
                        $element .= "</div>";
                        echo $element;
                        unset($_SESSION['success']);
                    }
                    ?>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" name="first_name" class="form-control transform-custom-1" id="first_name">
                            </div>
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" name="last_name" class="form-control transform-custom-1" id="last_name">
                            </div>
                            <div class="mb-3">
                                <label for="student_id" class="form-label">Student Id</label>
                                <input type="text" name="student_id" class="form-control" id="student_id">
                            </div>
                            <div class="mb-3">
                                <label for="class" class="form-label">Your Workspace</label>
                                <select class="form-select" id="class" onchange="selectClass(this.value)" name="class" aria-label="Default select example">
                                    <option value=""> -- Select Workspace --</option>
                                    <?php
                                    $file_to_read = fopen("../database/General/all_class.csv", "r");
                                    if ($file_to_read !== FALSE) {
                                        while (($data = fgetcsv($file_to_read)) !== FALSE) {
                                            foreach ($data as $i) {
                                                echo '<option class="text-capitalize" value="' . $data[0] . '">' . $data[1] . '</option>';
                                                break;
                                            }
                                        }
                                        fclose($file_to_read);
                                    }
                                    ?>

                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="friend" class="form-label">Your Friend In Selected Workspace (Optional)</label>
                                <select class="form-select" id="friend" name="friend" aria-label="Default select example">

                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="platform" class="form-label">You Preffered Platform</label>
                                <select class="form-select" name="platform" id="platform" aria-label="Default select example">
                                    <option value=""> -- Select Platform --</option>
                                    <option value="website">Website</option>
                                    <option value="desktop">Desktop</option>
                                    <option value="mobile">Mobile</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="day" class="form-label">Work Day</label>
                                <select class="form-select" name="day" id="day" aria-label="Default select example">
                                    <option value=""> -- Select Day --</option>
                                    <option value="monday">Monday</option>
                                    <option value="tuesday">Tuesday</option>
                                    <option value="wednesday">Wednesday</option>
                                    <option value="thursday">Thursday</option>
                                    <option value="friday">Friday</option>
                                    <option value="saturday">Saturday</option>
                                    <option value="sunday">Sunday</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="time" class="form-label">Working Time</label>
                                <select class="form-select" name="time" id="time" aria-label="Default select example">
                                    <option value=""> -- Select Time --</option>
                                    <option value="night">At Night</option>
                                    <option value="day">At Day</option>
                                </select>
                            </div>
                        </div>
                        <div class="text-center pe-3">
                            <button type="submit" name="save" class="btn bg-custom-1 text-custom-1 m-2 col-12">Submit Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End contact Section  -->
    <?php require_once 'components/_script.php' ?>
    <?php require_once 'components/_customJs.php' ?>
</body>

</html>
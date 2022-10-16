<?php 
require_once '../app/Config/config.php'; 
require_once '../App/Controller/uploadFileController.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $login = (new UploadFile())->store();
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
        <div class="row it d-flex justify-content-center">
            <br>
            <div class="col-sm-offset-1 col-sm-5" id="one">
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="needs-validation" name="save"
                    novalidate="" autocomplete="off" enctype="multipart/form-data">
                    <div class="col-sm-12 form-group pt-3">
                        <h3 class="text-center">Set your workspace file</h3>
                    </div>
                    <div id="uploader">
                        <div class="row uploadDoc">
                            <div class="col-sm-12">
                                <?php
                                    if (isset($_SESSION['success'])) {
                                      echo $_SESSION['success'];
                                      unset($_SESSION['success']);
                                    }
                                ?>
                                <label for="class_name" class="form-label">Workspace</label>
                                <input type="text" class="form-control text-capitalize" name="class_name">
                                <?php
                                  if (isset($_SESSION['message'])) {
                                    echo $_SESSION['message'];
                                    unset($_SESSION['message']);
                                  }
                                ?>
                            </div>
                            <div class="col-sm-12 mt-4">
                                <label for="file" class="form-label">File (.csv)</label>
                                <div class="fileUpload btn btn-orange">
                                    <img src="https://www.kindpng.com/picc/m/261-2619141_cage-clipart-victorian-cloud-upload-icon-svg-hd.png"
                                        class="icon">
                                    <span class="upl" id="file-upload-filename">No file selected</span>
                                    <input type="file" name="file" class="upload up" id="file-upload" accept=".csv" />
                                </div>
                                <?php
                                    if (isset($_SESSION['files'])) {
                                        echo $_SESSION['files'];
                                        unset($_SESSION['files']);
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="text-center pe-3">
                        <button type="submit" name="save"
                            class="btn bg-custom-1 text-custom-1 m-2 col-12">Submit</button>
                    </div>
            </div>
        </form>
    </div>
        <?php require_once 'components/_script.php' ?>
</body>

</html>
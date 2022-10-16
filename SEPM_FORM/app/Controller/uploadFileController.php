<?php

class UploadFile
{
    public $file_name;
    public $class_name;
    public $data;

    public function __construct()
    {
        $this->file_name = @htmlentities(strtolower($_POST['file_name']));
        $this->class_name = @htmlentities(strtolower($_POST['class_name']));
    }

    public function store()
    {
        if (isset($_POST['save'])) {
            $getData = file_get_contents("../database/General/all_class.csv");
            $data = explode("\n", $getData);
            $status = false;
            foreach ($data as $row => $data) {
                $row_class_name = explode(',', $data);
                $data_class_name = trim(strtolower($row_class_name[1]), '"');
                if ($data_class_name == strtolower($_POST['class_name'])) {
                    $status = true;
                    break;
                }
            }
            if (empty($class_name = $_POST['class_name']) || $_FILES['file']['size'] == 0) {
                $_SESSION['message'] = '<div style="color:red;">Workspace cannot be empty</div>';
                $_SESSION['files'] = '<div style="color:red;">Please select a valid file (.csv)</div>';
                header("Location: index.php");
            } else {
                if (!$status) {
                    if (isset($_FILES['file'])) {
                        $id = uniqid();
                        $class_name = $_POST['class_name'];
                        $file_name =  $_FILES['file']['name'];
                        $tmp_name = $_FILES['file']['tmp_name'];
                        $file_up_name = date('dmyYHis') . "_" . $file_name;
                        move_uploaded_file($tmp_name, "../database/Uploaded/" . $file_up_name);
                        $date = date("Y-m-d H:i:s");
                        $arrdata = array($id, ucfirst($class_name), $file_up_name, $date);
                        $fp = fopen('../database//General/all_class.csv', 'a+');
                        $create = fputcsv($fp, $arrdata);
                        fclose($fp);
                        $_SESSION['success'] = '<div class="alert alert-success">Success, successfully input data into data record</div>';
                        header("Location: index.php");
                    }
                } else {
                    $class_name = $_POST['class_name'];
                    $_SESSION['message'] = '<div style="color:red;">' . $class_name . ' is already in the record data</div>';
                    header("Location: index.php");
                }
            }
        }
    }
}

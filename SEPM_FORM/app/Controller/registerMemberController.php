<?php

namespace app\Controller;

require_once '../app/Services/generateGroupMemberService.php';

use app\Services\generateGroupMemberService;

class registerMemberController
{
    public $generateGroupMemberService;
    public function __construct()
    {
        $this->generateGroupMemberService = new generateGroupMemberService();
    }

    public function storeMember()
    {
        $request = $_REQUEST;
        if (!empty($request['first_name']) && !empty($request['last_name']) && !empty($request['student_id']) && !empty($request['class']) && !empty($request['day']) && !empty($request['time']) && !empty($request['platform'])) {
            $friend = isset($request['friend']) ? $request['friend'] : null;
            $group_member = $this->generateGroupMemberService->logic(
                $request['student_id'],
                $request['class'],
                $friend,
                $request['platform'],
                $request['day'],
            );
            if ($group_member == 400) {
                $_SESSION['notification'] = 'Student Id Already Used, Please Check Your Input';
                return header("Location: member.php");
            } else if ($group_member == 401) {
                $_SESSION['notification'] = 'Friend Not Found, Choose Other';
                return header("Location: member.php");
            } else if ($group_member == 402) {
                $_SESSION['notification'] = 'All Group In This Workspace Is Full';
                return header("Location: member.php");
            }
            // store data here, we get group member
            // 1. Get Class By $request->class
           
            if (isset($_POST['class'])) {
                $class_file = null;
                $file_to_read = fopen("../database/General/all_class.csv", "r");
                if ($file_to_read !== FALSE) {
                    while (($data = fgetcsv($file_to_read)) !== FALSE) {
                        foreach ($data as $i) {
                            if ($data[0] == $_POST['class']) {
                                $class_file = $data[2];
                                $class_name = $data[1];
                            }
                            break;
                        }
                    }
                    fclose($file_to_read);
                }
                // 2. Store to clas file csv
                $filename = "../database/Uploaded/" . $class_file . "";
                if (isset($_POST['save'])) {
                    $id = uniqid();
                    $first_name = $_POST['first_name'];
                    $last_name = $_POST['last_name'];
                    $student_id = $_POST['student_id'];
                    $class_id = $_POST['class'];
                    $day = $_POST['day'];
                    $time = $_POST['time'];
                    $platform = $_POST['platform'];
                    $date = date("Y-m-d H:i:s");
                    $arrdata = array($id, $student_id, ucfirst($first_name), ucfirst($last_name), ucfirst($class_name), ucfirst($group_member), ucfirst($platform), ucfirst($day), ucfirst($time), $date);
                    $fp = fopen($filename, 'a+');
                    $create = fputcsv($fp, $arrdata);
                    fclose($fp);
                    $_SESSION['success'] = 'Successfully input data into data record';
                    return header("Location: member.php");
                }
            }
        } else {
            $_SESSION['notification'] = 'Please fill in the required data';
            return header("Location: member.php");
        }
    }
}

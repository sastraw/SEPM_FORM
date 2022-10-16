<?php

namespace app\Services;

class generateGroupMemberService
{
    public $max_person_in_one_group;

    public function __construct()
    {
        $this->max_person_in_one_group = 5;
    }

    public function logic(
        string $studentID,
        string $class,
        string $friend = NULL,
        string $platform,
        string $day,
    ) {
        $class_file = null;
        $file_to_read = fopen("../database/General/all_class.csv", "r");
        if ($file_to_read !== FALSE) {
            while (($data = fgetcsv($file_to_read)) !== FALSE) {
                foreach ($data as $i) {
                    if ($data[0] == $class) {
                        $class_file = $data[2];
                    }
                    break;
                }
            }
            fclose($file_to_read);
        }

        $filename = "../database/Uploaded/" . $class_file . "";
        $is_student_same = $this->getStudentData($filename, $studentID);
        if (!$is_student_same) {
            return 400;
        }

        if ($friend != NULL) {
            $get_friend_data = $this->getFriendData($filename, $friend);
            if (!$get_friend_data) {
                return 401;
            }

            $count_member_in_group = $this->countMemberInGroup($filename, $get_friend_data[5]);
            if ($count_member_in_group < $this->max_person_in_one_group) {
                $is_same_platform = $this->getMemberPlatformInGroup($filename, $get_friend_data[5], $platform);
                if (!$is_same_platform) {
                    $get_allow_group_by_platform = $this->getAllowGroupByPlatform($filename, $platform, $get_friend_data[5]);
                    if (!$get_allow_group_by_platform) {
                        $get_allow_group_by_day = $this->getAllowGroupByDay($filename, $day);
                        if (!$get_allow_group_by_day) {
                            $get_group_by_count = $this->getAllowGroupByCount($filename);
                            if (!$get_group_by_count) {
                                return 402;
                            }
                            return $get_group_by_count;
                        }
                        $count_member_in_day_group = $this->countMemberInGroup($filename, $get_allow_group_by_day);
                        if ($count_member_in_day_group < $this->max_person_in_one_group) {
                            return $get_allow_group_by_day;
                        }

                        $get_group_by_count = $this->getAllowGroupByCount($filename);
                        if (!$get_group_by_count) {
                            return 402;
                        }
                        return $get_group_by_count;
                    }
                    $count_member_in_platform_group = $this->countMemberInGroup($filename, $get_allow_group_by_platform);
                    if ($count_member_in_platform_group < $this->max_person_in_one_group) {
                        return $get_allow_group_by_platform;
                    }

                    $get_group_by_count = $this->getAllowGroupByCount($filename);
                    if (!$get_group_by_count) {
                        return 402;
                    }
                    return $get_group_by_count;
                }
                return $get_friend_data[5];
            } else {
                $get_allow_group_by_platform = $this->getAllowGroupByPlatform($filename, $platform, $get_friend_data[5]);
                if (!$get_allow_group_by_platform) {
                    $get_allow_group_by_day = $this->getAllowGroupByDay($filename, $day);
                    if (!$get_allow_group_by_day) {
                        $get_group_by_count = $this->getAllowGroupByCount($filename);
                        if (!$get_group_by_count) {
                            return 402;
                        }
                        return $get_group_by_count;
                    }
                    $count_member_in_day_group = $this->countMemberInGroup($filename, $get_allow_group_by_day);
                    if ($count_member_in_day_group < $this->max_person_in_one_group) {
                        return $get_allow_group_by_day;
                    }

                    $get_group_by_count = $this->getAllowGroupByCount($filename);
                    if (!$get_group_by_count) {
                        return 402;
                    }
                    return $get_group_by_count;
                }
                $count_member_in_platform_group = $this->countMemberInGroup($filename, $get_allow_group_by_platform);
                if ($count_member_in_platform_group < $this->max_person_in_one_group) {
                    return $get_allow_group_by_platform;
                }

                $get_group_by_count = $this->getAllowGroupByCount($filename);
                if (!$get_group_by_count) {
                    return 402;
                }
                return $get_group_by_count;
            }
        } else {
            $get_allow_group_by_platform = $this->getAllowGroupByPlatform($filename, $platform);
            if (!$get_allow_group_by_platform) {
                $get_allow_group_by_day = $this->getAllowGroupByDay($filename, $day);
                if (!$get_allow_group_by_day) {
                    $get_group_by_count = $this->getAllowGroupByCount($filename);
                    if (!$get_group_by_count) {
                        return 402;
                    }
                    return $get_group_by_count;
                }
                $count_member_in_day_group = $this->countMemberInGroup($filename, $get_allow_group_by_day);
                if ($count_member_in_day_group < $this->max_person_in_one_group) {
                    return $get_allow_group_by_day;
                }

                $get_group_by_count = $this->getAllowGroupByCount($filename);
                if (!$get_group_by_count) {
                    return 402;
                }
                return $get_group_by_count;
            }
            $count_member_in_platform_group = $this->countMemberInGroup($filename, $get_allow_group_by_platform);
            if ($count_member_in_platform_group < $this->max_person_in_one_group) {
                return $get_allow_group_by_platform;
            }

            $get_group_by_count = $this->getAllowGroupByCount($filename);
            if (!$get_group_by_count) {
                return 402;
            }
            return $get_group_by_count;
        }
    }

    public function getStudentData(string $filename, string $studentID)
    {
        if (!file_exists($filename)) {
            fopen($filename, "w");
        }

        $student_to_read = fopen($filename, "r");
        if ($student_to_read !== FALSE) {
            while (($student = fgetcsv($student_to_read)) !== FALSE) {
                foreach ($student as $i) {
                    if (strtolower($student[1]) == strtolower($studentID)) {
                        return false;
                        break;
                    }
                }
            }
            fclose($student_to_read);
            return true;
        }
    }

    public function getFriendData(string $filename, string $friend)
    {
        if (!file_exists($filename)) {
            fopen($filename, "w");
        }

        $student_to_read = fopen($filename, "r");
        if ($student_to_read !== FALSE) {
            while (($student = fgetcsv($student_to_read)) !== FALSE) {
                foreach ($student as $i) {
                    if (strtolower($student[0]) == strtolower($friend)) {
                        return $student;
                        break;
                    }
                }
            }
            fclose($student_to_read);
            return false;
        }
    }

    public function countMemberInGroup(string $filename, string $group_name)
    {
        if (!file_exists($filename)) {
            fopen($filename, "w");
        }
        $count_group = 0;
        $student_to_read = fopen($filename, "r");
        if ($student_to_read !== FALSE) {
            while (($student = fgetcsv($student_to_read)) !== FALSE) {
                foreach ($student as $i) {
                    if (strtolower($student[5]) == strtolower($group_name)) {
                        $count_group += 1;
                        break;
                    }
                }
            }
            fclose($student_to_read);
            return $count_group;
        }
    }

    public function getMemberPlatformInGroup(string $filename, string $group_name, string $platform)
    {
        if (!file_exists($filename)) {
            fopen($filename, "w");
        }
        $student_to_read = fopen($filename, "r");
        if ($student_to_read !== FALSE) {
            while (($student = fgetcsv($student_to_read)) !== FALSE) {
                foreach ($student as $i) {
                    if (
                        strtolower($student[5]) == strtolower($group_name) &&
                        strtolower($student[6]) == strtolower($platform)
                    ) {
                        return true;
                        break;
                    }
                }
            }
            fclose($student_to_read);
            return false;
        }
    }

    public function getAllowGroupByPlatform(string $filename, string $platform, string $except = null)
    {
        $group_1 = "not allow";
        $group_2 = "not allow";
        $group_3 = "not allow";
        $group_4 = "not allow";
        $group_5 = "not allow";
        $arr_group = [];
        if (!file_exists($filename)) {
            fopen($filename, "w");
        }

        $student_to_read = fopen($filename, "r");
        if ($student_to_read !== FALSE) {
            while (($student = fgetcsv($student_to_read)) !== FALSE) {
                foreach ($student as $i) {
                    if (
                        strtolower($student[5]) == strtolower("Group 1") &&
                        strtolower($student[6]) == strtolower($platform)
                    ) {
                        $group_1 = "allow";
                        break;
                    } else if (
                        strtolower($student[5]) == strtolower("Group 2") &&
                        strtolower($student[6]) == strtolower($platform)
                    ) {
                        $group_2 = "allow";
                        break;
                    } else if (
                        strtolower($student[5]) == strtolower("Group 3") &&
                        strtolower($student[6]) == strtolower($platform)
                    ) {
                        $group_3 = "allow";
                        break;
                    } else if (
                        strtolower($student[5]) == strtolower("Group 4") &&
                        strtolower($student[6]) == strtolower($platform)
                    ) {
                        $group_4 = "allow";
                        break;
                    } else if (
                        strtolower($student[5]) == strtolower("Group 5") &&
                        strtolower($student[6]) == strtolower($platform)
                    ) {
                        $group_5 = "allow";
                        break;
                    }
                }
            }
            fclose($student_to_read);

            if (strtolower($except) == strtolower("Group 1")) {
                $group_1 = "except";
            } else if (strtolower($except) == strtolower("Group 2")) {
                $group_2 = "except";
            } else if (strtolower($except) == strtolower("Group 3")) {
                $group_3 = "except";
            } else if (strtolower($except) == strtolower("Group 4")) {
                $group_4 = "except";
            } else if (strtolower($except) == strtolower("Group 5")) {
                $group_5 = "except";
            }

            array_push($arr_group, $group_1, $group_2, $group_3, $group_4, $group_5);
            if (array_search("allow", $arr_group) !== false) {
                return "Group " . array_search("allow", $arr_group) + 1;
            }
            return false;
        }
    }

    public function getAllowGroupByDay(string $filename, string $day)
    {
        $group_1 = "not allow";
        $group_2 = "not allow";
        $group_3 = "not allow";
        $group_4 = "not allow";
        $group_5 = "not allow";
        $arr_group = [];
        if (!file_exists($filename)) {
            fopen($filename, "w");
        }

        $student_to_read = fopen($filename, "r");
        if ($student_to_read !== false) {
            while (($student = fgetcsv($student_to_read)) !== false) {
                foreach ($student as $i) {
                    if (
                        strtolower($student[5]) == strtolower("Group 1") &&
                        strtolower($student[7]) == strtolower($day)
                    ) {
                        $group_1 = "allow";
                        break;
                    } elseif (
                        strtolower($student[5]) == strtolower("Group 2") &&
                        strtolower($student[7]) == strtolower($day)
                    ) {
                        $group_2 = "allow";
                        break;
                    } elseif (
                        strtolower($student[5]) == strtolower("Group 3") &&
                        strtolower($student[7]) == strtolower($day)
                    ) {
                        $group_3 = "allow";
                        break;
                    } elseif (
                        strtolower($student[5]) == strtolower("Group 4") &&
                        strtolower($student[7]) == strtolower($day)
                    ) {
                        $group_4 = "allow";
                        break;
                    } elseif (
                        strtolower($student[5]) == strtolower("Group 5") &&
                        strtolower($student[7]) == strtolower($day)
                    ) {
                        $group_5 = "allow";
                        break;
                    }
                }
            }
            fclose($student_to_read);

            array_push($arr_group, $group_1, $group_2, $group_3, $group_4, $group_5);
            if (array_search("allow", $arr_group) !== false) {
                return "Group " . array_search("allow", $arr_group) + 1;
            }
            return false;
        }
    }

    public function getAllowGroupByCount(string $filename)
    {
        $group_1 = 0;
        $group_2 = 0;
        $group_3 = 0;
        $group_4 = 0;
        $group_5 = 0;
        if (!file_exists($filename)) {
            fopen($filename, "w");
        }

        $student_to_read = fopen($filename, "r");
        if ($student_to_read !== false) {
            while (($student = fgetcsv($student_to_read)) !== false) {
                foreach ($student as $i) {
                    if (
                        strtolower($student[5]) == strtolower("Group 1")
                    ) {
                        $group_1 += 1;
                        break;
                    } elseif (
                        strtolower($student[5]) == strtolower("Group 2")
                    ) {
                        $group_2 += 1;
                        break;
                    } elseif (
                        strtolower($student[5]) == strtolower("Group 3")
                    ) {
                        $group_3 += 1;
                        break;
                    } elseif (
                        strtolower($student[5]) == strtolower("Group 4")
                    ) {
                        $group_4 += 1;
                        break;
                    } elseif (
                        strtolower($student[5]) == strtolower("Group 5")
                    ) {
                        $group_5 += 1;
                        break;
                    }
                }
            }
            fclose($student_to_read);

            if ($group_1 < $this->max_person_in_one_group) {
                return "Group 1";
            } else if ($group_2 < $this->max_person_in_one_group) {
                return "Group 2";
            } else if ($group_3 < $this->max_person_in_one_group) {
                return "Group 3";
            } else if ($group_4 < $this->max_person_in_one_group) {
                return "Group 4";
            } else if ($group_5 < $this->max_person_in_one_group) {
                return "Group 5";
            } else {
                return false;
            }
        }
    }
}

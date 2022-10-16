<?php
if (isset($_POST['id_class'])) {
    $class_file = null;
    $file_to_read = fopen("../../database/General/all_class.csv", "r");
    if ($file_to_read !== FALSE) {
        while (($data = fgetcsv($file_to_read)) !== FALSE) {
            foreach ($data as $i) {
                if ($data[0] == $_POST['id_class']) {
                    $class_file = $data[2];
                }
                break;
            }
        }
        fclose($file_to_read);
    }


    $filename = "../../database/Uploaded/" . $class_file . "";

    if (!file_exists($filename)) {
        echo '<option value=""> -- No Data Found --</option>';
    } else {
        $file_to_read = fopen($filename, "r");
        echo '<option value="">-- Select or Skip This Field -- </option><br>';
        if ($file_to_read !== FALSE) {
            while (($data = fgetcsv($file_to_read)) !== FALSE) {
                foreach ($data as $i) {
                    echo '<option value="' . $data[0] . '">' . $data[1] . " - " . $data[2] . " " . $data[3] . '</option><br>';
                    break;
                }
            }
            fclose($file_to_read);
        }
    }
}

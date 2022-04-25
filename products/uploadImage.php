<?php

require_once "../inc/headers.php";
require_once "../inc/functions.php";


    if (isset($_FILES['file'])) {

        if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $filename = $_FILES['file']['name'];
            $type = $_FILES['file']['type'];
    
            if ($type === 'image/png' || $type === 'image/jpeg') {
                $path ='../images/' . basename($filename);
    
                if (move_uploaded_file($_FILES['file']['tmp_name'],$path)) {
                    $data = array('filename' => $filename, 'type' => $type);
                
                    echo json_encode($data);
                } else {
                    echo 'Error saving file to upload';
                }
            } else {
                echo 'Wrong file type';
            }
        } else {
            echo 'Error uploading file';
        }
     } else  {
         echo 'File was not submitted.';
     } 

 

 
 
 
?>
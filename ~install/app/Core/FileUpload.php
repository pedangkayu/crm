<?php
namespace App\Core;

class FileUpload
{  

    // valid extensions
    private $validExtensions = array('sql','txt'); 

    // upload and rename sql file to Load.sql
    public function doUpload($uploadPath = null)
    { 
        if (isset($_FILES['file'])) {
            if ($_FILES['file']['error'] == 0) {

                $fileName = $_FILES['file']['name'];
                $tmpName  = $_FILES['file']['tmp_name'];
                    
                // get uploaded file's extension
                $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                
                // can upload same file using rand function
                // $uploadPath contain the file name and ext
                $finalFile = "Load.sql";

                // check's valid format
                if (in_array($ext, $this->validExtensions)) {  

                    // $uploadPath = $uploadPath.strtolower($finalFile); 

                    if (move_uploaded_file($tmpName, $uploadPath)) {
                        echo $finalFile;
                    } else {
                        echo 3;
                    }

                } else {
                    echo 2;
                }
            } else {
                echo 3;
            }
        }
    }

    // copy and rename sql file to Load.sql
    public function doCopy($uploadPath = null)
    { 

        if (isset($_FILES['file'])) {
            if ($_FILES['file']['error'] == 0) {

                $fileName = $_FILES['file']['name'];
                $tmpName  = $_FILES['file']['tmp_name'];
                    
                // get uploaded file's extension
                $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                
                // can upload same file using rand function
                // $uploadPath contain the file name and ext
                $finalFile = "Load.sql";

                // check's valid format
                if (in_array($ext, $this->validExtensions)) {  

                    $data = file_get_contents($tmpName);
                    if (file_put_contents($uploadPath, $data)) {
                        echo $finalFile;
                    } else {
                        echo "Unable to upload...";
                    }

                } else {
                    echo "File must be text/sql format!";
                }
            } else {
                echo "Invalid file!";
            }
        }
    }


}
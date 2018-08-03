<?php
namespace App\Core;

class WriteContent
{  

    // create database with post data
    public function createDatabaseFile($data = [])
    { 
        //check template file is exists
        if (file_exists($data['templatePath'])) {

            //get template data
            $templateFile =file_get_contents($data['templatePath']);
            //replace data with post data
            $content  = str_replace("|HOSTNAME|",$data['hostname'],$templateFile);
            $content  = str_replace("|USERNAME|",$data['username'],$content);
            $content  = str_replace("|PASSWORD|",$data['password'],$content);
            $content  = str_replace("|DATABASE|",$data['database'],$content);
            //file with string replace

            //create a new file with string replace
            $this->createFileWithStringReplace([
                'outputPath' => $data['outputPath'],
                'content'    => $content,
            ]);

        } else {
            //template file is not exists
            return false;
        }
    }

    // create httacess with post data
    public function createHtaccess($data = null)
    { 
        //check output path is writeable
        if (is_writable(CI_HTACCESS_OUTPUT)) {
            //create a new file with post data 
            if (file_put_contents(CI_HTACCESS_OUTPUT.'.htaccess', $data)) {
                return true;
            } else {
                return false;
            }
        } else {  
            return false;
        }
    }

    //create codeigniter config file with base_url
    public function createCodeigniterConfigFile($outputPath = null)
    { 
        //check the output file is exists
        if (file_exists($outputPath)) { 
            // get file data
            $content = file_get_contents($outputPath);

            //create a new base_url
            // --------------------------------------------------------
            $newBaseUrl  =  '$root=(isset($_SERVER["HTTPS"]) ? "https://" : "http://").$_SERVER["HTTP_HOST"];';
            $newBaseUrl .= "\r\n";
            $newBaseUrl .= '$root.= str_replace(basename($_SERVER["SCRIPT_NAME"]), "", $_SERVER["SCRIPT_NAME"]);';
            $newBaseUrl .= "\r\n";
            $newBaseUrl .= '$config["base_url"] = $root; ';
            // --------------------------------------------------------
            //set a current base_url
            $currentBaseUrl     = '$config["base_url"] = $root; ';
            // --------------------------------------------------------

            //search string 
            $search = array();
            preg_match('/[^\n]*base_url[^\n]*/', $content, $search);

            //if $search[0] is not empty
            if (!empty($search[0])) {
                //check config data is not matche with flag data
                if ($search[0]!=$currentBaseUrl) {
                    //set $search[0] as content base_url data  
                    $currentBaseUrl = $search[0];
         
                    //create a new file with new base_url replace
                    $this->createFileWithStringReplace([
                        'outputPath' => $outputPath,
                        'content'    => str_replace($currentBaseUrl,$newBaseUrl,$content)
                    ]);

                } else {
                    //$newBaseUrl is match with $flag data
                    return true;
                }
            } else {
                //if $matches[0] is empty
                return false;
            }
        } else {
            //if $outputPath is not exists
            return false;
        }      
    }


    //create a file with string replace
    public function createFileWithStringReplace($file = [])
    { 
        //check output file is exists
        if (file_exists($file['outputPath'])) {
            // write the new database.php file
            $handle = fopen($file['outputPath'],'w+');

            // chmod the file, in case the user forgot
            @chmod($file['outputPath'],0777);

            // Verify file permissions
            if (is_writable($file['outputPath'])) {
                // Write the file
                if (fwrite($handle,$file['content'])) {
                    return true;
                } else {
                    //file not write
                    return false;
                }
            } else {
                //file is not writeable
                return false;
            }
        } else {
            //output file is not exists
            return false;
        }
    }


    //create a file with directory and data
    public function createFileWithDirectory($data = [])
    { 
        //get file info 
        $fileInfo   = pathinfo($data['outputPath']);
        //get the file directory path
        $directoryPath  = $fileInfo['dirname'];
        //get the file name with ext.
        $newFileName = $fileInfo['basename'];

        if (!is_dir($directoryPath)) {
            @mkdir($directoryPath, 0777, true);
        }

        if (file_put_contents($directoryPath.'/'.$newFileName, $data['content'])) {
            return true;
        } else {
            return false;
        }
    }


    // check a file
    public function fileExists($filePath = null)
    {
        //check file exits
        if (!file_exists($filePath)) {
            return false;
        } else {
            return true;
        }
    }


    // delete a file
    public function deleteFile($filePath = null)
    {
        //check file exits
        if (!file_exists($filePath)) {
            return false;
        } else {
            // delete a file
            @unlink($filePath);
        }
    }
}


<?php
namespace App\Core;

class AppRequirements
{  

    private $extensions      = null;
    private $permissions     = null;  
    private $versions        = null;  
    private $errors          = null;  

    //check files permission, extensions and version
    public function check($files = [])
    {  
        foreach ($files as $file) {
            if (!file_exists($file) && !is_writable($file)) { 
                $this->permissions[$file] = '<i class="fa fa-times red"></i>';
                $this->error[] = true;
            } else { 
                $this->permissions[$file] = '<i class="fa fa-check green"></i>';
            }
        }       

        $this->checkExtension([
            'pdo',
            'mysqli',
            'mcrypt', 
            // 'pdo_mysql',
            // 'mcrypt',
            // 'fileinfo',
            // 'sqlite3',
            'json',
            'session',
            // 'Core', 
            // 'curl',
            // 'dom', 
            // 'gd', 
            // 'hash',
            // 'iconv',
            // 'pcre',    
            // 'simplexml' 
        ]); 

        $this->checkPhpVersion('5.3.10', '<');
        $this->checkMySqlVersion('4.1.20', '<');
        $this->checkSafeMode();

        return [ 
            'permissions' => $this->permissions,
            'extensions'  => $this->extensions,
            'versions'    => $this->versions,
            'errors'      => $this->errors
        ];

    }

    //check the version
    public function checkPhpVersion($required = null, $condition = null)
    {
        if (version_compare(phpversion(), $required, $condition)) {
            //unsuccess
            $this->versions['php'] =  "<i class='fa fa-times red'></i> You need <strong> PHP version $required </strong>";
            $this->error[] = true;
        } else {
            //success
            $this->versions['php'] = "<i class='fa fa-ok green'></i> You have<strong class='green'> PHP $required</strong> (or greater. <strong>current version ".phpversion().")</strong>";
        } 

    }

    //check mysql version
    public function checkMySqlVersion($required = null, $condition = null)
    {
        ob_start(); 
        phpinfo(INFO_MODULES); 
        $mysql = ob_get_contents(); 
        ob_end_clean(); 
        $mysql = stristr($mysql, 'Client API version'); 
        preg_match('/[1-9].[0-9].[1-9][0-9]/', $mysql, $search);    
        if (version_compare($search[0],  $required, $condition)) {
            $this->versions['mysql'] =  "<i class='fa fa-times red'></i> You need <strong class='red'> MySql version $required </strong>";
            $this->error[] = true;
        } else {    
            $this->versions['mysql'] = "<i class='fa fa-ok green'></i> You have<strong class='green'> MySql version $required</strong> (or greater. <strong>current version ".$search[0]."</strong>)"; 
        }         
    }

    //check safe mode
    public function checkSafeMode()
    { 
        if (!ini_get('safe_mode')) {
            $this->versions['safe_mode'] = '<strong class="red">Disabled</i> '; 
        } else {   
            $this->versions['safe_mode'] = '<strong class="green">Enable</strong>'; 
        }      
    }

    //check extension
    public function checkExtension($extensions = null)
    { 
        foreach($extensions as $ext) {

            if (!extension_loaded($ext)) { 
                $this->extensions[$ext] = '<i class="fa fa-times red"></i>'; 
                $this->error[] = true;
            } else {   
                $this->extensions[$ext] = '<i class="fa fa-check green"></i>'; 
            }

        }
    }

}
 
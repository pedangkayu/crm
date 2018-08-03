<?php
//handling error reporting  
error_reporting(E_ALL);
// session start
ini_set('session.use_trans_sid', false);
ini_set('session.use_cookies', true);
ini_set('session.use_only_cookies', true);
$https = false;
if(isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] != 'off') $https = true;
$dirname = rtrim(dirname($_SERVER['PHP_SELF']), '/').'/';
session_name('installer');
session_set_cookie_params(0, $dirname, $_SERVER['HTTP_HOST'], $https, true);
session_start();

//including vendor/autoload.php
require_once __DIR__.'/../vendor/autoload.php';
 
use App\Core\DatabaseMigration as DB;
use App\Core\WriteContent      as Write;
use App\Core\FormValidation    as Validation;
use App\Core\FileUpload        as Upload;
use App\Core\AppRequirements   as Requirement;

$DB          = new DB();
$Write       = new Write();
$Validation  = new Validation();
$Upload      = new Upload();
$Requirement = new Requirement();

// ------------------DEFAULT VARIABLES----------------
define('CI_DATABASE_OUTPUT',    '../../../application/config/database.php');
define('CI_CONFIG_OUTPUT',      '../../../application/config/config.php');
define('CI_HTACCESS_OUTPUT',    '../../../'); 
define('CI_DATABASE_TEMPLATE',  '../templates/codeigniter_2x_&_3x.php'); 
define('INSTALL_FLAG',          '../application/config/system.config');  
define('SQL_FILE_PATH',         '../../public/files/Load.sql');  

// -------------CHECK FLAG IS EXISTS------------------
$Validation->checkFlag(INSTALL_FLAG);

// -----------------MENU & VARIABLE SET---------------
if (!empty($_GET['step'])) {
    switch ($_GET['step']) {
        case 'requirements':
            $content = './app/pages/requirements.php';
            $title   = 'Requirements';
            //generate token 
            unset($_SESSION['csrf_token']);
            $_SESSION['csrf_token'] = $Validation::csrfToken();
            break;
        case 'installation':
            $content = './app/pages/installation.php';
            $title   = 'Installation';
            break;
        case 'complete':
            $content = './app/pages/complete.php';
            $title   = 'Complete';
            //install flag file
            $Write->createFileWithDirectory([
             'outputPath' => INSTALL_FLAG, 
             'content'    => date('d-m-Y h:i:s')
            ]); 
            // delete a file
            $Write->deleteFile(SQL_FILE_PATH); 
            break; 
        default:
        case 'requirements':
            $content = './app/pages/requirements.php';
            $title   = 'Requirements';
            //generate token 
            unset($_SESSION['csrf_token']);
            $_SESSION['csrf_token'] = $Validation::csrfToken();
            break;
    }
} else {
    $content = './app/pages/requirements.php';
    $title   = 'Requirements';
    //generate token 
    unset($_SESSION['csrf_token']);
    $_SESSION['csrf_token'] = $Validation::csrfToken();
}  



 
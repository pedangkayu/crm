<?php
require '../Config.php'; 

//sumit form data
if($_SERVER['REQUEST_METHOD'] == "POST") {

	$validate = $Validation->validate([
	    'hostname'   => $_POST['hostname'],
	    'username'   => $_POST['username'],
	    'password'   => $_POST['password'],
	    'database'   => $_POST['database'],   
	    'htaccess'   => $_POST['htaccess'],  
	    'csrf_token' => $_SESSION['csrf_token'],
	]); 

	if (($validate) === true 
		&& $Write->fileExists(SQL_FILE_PATH)) {
 
		// it is use to create codeigniter database.php
		$data = [
			'templatePath' => CI_DATABASE_TEMPLATE,
			'outputPath'   => CI_DATABASE_OUTPUT,
			'hostname'  => $_POST['hostname'],
			'username'  => $_POST['username'],
			'password'  => $_POST['password'],
			'database'  => $_POST['database'] 
		];
		$Write->createDatabaseFile($data);

		// it is use to create codeigniter config.php and base_url
		if (isset($_POST['isHtaccess']) && ($_POST['isHtaccess'])==1)
		$Write->createHtaccess($_POST['htaccess']);

		// it is use to create codeigniter config.php and base_url
		$Write->createCodeigniterConfigFile(CI_CONFIG_OUTPUT);

		//create database & tables
		$data = [
			'hostname'  => $_POST['hostname'],
			'username'  => $_POST['username'],
			'password'  => $_POST['password'],
			'database'  => $_POST['database']   
		];
		
		$DB->createDatabase($data);
		$DB->createTables($data); 

        $data['status']  = true;
        $data['success'] = "Success!";
 
	} else { 

		$errors  = "";
		$errors .= "<ul>";
		if(!empty($validate))
		foreach ($validate as $error) {
		    $errors .= "<li>$error</li>";
		}
		$errors .= "</ul>";

		$data['status'] = false;
		$data['exception']  = $errors;	
	}

    echo json_encode($data);
}

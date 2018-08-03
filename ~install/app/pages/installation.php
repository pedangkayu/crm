<div class="content">
    <div class="row">
        <div class="col-sm-12">
            <!-- CUSTOM MESSAGE -->
            <div id="message"></div>
        </div>
        <div class="col-sm-12">
            <!-- BEGIN FORM -->
            <form action="./app/controller/Setup_process.php" method="post" id="setupForm">
              
              <!-- HIDDEN CSRF VALUE-->
              <input type="hidden" name="csrf_token" value="<?= (!empty($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : null) ?>" width=100%>

              <!-- UPLOAD SQL FILE -->
              <div class="form-group" style="display: none">
                <label for="upload">Upload SQL File</label>
                <input type="file" class="form-control" id="upload">
                <p class="text-danger" id="upload-help-block">
                  <?php 
                    if(file_exists('./public/files/Load.sql')) {
                      echo '<div role="alert" class="alert alert-success alert-icon alert-icon-border alert-dismissible">
                    <div class="icon"><span class="mdi mdi-check"></span></div>
                    <div class="message">
                      <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="mdi mdi-close"></span></button><strong>Good!</strong>The database file is already exits!. you can replace it by uploading another database file.
                    </div>
                  </div>';
                    } else {
                      echo "The Upload SQL File field is required";
                    }
                  ?>
                </p>                
              </div>

              <!-- HOSTNAME  -->
              <div class="form-group">
                <label for="hostname">Hostname</label>
                <input type="text" class="form-control" id="hostname" placeholder="Hostname" name="hostname" value="<?= (isset($_POST['hostname']) ? $_POST['hostname'] : 'localhost') ?>">
              </div>
              <!-- USERNAME -->
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" placeholder="Username" name="username" value="<?= (isset($_POST['username']) ? $_POST['username'] : 'root') ?>">
              </div>
              <!-- PASSWORD -->
              <div class="form-group">
                <label for="password">Password</label>
                <input type="text" class="form-control" id="password" placeholder="Password" name="password" value="<?= (isset($_POST['password']) ? $_POST['password'] : null) ?>">
              </div>
              <!-- DATABASE -->
              <div class="form-group">
                <label for="database">Database</label>
                <input type="text" class="form-control" id="database" placeholder="Database" name="database" value="<?= (isset($_POST['database']) ? $_POST['database'] : null) ?>">
              </div>

              <!-- HTACCESS -->
<?php
$htaccess = "
RewriteEngine on 
RewriteCond %{REQUEST_FILENAME} !-f 
RewriteCond %{REQUEST_FILENAME} !-d 
RewriteRule ^(.*)$ index.php?/$1 [L] 
"; 
?>
              <div class="form-group">
                <label for="htaccess">Htaccess <input type="checkbox" id="is_htaccess" name="isHtaccess" value="1"> (if you want to add .htacess file in your application then click on this checkbox)</label>
                <div class=" hide">
                    <textarea class="form-control" id="htaccess" rows="5" placeholder="Htaccess" name="htaccess"><?= (isset($_POST['htaccess']) ? $_POST['htaccess'] : $htaccess) ?></textarea>
                    <p class="help-block maroon">If you have custom htaccess, please paste your htaccess code here else nothing needs to do.</p>
                </div>
              </div>


              <!-- BUTTONS -->
              <div class="divider"></div>
              <a href="?step=requirements" class="btn btn-default left-right"> <i class="fa fa-backward"></i> Previous</a>
              <div class="pull-right btn-group">
                <button type="reset" class="btn btn-default">Reset</button>
                <button type="submit" class="btn btn-default">Install</button>
              </div>

            </form> 
            <!-- ENDS FORM -->
        </div>
    </div>
</div>

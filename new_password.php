<?php
include_once 'includes/new_pass.inc.php';
include_once 'includes/functions.php';

// START SESSION AND CHECK IF LOGGED IN

sec_session_start(); 
 
if (login_check($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<link href="bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet">
<link href='https://fonts.googleapis.com/css?family=Lato:400,700,900,300' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<!-- HEADER -->

    <a href="index.php">
        <header>
            <h1><br/>
                <small>API Pacing Tool</small>
            </h1>
        </header>
    </a>

<!-- CONTAINER -->

    <div class="container">

    <!-- GET NOTICES -->
            
        <?php
            if (isset($_GET['error'])) {
                echo '<p class="error">Error Logging In!</p>';
            }
            elseif (!empty($_POST)){
                echo "There was a post.";
                print_r($_POST);    
                exit;
            }
        ?>
        
        <?php
            if (login_check($mysqli) == true) {
                echo '<div class="text-right"><p>Currently logged ' . $logged . ' as ' . htmlentities($_SESSION['username']) . '.</p>';
                echo '<p>Do you want to change user? <a href="includes/logout.php">Log out</a>.</p></div>';
            } else {
                echo '<div class="text-right"><p>Currently logged ' . $logged . '.</p>';
                echo '<p>If you don\'t have a login, please <a href="register.php">register</a></p></div>';
            }
        ?>

<!-- BEGIN PROTECTED AREA -->
   
        <?php $name = ""; if (token_check($mysqli, $email, $token) == true) : ?>
       
        <section class="row">
            <h1 class="text-center">Create a new password</h1>

<!-- IF THERE IS A SUBMISSION ERROR -->

            <?php
                if (!empty($error_msg)) {
                    echo $error_msg;
                }
            ?>

                                
            <div class="col-sm-offset-4 col-sm-4">
                <form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="post" name="registration_form">
                    <div class="form-group hidden">
                        <label for="token">Token:</label> 
                            <input class="form-control" type="text" name="token" id="token" value="<?php echo $token ?>"/>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label> 
                            <input class="form-control" type="text" name="email" id="email" value="<?php echo $email ?>" disabled/>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label> 
                            <input class="form-control" type="password" name="password" id="password"/>
                    </div>
                    <div class="form-group">
                        <label for="confirmpwd">Confirm password:</label> 
                            <input class="form-control" type="password" name="confirmpwd" id="confirmpwd" />
                    </div>
                    <input id="new-pass-submit" type="submit"/>
                    <input class="btn btn-default center-block" type="button" value="Submit" onclick="return passformhash(this.form, this.form.token, this.form.email, this.form.password, this.form.confirmpwd);" />
                </form>
                <br/>
                <p>Return to the <a href="login.php">login page</a>.</p>
            </div>
        </section>    

<!-- END PROTECTED AREA -->
                           
       <?php else : ?>
           <p>Sorry - Access Denied</p>
       <?php endif; ?>
                        
    </div>

<!-- END CONTAINER -->

    <footer>
        <p class="text-center">&copy; <?php echo date('Y'); ?></p>
    </footer>
</body>
<script src="https://code.jquery.com/jquery-2.2.3.min.js" integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="http://code.jquery.com/color/jquery.color-2.1.2.min.js" integrity="sha256-H28SdxWrZ387Ldn0qogCzFiUDDxfPiNIyJX7BECQkDE=" crossorigin="anonymous"></script>
<script src="https://use.fontawesome.com/97b0240bea.js"></script>
<script src="bootstrap3-editable/js/bootstrap-editable.js"></script>
<script src="js/functions.js"></script>
<script type="text/JavaScript" src="js/sha512.js"></script> 
<script type="text/JavaScript" src="js/forms.js"></script>
</html>
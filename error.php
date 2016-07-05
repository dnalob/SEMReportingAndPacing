<?php

	$error = filter_input(INPUT_GET, 'err', $filter = FILTER_SANITIZE_STRING);
	 
	if (! $error) {
	    $error = 'Oops! An unknown error happened.';
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
		<a href="index.php">
			<header>
	        	<h1><br/>
	            	<small>API Pacing Tool</small>
	        	</h1>
	    	</header>
		</a>
        <h1>There was a problem</h1>
        <p class="error"><?php echo $error; ?></p>  
    </body>
</html>
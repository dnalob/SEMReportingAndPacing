<?php 
require_once 'includes/db_conn.php'; 
require_once 'includes/ajax.php';  
require_once 'includes/ajax_editable.php';
include_once 'includes/db_connect.php';
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
<meta name="viewport" content="width=device-width, minimum-scale=1.0">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<link href="bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet">
<link href='https://fonts.googleapis.com/css?family=Lato:400,700,900,300' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/style.css">
</head>

<body>


<!-- Header -->


	<a href="index.php">
		<header>
			<h1><br/>
				<small>API Pacing Tool</small>
			</h1>
		</header>
	</a>

	<div class="container">


<!-- Get Notices -->


		<?php
		    if (isset($_GET['error'])) {
		            echo '<p class="error">Error Logging In!</p>';
		    }
		    elseif (isset($_GET['new'])) {
		            echo '<p class="alert alert-success">Register successful!</p>';
		        }
		    elseif (isset($_GET['T2email'])) {
		            echo '<p class="alert alert-success">Tier 2 reports sent to your email!</p>';
		        }
		    elseif (isset($_GET['not_found'])) {
		        echo "<p class=\"alert alert-danger\">Account in DB $_GET[not_found] not found in google sheet.</p>";
		    }

		    if (login_check($mysqli) == true) {
		        echo '<div class="text-right log-screen"><p>Currently logged ' . $logged . ' as ' . htmlentities($_SESSION['username']) . '.</p>';
		        echo '<p>Do you want to change user? <a href="includes/logout.php">Log out</a>.</p></div>';
		    } else {
		        echo '<div class="text-right log-screen"><p>Currently logged ' . $logged . '.</p>';
		        echo '<p>If you don\'t have a login, please <a href="register.php">register</a></p></div>';
		            }
		?>


<!-- Start Protected Area -->

                    
	    <?php if (login_check($mysqli) == true) : ?>


<!-- TAB SELECTION -->


		<div class="row tab-level">
		  <ul id="myTabs" class="nav nav-tabs" role="tablist">
		    <li><a href="#T2Google" role="tab" data-toggle="tab">Google - T2</a></li>
		    <li><a href="#T2Bing" role="tab" data-toggle="tab">Bing - T2</a></li>
		    <li><a href="#T2Yahoo" role="tab" data-toggle="tab">Yahoo - T2</a></li>
		    <li><a href="#T3Google" role="tab" data-toggle="tab">Google - T3</a></li>
		    <li><a href="#T3Bing" role="tab" data-toggle="tab">Bing - T3</a></li>
		    <li><a href="#SEIM" role="tab" data-toggle="tab">Google - SEIM</a></li>
		    <li class="active"><a href="#Buttons" role="tab" data-toggle="tab">- Run -</a></li>
		  </ul>

		  <div class="tab-content">



<!-- TAB SECTIONS -->



<!-- Run Tab -->


		  	<div class="tab-pane active row" id="Buttons">
		    	<section class="col-sm-4 text-center">

					<h2>Google</h2>

					<form action="Google/Tier2ReportsExt.php" method="get">
				    	<input class="btn btn-primary" type="submit" value="Backup Billing" name="Submit" />
					</form>
					<form action="Google/Tier2PacingExt.php" method="get">
				    	<input class="btn btn-primary" type="submit" value="Tier 2 Pacing" name="Submit" />
					</form>
					<form action="Google/Tier3PacingExt.php" method="get">
				    	<input class="btn btn-primary" type="submit" value="Tier 3 Pacing" name="Submit" />
					</form>
					<form action="Google/SEIMPacingExt.php" method="get">
				    	<input class="btn btn-primary" type="submit" value="SEIM Pacing" name="Submit" />
					</form>
				</section>

				<section class="col-sm-4 text-center">

					<h2>Bing</h2>

					<form action="Bing/Auth.php" method="get">
				    	<input class="btn btn-primary" type="submit" value="Backup Billing" name="Submit" />
					</form>
					<form action="Bing/Auth2.php" method="get">
				    	<input class="btn btn-primary" type="submit" value="Tier 2 Pacing" name="Submit" />
					</form>
					<form action="Bing/Auth3.php" method="get">
				    	<input class="btn btn-primary" type="submit" value="Tier 3 Pacing" name="Submit" />
					</form>
				</section>

				<section class="col-sm-4 text-center">

					<h2>Yahoo</h2>

					<form action="Yahoo/Tier2Reports.php" method="get">
				    	<input class="btn btn-primary" type="submit" value="Backup Billing" name="Submit" />
					</form>
					<form action="Yahoo/Tier2Pacing.php" method="get">
				    	<input class="btn btn-primary" type="submit" value="Tier 2 Pacing" name="Submit" />
					</form>
				</section>

				<!-- Fetch google sheet info from database -->

				<?php 
					$sql = "SELECT * FROM id";
					$g2col = $conn->query($sql);

					while($row = mysqli_fetch_array($g2col)) {				
	    				$ids= array();
	    				$ids['sheet'] = $row['sheet'];
	    				$ids['SEIMid'] = $row['SEIMid'];
	    				$ids['SEIMsheet'] = $row['SEIMsheet'];
					    $ids['t2'] = $row['t2'];
					    $ids['t3'] = $row['t3'];            
					    $idsList[] = $ids;
					}

				?>

				<!-- Display sheet info -->

				<section class="col-sm-12">
					<hr/>

					<h4>Google Sheet Info</h4>

					<form class="form-inline">
						<label for="sheet">SEM Worksheet Name:</label>
							<input id="sheet" class="form-control" name="sheet" onchange="changeID(this.value, this.id)" value="<?php echo $idsList[0]['sheet'];?>">
						<label for="t2">Tier 2 Sheet Name:</label>
							<input id="t2" class="form-control" name="t2" onchange="changeID(this.value, this.id)" value="<?php echo $idsList[0]['t2'];?>">
						<label for="t3">Tier 3 Sheet Name:</label>
							<input id="t3" class="form-control" name="t3" onchange="changeID(this.value, this.id)" value="<?php echo $idsList[0]['t3'];?>">
						<label for="SEIMid" class="pull-left formAlign">&nbsp;&nbsp;&nbsp;&nbsp;SEIM Worksheet Name:&nbsp;</label>
							<input id="SEIMid" class="pull-left form-control" name="SEIM" onchange="changeID(this.value, this.id)" value="<?php echo $idsList[0]['SEIMid'];?>">
						<label for="SEIMsheet" class="pull-left formAlign">&nbsp;SEIM Sheet Name:&nbsp;</label>
							<input id="SEIMsheet" class="pull-left form-control" name="SEIM" onchange="changeID(this.value, this.id)" value="<?php echo $idsList[0]['SEIMsheet'];?>">
						<br/><br/><br/>
						<p class="pull-left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Share Google Sheet files with alan-516@sheets-api-1269.iam.gserviceaccount.com</p>
						
						<!-- Display saved message -->

						<span id="savedAlert">
						</span>
					</form>
				</section>
		    </div>


	<!-- GOOGLE TIER 2 TAB -->


		    <div class="tab-pane row" id="T2Google">
		    	<section class="col-sm-6">
					<h2>T2 Google Regular Accounts</h2>	

					<!-- JS Generated List Container -->

					<div id="regT2TableGoogle">
					</div>
				</section>

				<!-- Column selection form -->

				<div class="col-sm-offset-2 col-sm-4 column-select">
			    	<form>
			    		<p><b>Column Selection:</b> Clicks > Spend > Error > Crosscheck</p>
						<select class="form-control" name="columnSelect" onchange="sendColumnsG2(this.value)">

						<!-- Get column data from database -->

							<?php
								$sql = "SELECT * FROM columns";
								$g2col = $conn->query($sql);

								while($row = mysqli_fetch_array($g2col)) {
				    				$columns= array();
				    				$columns['tier'] = $row['tier'];
								    $columns['c1'] = $row['c1'];
								    $columns['c2'] = $row['c2'];
								    $columns['c3'] = $row['c3'];
								    $columns['c4'] = $row['c4'];                  
								    $columnsList[] = $columns;
								}

								$key = array_search('g2', array_column($columnsList, 'tier'));
								$one = $columnsList[$key]['c1'];
								$two = $columnsList[$key]['c1'];
								$three = $columnsList[$key]['c1'];
								$four = $columnsList[$key]['c4'];
								$letters = range('A', 'Z');
								$one = $letters[($one-1)];
								$four = $letters[($four-1)];

			    				for ($i=0; $i < (count($letters)-3); $i++) {
			    					$plus = $i+3;
			    					$html = [($i+1),($i+2),($i+3),($i+4)];
			    					$html = json_encode($html);

			    					if (($letters[$i] . ":" . $letters[$plus]) == ($one . ":" . $four)){
			    						echo "<option selected value=\"$html\">$letters[$i]:$letters[$plus]</option>";
			    					}
			    					else{
			    					echo "<option value=\"$html\">$letters[$i]:$letters[$plus]</option>";
			    					}

			    				} 

			    			?>

						</select>
					</form>
				</div>

				<section class="col-sm-6 lux-column">
					<h2>T2 Google Luxury/Honda Accounts</h2>

					<!-- JS Generated List Container -->

					<div id="luxT2TableGoogle">
					</div>
				</section>
		    </div>


	<!-- BING TIER 2 TAB -->


		    <div class="tab-pane row" id="T2Bing">	
		    	<section class="col-sm-6">
					<h2>T2 Bing Regular Accounts</h2>

					<!-- JS Generated List Container -->
					
					<div id="regT2TableBing">
					</div>
				</section>

				<!-- Column selection form -->

				<div class="col-sm-offset-2 col-sm-4 column-select">
			    	<form>
			    		<p><b>Column Selection:</b> Clicks > Spend > Error > Crosscheck</p>
						<select class="form-control" name="columnSelect" onchange="sendColumnsB2(this.value)">

						<!-- Get column data from database -->

							<?php
								$sql = "SELECT * FROM columns";
								$g2col = $conn->query($sql);

								while($row = mysqli_fetch_array($g2col)) {
				    				$columns= array();
				    				$columns['tier'] = $row['tier'];
								    $columns['c1'] = $row['c1'];
								    $columns['c2'] = $row['c2'];
								    $columns['c3'] = $row['c3'];
								    $columns['c4'] = $row['c4'];                  
								    $columnsList[] = $columns;
								}

								$key = array_search('b2', array_column($columnsList, 'tier'));
								$one = $columnsList[$key]['c1'];
								$two = $columnsList[$key]['c1'];
								$three = $columnsList[$key]['c1'];
								$four = $columnsList[$key]['c4'];
								$letters = range('A', 'Z');
								$one = $letters[($one-1)];
								$four = $letters[($four-1)];

			    				for ($i=0; $i < (count($letters)-3); $i++) {
			    					$plus = $i+3;
			    					$html = [($i+1),($i+2),($i+3),($i+4)];
			    					$html = json_encode($html);

			    					if (($letters[$i] . ":" . $letters[$plus]) == ($one . ":" . $four)){
			    						echo "<option selected value=\"$html\">$letters[$i]:$letters[$plus]</option>";
			    					}
			    					else{
			    					echo "<option value=\"$html\">$letters[$i]:$letters[$plus]</option>";
			    					}

			    				} 

			    			?>

						</select>
					</form>
				</div>

				<section class="col-sm-6 lux-column">
					<h2>T2 Bing Luxury/Honda Accounts</h2>

					<!-- JS Generated List Container -->
					
					<div id="luxT2TableBing">
					</div>
				</section>
		    </div>


	<!-- YAHOO TIER 2 TAB -->


		    <div class="tab-pane row" id="T2Yahoo">
		    	<section class="col-sm-5">
					<h2>T2 Yahoo Regular Accounts</h2>

					<!-- JS Generated List Container -->

					<div id="regTableYahoo">
					</div>
				</section>

				<!-- Column selection form -->

				<div class="col-sm-offset-3 col-sm-4 column-select">
			    	<form>
			    		<p><b>Column Selection:</b> Clicks > Spend > Error > Crosscheck</p>
						<select class="form-control" name="columnSelect" onchange="sendColumnsY2(this.value)">

						<!-- Get column data from database -->

							<?php
								$sql = "SELECT * FROM columns";
								$g2col = $conn->query($sql);

								while($row = mysqli_fetch_array($g2col)) {
				    				$columns= array();
				    				$columns['tier'] = $row['tier'];
								    $columns['c1'] = $row['c1'];
								    $columns['c2'] = $row['c2'];
								    $columns['c3'] = $row['c3'];
								    $columns['c4'] = $row['c4'];                  
								    $columnsList[] = $columns;
								}

								$key = array_search('y2', array_column($columnsList, 'tier'));
								$one = $columnsList[$key]['c1'];
								$two = $columnsList[$key]['c2'];
								$three = $columnsList[$key]['c3'];
								$four = $columnsList[$key]['c4'];
								$letters = range('A', 'Z');
								$one = $letters[($one-1)];
								$four = $letters[($four-1)];

			    				for ($i=0; $i < (count($letters)-3); $i++) {
			    					$plus = $i+3;
			    					$html = [($i+1),($i+2),($i+3),($i+4)];
			    					$html = json_encode($html);

			    					if (($letters[$i] . ":" . $letters[$plus]) == ($one . ":" . $four)){
			    						echo "<option selected value=\"$html\">$letters[$i]:$letters[$plus]</option>";
			    					}
			    					else{
			    					echo "<option value=\"$html\">$letters[$i]:$letters[$plus]</option>";
			    					}

			    				} 

			    			?>
						</select>
					</form>
				</div>

				<section class="col-sm-7 lux-column">
					<h2>T2 Yahoo Luxury Accounts</h2>

					<!-- JS Generated List Container -->

					<div id="luxTableYahoo">
					</div>
				</section>
		    </div>


	<!-- GOOGLE TIER 3 TAB -->


		    <div class="tab-pane row" id="T3Google">	    	
		    	<section class="col-sm-8">
					<h2>T3 Google Accounts</h2>

					<!-- JS Generated List Container -->
					
					<div id="regT3TableGoogle">
					</div>
				</section>

				<!-- Column selection form -->

				<div class="col-sm-4 column-select">
			    	<form>
			    		<p><b>Column Selection:</b> Spend > Error > Crosscheck</p>
						<select class="form-control" name="columnSelect" onchange="sendColumnsG3(this.value)">

						<!-- Get column data from database -->

							<?php
								$sql = "SELECT * FROM columns";
								$g2col = $conn->query($sql);

								while($row = mysqli_fetch_array($g2col)) {
				    				$columns= array();
				    				$columns['tier'] = $row['tier'];
								    $columns['c1'] = $row['c1'];
								    $columns['c2'] = $row['c2'];
								    $columns['c3'] = $row['c3'];                  
								    $columnsList[] = $columns;
								}

								$key = array_search('g3', array_column($columnsList, 'tier'));
								$one = $columnsList[$key]['c1'];
								$two = $columnsList[$key]['c2'];
								$three = $columnsList[$key]['c3'];
								$letters = range('A', 'Z');
								$one = $letters[($one-1)];
								$three = $letters[($three-1)];

			    				for ($i=0; $i < (count($letters)-2); $i++) {
			    					$plus = $i+2;
			    					$html = [($i+1),($i+2),($i+3)];
			    					$html = json_encode($html);

			    					if (($letters[$i] . ":" . $letters[$plus]) == ($one . ":" . $three)){
			    						echo "<option selected value=\"$html\">$letters[$i]:$letters[$plus]</option>";
			    					}
			    					else{
			    					echo "<option value=\"$html\">$letters[$i]:$letters[$plus]</option>";
			    					}

			    				} 

			    			?>
						</select>
					</form>
				</div>

				<section class="col-sm-4 lux-column">
					<h2>T3 Campaigns</h2>

					<!-- JS Generated List Container -->
					
					<div id="T3campaignlist" class="well">
					</div>
				</section>
		    </div>


		    <!-- BING TIER 3 TAB -->


		    <div class="tab-pane row" id="T3Bing">
		    	<section class="col-sm-8">
					<h2>T3 Bing Accounts</h2>

					<!-- JS Generated List Container -->

					<div id="regT3TableBing">
					</div>
				</section>

				<!-- Column selection form -->

				<div class="col-sm-4 column-select">
			    	<form>
			    		<p><b>Column Selection:</b> Spend > Error > Crosscheck</p>
						<select class="form-control" name="columnSelect" onchange="sendColumnsB3(this.value)">

						<!-- Get column data from database -->

							<?php
								$sql = "SELECT * FROM columns";
								$g2col = $conn->query($sql);

								while($row = mysqli_fetch_array($g2col)) {
				    				$columns= array();
				    				$columns['tier'] = $row['tier'];
								    $columns['c1'] = $row['c1'];
								    $columns['c2'] = $row['c2'];
								    $columns['c3'] = $row['c3'];                  
								    $columnsList[] = $columns;
								}

								$key = array_search('b3', array_column($columnsList, 'tier'));
								$one = $columnsList[$key]['c1'];
								$two = $columnsList[$key]['c2'];
								$three = $columnsList[$key]['c3'];
								$letters = range('A', 'Z');
								$one = $letters[($one-1)];
								$three = $letters[($three-1)];

			    				for ($i=0; $i < (count($letters)-2); $i++) {
			    					$plus = $i+2;
			    					$html = [($i+1),($i+2),($i+3)];
			    					$html = json_encode($html);

			    					if (($letters[$i] . ":" . $letters[$plus]) == ($one . ":" . $three)){
			    						echo "<option selected value=\"$html\">$letters[$i]:$letters[$plus]</option>";
			    					}
			    					else{
			    					echo "<option value=\"$html\">$letters[$i]:$letters[$plus]</option>";
			    					}

			    				}

			    			?>
						</select>
					</form>
				</div>

				<section class="col-sm-4 lux-column">
					<h2>T3 Campaigns</h2>

					<!-- JS Generated List Container -->
					
					<div id="T3Bingcampaignlist" class="well">
					</div>
				</section>
		    </div>


		    <!-- GOOGLE SEIM TAB-->


		    <div class="tab-pane row" id="SEIM">
		    	<section class="col-sm-8">
					<h2>SEIM Google Accounts</h2>

					<!-- JS Generated List Container -->
					
					<div id="SEIMTableGoogle">
					</div>
				</section>

				<!-- Column selection form -->

				<div class="col-sm-4 column-select">
			    	<form>
			    		<p><b>Column Selection:</b> Clicks > Spend > Error > Crosscheck > Recommended Daily Budget</p>
						<select class="form-control" name="columnSelect" onchange="sendColumnsSEIM(this.value)">

						<!-- Get column data from database -->

							<?php
								$sql = "SELECT * FROM columns";
								$g2col = $conn->query($sql);

								while($row = mysqli_fetch_array($g2col)) {
				    				$columns= array();
				    				$columns['tier'] = $row['tier'];
								    $columns['c1'] = $row['c1'];
								    $columns['c2'] = $row['c2'];
								    $columns['c3'] = $row['c3'];
								    $columns['c4'] = $row['c4'];
								    $columns['c5'] = $row['c5'];                  
								    $columnsList[] = $columns;
								}

								$realColumnsList = [];

								for ($x=0;$x<count($columnsList);$x++){

									if (isset($columnsList[$x]['c5'])){
										$realColumnsList[] = $columnsList[$x];
									}

								}

								$key = array_search('seim', array_column($realColumnsList, 'tier'));
								$one = $realColumnsList[$key]['c1'];
								$five = $realColumnsList[$key]['c5'];
								$letters = range('A', 'Z');
								$one = $letters[($one-1)];
								$five = $letters[($five-1)];

			    				for ($i=0; $i < (count($letters)-4); $i++) {
			    					$plus = $i+4;
			    					$html = [($i+1),($i+2),($i+3),($i+4),($i+5)];
			    					$html = json_encode($html);

			    					if (($letters[$i] . ":" . $letters[$plus]) == ($one . ":" . $five)){
			    						echo "<option selected value=\"$html\">$letters[$i]:$letters[$plus]</option>";
			    					}
			    					else{
			    					echo "<option data=\"($one . \":\" . $five)\" value=\"$html\">$letters[$i]:$letters[$plus]</option>";
			    					}

			    				} 

			    			?>
						</select>
					</form>
				</div>

				<section class="col-sm-4 lux-column">
					<h2>SEIM Campaigns</h2>

					<!-- JS Generated List Container -->

					<div id="SEIMGooglecampaignlist" class="well">
					</div>
				</section>
		    </div>



<!-- END TAB SECTIONS -->
	   


	  	</div>
	</div>


<!-- END PROTECTED AREA -->


	<?php else : ?>
        <p>
            <span class="error">You are not authorized to access this page.</span> Please <a href="login.php">login</a>.
        </p>
    <?php endif; ?>
    <hr/>
</div>

<!-- container	 -->

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
<script src="js/sha512.js"></script> 
<script src="js/forms.js"></script>
<script src="js/googleT2.js"></script>
<script src="js/bingT2.js"></script>
<script src="js/yahooT2.js"></script>
<script src="js/googleT3.js"></script>
<script src="js/bingT3.js"></script>
<script src="js/googleSEIM.js"></script>
</html>
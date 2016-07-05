<?php require_once dirname(__FILE__) . '/T3_reg_campaigns_google_AJAX.php'; 
	  require_once dirname(__FILE__) . '/T3_reg_campaigns_bing_AJAX.php'; 

//////////////////////////////////////////////////////////////////////

// Formula Option Selection

//////////////////////////////////////////////////////////////////////


if(isset($_POST['regT3GoogleFormula'])) {
	try {
	   

	    echo $_POST['regT3GoogleFormula'] . $_POST['regT3GoogleFormulaId'];
	    $sql_id_update = "UPDATE google_reg_accounts_T3 SET `f`='" . mysql_real_escape_string ($_POST['regT3GoogleFormula']) . "' WHERE `id` = '" . mysql_real_escape_string ($_POST['regT3GoogleFormulaId']) . "'";
	    echo $sql_id_update;

	    echo "Tried" . $sql_id_update;
		$conn->query($sql_id_update);

	    echo "New records created successfully";
	} catch(PDOException $e){
	    echo "Error: " . $e->getMessage();
	}
}


if(isset($_POST['regT3BingFormula'])) {
	try {
	   
	    echo $_POST['regT3BingFormula'] . $_POST['regT3BingFormulaId'];
	    $sql_id_update = "UPDATE bing_reg_accounts_T3 SET `f`='" . mysql_real_escape_string ($_POST['regT3BingFormula']) . "' WHERE `id` = '" . mysql_real_escape_string ($_POST['regT3BingFormulaId']) . "'";
	    echo $sql_id_update;

	    echo "Tried" . $sql_id_update;
		$conn->query($sql_id_update);

	    echo "New records created successfully";
	} catch(PDOException $e){
	    echo "Error: " . $e->getMessage();
	}
}



//////////////////////////////////////////////////////////////////////

// UPDATE IDS

//////////////////////////////////////////////////////////////////////


if(isset($_POST['id_value'])) {
	try {
	    echo $_POST['id_value'] . $_POST['id_id'];
	    $sql_id_update = "UPDATE id SET `" . mysql_real_escape_string ($_POST['id_id']) . "`='" . mysql_real_escape_string ($_POST['id_value']) . "' WHERE `id` = '1'";
	    echo $sql_id_update;

	    echo "Tried" . $sql_id_update;
		$conn->query($sql_id_update);

	    echo "New records created successfully";
	} catch(PDOException $e){
	    echo "Error: " . $e->getMessage();
	}
}



//////////////////////////////////////////////////////////////////////

// G2 columns

//////////////////////////////////////////////////////////////////////


if(isset($_POST['g2_column1'])) {
	try {
	    echo $_POST['g2_column1'] . $_POST['g2_column2'] . $_POST['g2_column3'] . $_POST['g2_column4'];
	    $sql_column_update = "UPDATE columns SET `c1`='" . mysql_real_escape_string ($_POST['g2_column1']) . "', `c2`='" . mysql_real_escape_string ($_POST['g2_column2']) . "', `c3`='" . mysql_real_escape_string ($_POST['g2_column3']) . "', `c4`='" . mysql_real_escape_string ($_POST['g2_column4']) . "'  WHERE `tier` = 'g2'";

	    echo "Tried" . $sql_column_update;
		$conn->query($sql_column_update);

	    echo "New records created successfully";
	} catch(PDOException $e){
	    echo "Error: " . $e->getMessage();
	}
}

if(isset($_POST['b2_column1'])) {
	try {
	    $sql_column_update = "UPDATE columns SET `c1`='" . mysql_real_escape_string ($_POST['b2_column1']) . "', `c2`='" . mysql_real_escape_string ($_POST['b2_column2']) . "', `c3`='" . mysql_real_escape_string ($_POST['b2_column3']) . "', `c4`='" . mysql_real_escape_string ($_POST['b2_column4']) . "'  WHERE `tier` = 'b2'";

	    echo "Tried" . $sql_column_update;
		$conn->query($sql_column_update);

	    echo "New records created successfully";
	} catch(PDOException $e){
	    echo "Error: " . $e->getMessage();
	}
}

if(isset($_POST['y2_column1'])) {
	try {
	    $sql_column_update = "UPDATE columns SET `c1`='" . mysql_real_escape_string ($_POST['y2_column1']) . "', `c2`='" . mysql_real_escape_string ($_POST['y2_column2']) . "', `c3`='" . mysql_real_escape_string ($_POST['y2_column3']) . "', `c4`='" . mysql_real_escape_string ($_POST['y2_column4']) . "'  WHERE `tier` = 'y2'";

	    echo "Tried" . $sql_column_update;
		$conn->query($sql_column_update);

	    echo "New records created successfully";
	} catch(PDOException $e){
	    echo "Error: " . $e->getMessage();
	}
}

if(isset($_POST['g3_column1'])) {
	try {
	    $sql_column_update = "UPDATE columns SET `c1`='" . mysql_real_escape_string ($_POST['g3_column1']) . "', `c2`='" . mysql_real_escape_string ($_POST['g3_column2']) . "', `c3`='" . mysql_real_escape_string ($_POST['g3_column3']) . "' WHERE `tier` = 'g3'";

	    echo "Tried" . $sql_column_update;
		$conn->query($sql_column_update);

	    echo "New records created successfully";
	} catch(PDOException $e){
	    echo "Error: " . $e->getMessage();
	}
}


if(isset($_POST['b3_column1'])) {
	try {
	    $sql_column_update = "UPDATE columns SET `c1`='" . mysql_real_escape_string ($_POST['b3_column1']) . "', `c2`='" . mysql_real_escape_string ($_POST['b3_column2']) . "', `c3`='" . mysql_real_escape_string ($_POST['b3_column3']) . "' WHERE `tier` = 'b3'";

	    echo "Tried" . $sql_column_update;
		$conn->query($sql_column_update);

	    echo "New records created successfully";
	} catch(PDOException $e){
	    echo "Error: " . $e->getMessage();
	}
}

if(isset($_POST['seim_column1'])) {
	try {
	    $sql_column_update = "UPDATE columns SET `c1`='" . mysql_real_escape_string ($_POST['seim_column1']) . "', `c2`='" . mysql_real_escape_string ($_POST['seim_column2']) . "', `c3`='" . mysql_real_escape_string ($_POST['seim_column3']) . "', `c4`='" . mysql_real_escape_string ($_POST['seim_column4']) . "', `c5`='" . mysql_real_escape_string ($_POST['seim_column5']) . "'  WHERE `tier` = 'seim'";

	    echo "Tried" . $sql_column_update;
		$conn->query($sql_column_update);

	    echo "New records created successfully";
	} catch(PDOException $e){
	    echo "Error: " . $e->getMessage();
	}
}



//////////////////////////////////////////////////////////////////////

//GOOGLE DELETE T2

//////////////////////////////////////////////////////////////////////


if(isset($_GET['google_reg_delete'])) {
	$result = $_GET['google_reg_delete'];
	echo "<h1>" . $result . "</h1>";
	$sql_reg_delete = "DELETE FROM google_reg_accounts_T2 WHERE id = '" . mysql_real_escape_string ($result) . "'";
	echo "Tried" . $sql_reg_delete;
	$conn->query($sql_reg_delete);
}


if(isset($_GET['google_lux_delete'])) {
	echo "I got here!";
	$luxResult = $_GET['google_lux_delete'];
	echo "<h1>" . $luxResult . "</h1>";
	$sql_lux_delete = "DELETE FROM google_lux_accounts_T2 WHERE id = '" . mysql_real_escape_string ($luxResult) . "'";
	echo "Tried" . $sql_lux_delete;
	$conn->query($sql_lux_delete);
}



//////////////////////////////////////////////////////////////////////

//GOOGLE INSERT T2

//////////////////////////////////////////////////////////////////////


if(isset($_POST['regGoogleContent1'])) {
	try {
	    $sql_reg_insert = "INSERT INTO google_reg_accounts_T2 (`Account ID`, `Name`, `Filter`) VALUES (?, ?, ?)";
	    $stmt = $conn->prepare($sql_reg_insert);
	    $stmt->bind_param('sss', $id, $name, $filter);
	    $id = $_POST['regGoogleContent2'];
	    $name = $_POST['regGoogleContent1'];
	    $filter = $_POST['regGoogleContent3'];
	    $stmt->execute();
	    echo "New records created successfully";
	} catch(PDOException $e){
	    echo "Error: " . $e->getMessage();
	}
}

if(isset($_POST['luxGoogleContent1'])) {
	try {
		$sql_lux_insert = "INSERT INTO google_lux_accounts_T2 (`Account ID`, `Name`, `Filter`) VALUES (?, ?, ?)";
		$stmt = $conn->prepare($sql_lux_insert);
	    $stmt->bind_param('sss', $id, $name, $filter);
	    $id = $_POST['luxGoogleContent2'];
	    $name = $_POST['luxGoogleContent1'];
	    $filter = $_POST['luxGoogleContent3'];
	    $stmt->execute();
	    echo "New records created successfully";
	} catch(PDOException $e){
	    echo "Error: " . $e->getMessage();
	}
}



//////////////////////////////////////////////////////////////////////

//GOOGLE DELETE T2

//////////////////////////////////////////////////////////////////////


if(isset($_GET['google_reg_delete'])) {
	$result = $_GET['google_reg_delete'];
	echo "<h1>" . $result . "</h1>";
	$sql_reg_delete = "DELETE FROM google_reg_accounts_T2 WHERE id = '" . mysql_real_escape_string ($result) . "'";
	echo "Tried" . $sql_reg_delete;
	$conn->query($sql_reg_delete);
}


if(isset($_GET['google_lux_delete'])) {
	echo "I got here!";
	$luxResult = $_GET['google_lux_delete'];
	echo "<h1>" . $luxResult . "</h1>";
	$sql_lux_delete = "DELETE FROM google_lux_accounts_T2 WHERE id = '" . mysql_real_escape_string ($luxResult) . "'";
	echo "Tried" . $sql_lux_delete;
	$conn->query($sql_lux_delete);
}



//////////////////////////////////////////////////////////////////////

//GOOGLE INSERT T3

//////////////////////////////////////////////////////////////////////


if(isset($_POST['regT3GoogleContent1'])) {
	try {
	    $sql_reg_insert = "INSERT INTO google_reg_accounts_T3 (`Account ID`, `Name`, `Filter`, `f`) VALUES (?, ?, ?, ?)";
	    $stmt = $conn->prepare($sql_reg_insert);
	    $stmt->bind_param('sssi', $id, $name, $filter, $formula);
	    $id = $_POST['regT3GoogleContent2'];
	    $name = $_POST['regT3GoogleContent1'];
	    $filter = $_POST['regT3GoogleContent3'];
	    $formula = $_POST['regT3GoogleContent4'];
	    $stmt->execute();
	    echo "New records created successfully";
	} catch(PDOException $e){
	    echo "Error: " . $e->getMessage();
	}
}



//////////////////////////////////////////////////////////////////////

//BING INSERT T3

//////////////////////////////////////////////////////////////////////


if(isset($_POST['regT3BingContent1'])) {
	try {
	    $sql_reg_insert = "INSERT INTO bing_reg_accounts_T3 (`Account ID`, `Name`, `Filter`, `f`) VALUES (?, ?, ?, ?)";
	    $stmt = $conn->prepare($sql_reg_insert);
	    $stmt->bind_param('sssi', $id, $name, $filter, $formula);
	    $id = $_POST['regT3BingContent2'];
	    $name = $_POST['regT3BingContent1'];
	    $filter = $_POST['regT3BingContent3'];
	    $formula = $_POST['regT3BingContent4'];
	    $stmt->execute();
	    echo "New records created successfully";
	} catch(PDOException $e){
	    echo "Error: " . $e->getMessage();
	}
}



//////////////////////////////////////////////////////////////////////

//GOOGLE INSERT SEIM

//////////////////////////////////////////////////////////////////////


if(isset($_POST['regSEIMGoogleContent1'])) {
	try {
	    $sql_reg_insert = "INSERT INTO google_reg_accounts_SEIM (`Account ID`, `Name`, `Filter`) VALUES (?, ?, ?)";
	    $stmt = $conn->prepare($sql_reg_insert);
	    $stmt->bind_param('sss', $id, $name, $filter);
	    $id = $_POST['regSEIMGoogleContent2'];
	    $name = $_POST['regSEIMGoogleContent1'];
	    $filter = $_POST['regSEIMGoogleContent3'];
	    $stmt->execute();
	    echo "New records created successfully";
	} catch(PDOException $e){
	    echo "Error: " . $e->getMessage();
	}
}



//////////////////////////////////////////////////////////////////////

//GOOGLE DELETE T3

//////////////////////////////////////////////////////////////////////


if(isset($_GET['google_T3_reg_delete'])) {
	$result = $_GET['google_T3_reg_delete'];
	$sql_reg_delete = "DELETE FROM google_reg_accounts_T3 WHERE id = '" . mysql_real_escape_string ($result) . "'";
	echo "Tried" . $sql_reg_delete;
	$conn->query($sql_reg_delete);
}



//////////////////////////////////////////////////////////////////////

//BING DELETE T3

//////////////////////////////////////////////////////////////////////


if(isset($_GET['bing_T3_reg_delete'])) {
	$result = $_GET['bing_T3_reg_delete'];
	$sql_reg_delete = "DELETE FROM bing_reg_accounts_T3 WHERE id = '" . mysql_real_escape_string ($result) . "'";
	echo "Tried" . $sql_reg_delete;
	$conn->query($sql_reg_delete);
}



//////////////////////////////////////////////////////////////////////

//GOOGLE DELETE SEIM

//////////////////////////////////////////////////////////////////////


if(isset($_GET['google_SEIM_reg_delete'])) {
	$result = $_GET['google_SEIM_reg_delete'];
	$sql_reg_delete = "DELETE FROM google_reg_accounts_SEIM WHERE id = '" . mysql_real_escape_string ($result) . "'";
	echo "Tried" . $sql_reg_delete;
	$conn->query($sql_reg_delete);
}



//////////////////////////////////////////////////////////////////////

//GOOGLE DELETE CAMPAIGN T3

//////////////////////////////////////////////////////////////////////


if(isset($_GET['google_T3_campaign_delete'])) {
	$result = $_GET['google_T3_campaign_delete'];
	$filter = $_GET['google_T3_campaign_delete_2'];
	$pieces = explode("_", $result);
	$sql_campaign_delete = "UPDATE t3_google_campaigns_reg SET `$pieces[1]`='' WHERE `Account ID` = '" . mysql_real_escape_string ($pieces[0]) . "' AND `Filter` = '" . mysql_real_escape_string ($filter) . "'";
	echo "Tried" . $sql_campaign_delete;
	$conn->query($sql_campaign_delete);
}


//////////////////////////////////////////////////////////////////////

//BING DELETE CAMPAIGN T3

//////////////////////////////////////////////////////////////////////


if(isset($_GET['bing_T3_campaign_delete'])) {
	$result = $_GET['bing_T3_campaign_delete'];
	$filter = $_GET['bing_T3_campaign_delete_2'];
	$pieces = explode("_", $result);
	$sql_campaign_delete = "UPDATE t3_bing_campaigns_reg SET `$pieces[1]`='' WHERE `Account ID` = '" . mysql_real_escape_string ($pieces[0]) . "' AND `Filter` = '" . mysql_real_escape_string ($filter) . "'";
	echo "Tried" . $sql_campaign_delete;
	$conn->query($sql_campaign_delete);
}



//////////////////////////////////////////////////////////////////////

//GOOGLE DELETE CAMPAIGN SEIM

//////////////////////////////////////////////////////////////////////


if(isset($_GET['google_SEIM_campaign_delete'])) {
	$result = $_GET['google_SEIM_campaign_delete'];
	$filter = $_GET['google_SEIM_campaign_delete_2'];
	$pieces = explode("_", $result);
	$sql_campaign_delete = "UPDATE SEIM_google_campaigns_reg SET `$pieces[1]`='' WHERE `Name` = '" . mysql_real_escape_string ($pieces[0]) . "'";
	echo "Tried" . $sql_campaign_delete;
	$conn->query($sql_campaign_delete);
}



//////////////////////////////////////////////////////////////////////

//GOOGLE CAMPAIGN INSERT T3

//////////////////////////////////////////////////////////////////////


if(isset($_POST['regT3GoogleCampaignContent1'])) {
	try {
		$result1 = $_POST['regT3GoogleCampaignContent1'];
		$result2 = $_POST['regT3GoogleCampaignContent2'];
		$result3 = $_POST['regT3GoogleCampaignContent3'];

	    $sql_campaign_insert = "UPDATE t3_google_campaigns_reg SET `C10`= CASE WHEN `C9`!='' AND `C10`='' THEN '" . mysql_real_escape_string ($result1) . "' ELSE `C10` END, `C9`= CASE WHEN `C8`!='' AND `C9`='' THEN '" . mysql_real_escape_string ($result1) . "' ELSE `C9` END, `C8`= CASE WHEN `C7`!='' AND `C8`='' THEN '" . mysql_real_escape_string ($result1) . "' ELSE `C8` END, `C7`= CASE WHEN `C6`!='' AND `C7`='' THEN '" . mysql_real_escape_string ($result1) . "' ELSE `C7` END, `C6`= CASE WHEN `C5`!='' AND `C6`='' THEN '" . mysql_real_escape_string ($result1) . "' ELSE `C6` END, `C5`= CASE WHEN `C4`!='' AND `C5`='' THEN '" . mysql_real_escape_string ($result1) . "' ELSE `C5` END, `C4`= CASE WHEN `C3`!='' AND `C4`='' THEN '" . mysql_real_escape_string ($result1) . "' ELSE `C4` END, `C3`= CASE WHEN `C2`!='' AND `C3`='' THEN '" . mysql_real_escape_string ($result1) . "' ELSE `C3` END, `C2`= CASE WHEN `C1`!='' AND `C2`='' THEN '" . mysql_real_escape_string ($result1) . "' ELSE `C2` END, `C1`= CASE WHEN `C1`='' THEN '" . mysql_real_escape_string ($result1) . "' ELSE `C1` END WHERE `Account ID` = '" . mysql_real_escape_string ($result2) . "' AND `Filter` = '" . mysql_real_escape_string ($result3) . "'";

	    echo "Tried" . $sql_campaign_insert;
		$conn->query($sql_campaign_insert);
	    echo "New records created successfully";
	} catch(PDOException $e){
	    echo "Error: " . $e->getMessage();
	}
}



//////////////////////////////////////////////////////////////////////

//GOOGLE CAMPAIGN BUTTON

//////////////////////////////////////////////////////////////////////


if(isset($_POST['google_T3_add_campaigns'])) {
	try {
	    $sql_reg_insert = "INSERT INTO t3_google_campaigns_reg (`Account ID`, `Filter`) VALUES (?,?)";
	    $stmt = $conn->prepare($sql_reg_insert);
	    $stmt->bind_param('ss', $id, $filter);
	    $id = $_POST['google_T3_add_campaigns'];
	    $filter = $_POST['filter'];
	    $stmt->execute();
	    echo "New records created successfully";
	} catch(PDOException $e){
	    echo "Error: " . $e->getMessage();
	}
}



//////////////////////////////////////////////////////////////////////

//BING CAMPAIGN INSERT T3

//////////////////////////////////////////////////////////////////////


if(isset($_POST['regT3BingCampaignContent1'])) {
	try {
		$result1 = $_POST['regT3BingCampaignContent1'];
		$result2 = $_POST['regT3BingCampaignContent2'];
		$result3 = $_POST['regT3BingCampaignContent3'];

	    $sql_campaign_insert = "UPDATE t3_bing_campaigns_reg SET `C10`= CASE WHEN `C9`!='' AND `C10`='' THEN '" . mysql_real_escape_string ($result1) . "' ELSE `C10` END, `C9`= CASE WHEN `C8`!='' AND `C9`='' THEN '" . mysql_real_escape_string ($result1) . "' ELSE `C9` END, `C8`= CASE WHEN `C7`!='' AND `C8`='' THEN '" . mysql_real_escape_string ($result1) . "' ELSE `C8` END, `C7`= CASE WHEN `C6`!='' AND `C7`='' THEN '" . mysql_real_escape_string ($result1) . "' ELSE `C7` END, `C6`= CASE WHEN `C5`!='' AND `C6`='' THEN '" . mysql_real_escape_string ($result1) . "' ELSE `C6` END, `C5`= CASE WHEN `C4`!='' AND `C5`='' THEN '" . mysql_real_escape_string ($result1) . "' ELSE `C5` END, `C4`= CASE WHEN `C3`!='' AND `C4`='' THEN '" . mysql_real_escape_string ($result1) . "' ELSE `C4` END, `C3`= CASE WHEN `C2`!='' AND `C3`='' THEN '" . mysql_real_escape_string ($result1) . "' ELSE `C3` END, `C2`= CASE WHEN `C1`!='' AND `C2`='' THEN '" . mysql_real_escape_string ($result1) . "' ELSE `C2` END, `C1`= CASE WHEN `C1`='' THEN '" . mysql_real_escape_string ($result1) . "' ELSE `C1` END WHERE `Account ID` = '" . mysql_real_escape_string ($result2) . "' AND `Filter` = '" . mysql_real_escape_string ($result3) . "'";

	    echo "Tried" . $sql_campaign_insert;
		$conn->query($sql_campaign_insert);
	    echo "New records created successfully";
	} catch(PDOException $e){
	    echo "Error: " . $e->getMessage();
	}
}



//////////////////////////////////////////////////////////////////////

//BING CAMPAIGN BUTTON

//////////////////////////////////////////////////////////////////////


if(isset($_POST['bing_T3_add_campaigns'])) {
	try {
	    $sql_reg_insert = "INSERT INTO t3_bing_campaigns_reg (`Account ID`, `Filter`) VALUES (?,?)";
	    $stmt = $conn->prepare($sql_reg_insert);
	    $stmt->bind_param('ss', $id, $filter);
	    $id = $_POST['bing_T3_add_campaigns'];
	    $filter = $_POST['filter'];
	    $stmt->execute();
	    echo "New records created successfully";
	} catch(PDOException $e){
	    echo "Error: " . $e->getMessage();
	}
}



//////////////////////////////////////////////////////////////////////

//GOOGLE CAMPAIGN INSERT SEIM

//////////////////////////////////////////////////////////////////////


if(isset($_POST['regSEIMGoogleCampaignContent1'])) {
	try {
		$result1 = $_POST['regSEIMGoogleCampaignContent1'];
		$result2 = $_POST['regSEIMGoogleCampaignContent2'];
		$result3 = $_POST['regSEIMGoogleCampaignContent3'];

	    $sql_campaign_insert = "UPDATE SEIM_google_campaigns_reg SET `C10`= CASE WHEN `C9`!='' AND `C10`='' THEN '" . mysql_real_escape_string ($result1) . "' ELSE `C10` END, `C9`= CASE WHEN `C8`!='' AND `C9`='' THEN '" . mysql_real_escape_string ($result1) . "' ELSE `C9` END, `C8`= CASE WHEN `C7`!='' AND `C8`='' THEN '" . mysql_real_escape_string ($result1) . "' ELSE `C8` END, `C7`= CASE WHEN `C6`!='' AND `C7`='' THEN '" . mysql_real_escape_string ($result1) . "' ELSE `C7` END, `C6`= CASE WHEN `C5`!='' AND `C6`='' THEN '" . mysql_real_escape_string ($result1) . "' ELSE `C6` END, `C5`= CASE WHEN `C4`!='' AND `C5`='' THEN '" . mysql_real_escape_string ($result1) . "' ELSE `C5` END, `C4`= CASE WHEN `C3`!='' AND `C4`='' THEN '" . mysql_real_escape_string ($result1) . "' ELSE `C4` END, `C3`= CASE WHEN `C2`!='' AND `C3`='' THEN '" . mysql_real_escape_string ($result1) . "' ELSE `C3` END, `C2`= CASE WHEN `C1`!='' AND `C2`='' THEN '" . mysql_real_escape_string ($result1) . "' ELSE `C2` END, `C1`= CASE WHEN `C1`='' THEN '" . mysql_real_escape_string ($result1) . "' ELSE `C1` END WHERE `Name` = '" . mysql_real_escape_string ($result2) . "' AND `Filter` = '" . mysql_real_escape_string ($result3) . "'";

	    echo "Tried" . $sql_campaign_insert;
		$conn->query($sql_campaign_insert);
	    echo "New records created successfully";
	} catch(PDOException $e){
	    echo "Error: " . $e->getMessage();
	}
}



//////////////////////////////////////////////////////////////////////

//GOOGLE CAMPAIGN BUTTON SEIM

//////////////////////////////////////////////////////////////////////


if(isset($_POST['google_SEIM_add_campaigns'])) {
	try {
	    $sql_reg_insert = "INSERT INTO SEIM_google_campaigns_reg (`Account ID`, `Filter`, `Name`) VALUES (?,?,?)";
	    $stmt = $conn->prepare($sql_reg_insert);
	    $stmt->bind_param('sss', $id, $filter, $name);
	    $id = $_POST['google_SEIM_add_campaigns'];
	    $filter = $_POST['filter'];
	    $name = $_POST['name'];
	    $stmt->execute();
	    echo "New records created successfully";
	} catch(PDOException $e){
	    echo "Error: " . $e->getMessage();
	}
}



//////////////////////////////////////////////////////////////////////

//BING DELETE T2

//////////////////////////////////////////////////////////////////////


if(isset($_GET['bing_reg_delete'])) {
	$result = $_GET['bing_reg_delete'];
	echo "<h1>" . $result . "</h1>";
	$sql_reg_delete = "DELETE FROM bing_reg_accounts_T2 WHERE id = '" . mysql_real_escape_string ($result) . "'";
	echo "Tried" . $sql_reg_delete;
	$conn->query($sql_reg_delete);
}

if(isset($_GET['bing_lux_delete'])) {
	echo "I got here!";
	$luxResult = $_GET['bing_lux_delete'];
	echo "<h1>" . $luxResult . "</h1>";
	$sql_lux_delete = "DELETE FROM bing_lux_accounts_T2 WHERE id = '" . mysql_real_escape_string ($luxResult) . "'";
	echo "Tried" . $sql_lux_delete;
	$conn->query($sql_lux_delete);
}



//////////////////////////////////////////////////////////////////////

//BING INSERT

//////////////////////////////////////////////////////////////////////


if(isset($_POST['regBingContent1'])) {
	try {	
	    $sql_reg_insert = "INSERT INTO bing_reg_accounts_T2 (`Account ID`, `Name`, `Filter`) VALUES (?, ?, ?)";
	    $stmt = $conn->prepare($sql_reg_insert);
	    $stmt->bind_param('sss', $id, $name, $filter);
	    $id = $_POST['regBingContent2'];
	    $name = $_POST['regBingContent1'];
	    $filter = $_POST['regBingContent3'];
	    $stmt->execute();
	    echo "New records created successfully";
	} catch(PDOException $e){
	    echo "Error: " . $e->getMessage();
	}
}

if(isset($_POST['luxBingContent1'])) {
	try {
	    $sql_lux_insert = "INSERT INTO bing_lux_accounts_T2 (`Account ID`, `Name`, `Filter`) VALUES (?, ?, ?)";
	    $stmt = $conn->prepare($sql_lux_insert);
	    $stmt->bind_param('sss', $id, $name, $filter);
	    $id = $_POST['luxBingContent2'];
	    $name = $_POST['luxBingContent1'];
	    $filter = $_POST['luxBingContent3'];
	    $stmt->execute();
	    echo "New records created successfully";
	} catch(PDOException $e){
	    echo "Error: " . $e->getMessage();
	}
}



//////////////////////////////////////////////////////////////////////

//YAHOO DELETE

//////////////////////////////////////////////////////////////////////

if(isset($_GET['yahoo_reg_delete'])) {
	$result = $_GET['yahoo_reg_delete'];
	echo "<h1>" . $result . "</h1>";
	$sql_reg_delete = "DELETE FROM yahoo_reg_accounts_T2 WHERE id = '" . mysql_real_escape_string ($result) . "'";
	echo "Tried" . $sql_reg_delete;
	$conn->query($sql_reg_delete);
}

if(isset($_GET['yahoo_lux_delete'])) {
	echo "I got here!";
	$luxResult = $_GET['yahoo_lux_delete'];
	echo "<h1>" . $luxResult . "</h1>";
	$sql_lux_delete = "DELETE FROM yahoo_lux_accounts_T2 WHERE id = '" . mysql_real_escape_string ($luxResult) . "'";
	echo "Tried" . $sql_lux_delete;
	$conn->query($sql_lux_delete);
}



//////////////////////////////////////////////////////////////////////

//YAHOO INSERT

//////////////////////////////////////////////////////////////////////


if(isset($_POST['regYahooContent1'])) {
	try {
	    $sql_reg_insert = "INSERT INTO yahoo_reg_accounts_T2 (`Account ID`, `Name`, `Filter`) VALUES (?, ?, ?)";
	    $stmt = $conn->prepare($sql_reg_insert);
	    $stmt->bind_param('sss', $id, $name, $filter);
	    $id = $_POST['regYahooContent2'];
	    $name = $_POST['regYahooContent1'];
	    $filter = $_POST['regYahooContent3'];
	    $stmt->execute();
	    echo "New records created successfully";
	    echo $conn->error;
	} catch(PDOException $e){
	    echo "Error: " . $e->getMessage();
	}
}

if(isset($_POST['luxYahooContent1'])) {
	try {
	    $sql_lux_insert = "INSERT INTO yahoo_lux_accounts_T2 (`Account ID`, `Name`, `Filter`, `lux_campaign_1`, `lux_campaign_2`) VALUES (?, ?, ?, ?, ?)";
	    $stmt = $conn->prepare($sql_lux_insert);
	    $stmt->bind_param('sssss', $id, $name, $filter, $campaign1, $campaign2);
	    $id = $_POST['luxYahooContent2'];
	    $name = $_POST['luxYahooContent1'];
	    $filter = $_POST['luxYahooContent3'];
	    $campaign1 = $_POST['luxYahooContent4'];
	    $campaign2 = $_POST['luxYahooContent5'];
	    $stmt->execute();
	    echo "New records created successfully";
	} catch(PDOException $e){
	    echo "Error: " . $e->getMessage();
	}
}

?>
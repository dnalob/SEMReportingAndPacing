<?php 

//////////////////////////////////////////////////////////////////////

//T3 EDITABLE

//////////////////////////////////////////////////////////////////////


if(isset($_POST['bing_edit_id'])) {
	$id = $_POST['bing_edit_id'];
	$col = $_POST['bing_edit_col'];
	$content = $_POST['bing_edit_content'];
	echo $id . $col . $content;
	$sql_update_editable = "UPDATE bing_reg_accounts_T3 SET `" . mysql_real_escape_string($col) . "`='" . mysql_real_escape_string ($content) . "' WHERE `id` = '" . mysql_real_escape_string ($id) . "'";
	echo "Tried" . $sql_update_editable;
	$conn->query($sql_update_editable);
}

if(isset($_POST['google_edit_id'])) {
	$id = $_POST['google_edit_id'];
	$col = $_POST['google_edit_col'];
	$content = $_POST['google_edit_content'];
	echo $id . $col . $content;
	$sql_update_editable = "UPDATE google_reg_accounts_T3 SET `" . mysql_real_escape_string($col) . "`='" . mysql_real_escape_string ($content) . "' WHERE `id` = '" . mysql_real_escape_string ($id) . "'";
	echo "Tried" . $sql_update_editable;
	$conn->query($sql_update_editable);
}

if(isset($_POST['seim_edit_id'])) {
	$id = $_POST['seim_edit_id'];
	$col = $_POST['seim_edit_col'];
	$content = $_POST['seim_edit_content'];
	echo $id . $col . $content;
	$sql_update_editable = "UPDATE google_reg_accounts_SEIM SET `" . mysql_real_escape_string($col) . "`='" . mysql_real_escape_string ($content) . "' WHERE `id` = '" . mysql_real_escape_string ($id) . "'";
	echo "Tried" . $sql_update_editable;
	$conn->query($sql_update_editable);
}

if(isset($_POST['yahoo_edit_id'])) {
	$id = $_POST['yahoo_edit_id'];
	$col = $_POST['yahoo_edit_col'];
	$content = $_POST['yahoo_edit_content'];
	echo $id . $col . $content;
	$sql_update_editable = "UPDATE yahoo_reg_accounts_T2 SET `" . mysql_real_escape_string($col) . "`='" . mysql_real_escape_string ($content) . "' WHERE `id` = '" . mysql_real_escape_string ($id) . "'";
	echo "Tried" . $sql_update_editable;
	$conn->query($sql_update_editable);
}

if(isset($_POST['yahoolux_edit_id'])) {
	$id = $_POST['yahoolux_edit_id'];
	$col = $_POST['yahoolux_edit_col'];
	$content = $_POST['yahoolux_edit_content'];
	echo $id . $col . $content;
	$sql_update_editable = "UPDATE yahoo_lux_accounts_T2 SET `" . mysql_real_escape_string($col) . "`='" . mysql_real_escape_string ($content) . "' WHERE `id` = '" . mysql_real_escape_string ($id) . "'";
	echo "Tried" . $sql_update_editable;
	$conn->query($sql_update_editable);
}

if(isset($_POST['bingt2_edit_id'])) {
	$id = $_POST['bingt2_edit_id'];
	$col = $_POST['bingt2_edit_col'];
	$content = $_POST['bingt2_edit_content'];
	echo $id . $col . $content;
	$sql_update_editable = "UPDATE bing_reg_accounts_T2 SET `" . mysql_real_escape_string($col) . "`='" . mysql_real_escape_string ($content) . "' WHERE `id` = '" . mysql_real_escape_string ($id) . "'";
	echo "Tried" . $sql_update_editable;
	$conn->query($sql_update_editable);
}

if(isset($_POST['bingt2lux_edit_id'])) {
	$id = $_POST['bingt2lux_edit_id'];
	$col = $_POST['bingt2lux_edit_col'];
	$content = $_POST['bingt2lux_edit_content'];
	echo $id . $col . $content;
	$sql_update_editable = "UPDATE bing_lux_accounts_T2 SET `" . mysql_real_escape_string($col) . "`='" . mysql_real_escape_string ($content) . "' WHERE `id` = '" . mysql_real_escape_string ($id) . "'";
	echo "Tried" . $sql_update_editable;
	$conn->query($sql_update_editable);
}

if(isset($_POST['googlet2_edit_id'])) {
	$id = $_POST['googlet2_edit_id'];
	$col = $_POST['googlet2_edit_col'];
	$content = $_POST['googlet2_edit_content'];
	echo $id . $col . $content;
	$sql_update_editable = "UPDATE google_reg_accounts_T2 SET `" . mysql_real_escape_string($col) . "`='" . mysql_real_escape_string ($content) . "' WHERE `id` = '" . mysql_real_escape_string ($id) . "'";
	echo "Tried" . $sql_update_editable;
	$conn->query($sql_update_editable);
}

if(isset($_POST['googlet2lux_edit_id'])) {
	$id = $_POST['googlet2lux_edit_id'];
	$col = $_POST['googlet2lux_edit_col'];
	$content = $_POST['googlet2lux_edit_content'];
	echo $id . $col . $content;
	$sql_update_editable = "UPDATE google_lux_accounts_T2 SET `" . mysql_real_escape_string($col) . "`='" . mysql_real_escape_string ($content) . "' WHERE `id` = '" . mysql_real_escape_string ($id) . "'";
	echo "Tried" . $sql_update_editable;
	$conn->query($sql_update_editable);
}

?>
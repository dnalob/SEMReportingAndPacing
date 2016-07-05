<?php 

require_once dirname(__FILE__) . '/db_conn.php';  

$sql = "SELECT * FROM t3_google_campaigns_reg";

$regAccounts = $conn->query($sql);

while($row = mysqli_fetch_array($regAccounts))
					{
				
    				$nameAndCode = array();
				    $nameAndCode['code'] = $row['Account ID'];
				    $nameAndCode['filter'] = $row['Filter'];
				    $nameAndCode['campaign1'] = $row['C1'];
				    $nameAndCode['campaign2'] = $row['C2']; 
				    $nameAndCode['campaign3'] = $row['C3']; 
				    $nameAndCode['campaign4'] = $row['C4']; 
				    $nameAndCode['campaign5'] = $row['C5']; 
				    $nameAndCode['campaign6'] = $row['C6']; 
				    $nameAndCode['campaign7'] = $row['C7']; 
				    $nameAndCode['campaign8'] = $row['C8']; 
				    $nameAndCode['campaign9'] = $row['C9']; 
				    $nameAndCode['campaign10'] = $row['C10'];                  
				    $regCampaignList[] = $nameAndCode;
					
					}

$regCampJSON = json_encode($regCampaignList);

echo $regCampJSON;

?>
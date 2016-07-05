<?php 

require_once dirname(__FILE__) . '/db_conn.php';

$sql = "SELECT * FROM yahoo_lux_accounts_T2";

$luxAccounts = $conn->query($sql);

while($row = mysqli_fetch_array($luxAccounts))
					{
				
    				$nameAndCode = array();
    				$nameAndCode['name'] = $row['Name'];
    				$nameAndCode['filter'] = $row['Filter'];
    				$nameAndCode['id'] = $row['id'];
				    $nameAndCode['code'] = $row['Account ID'];
				    $nameAndCode['lux_campaign_1'] = $row['lux_campaign_1']; 
				    $nameAndCode['lux_campaign_2'] = $row['lux_campaign_2'];                   
				    $luxAccountList[] = $nameAndCode;
					
					}

sort($luxAccountList);

$luxJSON = json_encode($luxAccountList);

echo $luxJSON;

?>
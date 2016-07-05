<?php 

require_once dirname(__FILE__) . '/db_conn.php';  

$sql = "SELECT * FROM google_reg_accounts_SEIM";

$regAccounts = $conn->query($sql);

while($row = mysqli_fetch_array($regAccounts))
					{
				
    				$nameAndCode = array();
    				$nameAndCode['name'] = $row['Name'];
    				$nameAndCode['id'] = $row['id'];
				    $nameAndCode['code'] = $row['Account ID'];
				    $nameAndCode['filter'] = $row['Filter'];                 
				    $regAccountList[] = $nameAndCode;
					
					}

sort($regAccountList);

$regJSON = json_encode($regAccountList);

echo $regJSON;

?>
<?php 

require_once dirname(__FILE__) . '/db_conn.php';

$sql = "SELECT * FROM google_lux_accounts_T2";

$luxAccounts = $conn->query($sql);

while($row = mysqli_fetch_array($luxAccounts))
					{
				
    				$nameAndCode = array();
    				$nameAndCode['name'] = $row['Name'];
				    $nameAndCode['code'] = $row['Account ID'];
				    $nameAndCode['id'] = $row['id'];
				    $nameAndCode['filter'] = $row['Filter'];                  
				    $luxAccountList[] = $nameAndCode;
					
					}

sort($luxAccountList);

$luxJSON = json_encode($luxAccountList);

echo $luxJSON;

?>
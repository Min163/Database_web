<?php
	include "config.php"; 
	include "util.php"; 
	
	$conn = dbconnect($host,$dbid,$dbpass,$dbname);
	
	mysqli_query("set autocommit = 0", $conn);
	mysqli_query("set session transaction isolation level serializable", $conn); //serializable
	//입력받은 정보를 DB에 insert하기 전에 입력받은 정보 중 이미 DB에 존재하는 ID인지 확인한다. 
	mysqli_query("begin", $conn);
	
	$id = $_POST['ID'];
	$pwd = $_POST['pwd'];
	$mem_ret = mysqli_query($conn, "select * from customer where c_id = '$id'");
	
	if(!$mem_ret){ //roll back이 발생하는 경우
		mysqli_query("rollback", $conn);
        die('Query Error : ' . mysqli_error());
	}
	else{
		mysqli_query("commit", $conn);
		
		$mem_num = mysqli_num_rows($mem_ret);

		if(!$mem_num) {
			msg('NO ID!');
		}
		else {
			$mem_array = mysqli_fetch_array($mem_ret);
			$db_name = $mem_array['name'];
			$db_pwd = $mem_array['pwd'];
			$db_admin = $mem_array['admin'];
			if($db_pwd == $pwd) {
				SetCookie("cookie_id", $id,0,"/"); // 0 : browser lifetime – 0 or omitted : end of session
				SetCookie("cookie_name", $db_name,0, "/");
				SetCookie("cookie_admin", $db_admin,0, "/");
	
				echo "<meta http-equiv='refresh' content='0;url=index.php'>";
			}
			else {
				msg('PASSWORD ERROR!');
				
			}	
		}
	}
	
	mysqli_close($conn);
?>
<?php
	include "config.php";
	include "util.php";

	$conn = dbconnect($host,$dbid,$dbpass,$dbname);
	
	mysqli_query("set autocommit = 0", $conn);
	mysqli_query("set session transaction isolation level serializable", $conn); //serializable
	mysqli_query("begin", $conn);
	
	//입력받은 정보를 insert할 때, 누구도 해당 relation을 수정할 수 없도록 하고 싶어서 serailizable을 선택하였다. 
	
	$id = $_POST['ID'];
	
	$pwd = $_POST['pwd'];
	$c_pwd = $_POST['c_pwd'];
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$birth = $_POST['birth'];

	//ID 유무확인
	$ret = mysqli_query($conn, "select c_id from customer where c_id='$id'");
	if(!$ret){ //roll back이 발생한 경우
		mysqli_query("rollback", $conn);
		msg('ERROR!');
	}
	else{ //commit이 발생한 경우
		$num = mysqli_num_rows($ret);

		if(check_pass($pwd, $c_pwd) != 0) { //password 확인
			msg('패스워드가 맞지 않습니다!');
		}
		else if($num) {
			msg('이미 존재하는 ID입니다!');
		}
		else { //입력받은 정보를 DB에 insert하는 경우
			$insert_query = "insert into customer (c_id, pwd, name, phone, birth, admin) values ('$id','$pwd','$name','$phone','$birth', 0 )";
			$insert_ret = mysqli_query($conn, $insert_query);
			if(!insert_ret){ 
				mysqli_query("rollback", $conn); //rollback
				msg('ERROR!'); 
			}
			else { 
				mysqli_query("commit", $conn);
				s_msg('가입을 축하드립니다!'); //commit
				echo "<meta http-equiv='refresh' content='0;url=login.php'>";
			}
		}
	}
	
	mysqli_close($conn);
?>
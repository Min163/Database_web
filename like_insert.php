<?php
	include "config.php";    //데이터베이스 연결 설정파일
	include "util.php";      //유틸 함수

	$conn = dbconnect($host,$dbid,$dbpass,$dbname);
	
	mysqli_query("set autocommit = 0", $conn);
	mysqli_query("set session transaction isolation level serializable", $conn); //serializable
	mysqli_query("begin", $conn);
	
	//입력받은 정보를 insert할 때, 누구도 해당 relation을 수정할 수 없도록 하고 싶어서 serailizable을 선택하였다. 

	$m_id = $_GET['m_id'];
	$c_id = $_COOKIE[cookie_id];
	
	$rec = mysqli_query($conn, "select * from likes where m_id = $m_id and c_id = '$c_id'");
	if(!$rec) { //rollback이 발생한 경우
		mysqli_query("rollback", $conn);
		s_msg('ERROR!');
	}
	else{ 
		$check = mysqli_fetch_array($rec);
		if(!$check) {
			$ret = mysqli_query($conn, "insert into likes (m_id, c_id) values('$m_id', '$c_id')");
			if(!$ret){ //rollback이 발생한 경우
				mysqli_query("rollback", $conn); //rollback
				msg('2. ERROR!'); 
			}
			else{ //commit이 발생하는 경우
				mysqli_query("commit", $conn);
	    		s_msg ('성공적으로 입력되었습니다'); //commit
	    		echo "<meta http-equiv='refresh' content='0;url=movie_list.php'>";
			}
		}
		else {
			msg('Alread did!');
			echo "<meta http-equiv='refresh' content='0;url=movie_list.php'>";
		}
	}
?>
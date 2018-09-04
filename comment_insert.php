<?php
	include "config.php";    //데이터베이스 연결 설정파일
	include "util.php";      //유틸 함수

	$conn = dbconnect($host,$dbid,$dbpass,$dbname);
	
	mysqli_query("set autocommit = 0", $conn);
	mysqli_query("set session transaction isolation level serializable", $conn); //serializable
	mysqli_query("begin", $conn);
	
	//입력받은 정보를 insert할 때, 누구도 해당 relation을 수정할 수 없도록 하고 싶어서 serailizable을 선택하였다. 
	
	if(!$_COOKIE[cookie_id] || !$_COOKIE[cookie_name]){
		msg("로그인이 필요합니다!");
	}
	else{
		$m_id = $_POST['movie_id'];
		$comment = $_POST['comment'];
		$c_id = $_COOKIE[cookie_id];
	
		$query = "insert into comments (c_id, m_id, comment) values ('$c_id', '$m_id', '$comment')";
		$ret = mysqli_query($conn, $query);
		
		if(!ret) { //rollback이 발생한 경우
			mysqli_query("rollback", $conn); //rollback
    		msg('Query Error : '.mysqli_error($conn));
		}
		else { //commit이 발생한 경우
			mysqli_query("commit", $conn);
    		s_msg ('성공적으로 입력되었습니다'); //commit
			echo "<meta http-equiv='refresh' content='0;url=movie_view.php?m_id={$m_id}'>";		
		}
	}
?>
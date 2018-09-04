<?php
	include "config.php";    //데이터베이스 연결 설정파일
	include "util.php";      //유틸 함수

	$conn = dbconnect($host,$dbid,$dbpass,$dbname);

	mysqli_query("set autocommit = 0", $conn);
	mysqli_query("set session transaction isolation level serializable", $conn); //serializable 
	mysqli_query("begin", $conn);
	
	//수정된 정보를 insert할 때, 누구도 해당 relation을 수정할 수 없도록 하고 싶어서 serailizable을 선택하였다.
	
	$m_id = $_POST['m_id'];
	$title = $_POST['title']; //영화제목
	$age = $_POST['a_id']; //연령등급
	$genre = $_POST['g_id']; //장르
	$date = $_POST['date']; //개봉일
	$type = $_POST['i_id']; //상영정보

	$ret = mysqli_query($conn, "update movie set title = '$title', a_id = '$age', open_date = '$date', i_id = '$type', g_id = '$genre' where m_id = $m_id");

	if(!$ret) { //rollback이 발생한 경우
		mysqli_query("rollback", $conn); //rollback
    	msg('Query Error : '.mysqli_error($conn));
	}
	else { //commit이 발생한 경우
		mysqli_query("commit", $conn); //commit
    	s_msg ('성공적으로 수정 되었습니다');
    	echo "<meta http-equiv='refresh' content='0;url=movie_view.php?m_id={$m_id}'>";
	}
?>
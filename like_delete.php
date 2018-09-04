<?php
	include "config.php";    //데이터베이스 연결 설정파일
	include "util.php";      //유틸 함수
	
	$conn = dbconnect($host,$dbid,$dbpass,$dbname);

	mysqli_query("set autocommit = 0", $conn);
	mysqli_query("set session transaction isolation level read uncommitted", $conn); //read uncommitted
	mysqli_query("begin", $conn);

	//delete를 할 때, primary key인 속성을 조건으로 삭제할 것이기 때문에 read uncommitted 레벨을 부여하였다.

	$l_id = $_GET['l_id'];
	$c_id = $_COOKIE[cookie_id];

	$ret = mysqli_query($conn, "delete from likes where l_id = $l_id");
	
	if(!$ret) { //rollback이 발생한 경우
		mysqli_query("rollback", $conn);
		msg('Query Error : '.mysqli_error($conn));
	}
	else{ //commit이 발생한 경우
		mysqli_query("commit", $conn);
		echo "<meta http-equiv='refresh' content='0;url=member_view.php?c_id={$c_id}'>";
	}
?>

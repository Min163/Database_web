<?php
	include "config.php";    //데이터베이스 연결 설정파일
	include "util.php";      //유틸 함수

	$conn = dbconnect($host,$dbid,$dbpass,$dbname);
	
	mysqli_query("set autocommit = 0", $conn);
	mysqli_query("set session transaction isolation level serializable", $conn); //serializable
	mysqli_query("begin", $conn);
	
	//수정된 정보를 insert할 때, 누구도 해당 relation을 수정할 수 없도록 하고 싶어서 serailizable을 선택하였다.

	$c_id = $_POST['c_id'];
	$pwd = $_POST['pwd']; 
	$name = $_POST['name']; 
	$birth = $_POST['birth']; 
	$phone = $_POST['phone']; 

	$ret = mysqli_query($conn, "update customer set c_id = '$c_id', pwd = '$pwd', name = '$name', birth = '$birth', phone = '$phone' where c_id = '$c_id'");

	if(!$ret) { //roll back이 발생하는 경우
		mysqli_query("rollback", $conn);
    	msg('Query Error : '.mysqli_error($conn));
	}
	else { //commit이 발생한 경우 
		mysqli_query("commit", $conn);
    	s_msg ('성공적으로 수정 되었습니다');
    	echo "<meta http-equiv='refresh' content='0;url=member_view.php?c_id={$c_id}'>";
	}
?>
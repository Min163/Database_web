<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

mysqli_query("set autocommit = 0", $conn);
mysqli_query("set session transaction isolation level read uncommitted", $conn); //read uncommitted
mysqli_query("begin", $conn);

//delete를 할 때, primary key인 속성을 조건으로 삭제할 것이기 때문에 read uncommitted 레벨을 부여하였다.

$c_id = $_GET['c_id'];

$ret = mysqli_query($conn, "delete from customer where c_id = '$c_id'");

if(!$ret) { //roll back이 발생한 경우
	mysqli_query("rollback", $conn);
    msg('Query Error : '.mysqli_error($conn));
}
else { //commit이 발생한 경우
	mysqli_query("commit", $conn);
    s_msg ('삭제되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=logout.php?c_id={$c_id}'>";
}
?>


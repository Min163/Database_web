<?php
	include "config.php";    //데이터베이스 연결 설정파일
	include "util.php";      //유틸 함수

	$conn = dbconnect($host,$dbid,$dbpass,$dbname);
	
	mysqli_query("set autocommit = 0", $conn);
	mysqli_query("set session transaction isolation level serializable", $conn); //serializable 
	mysqli_query("begin", $conn);
	
	//입력받은 정보를 insert할 때, 누구도 해당 relation을 수정할 수 없도록 하고 싶어서 serailizable을 선택하였다. 

	$title = $_POST['title']; //영화제목
	$age = $_POST['a_id']; //연령등급
	$genre = $_POST['g_id']; //장르
	$date = $_POST['date']; //개봉일
	$type = $_POST['i_id']; //상영정보
	
	$ret = mysqli_query($conn, "insert into movie (title, a_id, open_date, i_id, g_id) values('$title', '$age', '$date', '$type', '$genre')");
	
	if(!$ret) { //roll back이 발생한 경우
		mysqli_query("rollback", $conn); //rollback
    	msg('Query Error : '.mysqli_error($conn));
	}
	else { 
    	s_msg ('성공적으로 입력되었습니다');
    	$rec = mysqli_query($conn, "select * from movie where title = '$title'");
    	if(!$rec){
    		mysqli_query("rollback", $conn);
    	}
    	else{
    		mysqli_query("commit", $conn);
    	}
    	$movie = mysqli_fetch_array($rec);
		$m_id = $movie['m_id'];
    	echo "<meta http-equiv='refresh' content='0;url=movie_view.php?m_id={$m_id}'>";
	}

?>
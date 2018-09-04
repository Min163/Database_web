<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

mysqli_query("set autocommit = 0", $conn);
mysqli_query("set session transaction isolation level read committed", $conn); //read committed
mysqli_query("begin", $conn);

//해당 relation에서 정보를 읽어와서 보여주면 되므로 dirty read만 제한하도록 read committed를 선택하였다. 

$mode = "ADD";
$action = "schedule_insert.php";

//개봉 영화 카테고리
$open_movie = array();

$query = "select * from movie natural join movie_inform where i_id = 1";
$res = mysqli_query($conn, $query);
if($res) {
	while($row = mysqli_fetch_array($res)) {
    	$open_movie[$row['m_id']] = $row['title'];
	}	
	$movie_room = array();

	$query1 = "select * from room";
	$res1 = mysqli_query($conn, $query1);
	if($res1){
		while($row = mysqli_fetch_array($res1)) {
    		$movie_room[$row['r_id']] = $row['r_id'];
		}	
	}
	else{
		mysqli_query("rollback", $conn);
	}
}
else{
	mysqli_query("rollback", $conn);
}


//상영관 카테고리
//$movie_room = array();

//$query1 = "select * from room";
//$res1 = mysqli_query($conn, $query1);
//while($row = mysqli_fetch_array($res1)) {
//    $movie_room[$row['r_id']] = $row['r_id'];
//}


?>
<div id="wrapper">
	<div id="featured-wrapper">
		<div class="extra2 container">
			<form class="form-horizontal" name ="form" action="schedule_insert.php" method="post">
			<div class="ebox1">
				<div class="hexagon"><span class="icon icon-lightbulb"></span></div>
				<div class="title">
					<h2>ADD Schedule</h2>
				</div>
				<div class="form-group">
					<label for="day" class="col-sm-2 control-label">날짜</label>
    				<div class="col-sm-10">
    					<input type="text" name="day" class="form-control" id="day" placeholder="YYYY-MM-DD">
					</div>
				</div>
				<div class="form-group">
					<label for="m_id" class="col-sm-2 control-label">영화</label>
    				<div class="col-sm-10">
    					<select name="m_id" id="m_id" class="form-control">
    						<option value="-1">영화를 선택해주세요</option>
        					<?
                        		foreach($open_movie as $id => $name) {
                            		echo "<option value='{$id}'>{$name}</option>";
                        		}
                    		?>
    					</select>
					</div>
				</div>
				<div class="form-group">
					<label for="r_id" class="col-sm-2 control-label">상영관</label>
    				<div class="col-sm-10">
    					<select name="r_id" id="r_id" class="form-control">
    						<option value="-1">상영관을 선택해주세요</option>
                    		<?
                        		foreach($movie_room as $id => $name) {
                            	 	echo "<option value='{$id}'>{$name}</option>";
                    			}
                    		?>
    					</select>
					</div>
				</div>
				<button class="button primary small" onclick="javascript:return validate();">ADD</button>
				<script>
                function validate() {
                    if(document.getElementById("day").value == "") {
                        alert ("날짜를 입력해주십시오"); return false;
                    }
                    else if(document.getElementById("m_id").value == "-1") {
                        alert ("영화를 선택해주십시오"); return false;
                    }
                    else if(document.getElementById("r_id").value == "-1") {
                        alert ("상영관을 선택해주십시오"); return false;
                    }
                    return true;
                }
            </script>
			</div>
			
			</form>
		</div>	

	</div>
</div>
<? include "footer.php" ?>
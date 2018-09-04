<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

mysqli_query("set autocommit = 0", $conn);
mysqli_query("set session transaction isolation level read committed", $conn); //read committed
mysqli_query("begin", $conn);

//해당 relation에서 정보를 읽어와서 보여주면 되므로 dirty read만 제한하도록 read committed를 선택하였다. 

$t_id = $_GET["t_id"];
$query1 = "select * from time_table natural join movie where t_id = $t_id";
$res1 = mysqli_query($conn, $query1);

if(!$res1) {
	mysqli_query("rollback", $conn);
}
else{
	mysqli_query("commit", $conn);
}
$table = mysqli_fetch_array($res1);

?>
<div id="wrapper">
	<div id="featured-wrapper">
		<div class="extra2 container">
			<form class="form-horizontal" name ="form" action="booking_insert.php" method="post">
			<input type="hidden" name="t_id" value="<?=$t_id?>"/>
			<div class="ebox1">
				<div class="hexagon"><span class="icon icon-lightbulb"></span></div>
				<div class="title">
					<h2>Booking ADD</h2>
				</div>
				<div class="form-group">
					<label for="genre" class="col-sm-2 control-label">제목</label>
    				<div class="col-xs-9">
    					<input readonly type="text" name="title" class="form-control" id="title" value="<?= $table['title'] ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="genre" class="col-sm-2 control-label">상영날짜</label>
    				<div class="col-xs-9">
    					<input readonly type="text" name="day" class="form-control" id="day" value="<?= $table['day'] ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="genre" class="col-sm-2 control-label">상영관</label>
    				<div class="col-xs-9">
    					<input readonly type="text" name="r_id" class="form-control" id="r_id" value="<?= $table['r_id'] ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="num_people" class="col-sm-2 control-label">인원</label>
    				<div class="col-xs-9">
    					<input type="text" name="num_people" class="form-control" id="num_people" placeholder="인원 입력" value ="<?=$booking['num_people']?>">
					</div>
				</div>
				<button class="button primary small" onclick="javascript:return validate();">Booking</button>
				<script>
                function validate() {
                    if(document.getElementById("num_people").value == "") {
                        alert ("인원을 입력해주십시오"); return false;
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
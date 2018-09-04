<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);
$mode = "ADD";
$action = "movie_insert.php";

mysqli_query("set autocommit = 0", $conn);
mysqli_query("set session transaction isolation level read committed", $conn); //read committed
mysqli_query("begin", $conn);

//해당 relation에서 정보를 읽어와서 보여주면 되므로 dirty read만 제한하도록 read committed를 선택하였다. 

if (array_key_exists("m_id", $_GET)) {
    $m_id = $_GET["m_id"];
    $query =  "select * from movie where m_id = $m_id";
    $ret = mysqli_query($conn, $query);
    if(!$ret) {
    	mysqli_query("rollback", $conn);
    }
    $movie = mysqli_fetch_array($ret);
    if(!$movie) {
        msg("NO MOVIE!");
    }
    $mode = "MODIFY";
    $action = "movie_modify.php";
}

//age 카테고리
$age = array();

$query = "select * from age";
$res = mysqli_query($conn, $query);
if(!$res){
	mysqli_query("rollback", $conn);
}
while($row = mysqli_fetch_array($res)) {
    $age[$row['a_id']] = $row['a_name'];
}

//genre 카테고리
$genre = array();

$query1 = "select * from genre";
$res1 = mysqli_query($conn, $query1);
if(!$res1) {
	mysqli_query("rollback", $conn);
}
while($row = mysqli_fetch_array($res1)) {
    $genre[$row['g_id']] = $row['g_name'];
}

//type 카테고리
$type = array();

$query2 = "select * from movie_inform";
$res2 = mysqli_query($conn, $query2);
if(!$res2) {
	mysqli_query("rollback", $conn);
}
else{
	mysqli_query("commit", $conn);
}
while($row = mysqli_fetch_array($res2)) {
    $type[$row['i_id']] = $row['i_name'];
}


?>
<div id="wrapper">
	<div id="featured-wrapper">
		<div class="extra2 container">
			<form class="form-horizontal" name ="form" action="<?=$action?>" method="post">
			<input type="hidden" name="m_id" value="<?=$movie['m_id']?>"/>
			<div class="ebox1">
				<div class="hexagon"><span class="icon icon-lightbulb"></span></div>
				<div class="title">
					<h2><?=$mode?></h2>
				</div>
				<div class="form-group">
					<label for="title" class="col-sm-2 control-label">제목</label>
    				<div class="col-sm-10">
    					<input type="text" name="title" class="form-control" id="title" placeholder="제목입력" value="<?=$movie['title']?>">
					</div>
				</div>
				<div class="form-group">
					<label for="g_id" class="col-sm-2 control-label">개요</label>
    				<div class="col-sm-10">
    					<select name="g_id" id="g_id" class="form-control">
    						<option value="-1">개요를 선택해주세요</option>
        					<?
                        		foreach($genre as $id => $name) {
                            		if($id == $movie['a_id']){
                                		echo "<option value='{$id}' selected>{$name}</option>";
                        			} 
                        			else {
                                		echo "<option value='{$id}'>{$name}</option>";
                            		}
                        		}
                    		?>
    					</select>
					</div>
				</div>
				<div class="form-group">
					<label for="a_id" class="col-sm-2 control-label">등급</label>
    				<div class="col-sm-10">
    					<select name="a_id" id="a_id" class="form-control">
    						<option value="-1">등급을 선택해주세요</option>
                    		<?
                        		foreach($age as $id => $name) {
                            		if($id == $movie['a_id']) {
                            		    echo "<option value='{$id}' selected>{$name}</option>";
                            		} 
                            		else {
                            	 		echo "<option value='{$id}'>{$name}</option>";
                            		}
                    			}
                    		?>
    					</select>
					</div>
				</div>
				<div class="form-group">
					<label for="date" class="col-sm-2 control-label">개봉일</label>
    				<div class="col-sm-10">
    					<input type="text" name="date" class="form-control" id="date" placeholder="YYYY-MM-DD" value ="<?=$movie['open_date']?>">
					</div>
				</div>
				<div class="form-group">
					<label for="i_id" class="col-sm-2 control-label">상영정보</label>
    				<div class="col-sm-10">
    					<select name="i_id" id="i_id" class="form-control">
							<option value="-1">상영정보를 선택해주세요</option>
                    		<?
                        		foreach($type as $id => $name) {
                            		if($id == $movie['i_id']){
                                		echo "<option value='{$id}' selected>{$name}</option>";
                            		} 
                            		else {
                                		echo "<option value='{$id}'>{$name}</option>";
                            		}
                        		}
                    		?>
    					</select>
					</div>
				</div>
				<button class="button primary small" onclick="javascript:return validate();"><?=$mode?></button>
				<script>
                function validate() {
                    if(document.getElementById("a_id").value == "-1") {
                        alert ("연령등급을 선택해주십시오"); return false;
                    }
                    else if(document.getElementById("g_id").value == "-1") {
                        alert ("장르를 선택해주십시오"); return false;
                    }
                    else if(document.getElementById("i_id").value == "-1") {
                        alert ("상영정보를 선택해주십시오"); return false;
                    }
                    else if(document.getElementById("title").value == "") {
                        alert ("제목을 입력해주십시오"); return false;
                    }
                    else if(document.getElementById("date").value == "") {
                        alert ("개봉일을 입력해주십시오"); return false;
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
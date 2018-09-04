<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

if (array_key_exists("m_id", $_GET)) {
	mysqli_query("set autocommit = 0", $conn);
	mysqli_query("set session transaction isolation level read committed", $conn); //read committed
	mysqli_query("begin", $conn);
	
	//해당 relation에서 정보를 읽어와서 보여주면 되므로 dirty read만 제한하도록 read committed를 선택하였다. 

    $m_id = $_GET["m_id"];
    $query = "select * from movie natural join genre natural join age natural join movie_inform where m_id = $m_id";
    $res = mysqli_query($conn, $query);
    
    if(!res){ //rollback이 발생한 경우
    	mysqli_query("rollback", $conn);
        die('Query Error : ' . mysqli_error());
    } 
    else{ //commit이 발생한 경우
    	mysqli_query("commit", $conn);
    	$movie = mysqli_fetch_assoc($res);
    	if (!$movie) {
        	msg("No Movie!");
    	}
    }
}
?>
<div id="wrapper">
	<div id="featured-wrapper">
		<div class="extra2 container">
			<div class="ebox1">
				<div class="hexagon"><span class="icon icon-tag"></span></div>
				<div class="title">
					<h2><?=$movie['title']?></h2>
				</div>
				<div class="form-group">
					<label for="genre" class="col-sm-2 control-label">개요</label>
    				<div class="col-xs-9">
    					<input readonly type="text" name="genre" class="form-control" id="genre" value="<?= $movie['g_name'] ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="age" class="col-sm-2 control-label">등급</label>
    				<div class="col-xs-9">
    					<input readonly type="text" name="age" class="form-control" id="age" value="<?= $movie['a_name'] ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="date" class="col-sm-2 control-label">개봉일</label>
    				<div class="col-xs-9">
    					<input readonly type="text" name="date" class="form-control" id="date" value="<?= $movie['open_date'] ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="type" class="col-sm-2 control-label">상영정보</label>
    				<div class="col-xs-9">
    					<input readonly type="text" name="type" class="form-control" id="type" value="<?= $movie['i_name'] ?>">
					</div>
				</div>
			</div>
		</div>
		<div class="extra2 container">
			<form action = "comment_insert.php" method="post">
			<div class="ebox2">
				<div class="hexagon"><span class="icon icon-pencil"></span></div>
				<div class="title">
					<h2>Comments</h2>
				</div>
				<div class="input-group">
					<input type="hidden" name="movie_id" value="<?=$movie['m_id']?>"/>
    				<input type="text" name="comment" class="form-control" placeholder="Write comment about movie!">
    				<span class="input-group-btn">
        				<button class="btn btn-default">Enter!</button>
    				</span>
    			</div>
    			</form>
    			<table class="table table-condensed">
    				<thead>
    					<tr>
    						<th><center>#</center></th>
    						<th><center>ID</center></th>
    						<th><center>COMMENTS</center></th>
    						<th>  </th>
    					</tr>
    				</thead>
    				<tbody>
    					<?
    					mysqli_query("set autocommit = 0", $conn);
						mysqli_query("set session transaction isolation level read committed", $conn); //read committed
						mysqli_query("begin", $conn);
						
						//해당 relation에서 정보를 읽어와서 보여주면 되므로 dirty read만 제한하도록 read committed를 선택하였다. 
    					
    					$query2 = "select * from comments";
    					$res2 = mysqli_query($conn, $query2);
    					
    					if(!$res2) { //rollback이 발생한 경우
    						mysqli_query("rollback", $conn);
    						die('Query Error : ' . mysqli_error());
    					}
    					else{ //commit이 발생한 경우
    						mysqli_query("commit", $conn);
    						$row_index2 = 1;
        					while ($row = mysqli_fetch_array($res2)) {
        						if($row['m_id']==$m_id){
        							$comment_id = $row['comment_id'];
        							$movie_id = $row['m_id'];
            						echo "<tr>";
            						echo "<td>{$row_index2}</td>";
            						echo "<td>{$row['c_id']}</td>";
            						echo "<td>{$row['comment']}</td>";
            						if(!check_pass($row['c_id'],$_COOKIE[cookie_id])){
            							echo "<td><a href='comment_delete.php?comment_id={$comment_id}&m_id={$movie_id}'><span class='icon icon-remove'></span></a></td>";
            						}
            						echo "</tr>";
            						$row_index2++;
        						}
        					}
    					}
        				?>
    				</tbody>
    			</table>
			</div>	
		</div>
	</div>
</div>
<? include "footer.php" ?>
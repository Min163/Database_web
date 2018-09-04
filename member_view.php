<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

if (array_key_exists("c_id", $_GET)) {
	mysqli_query("set autocommit = 0", $conn);
	mysqli_query("set session transaction isolation level read committed", $conn); //read committed
	mysqli_query("begin", $conn);
	
	//해당 relation에서 정보를 읽어와서 보여주면 되므로 dirty read만 제한하도록 read committed를 선택하였다. 
	
    $c_id = $_GET["c_id"];
    $query = "select * from customer where c_id = '$c_id'";
    $res = mysqli_query($conn, $query);
    if(!$res){ //roll back이 발생한 경우
    	mysqli_query("rollback", $conn);
    	msg('Query Error : '.mysqli_error($conn));
    }
    else { //commit이 발생한 경우
    	mysqli_query("commit", $conn);
    	$member = mysqli_fetch_assoc($res);
    	if (!$member) {
    	    msg("ERROR!");
    	}
    }
}
?>
<div id="wrapper">
	<div id="featured-wrapper">
		<div class="extra2 container">
			<div class="ebox1">
				<div class="hexagon"><span class="icon icon-comment"></span></div>
				<div class="title">
					<h2>My Information</h2>
				</div>
				<div class="form-group">
					<label for="c_id" class="col-sm-2 control-label">ID</label>
    				<div class="col-sm-9">
    					<input readonly type="text" name="c_id" class="form-control" id="c_id" value="<?= $member['c_id'] ?>">
					</div>
				</div> 
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">Name</label>
    				<div class="col-sm-9">
					   	<input readonly type="text" name="name" class="form-control" id="name" value="<?= $member['name'] ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="birth" class="col-sm-2 control-label">Birth</label>
					<div class="col-sm-9">
					   	<input readonly type="text" name="birth" class="form-control" id="birth" value="<?= $member['birth'] ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="phone" class="col-sm-2 control-label">Phone Number</label>
    				<div class="col-sm-9">
					   	<input readonly type="text" name="phone" class="form-control" id="phone" value="<?= $member['phone'] ?>">
					</div>
				</div>
				<?php 
				$c_id = $member['c_id'];
				echo "<a href='member_form.php?c_id={$member['c_id']}'><button class='button primary small'>수정</button></a>";
				//echo "<button onclick='javascript:deleteConfrim($c_id)' class='button danger small'>탈퇴</button>";
                echo "<a href='member_delete.php?c_id={$member['c_id']}'><button class='button danger small'>탈퇴</button></a>";
    			?>
			</div>		

			<div class="ebox2">
				<div class="hexagon"><span class="icon icon-star"></span></div>
				<div class="title">
					<h2>My Movie List</h2>
				</div>
				<table class="table table-hover table-condensed">
					<thead>
						<tr>
							<th><center>#</center></th>
							<th><center>Title</center></th>
							<th> </th>
						</tr>
					</thead>
					<tbody>
						<?php
						mysqli_query("set autocommit = 0", $conn);
						mysqli_query("set session transaction isolation level read committed", $conn); //read committed
						mysqli_query("begin", $conn);
						
						//해당 relation에서 정보를 읽어와서 보여주면 되므로 dirty read만 제한하도록 read committed를 선택하였다. 
						
    					$c_id = $_GET["c_id"];
    					$query = "select * from likes natural join movie where c_id = '$c_id'";
						$res = mysqli_query($conn, $query);
						
						if(!$res){ //roll back이 발생한 경우
							mysqli_query("rollback", $conn);
    						msg('Query Error : '.mysqli_error($conn));
						}
						else{ //commit이 발생한 경우
							mysqli_query("commit", $conn);
							$row_index = 1;
    						while($row = mysqli_fetch_array($res)){
    							$l_id = $row['l_id'];
    							echo "<tr>";
    							echo "<td>{$row_index}</td>";
    							echo "<td><a href='movie_view.php?m_id={$row['m_id']}'>{$row['title']}</a></td>";?>
    							<?php echo "<td><a href='like_delete.php?l_id={$l_id}'>";?><span class="icon icon-heart"></span><?php echo "</a></td>";?>
    							<?echo "</tr>";
    							$row_index++;
    						}	
						}
    					?>
					</tbody>
				</table>
			</div>		
		</div>	
	</div>
	<script>
    	function deleteConfirm(id) {
           	if (confirm("정말 탈퇴하시겠습니까?") == true) {    //확인
               	window.location = "member_delete.php?c_id=" + id;
           	}
           	else {   //취소
               	return;
           	}
        }
	</script>
</div>
<? include "footer.php" ?>
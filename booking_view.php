<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>
<div id="wrapper">
	<div id="featured-wrapper">
		<div class="extra2 container">
			<div class="ebox1">
				<div class="hexagon"><span class="icon icon-lightbulb"></span></div>
				<div class="title">
					<h2>Booking List</h2>
				</div>
				 <?
    			$conn = dbconnect($host, $dbid, $dbpass, $dbname);
    			
    			mysqli_query("set autocommit = 0", $conn);
				mysqli_query("set session transaction isolation level read committed", $conn); //read committed
				mysqli_query("begin", $conn);
    			
    			//해당 relation에서 정보를 읽어와서 보여주면 되므로 dirty read만 제한하도록 read committed를 선택하였다. 
    			
				$query = "select * from booking_list natural join movie natural join time_table where c_id = '$_COOKIE[cookie_id]'";
    			$res = mysqli_query($conn, $query);
    			
    			if (!$res) { //rollback이 발생한 경우
    				mysqli_query("rollback", $conn);
        			die('Query Error : ' . mysqli_error());
    			}
    			else{ //commit이 발생한 경우
    				mysqli_query("commit", $conn);
    			}
    			?>
    			<table class="table table-hover table-condensed">
    				<thead>
    					<tr>
    						<th><center>#</center></th>
    						<th><center>제목</center></th>
    						<th><center>상영 날짜</center></th>
    						<th><center>예매 날짜</center></th>
    						<th><center>예매 인원</center></th>
    						<th></th>
    					</tr>
    				</thead>
    				<tbody>
    					<?
        				$row_index = 1;
        				while ($row = mysqli_fetch_array($res)) {
            				echo "<tr>";
            				echo "<td><center>{$row_index}</center></td>";
            				echo "<td><a href='movie_view.php?m_id={$row['m_id']}'><center>{$row['title']}</center></a></td>";
            				echo "<td><center>{$row['day']}</center></td>";
            				echo "<td><center>{$row['book_date']}</center></td>";
            				echo "<td><center>{$row['num_people']}</center></td>";
        					$b_id = $row['b_id'];
        					if(!$_COOKIE[cookie_id] || !$_COOKIE[cookie_name]){
								echo "<td></td>";
        					}
        					else if ($_COOKIE[cookie_admin] == 0) {
    							echo "<td><span onclick='javascript:deleteConfirm({$b_id})' class='icon icon-remove'></span></td>";
        					}
        					else {
            					echo "<td></td>";
        					}
            				echo "</tr>";
            				$row_index++;
        				}
        				?>
        				<!--<button onclick='javascript:deleteConfirm({$m_id})' class='button danger small'>삭제</button>
        				<button class='button primary small'>수정</button>-->
    				</tbody>
    			</table>
    			<script>
        			function deleteConfirm(id) {
        		    	if (confirm("정말 삭제하시겠습니까?") == true){    //확인
            			    window.location = "booking_delete.php?b_id=" + id;
        		    	}
        		    	else {   //취소/home/db2018/db363/public_html/movie_list.php
            			    return;
        				}
        			}
    			</script>
			</div>		
		</div>	
	</div>
</div>
<? include "footer.php" ?>
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
					<h2>Movie List</h2>
				</div>
				 <?
    			$conn = dbconnect($host, $dbid, $dbpass, $dbname);
    			
    			mysqli_query("set autocommit = 0", $conn);
				mysqli_query("set session transaction isolation level read committed", $conn); //read committed
				mysqli_query("begin", $conn);
    			
    			//해당 relation에서 정보를 읽어와서 보여주면 되므로 dirty read만 제한하도록 read committed를 선택하였다. 
    			
				$query = "select * from movie natural join genre natural join age natural join movie_inform";
    			if (array_key_exists("search_keyword", $_POST)) {  // array_key_exists() : Checks if the specified key exists in the array
        			$search_keyword = $_POST["search_keyword"];
    				$query =  $query . " where title like '%$search_keyword%'";
    
			    }
    			$res = mysqli_query($conn, $query);
    			
    			if (!$res) { //rollback이 발생한 경우
    				mysqli_query("rollback", $conn);
        			die('Query Error : ' . mysqli_error());
    			}
    			else { //commit이 발생한 경우
    				mysqli_query("commit", $conn);
    			}
    			?>
    			<table class="table table-hover table-condensed">
    				<thead>
    					<tr>
    						<th><center>#</center></th>
    						<th><center>제목</center></th>
    						<th><center>개요</center></th>
    						<th><center>개봉일</center></th>
    						<th><center>등급</center></th>
    						<th><center>상영정보</center></th>
    						<th>  </th>
    						<th>  </th>
    					</tr>
    				</thead>
    				<tbody>
    					<?
        				$row_index = 1;
        				while ($row = mysqli_fetch_array($res)) {
            				echo "<tr>";
            				echo "<td><center>{$row_index}</center></td>";
            				echo "<td><a href='movie_view.php?m_id={$row['m_id']}'><center>{$row['title']}</center></a></td>";
            				echo "<td><center>{$row['g_name']}</center></td>";
            				echo "<td><center>{$row['open_date']}</center></td>";
            				echo "<td><center>{$row['a_name']}</center></td>";
        					echo "<td><center>{$row['i_name']}</center></td>";
        					$m_id = $row['m_id'];
        					//s_msg($_COOKIE[cookie_admin]);
        					if(!$_COOKIE[cookie_id] || !$_COOKIE[cookie_name]){
								echo "<td></td>";
        					}
        					else if ($_COOKIE[cookie_admin] == 0) {
    							echo "<td>
            						  <a href='like_insert.php?m_id={$row['m_id']}'><span class='icon icon-heart-empty'></span></a>
            						  </td>";
        					}
        					else {
            					echo "<td>
            						  <a href='movie_form.php?m_id={$row['m_id']}'><span class='icon icon-plus'></span></a>
            						  </td>
            						  <td>
            				    	  <span onclick='javascript:deleteConfirm({$m_id})' class='icon icon-remove'></span>
            				    	  </td>";
        					}
            				echo "</tr>";
            				$row_index++;
        				}
        			?>
        				<!--<button onclick='javascript:deleteConfirm({$m_id})' class='button danger small'>삭제</button>
        				<button class='button primary small'>수정</button>-->
    				</tbody>
    			</table>
    			<?
    			if(!$_COOKIE[cookie_id] || !$_COOKIE[cookie_name]){
    				echo "";
    			}
    			else if($_COOKIE[cookie_admin] == 0){
    				echo "";
    			}
    			else {
    				echo "<a href='movie_form.php'><button class='button primary small'>ADD MOVIE</button></a>";
    			}
    			?>
    			<script>
        			function deleteConfirm(id) {
        		    	if (confirm("정말 삭제하시겠습니까?") == true){    //확인
            			    window.location = "movie_delete.php?m_id=" + id;
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
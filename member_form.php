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
    if(!$res){
    	mysqli_query("rollback", $conn);
    }
    else{
    	mysqli_query("commit", $conn);
    }
    $member = mysqli_fetch_assoc($res);
    if (!$member) {
        msg("ERROR!");
    }
}

$row = mysqli_fetch_array($res);
?>
<div id="wrapper">
	<div id="featured-wrapper">
		<form class="form-horizontal" name ="form" action="member_modify.php" method="post">
		<input type="hidden" name="c_id" value="<?=$member['c_id']?>"/>
		<div class="extra1 container">
			<div class="ebox1">
				<div class="hexagon"><span class="icon icon-lightbulb"></span></div>
				<div class="title">
					<h2>Modify My Information</h2>
				</div>
			</div>		
		</div>	
		<div class="form-group">
			<label for="c_id" class="col-sm-2 control-label">ID</label>
    		<div class="col-xs-9">
    			<input readonly type="text" name="c_id" class="form-control" id="c_id" value="<?=$member['c_id']?>">
			</div>
		</div>
		<div class="form-group">
			<label for="pwd" class="col-sm-2 control-label">Password</label>
    		<div class="col-xs-9">
			   	<input name="pwd" type="password" class="form-control" id="pwd" value="<?=$member['pwd']?>">
			</div>
		</div>
		<div class="form-group">
			<label for="name" class="col-sm-2 control-label">Name</label>
    		<div class="col-xs-9">
			   	<input name="name" type="text" class="form-control" id="name" value="<?=$member['name']?>">
			</div>
		</div>
		<div class="form-group">
			<label for="birth" class="col-sm-2 control-label">Birth</label>
    		<div class="col-xs-9">
			   	<input name="birth" type="text" class="form-control" id="birth" value="<?=$member['birth']?>">
			</div>
		</div>
		<div class="form-group">
			<label for="phone" class="col-sm-2 control-label">Phone Number</label>
    		<div class="col-xs-9">
			   	<input name="phone" type="text" class="form-control" id="text" value="<?=$member['phone']?>">
			</div>
		</div>
		<div class="form-group">
    		<button type="submit" class="btn btn-warning" onclick="javascript:return validate();">Modify</button>
    	</div>
    	
    	<script>
                function validate() {
                    if(document.getElementById("c_id").value == "") {
                        alert ("No ID!"); return false;
                    }
                    else if(document.getElementById("pwd").value == "") {
                        alert ("No Password!"); return false;
                    }
                    else if(document.getElementById("name").value == "") {
                        alert ("No Name"); return false;
                    }
                    else if(document.getElementById("birth").value == "") {
                        alert ("No Birth!"); return false;
                    }
                    else if(document.getElementById("phone").value == "") {
                        alert ("No Phone Number!"); return false;
                    }
                    return true;
                }
        </script>
    	</form>
	</div>
</div>
<? include "footer.php" ?>
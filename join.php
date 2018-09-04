<? include "header.php" ?>
<div id="wrapper">
	<div id="featured-wrapper">
		<form class="form-horizontal" name ="form" action="join_insert.php" method="post">
		<div class="extra1 container">
			<div class="ebox1">
				<div class="hexagon"><span class="icon icon-lightbulb"></span></div>
				<div class="title">
					<h2>Join</h2>
				</div>
				
			</div>		
		</div>	
		<div class="form-group">
			<label for="inputEmail3" class="col-sm-3 control-label">ID</label>
    		<div class="col-xs-7">
    			<input name="ID" type="id" class="form-control" id="ID" placeholder="ID">
			</div>
		</div>
		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label">Password</label>
    		<div class="col-xs-7">
			   	<input name="pwd" type="password" class="form-control" id="pwd" placeholder="Password">
			</div>
		</div>
		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label">Password Check</label>
    		<div class="col-xs-7">
			   	<input name="c_pwd" type="password" class="form-control" id="c_pwd" placeholder="Password Check">
			</div>
		</div>
		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label">Name</label>
    		<div class="col-xs-7">
			   	<input name="name" type="id" class="form-control" id="name" placeholder="Name">
			</div>
		</div>
		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label">Birth</label>
    		<div class="col-xs-7">
			   	<input name="birth" type="id" class="form-control" id="birth" placeholder="ex) YYYY-MM-DD">
			</div>
		</div>
		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label">Phone Number</label>
    		<div class="col-xs-7">
			   	<input name="phone" type="id" class="form-control" id="phone" placeholder="ex) 000-0000-0000">
			</div>
		</div>
		<div class="form-group">
    		<div class="col-sm-offset-1 col-sm-10">
    			<button type="submit" class="btn btn-warning" onclick="javascript:return validate();">Join</button>
    		</div>
    	</div>
    	</form>
	</div>
	<script>
                function validate() {
                    if(document.getElementById("ID").value == "") {
                        alert ("No ID!"); return false;
                    }
                    else if(document.getElementById("pwd").value == "") {
                        alert ("No Password!"); return false;
                    }
                     else if(document.getElementById("c_pwd").value == "") {
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
</div>
<? include "footer.php" ?>
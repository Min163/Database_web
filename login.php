<? include "header.php" ?>
<div id="wrapper">
	<div id="featured-wrapper">
		<form class="form-horizontal" name ="form" action="login_confirm.php" method="post">
			<div class="extra2 container">
				<div class="ebox1">
					<div class="hexagon"><span class="icon icon-lightbulb"></span></div>
					<div class="title">
						<h2>Login</h2>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">ID</label>
    					<div class="col-xs-6">
    						<input name="ID" type="id" class="form-control" id="inputEmail3" placeholder="ID">
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-3 control-label">Password</label>
    					<div class="col-xs-6">
					    	<input name="pwd" type="password" class="form-control" id="inputPassword3" placeholder="Password">
						</div>
					</div>
					<div class="form-group">
    						<button type="submit" class="btn btn-warning">Sign in</button>
    				</div>
				</div>
			</div>
		</form>
		<div class="extra2 container">
			<div class="ebox1">
				<span>회원이 아니신가요?</span><br>
				<button type="submit" class="btn btn-warning"><a href="join.php">Join</a></button>
			</div>
		</div>
	</div>
</div>
<? include "footer.php" ?>

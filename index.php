<? include "header.php" ?>
<div id="wrapper">
	<div id="featured-wrapper">
		<div class="extra2 container">
			<form action = "movie_list.php" method="post">
			<div class="ebox1">
				<div class="hexagon"><span class="icon icon-search"></span></div>
				<div class="title">
					<h2>Search for Movie</h2>
					<span class="byline">보고 싶은 영화를 검색하세요!</span>
				</div>
				<div class="input-group">
    				<input type="text" name="search_keyword" class="form-control" placeholder="Search for Movie">
    					<span class="input-group-btn">
        					<button class="btn btn-default">Go!</button>
    					</span>
    			</div>
			</div>	
			</form>
		</div>	
	</div>
</div>
<? include "footer.php" ?>
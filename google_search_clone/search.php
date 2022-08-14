<?php 

	include("config.php");
	include("classes/SiteResultsProvider.php");
	include("classes/ImageResultsProvider.php");


	if (isset($_GET['term'])) {
		$term = $_GET['term'];
	}
	else{
		exit("you must enter a search term");
	}

	if (isset($_GET['type'])) {
		$type= $_GET['type'];
	}else{
		$type = "sites";
	}

	if (isset($_GET['page'])) {
		$page= $_GET['page'];
	}else{
		$page = 1;
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Welcome to Doodle</title>
	<link rel="stylesheet" type="text/css" href="assets/css/fancybox.css">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<script type="text/javascript" src="assets/js/jquery-3.5.1.min.js"></script>
</head>
<body>

	<div class="wrapper">
		<div class="header">
			<div class="headerContent">
				<div class="logoContainer">
					<a href="index.php"><img src="assets/images/doodleLogo.png" alt="site logo"></a>
					
				</div>
				<div class="searchContainer">
					<form action="search.php" method="GET">
						<div class="searchBarContainer">
							<input type="hidden" name="type" value="<?php echo $type; ?>">
							<input type="text" class="searchBox" name="term" value="<?php echo $term; ?>">
							<button class="searchButton">
								<img src="assets/images/icons/search.png" alt="">
							</button>
						</div>
					</form>
				</div>
			</div>

			<div class="tabsContainer">
				<ul class="tabList">
					<li class="<?php echo $type == 'sites' ? 'active' : ''; ?>">
						<a href='<?php echo "search.php?term=$term&type=sites"; ?>'>
							Sites
						</a>
					</li>

					<li class="<?php echo $type == 'images' ? 'active' : ''; ?>">
						<a href='<?php echo "search.php?term=$term&type=images"; ?>'>
							Images
						</a>
					</li>
				</ul>
			</div>

		</div>

		<div class="mainResultsSection">
			<?php 

			if ($type == "sites") {
				$resultsProvider = new SiteResultsProvider($con);
				$pageSize = 20;			
			}
			else{
				$resultsProvider = new ImageResultsProvider($con);
				$pageSize = 30;
			}
				
			$numResults = $resultsProvider->getNumResults($term);

		
			echo "<p class='resultsCount'>$numResults results found</p>";
			echo $resultsProvider->getResultsHtml($page, $pageSize, $term);

			 ?>
		</div>	

		<div class="paginationContainer">
			<div class="pageButtons">
				<div class="pageNumberContainer">
					<img src="assets/images/pageStart.png" alt="">
				</div>

				<?php 
				$pagesToShow = 10;
				$numPages = ceil($numResults / $pageSize); // ceil: round up the value

				if ($page > $numPages) {
					
					$page = $numPages;
				}

				$pagesLeft = min($pagesToShow, $numPages); //show the lowest value

				$currentPage = $page - floor($pagesToShow / 2); // floor :round the value

				if ($currentPage < 1) {
					$currentPage = 1;
				}

				if ($currentPage + $pagesLeft > $numPages + 1) {
					$currentPage = ($NumPages + 1) - $pagesLeft;
				}

				while ($pagesLeft != 0 && $currentPage <= $numPages ) {

					if ($currentPage == $page) {
						echo "<div class='pageNumberContainer'>
						<img src='assets/images/pageSelected.png'>
						<span class='pageNumber'>$currentPage</span> 
						</div>";
					}
					else{
						echo "<div class='pageNumberContainer'>
						<a href='search.php?term=$term&type=$type&page=$currentPage'>
						<img src='assets/images/page.png'>
						<span class='pageNumber'>$currentPage</span>
						</a>
						</div>";

					}
					

					$currentPage++;
					$pagesLeft--;
				}



				?>

				<div class="pageNumberContainer">
					<img src="assets/images/pageEnd.png" alt="">
				</div>
			</div>
			
		</div>
	</div>
	<script src="assets/js/fancybox.umd.js"></script>
	<script src="assets/js/masonry.pkgd.min.js"></script>
	<script type="text/javascript" src='assets/js/script.js'></script>
</body>
</html>
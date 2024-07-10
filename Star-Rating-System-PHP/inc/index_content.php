
<div class="container">
	<!-- <h2>Example: Star Rating System with Ajax, PHP and MySQL</h2> -->
	<h2>Star Rating System</h2>
	<?php

	include_once 'class/Rating.php';

	$rating = new Rating();
	$productList = $rating->getProductList();
	foreach($productList as $product){
		$average = $rating->getRatingAverage($product["id"]);
		$count = $rating->getRatingTotal($product['id']);
	?>
	<div class="row">
		<div class="col-sm-2" style="width:150px">
			<img class="product_image" src="image/<?php echo $product["image"]; ?>" style="width:200px;height:200px;padding:20px;">
		</div>
		<div class="col-sm-4">
		<h4 style="margin-top:10px;"><a href="product_detail.php?product_id=<?php echo $product["id"]; ?>"><?php echo $product["name"]; ?></a></h4>

		<?php



				//$averageRating = round($average, 0);
				for ($i = 1; $i <= 5; $i++) {
					$ratingClass = "star-grey";
					if($i <= $average) {
						$ratingClass = "star-highlight";
					}


				echo	'<i class="fa fa-star '.$ratingClass. '"; aria-hidden="true"></i>';

				 }
				echo $count . ' Reviews';
			?>
	<!--	<div><span class="average"><?php printf('%.1f', $average); ?> <small>/ 5</small></span> <span class="rating-reviews"><a href="show_rating.php?product_id=<?php echo $product["id"]; ?>">Rating & Reviews</a></span></div>-->
	  <?php
		  echo '<br>';
		  echo '<div class = "product_price">$'.$product["price"].'</div>';
		  echo $product["description"];

		 ?>
		</div>
	</div>
	<?php } ?>
</div>
</div>

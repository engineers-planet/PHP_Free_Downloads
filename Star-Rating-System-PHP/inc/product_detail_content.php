



<div class="container">
	<h2>Product Detail Page</h2>
	<?php

	include 'class/Rating.php';
	$rating = new Rating();
	$productDetails = $rating->getProduct($_GET['product_id']);
	$average = $rating->getRatingAverage($_GET['product_id']);
	$count = $rating->getRatingTotal($_GET['product_id']);
	$settingClass = $rating->getSetting();


	foreach($productDetails as $product){
		$average = $rating->getRatingAverage($product["id"]);


	?>
	<div class="row">
		<div class="col-sm-2" style="width:150px">
			<img class="product_image" src="image/<?php echo $product["image"]; ?>" style="width:200px;height:200px;padding:20px  25px;">
		</div>
		<div class="col-sm-4">
		<h4 style="margin-top:10px;"><?php echo $product["name"]; ?></h4>
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
		<!--<div><span class="average"><?php printf('%.1f', $average); ?> <small>/ 5</small></span> <span class="rating-reviews"><a href="show_rating.php?product_id=<?php echo $product["id"]; ?>">Rating & Reviews</a></span></div> -->
   <?php
		echo '<br>';
		echo '<div class = "product_price">$'.$product["price"].'</div>';
		 echo $product["description"]; ?>
		</div>
	</div>
	<?php } ?>




	<br>
	<div >
		<div class="row">
			<!--
			<div class="col-sm-3">


				<?php
				//$averageRating = round($average, 0);
				for ($i = 1; $i <= 5; $i++) {
					$ratingClass = "star-grey";
					if($i <= $average) {
						$ratingClass = "star-highlight";
					}
				?>

					<i class="fa fa-star fa-lg <?php echo $ratingClass; ?>" aria-hidden="true"></i>

				<?php } ?>
				<?php echo $count. ' Reviews'; ?>
			</div>
-->
			<div class="col-sm-3">

			</div>

			<div class="col-sm-3">
				<button type="button" id="rateProduct" class="btn btn-secondary btn-sm <?php if(empty($_SESSION['userid'])){echo $settingClass;}  ?>">Rate This Product</button>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-7">
				<div id="ratingSection" style="display:none;">
					<hr/>
					<div class="row">
						<div class="col-sm-12">
							<form id="ratingForm" method="POST">
								<div class="form-group">
									<h4>Rate this product</h4>
										<i class="fa fa-star fa-lg star-grey rateButton" aria-hidden="true"></i>
										<i class="fa fa-star fa-lg star-grey rateButton" aria-hidden="true"></i>
										<i class="fa fa-star fa-lg star-grey rateButton" aria-hidden="true"></i>
										<i class="fa fa-star fa-lg star-grey rateButton" aria-hidden="true"></i>
										<i class="fa fa-star fa-lg star-grey rateButton" aria-hidden="true"></i>


									<input type="hidden" class="form-control" id="rating" name="rating" value="1">
									<input type="hidden" class="form-control" id="product_id" name="product_id" value="<?php echo $_GET['product_id']; ?>">
									<input type="hidden" name="action" value="saveRating">
								</div>
								<div class="form-group">
									<label for="usr">Title</label>
									<input type="text" class="form-control" id="title" name="title" required>
								</div>
								<div class="form-group">
									<label for="comment">Review</label>
									<textarea class="form-control" rows="5" id="comment" name="comment" required></textarea>
								</div>
								<div class="form-group">
									<label for="name">Name</label>
										<input type="text" class="form-control"  id = "reviewer" name="reviewer" placeholder="Username" required>
								</div>
								<div class="form-group">
									<label for="email">Email</label>
									<input type="email" class="form-control" id = "email"  name="email" placeholder="Email" required>
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-secondary btn-sm" id="saveReview">Post</button> <button type="button" class="btn btn-secondary btn-sm" id="cancelReview">Cancel</button>
								</div>
							</form>
						</div>
					</div>
				</div>

				<h5>REVIEWS</h5>
				<?php echo $count . ' Reviews'; ?>

				<hr/>
				<div id="ratingDetails">
				<?php
				$productRating = $rating->getProductRating($_GET['product_id']);
				foreach($productRating as $rating){
					$date=date_create($rating['created_at']);
					$reviewDate = date_format($date,"M d, Y");
				//	$profilePic = "profile.png";
				//	if($rating['avatar']) {
				//		$profilePic = $rating['avatar'];
				//	}
				?>
					<div class="row">
						<div class="col-sm-3">
							<!--<img src="image/userpics/<?php echo $profilePic; ?>" class="img-rounded user-pic">-->
							<!--display the first letter of the reviewer name   -->
							<div class="circle">
                <div><?php echo strtoupper($rating['reviewer'][0]); ?></div>
              </div>
							<?php
						  	//check if the reviewer is a registered buyer or not
								if($rating['user_id']) {
									echo '<div class = "review-block-verified-name">Verified Buyer</div>';
								}
							?>
							<div class="review-block-name">By <?php echo $rating['reviewer']; ?></div>
						</div>

						<div class="col-sm-6">
							<div class="review-block-rate">
								<?php
								for ($i = 1; $i <= 5; $i++) {
									$ratingClass = "star-grey";
									if($i <= $rating['rating_score']) {
										$ratingClass = "star-highlight";
									}
								?>

								 <i class="fa fa-star <?php echo $ratingClass; ?>" aria-hidden="true"></i>

								<?php } ?>
							</div>
							<div class="review-block-title"><?php echo $rating['title']; ?></div>
							<div class="review-block-description"><?php echo $rating['comment']; ?></div>
						</div>

						<div class="col-sm-3">
							<div class="review-block-date"><?php echo $reviewDate; ?></div>
						</div>


					</div>
					<hr/>
				<?php } ?>
				</div>
			</div>
		</div>
	</div>


	<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Login to rate this product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<div style="display:none;" id="loginError" class="alert alert-danger">Invalid username/Password</div>
				<form method="post" id="loginForm" name="loginForm">
					<input type="text" name="user" placeholder="Username" required>
					<input type="password" name="pass" placeholder="Password" required>
					<input type="hidden" name="action" value="userLogin">
					<input type="submit" name="login" class="login loginmodal-submit" value="Login">
				</form>
				<div class="login-help">
					<p><b>Username</b> : joseph, mary, lisa <b>Password</b>: 123</p>
				</div>
      </div>

    </div>
  </div>
</div>



</div>

<?php 

    ob_start();
    session_start();

    require_once 'config/connect.php';
    include 'inc/index_header.php'; 
    include 'inc/nav.php'; 

    if(isset($_GET['id']) & !empty($_GET['id'])) {
        $id = $_GET['id'];
        $prodsql = "SELECT * FROM products 
                    WHERE id=$id";
        
        $prodres = mysqli_query($connection, $prodsql);
        $prodr = mysqli_fetch_assoc($prodres);
    }

    else {
        header('location: index.php');
    }

    $uid = $_SESSION['customerid'];

    if(isset($_POST) & !empty($_POST)) {

        $review = filter_var($_POST['review'], FILTER_SANITIZE_STRING);

        $revsql = "INSERT INTO reviews (pid, uid, review) VALUES ($id, $uid, '$review')";
        $revres = mysqli_query($connection, $revsql);

    }

?>
	<!-- CONTENT -->
	<section id="content">
		<div class="content-blog">
			<div class="container">
				<div class="row">
					<div class="page_header text-center">
						<h2><?php echo $prodr['name']; ?></h2>
					</div>

					<div class="col-md-10 col-md-offset-1">
                        
                        <?php if(isset($fmsg)){ ?><div class="alert alert-danger" role="alert"> <?php echo $fmsg; ?> </div><?php } ?>
                        <?php if(isset($smsg)){ ?><div class="alert alert-success" role="alert"> <?php echo $smsg; ?> </div><?php } ?>
                        
                        <div class="row">
                            <div class="col-md-5">
                                <div class="gal-wrap">
                                    <div id="gal-slider" class="flexslider">
                                        <ul class="slides">
                                            <li><img src="admin/<?php echo $prodr['thumb']; ?>" class="img-responsive" alt=""/></li>
                                        </ul>
                                    </div>
                                    <ul class="gal-nav">
                                        <li>
                                            <div>
                                                <img src="admin/<?php echo $prodr['thumb']; ?>" class="img-responsive" alt=""/>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="col-md-7 product-single">
                                <div class="space10"></div>
                                <div class="p-price">$ <?php echo $prodr['price']; ?></div>
                                <p><?php echo $prodr['description']; ?></p>
                                
                                <form method="get" action="addtocart.php">
                                    <div class="product-quantity">
                                        <span>Quantity:</span> 
                                        <input type="hidden" name="id" value="<?php echo $prodr['id']; ?>">
                                        <input type="text" name="quant" placeholder="1">
                                    </div>
                                    <div class="shop-btn-wrap">
                                        <input type="submit" class="button btn-small" value="Add to Cart">
                                    </div>
                                </form>
                                
                                <div class="product-meta">
                                    <span>Categories: 
                                    <?php 
                                        $prodcatsql = "SELECT * 
                                                       FROM category 
                                                       WHERE id={$prodr['catid']}";
                                        
                                        $prodcatres = mysqli_query($connection, $prodcatsql);
                                        $prodcatr = mysqli_fetch_assoc($prodcatres);
                                    ?>
                                        <a href="menu.php?id=<?php echo $prodcatr['id']; ?>"><?php echo $prodcatr['name']; ?></a>
                                    </span>
                                    
                                    <br>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="clearfix space30"></div>
					   
                        <div class="tab-style3">
				        
                        <!-- Navigation Tabs -->
				        <div class="align-center mb-40 mb-xs-30">
                            <ul class="nav nav-tabs tpl-minimal-tabs animate">
                                
                                <li class="active col-md-6">
									<a aria-expanded="true" href="#mini-one" data-toggle="tab">Overview</a>
                                </li>
		
				                <li class="col-md-6">
									<a aria-expanded="false" href="#mini-three" data-toggle="tab">Reviews</a>
				                </li>
                                
							</ul>
						</div>
                            
						<!-- Tab Panes -->
						<div style="height: auto;" class="tab-content tpl-minimal-tabs-cont align-center section-text">
							
                            <div style="" class="tab-pane fade active in" id="mini-one">
								<p><?php echo $prodr['description']; ?></p>
							</div>

							<div style="" class="tab-pane fade" id="mini-three">
                                
								<div class="col-md-12">
                                    <?php
                                
                                        $revcountsql = "SELECT count(*) AS count 
                                                        FROM reviews r 
                                                        WHERE r.pid=$id";

                                        $revcountres = mysqli_query($connection, $revcountsql);
                                        $revcountr = mysqli_fetch_assoc($revcountres);
                                     ?>
                                    
									<h4 class="uppercase space35"><?php echo $revcountr['count']; ?> Reviews for <?php echo substr($prodr['name'], 0, 20); ?></h4>
                                    
									<ul class="comment-list">
                                        
                                        <?php 
                                            
                                            $selrevsql = "SELECT u.firstname, u.lastname, r.`timestamp`, r.review 
                                                          FROM reviews r 
                                                          JOIN usersmeta u 
                                                          WHERE r.uid=u.uid AND r.pid=$id";

                                            $selrevres = mysqli_query($connection, $selrevsql);
                                            while($selrevr = mysqli_fetch_assoc($selrevres)){
                                        ?>
										<li>
											<a class="pull-left" href="#"><img class="comment-avatar" src="images/quote/1.jpg" alt="" height="50" width="50"></a>
											
                                            <div class="comment-meta">
												<a href="#"><?php echo $selrevr['firstname']." ". $selrevr['lastname']; ?></a>
												<span>
												    <em><?php echo $selrevr['timestamp']; ?></em>
												</span>
											</div>
											
                                            <p>
												<?php echo $selrevr['review']; ?>
											</p>
										</li>
									<?php } ?>
									</ul>
                                    
									<?php 
										$chkrevsql = "SELECT count(*) reviewcount 
                                                      FROM reviews r 
                                                      WHERE r.uid=$uid";
                                    
										$chkrevres = mysqli_query($connection, $chkrevsql);
										$chkrevr = mysqli_fetch_assoc($chkrevres);
                                    
										if($chkrevr['reviewcount'] >= 1) {
											echo "<h4 class='uppercase space20'>You have already reviewed this product...</h4>";
										}
                                    
                                        else { /* Write a Review */
									?>
                                    
									<h4 class="uppercase space20">Add a review</h4>
									<form id="form" class="review-form" method="post">
									<?php
										$usersql = "SELECT u.email, u1.firstname, u1.lastname 
                                                    FROM users u 
                                                    JOIN usersmeta u1 
                                                    WHERE u.id=u1.uid AND u.id=$uid";
                                            
										$userres = mysqli_query($connection, $usersql);
										$userr = mysqli_fetch_assoc($userres);
									 ?>
										<div class="row">      
											<div class="col-md-6 space20">
												<input name="name" class="input-md form-control" placeholder="Name *" maxlength="100" required="" type="text" value="<?php echo $userr['firstname'] . " " . $userr['lastname'];?>" disabled>
											</div>
                                            
											<div class="col-md-6 space20">
												<input name="email" class="input-md form-control" placeholder="Email *" maxlength="100" required="" type="email" value="<?php echo $userr['email']; ?>" disabled>
											</div> 
										</div>

										<div class="space20">
											<textarea name="review" id="text" class="input-md form-control" rows="6" placeholder="Add review.." maxlength="400"></textarea>
										</div>
                                        
										<button type="submit" class="button btn-small"> Submit Review </button>
                                        
									</form>
                                    
									<?php } ?>
								</div> <!-- Close col-md-12 --> 
                                
								<div class="clearfix space30"></div>
                                
							</div> <!-- Close tab-pane fade --> 
						</div> <!-- Close tab-content tpl-minimal-tabs-cont align-center section-text --> 
					</div> <!-- Close tab-style3 --> 
                        
					<div class="space30"></div>
                        
					</div> <!-- Close col-md-10 col-md-offset-1 --> 
				</div> <!-- Close row --> 
			</div> <!-- Close container --> 
		</div> <!-- Close content-blog --> 
	</section>

<!-- Footer --> 
<?php include 'inc/footer.php' ?>

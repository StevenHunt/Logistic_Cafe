<?php

    session_start();
    require_once 'config/connect.php';

    $page_title = 'cart';
    $sub_title = 'Review and proceed to checkout'; 
    
    include 'inc/header.php'; 
    include 'inc/nav.php'; 

    $cart = $_SESSION['cart'];
?>

	
	<!-- CONTENT -->
	<section id="content">
        <div class="content-blog">
			<div class="container">
				<div class="row">

                    
					<div class="col-md-12">
                        <table class="cart-table table table-bordered">
                            <thead>
                                <tr>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php
                                    $total = 0;
                                    foreach ($cart as $key => $value) {
                                        $cartsql = "SELECT * FROM products 
                                                    WHERE id=$key";
                                        
                                        $cartres = mysqli_query($connection, $cartsql);
                                        $cartr = mysqli_fetch_assoc($cartres);
                                 ?>
                                <tr>
                                    <td>
                                        <a class="remove" href="delcart.php?id=<?php echo $key; ?>"><i class="fa fa-times"></i></a>
                                    </td>
                                    <td>
                                        <a href="#"><img src="admin/<?php echo $cartr['thumb']; ?>" alt="" height="90" width="90"></a>					
                                    </td>
                                    <td>
                                        <a href="single.php?id=<?php echo $cartr['id']; ?>"><?php echo substr($cartr['name'], 0 , 30); ?></a>					
                                    </td>
                                    <td>
                                        <span class="amount">$<?php echo $cartr['price']; ?></span>					
                                    </td>
                                    <td>
                                        <div class="quantity"><?php echo $value['quantity']; ?></div>
                                    </td>
                                    <td>
                                        <span class="amount">$<?php echo ($cartr['price']*$value['quantity']); ?></span>					
                                    </td>
                                </tr>
                                    <?php 
                                        $total = $total + ($cartr['price']*$value['quantity']);
                                    } ?>
                                <tr>
                                    <td colspan="6" class="actions">
                                        <div class="col-md-6"> 
                                            
                                            <!-- Possible promo code area --> 
                                            
                                        </div>
                                        <div class="col-md-6">
                                            <div class="cart-btn">
                                                <a href="checkout.php" class="button btn-md" >Checkout</a>
                                            </div>
							             </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>		

                        <div class="cart_totals">
                            <div class="col-md-6 push-md-6 no-padding">
                                <h4 class="heading">Cart Totals</h4>
                                <table class="table table-bordered col-md-6">
                                    <tbody>
                                        <tr>
                                            <th>Subtotal</th>
                                            <td><span class="amount">$ <?php echo $total; ?></span></td>
                                        </tr>
                                        <tr>
                                            <th>Delivery Fee</th>
                                            <td>
                                                <!-- Delivery Estimator (Based on Location)

                                                    ** @NORMA & @LUPE ENTER CODE HERE **

                                                --> 
                                                <p> Based on Location </p> 			
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Order Total</th>
                                            <td><strong><span class="amount">$ <?php echo $total; ?></span></strong> </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- Close cart-totals --> 
                        
					</div> <!-- Close col-md-12 --> 
				</div> <!-- Close row --> 
			</div> <!-- close container --> 
		</div> <!-- Close content-blog --> 
	</section>

<?php include 'inc/footer.php' ?>

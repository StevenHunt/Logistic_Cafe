<?php 

	ob_start();
	session_start();

	require_once 'config/connect.php';

	if(!isset($_SESSION['customer']) & empty($_SESSION['customer'])) {
		header('location: login.php');
	}

    $page_title = "Recent Orders"; 
    include 'inc/header.php'; 
    include 'inc/nav.php'; 

    $uid = $_SESSION['customerid'];
    $cart = $_SESSION['cart'];
?>
	
	<!-- CONTENT -->
    <section id="content">
		<div class="content-blog content-account">
			<div class="container">
				<div class="row">
					<div class="page_header text-center">
                        <?php

                            $fname = "SELECT u1.firstname FROM users u JOIN usersmeta u1 WHERE u.id=u1.uid AND u.id=$uid";
                            $fname = mysqli_query($connection, $fname);

                            if(mysqli_num_rows($fname) == 1) {
                                $crs = mysqli_fetch_assoc($fname);
                                echo "<h2>".$crs['firstname'] ."'s  Account" . "</h2"; 
                            }
                        ?>
					</div>
					<div class="col-md-12">
                        
                        <br>
                        
                        <table class="cart-table account-table table table-bordered">    
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                
                                <?php
                                    $ordsql = "SELECT * 
                                               FROM orders 
                                               WHERE uid='$uid'";

                                    $ordres = mysqli_query($connection, $ordsql);
                                    while($ordr = mysqli_fetch_assoc($ordres)){
                                ?>
                                
                                <tr>
                                    <td>
                                        <?php echo $ordr['id']; ?>
                                    </td>
                                    <td>
                                        <?php echo $ordr['timestamp']; ?>
                                    </td>
                                    <td>
                                        <?php echo $ordr['orderstatus']; ?>			
                                    </td>      
                                    <td>
                                        $<?php echo $ordr['totalprice']; ?>
                                    </td>
                                    <td>
                                        <?php 
                                            if($ordr['orderstatus'] != 'Cancelled')
                                        {?>
                                        
                                        <a href="cancel-order.php?id= <?php echo $ordr['id']; ?>"> Cancel</a> <?php } ?>
                                    </td>
                                </tr>
                                
                            <?php } ?>
                                
                            </tbody>
                        </table>		

                        <br>
                        <br>
                        <br>

					</div> <!-- Close col-md-12 --> 
				</div> <!-- Close row --> 
			</div> <!-- Close container --> 
		</div> <!-- Close content-blog content-account --> 
	</section>
	
<br />
<br />
<br />

<?php include 'inc/footer.php' ?>

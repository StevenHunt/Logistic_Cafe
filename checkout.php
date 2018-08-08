<?php

	ob_start();
	session_start();

	require_once 'config/connect.php';

	if(!isset($_SESSION['customer']) & empty($_SESSION['customer'])) {
		header('location: login.php');
	}

    $page_title = 'Checkout'; 
    include 'inc/header.php'; 
    include 'inc/nav.php'; 

    $uid = $_SESSION['customerid'];
    $cart = $_SESSION['cart'];

    if(isset($_POST) & !empty($_POST)) {
            $fname = filter_var($_POST['fname'], FILTER_SANITIZE_STRING);
            $lname = filter_var($_POST['lname'], FILTER_SANITIZE_STRING);
            $company = filter_var($_POST['company'], FILTER_SANITIZE_STRING);
            $address1 = filter_var($_POST['address1'], FILTER_SANITIZE_STRING);
            $address2 = filter_var($_POST['address2'], FILTER_SANITIZE_STRING);
            $city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
            $state = filter_var($_POST['state'], FILTER_SANITIZE_STRING);
            $phone = filter_var($_POST['phone'], FILTER_SANITIZE_NUMBER_INT);
            $payment = filter_var($_POST['payment'], FILTER_SANITIZE_STRING);
            $zip = filter_var($_POST['zipcode'], FILTER_SANITIZE_NUMBER_INT);

            $sql = "SELECT * FROM usersmeta  
                    WHERE uid=$uid";

            $res = mysqli_query($connection, $sql);
            $r = mysqli_fetch_assoc($res);
            $count = mysqli_num_rows($res);
            
            if($count == 1) {

                // Update: Usermeta table
                $usql = "UPDATE usersmeta SET firstname='$fname', lastname='$lname', address1='$address1', address2='$address2', city='$city', state='$state',  zip='$zip', company='$company', mobile='$phone' WHERE uid=$uid";

                $ures = mysqli_query($connection, $usql) or die(mysqli_error($connection));

                if($ures) {

                    $total = 0;

                    foreach ($cart as $key => $value) {
                        
                        $ordsql = "SELECT * 
                                   FROM products 
                                   WHERE id=$key";

                        $ordres = mysqli_query($connection, $ordsql);
                        $ordr = mysqli_fetch_assoc($ordres);

                        $total = $total + ($ordr['price']*$value['quantity']);
                    }

                    echo $iosql = "INSERT INTO orders (uid, totalprice, orderstatus, paymentmode) VALUES ('$uid', '$total', 'Order Placed', '$payment')";

                    $iores = mysqli_query($connection, $iosql) or die(mysqli_error($connection));

                    if($iores) {

                        $orderid = mysqli_insert_id($connection);

                        foreach ($cart as $key => $value) {

                            $ordsql = "SELECT * 
                                       FROM products 
                                       WHERE id=$key";

                            $ordres = mysqli_query($connection, $ordsql);
                            $ordr = mysqli_fetch_assoc($ordres);

                            $pid = $ordr['id'];
                            $productprice = $ordr['price'];
                            $quantity = $value['quantity'];

                            $orditmsql = "INSERT INTO orderitems (pid, orderid, productprice, pquantity) VALUES ('$pid', '$orderid', '$productprice', '$quantity')";
                            $orditmres = mysqli_query($connection, $orditmsql) or die(mysqli_error($connection));
                        }
                    }

                    unset($_SESSION['cart']);
                    header("location: my-account.php");
                }
            }

            else {

                // Insert: Into Usermeta table
                $isql = "INSERT INTO usersmeta (firstname, lastname, address1, address2, city, state, zip, company, mobile, uid) VALUES ('$fname', '$lname', '$address1', '$address2', '$city', '$state', '$zip', '$company', '$phone', '$uid')";

                $ires = mysqli_query($connection, $isql) or die(mysqli_error($connection));

                if($ires) {

                    $total = 0;

                    foreach ($cart as $key => $value) {

                        $ordsql = "SELECT * 
                                   FROM products 
                                   WHERE id=$key";

                        $ordres = mysqli_query($connection, $ordsql);
                        $ordr = mysqli_fetch_assoc($ordres);
                        $total = $total + ($ordr['price']*$value['quantity']);
                    }
                    
                    // Insert: Into orders table
                    echo $iosql = "INSERT INTO orders (uid, totalprice, orderstatus, paymentmode) VALUES ('$uid', '$total', 'Order Placed', '$payment')";

                    $iores = mysqli_query($connection, $iosql) or die(mysqli_error($connection));

                    if($iores){

                        $orderid = mysqli_insert_id($connection);
                        foreach ($cart as $key => $value) {

                            $ordsql = "SELECT * 
                                       FROM products 
                                       WHERE id=$key";
                            
                            $ordres = mysqli_query($connection, $ordsql);
                            $ordr = mysqli_fetch_assoc($ordres);

                            $pid = $ordr['id'];
                            $productprice = $ordr['price'];
                            $quantity = $value['quantity'];

                            // Insert: Into orderitems table
                            $orditmsql = "INSERT INTO orderitems (pid, orderid, productprice, pquantity) VALUES ('$pid', '$orderid', '$productprice', '$quantity')";
                            $orditmres = mysqli_query($connection, $orditmsql) or die(mysqli_error($connection));

                        }
                    }

                    unset($_SESSION['cart']);
                    header("location: my-account.php");
                }

            }
        }

    $sql = "SELECT * 
            FROM usersmeta 
            WHERE uid=$uid";

    $res = mysqli_query($connection, $sql);
    $r = mysqli_fetch_assoc($res);
?>

	
    <!-- SHOP CONTENT -->
    <section id="content">
    <div class="content-blog">

    <form method="post" onsubmit="
    
   						if(document.getElementById('agree').checked) { 
   							return true; 
   						} 
   						
   						else { 
   							alert('Please indicate that you have read and agree to the Terms and Conditions'); 
   							return false; 
   						}">
 	
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
				<div class="billing-details">
				    <h3 class="uppercase">Billing Details</h3>
                    
				      <div class="space30"></div>

							<div class="row">
								<div class="col-md-6">
									<label>First Name </label>
									<input name="fname" class="form-control" placeholder="" value=" <?php
                                            if(!empty($r['firstname'])) { 
                                                echo $r['firstname']; 
                                            } 
                                            
                                            elseif(isset($fname)) { 
                                                echo $fname; 
                                            } 
                                        ?>" type="text">
								</div>
                                
								<div class="col-md-6">
									<label>Last Name </label>
									<input name="lname" class="form-control" placeholder="" value=" <?php
                                            if(!empty($r['lastname'])) { 
                                                echo $r['lastname']; 
                                            } 
                                            
                                            elseif(isset($lname)) { 
                                                echo $lname; 
                                            } 
                                        ?>" type="text">
								</div>
							</div>
							
                            <div class="clearfix space20"></div>
							<label>Company Name</label>
							<input name="company" class="form-control" placeholder="" value=" <?php
                                            if(!empty($r['company'])) { 
                                                echo $r['company']; 
                                            } 
                                            
                                            elseif(isset($company)) { 
                                                echo $company; 
                                            } 
                                        ?>" type="text">
							
                            <div class="clearfix space20"></div>
							<label>Address </label>
							<input name="address1" class="form-control" placeholder="Street Address" value=" <?php
                                            if(!empty($r['address1'])) { 
                                                echo $r['address1']; 
                                            } 
                                            
                                            elseif(isset($address1)) { 
                                                echo $address1; 
                                            } 
                                        ?>" type="text">
                    
							<div class="clearfix space20"></div>
							<input name="address2" class="form-control" placeholder="Apt, Suite, Unit, etc. (Optional)" value=" <?php
                                            if(!empty($r['address2'])) { 
                                                echo $r['address2']; 
                                            } 
                                            
                                            elseif(isset($address2)) { 
                                                echo $address2; 
                                            } 
                                        ?>" type="text">
                    
							<div class="clearfix space20"></div>
							<div class="row">
								<div class="col-md-4">
									<label>City </label>
									<input name="city" class="form-control" placeholder="City" value=" <?php
                                            if(!empty($r['city'])) { 
                                                echo $r['city']; 
                                            } 
                                            
                                            elseif(isset($city)) { 
                                                echo $city; 
                                            } 
                                        ?>" type="text">
								</div>
                                
								<div class="col-md-4">
									<label>State</label>
									<input name="state" class="form-control" placeholder="State" value=" <?php
                                            if(!empty($r['state'])) { 
                                                echo $r['state']; 
                                            } 
                                            
                                            elseif(isset($state)) { 
                                                echo $state; 
                                            } 
                                        ?>" type="text">
								</div>
                                
								<div class="col-md-4">
									<label>Postcode </label>
									<input name="zipcode" class="form-control" placeholder="Postal Code" value=" <?php
                                            if(!empty($r['zip'])) { 
                                                echo $r['zip']; 
                                            } 
                                            
                                            elseif(isset($zip)) { 
                                                echo $zip; 
                                            } 
                                        ?>" type="text">
								</div>
							</div>
							
                            <div class="clearfix space20"></div>
				                <label>Phone </label>
							     <input name="phone" class="form-control" id="billing_phone" placeholder="" value="<?php                         if(!empty($r['mobile'])) { 
                                                echo $r['mobile']; 
                                            }
                                            
                                            elseif(isset($phone)) { 
                                                echo $phone; 
                                            } 
                                        ?>" type="text">
					</div>
                </div>
			</div>
        
            <br />
            <br />
            <br />
        
            <!-- ORDER DETAILS --> 
			
			<div class="cart_totals">
				<div class="col-md-6 push-md-6 no-padding">
					<h4 class="heading">YOUR ORDER</h4>
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
                                    
                                        ** ENTER CODE HERE **

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
			</div>
			
			<div class="clearfix space30"></div>
			<h4 class="heading">Payment Method</h4>
			<div class="clearfix space20"></div>
			
			<div class="payment-method">
				<div class="row">
						<div class="col-md-4">
                                <table>
                                <tr>
                                    <td align="left" height="45">
                                        
                                        <input type="radio" class="radioBtn" name="Radio" id="Radio" value="Cash" required checked> Cash on Delivery <br /> <br />

                                        <input class="radioBtn" type="radio" name="Radio" id="Radio" value="Card" required > Credit / Debit Card 
                                    </td>
                                </tr>
                            </table>
                            
                            <br />
                            <br />
                            
                            <div class="stripe" style="display:none">
                                
                                <script src="https://js.stripe.com/v3/"></script>

                                <form action="/charge" method="post" id="payment-form">
                                  <div class="form-row">
                 
                                    <div id="card-element">
                                       <!-- Stripe element --> 
                                    </div>

                                  </div>

                                </form> 
                            
                            </div>
                            
                            <script> 
                                $('input[type="radio"]').click(function(){
                                    if($(this).attr("value")=="Cash"){
                                        $(".stripe").hide('slow');
                                    }
                                    if($(this).attr("value")=="Card"){
                                        $(".stripe").show('slow');

                                    }        
                                });
                                $('input[type="radio"]').trigger('click');
                                
                                /* STRIPE CLIENT ---------------------------------------- */ 
                                
                                // Create client:
                                var stripe = Stripe('pk_test_g6do5S237ekq10r65BnxO6S0');

                                // Create an instance (elements)
                                var elements = stripe.elements();

                                // Styling: 
                                var style = {
                                    base: {
                                        color: '#32325d',
                                        lineHeight: '18px',
                                        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                                        fontSmoothing: 'antialiased',
                                        fontSize: '16px',
                                        '::placeholder': {
                                            color: '#aab7c4'
                                        }
                                    },
                                };

                                // Create an instance (card)
                                var card = elements.create('card', {style: style});

                                // Add an instance of the card Element into the `card-element` <div>.
                                card.mount('#card-element');
                                
                                // Handle form submission.
                                var form = document.getElementById('payment-form');
                                
                                form.addEventListener('submit', function(event) {
                                    event.preventDefault();

                                    stripe.createToken(card).then(function(result) {
                                    
                                    if (result.error) {
                                        
                                        // Inform the user if there was an error.
                                        var errorElement = document.getElementById('card-errors');
                                        errorElement.textContent = result.error.message;
                                    } 
                                    
                                    else {
                                        
                                      // Send the token to your server.
                                      stripeTokenHandler(result.token);
                                    }
                                  });
                                });
                                
                            </script>
                            
                            <br />
                            <br />
                            
				    <div class="space30"></div>
                
					<input type="checkbox" name="checkbox" class="css-checkbox" value="check" id="agree"/>
                        <span>I've read and accept the 
                            <a href="terms.html" onclick="window.open(this.href,'nom_Popup','height=400 , width=400 ,location=no ,resizable=yes ,scrollbars=yes');return false;"> terms &amp; conditions</a>
                        </span>
				
				<div class="space30"></div>
				<input type="submit" class="button btn-sml" value="Pay Now">
                
                <br /> 
                <br />
                <br />
                <br />
                <br />
			</div>
		</div>		
    </form>		
</div>
</section>
	
<?php include 'inc/footer.php' ?>

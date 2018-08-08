<?php 

    session_start();
    require_once '../config/connect.php'; 

    if(isset($_POST) & !empty($_POST)) {
        
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $password = md5($_POST['password']);
        $sql = "SELECT * 
                FROM admin 
                WHERE email='$email' AND password='$password'";
        
        $result = mysqli_query($connection, $sql) or die(mysqli_error($connection));
        $count = mysqli_num_rows($result);
        
        if($count == 1) {
            $_SESSION['email'] = $email;
            header("location: orders.php");
        }
        
        else{
            $fmsg = "Invalid Login Credentials";
        }
    }

?>

<!DOCTYPE html>
<html>
<head>

	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="keywords" content="HTML5 Template" />
	<meta name="description" content="">
	<meta name="author" content="Logistic Solutions">

	<title>Login - Admin</title>

	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Favicon -->
	<link rel="shortcut icon" href="images/favicon.png">

	<!-- CSS -->
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="../js/isotope/isotope.css">
	<link rel="stylesheet" href="../js/flexslider/flexslider.css">
	<link rel="stylesheet" href="../js/owl-carousel/owl.carousel.css">
	<link rel="stylesheet" href="../js/owl-carousel/owl.theme.css">
	<link rel="stylesheet" href="../js/owl-carousel/owl.transitions.css">
	<link rel="stylesheet" href="../js/superfish/css/megafish.css" media="screen">
	<link rel="stylesheet" href="../js/superfish/css/superfish.css" media="screen">
	<link rel="stylesheet" href="../js/pikaday/pikaday.css">
	<link rel="stylesheet" href="../css/settings-panel.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/light.css">
	<link rel="stylesheet" href=".//css/responsive.css">
    
    <!-- Javascript -->
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/dialogFx.js"></script>
    <script src="../js/dialog-js.js"></script>
    <script src="../js/navigation/jquery.easing.js"></script>
    <script src="../js/flexslider/jquery.flexslider.js"></script>
    <script src="../js/navigation/scroll.js"></script>
    <script src="../js/navigation/jquery.sticky.js"></script>
    <script src="../js/owl-carousel/owl.carousel.min.js"></script>
    <script src="../js/isotope/isotope.pkgd.js"></script>
    <script src="../js/superfish/js/hoverIntent.js"></script>
    <script src="../js/superfish/js/superfish.js"></script>
    <script src="../js/tweecool.js"></script>
    <script src="../js/jquery.bpopup.js"></script>
    <script src="../js/pikaday/pikaday.js"></script>
    <script src="../js/classie.js"></script>
    <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script src="../js/rs-plugin/js/jquery.themepunch.tools.min.js"></script>   
    <script src="../js/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
    <script src="../js/jquery.prettyphoto.js"></script>
    <script src="../js/script.js"></script>
    <script src="../js/booking.js"></script>

    <script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
    <script src="../js/gmap.js"></script>
    <script src="../js/gmap2.js"></script>

	<!-- JS Font Script -->
	<script src="http://use.edgefonts.net/bebas-neue.js"></script>

	<!-- Modernizer -->
	<script src="js/modernizr.custom.js"></script>

</head>
<body class="multi-page">

    <div id="wrapper" class="wrapper">

        <!-- HEADER -->
        <header id="header2">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-xs-5 col-md-offset-4 logo">
                        <a href="http://[::1]/cishop/admin"><img src="http://[::1]/cishop/assets/images/logo.png" class="img-responsive" alt=""/></a>
                    </div>
                </div>
            </div>
        </header>

        <!-- CONTENT -->
        <section id="content">
            <div class="content-blog">
                <div class="container">
                    <div class="row">
                        <div class="page_header text-center">
                            <h2>Login</h2>
                            <p>Admin</p>
                        </div>
                        <div class="col-md-12">
                            <div class="row shop-login">
                                <div class="col-md-6 col-md-offset-3">
                                <?php if(isset($fmsg)){ ?><div class="alert alert-danger" role="alert"> <?php echo $fmsg; ?> </div><?php } ?>
                                    <div class="box-content">
                                        <div class="clearfix space40"></div>
                                        <form class="logregform" method="post">
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label>E-mail Address</label>
                                                        <input type="email" name="email" value="" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="clearfix space20"></div>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label>Password</label>
                                                        <input type="password" name="password" value="" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="clearfix space20"></div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                </div>
                                                <div class="col-md-6">
                                                    <button class="button btn-md pull-left"><a href="../index.php">Home</a></button>
                                                    <button type="submit" class="button btn-md pull-right">Login</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div> <!-- Close box-content --> 
                                </div> <!-- Close col-md-6 col-md-offset-3 --> 
                            </div> <!-- Close row shop-login --> 
                        </div> <!-- Close col-md-12 --> 
                    </div> <!-- Close row --> 
                </div> <!-- Close container --> 
            </div> <!-- Close content-blog --> 
        </section>

        <div class="clearfix space70"></div>

    </div> <!-- Close wrapper --> 

</body>
</html>

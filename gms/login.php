<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_POST['login'])) 
  {
    $username=$_POST['username'];
    $password=md5($_POST['password']);
    $sql ="SELECT ID FROM tbluser WHERE UserName=:username and Password=:password";
    $query=$dbh->prepare($sql);
    $query-> bindParam(':username', $username, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
    $query-> execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    if($query->rowCount() > 0)
{
foreach ($results as $result) {
$_SESSION['uuid']=$result->ID;
}
  if(!empty($_POST["remember"])) {
//COOKIES for username
setcookie ("user_login",$_POST["username"],time()+ (10 * 365 * 24 * 60 * 60));
//COOKIES for password
setcookie ("userpassword",$_POST["password"],time()+ (10 * 365 * 24 * 60 * 60));
} else {
if(isset($_COOKIE["user_login"])) {
setcookie ("user_login","");
if(isset($_COOKIE["userpassword"])) {
setcookie ("userpassword","");
        }
      }
}
$_SESSION['login']=$_POST['username'];
echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
} else{
echo "<script>alert('Invalid Details');</script>";
}
}
?>
<!doctype html>
<html lang="en">

<head>
    
    <title>Garbage Management System: Login</title>
    <link rel="stylesheet" href="../assets/vendor/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../assets/vendor/fontawesome/css/font-awesome.min.css">

    <link rel="stylesheet" href="../assets/css/login-theme.css" type="text/css">
</head>

<body class="login-clean">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30"><img src="../assets/images/brand/icon_black.svg" width="48" height="48" alt="ArrOw"></div>
            <p>Please wait...</p>
        </div>
    </div>
	<!-- WRAPPER -->
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle auth-main">
    			<div class="auth-box">
                        <div class="auth-illustration">
                            <img src="../assets/images/trash-illustration.png" alt="Trash illustration">
                        </div>
                        <div class="top">
                       
                            <a href="/GMS/index.php">
                                <img src="data:image/png;base64,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" alt="GMS Logo" style="height:54px;">
                            </a>
                        </div>
					<div class="card">
                        <div class="header">
                            <p class="lead">Login to your account</p>
                        </div>
                        <div class="body">
                            <form class="form-auth-small" action="" method="post">
                                <div class="form-group">
                                    <label for="signin-email" class="control-label sr-only">User Name</label>
                                    
                                    <input type="text" class="form-control" placeholder="User Name" required="true" name="username" value="<?php if(isset($_COOKIE["user_login"])) { echo $_COOKIE["user_login"]; } ?>" >
                                </div>
                                <div class="form-group">
                                    <label for="signin-password" class="control-label sr-only">Password</label>
                                    <input type="password" class="form-control" placeholder="Password" name="password" required="true" value="<?php if(isset($_COOKIE["userpassword"])) { echo $_COOKIE["userpassword"]; } ?>">
                                </div>
                                <div class="form-group clearfix">
                                    <label class="fancy-checkbox element-left">
                                        <input type="checkbox" id="remember" name="remember" <?php if(isset($_COOKIE["user_login"])) { ?> checked <?php } ?>>
                                        <span>Remember me</span>
                                    </label>                                
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block" name="login">LOGIN</button>
                                <div class="bottom">
                                    <span class="helper-text m-b-10"><i class="fa fa-lock"></i> <a href="forgot-password.php">Forgot password?</a></span>
                                    <span class="helper-text m-b-10"><i class="fa fa-user"></i> <a href="register.php">Signup</a></span>
                                   <a href="../index.php">Back Home!!</a>
                                </div>
                            </form>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
    <!-- END WRAPPER -->
    
<!-- Core -->
<script src="../assets/bundles/libscripts.bundle.js"></script>
<script src="../assets/bundles/vendorscripts.bundle.js"></script>

<script src="../assets/js/theme.js"></script>
</body>
</html>

<?php 
	require("../functions.php");
	
    require("../class/Helper.class.php");
	$Helper = new Helper();
	
	require("../class/User.class.php");
	$User = new User($mysqli);
	
	
	if(isset ($_SESSION["userId"])) {
		header("Location: data.php");
		exit();
	}
	
	$signupEmailError = "";
	$signupEmail = "";

	if (isset ($_POST["signupEmail"])) {
		

		if (empty ($_POST["signupEmail"])) {

			$signupEmailError = "See väli on kohustuslik";
			
		} else {

			$signupEmail = $_POST["signupEmail"];
		}
		
	}
	
	$signupPasswordError = "";

	if (isset ($_POST["signupPassword"])) {

		if (empty ($_POST["signupPassword"])) {

			$signupPasswordError = "See väli on kohustuslik";
			
		} else {

			if (strlen ($_POST["signupPassword"]) < 8 ) {
				
				$signupPasswordError = "Parool peab olema vähemalt 8 tm pikk";
				
			}
			
		}
		
	}
	
	
	$gender = "";
	if(isset($_POST["gender"])) {
		if(!empty($_POST["gender"])){

			$gender = $_POST["gender"];
		}
	}
	
	if ( isset($_POST["signupEmail"]) &&
		 isset($_POST["signupPassword"]) &&
		 $signupEmailError == "" && 
		 empty($signupPasswordError)
	   ) {

		echo "salvestan...<br>";
		echo "email ".$signupEmail."<br>";
		echo "parool ".$_POST["signupPassword"]."<br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		echo "räsi ".$password."<br>";

		$User->signup($signupEmail, $password);
		
	}	
	
	
	$notice = "";

	if (	isset($_POST["loginEmail"]) && 
			isset($_POST["loginPassword"]) && 
			!empty($_POST["loginEmail"]) && 
			!empty($_POST["loginPassword"]) 
	) {
		$notice = $User->login($_POST["loginEmail"], $_POST["loginPassword"]);
		
		if(isset($notice->success)){
			header("Location: login.php");
			exit();
		}else {
			$notice = $notice->error;
			var_dump($notice->error);
		}
		
	}
	
?>
<?php require("../header.php"); ?>

<div class="container">
	<div class="row">
	
		<div class="col-sm-4 col-md-3">
	
			<h1>Logi sisse</h1>
			<p style="color:red;"><?php echo $notice; ?></p>
			<form method="POST">
				
				<label>E-post</label><br>
				
				<div class="form-group">
					<input class="form-control" name="loginEmail" type="email">
				</div>
				
				<br><br>
				
				<label>Parool</label><br>
				<input name="loginPassword" type="password">
							
				<br><br>
				
				<input type="submit" value="Logi sisse">
			
			</form>
		</div>
		<div class="col-sm-4 col-md-3 col-sm-offset-4 col-md-offset-3">
			
			<h1>Loo kasutaja</h1>
			
			<form method="POST">
				
				<label>E-post</label><br>
				<input name="signupEmail" type="email" value="<?=$signupEmail;?>" > <?php echo $signupEmailError; ?>
				
				<br><br>
				
				<input placeholder="Parool" name="signupPassword" type="password"> <?php echo $signupPasswordError; ?>
							
				<br><br>
				
				<?php if ($gender == "male") { ?>
					<input type="radio" name="gender" value="male" checked > Mees<br>
				<?php } else { ?>
					<input type="radio" name="gender" value="male"> Mees<br>
				<?php } ?>
				
				<?php if ($gender == "female") { ?>
					<input type="radio" name="gender" value="female" checked > Naine<br>
				<?php } else { ?>
					<input type="radio" name="gender" value="female"> Naine<br>
				<?php } ?>
				
				<?php if ($gender == "other") { ?>
					<input type="radio" name="gender" value="other" checked > Muu<br>
				<?php } else { ?>
					<input type="radio" name="gender" value="other"> Muu<br>
				<?php } ?>
				
				<input type="submit" value="Loo kasutaja">
			
			</form>
		</div>
		
		
	</div>
</div>

<?php require("../footer.php"); ?>
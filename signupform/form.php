<!DOCTYPE html>
<html>
<head>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function () {
        const urlParams = new URLSearchParams(window.location.search);
        
        if (urlParams.has('error')) {
            if (urlParams.get('error') === 'user_exists') {
                alert("User already exists!");
            } else if (urlParams.get('error') === 'signup_failed') {
                alert("Signup failed! Please try again.");
            }
        } else if (urlParams.has('success')) {
            if (urlParams.get('success') === 'signup_successful') {
                alert("Signup successful!");
            }
        }
    });
</script>
	<title>FORM</title>
	<link rel="stylesheet" type="text/css" href="mystyle.css">
</head>
<body>
	<div class="main">  	
		<input type="checkbox" id="chk" aria-hidden="true">

			<div class="signup">
				<form action="registration.php" method="POST">
					<label for="chk" aria-hidden="true">Sign up</label>
					<input type="text" name="user" placeholder="User name" required="">
					<input type="password" name="pswd" placeholder="Password" required="">
					<button type="submit">Sign up</button>
				</form>
			</div>

			<div class="login">
				<form action="validation.php" method="POST">
					<label for="chk" aria-hidden="true">Login</label>
					<input type="text" name="user" placeholder="User name" required="">
					<input type="password" name="pswd" placeholder="Password" required="">
					<button type="submit">Login</button>
				</form>
			</div>
	</div>
</body>
</html>
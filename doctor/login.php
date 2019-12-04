<?php
include('../config/autoload.php');
include('./includes/path.inc.php');
?>
<!DOCTYPE html>
<html>
<head>
    <?php include CSS_PATH; ?>
    <link rel="stylesheet" href="../assets/css/clinic/login.css">
</head>
<body>
    <div class="container">
        <div class="login-wrap mx-auto">
            <div class="login-head">
                <h4><?php echo $BRAND_NAME;?></h4>
                <p>Hello there, Sign into your Account!</p>
            </div>
            <div class="login-body">
                <form name="login_form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" value="doctor@email.com">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password" value="aENLiLfy">
                    </div>
                    <div class="mb-3">
                        <a href="forgot.php">Forgot Password?</a>
                    </div>
                    <button type="submit" name="loginbtn" class="btn btn-primary btn-block button">Log In</button>
                </form>
            </div>
            <div class="login-footer">
                <p class="text-muted">Don't have an account? <a href="register.php">Sign up</a></p>
            </div>
        </div>
    </div>
    <?php include JS_PATH; ?>
</body>

</html>
<?php
if (isset($_POST['loginbtn'])) {
    $inputEmail = $conn->real_escape_string($_POST['email']);
    $inputPassword = $conn->real_escape_string($_POST['password']);

    $sql = "SELECT * FROM doctors WHERE doctor_email = '" . $inputEmail . "' AND doctor_password = '" . $inputPassword . "'";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if (!$result = $conn->query($sql)) {
        die('There was an error running the query [' . $conn->error . ']');
    }

    if ($inputEmail == "" && empty($inputEmail)) {
        echo "<script>Swal.fire({title: 'Error!', text: 'Please Enter a Email', type: 'error'}).then(function() { $('#inputEmail').focus(); });</script>";
        exit();
    }

    if ($inputPassword == "" && empty($inputPassword)) {
        echo "<script>Swal.fire({title: 'Error!', text: 'Please Enter a Password', type: 'error'}).then(function() { $('#inputPassword').focus(); });</script>";
        exit();
    }

    if (mysqli_num_rows($result) != 1) {
        echo "<script>Swal.fire({title: 'Error!', text: 'Email & Password Not Exist', type: 'error', confirmButtonText: 'Try Again'})</script>";
        exit();
    } else {
        $_SESSION['sess_id'] = $row['doctor_id'];
        $_SESSION['sess_email'] = $row['doctor_email'];
        $_SESSION['loggedin'] = 1;
        header("Location: index.php");
    }
    mysqli_close($conn);
}
?>
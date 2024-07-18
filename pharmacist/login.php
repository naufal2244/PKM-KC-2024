<?php
include('../config/autoload.php');
include('./includes/path.inc.php');
?>
<!DOCTYPE html>
<html>

<head>
    <?php include CSS_PATH; ?>
    <link rel="stylesheet" href="../assets/css/clinic/login_copy.css">
</head>
    
<body>
    <div class="container">
        <div class="login-wrap mx-auto">
            <div class="login-head">
                <h4><?php echo $BRAND_NAME; ?></h4>
                <p>Halo, Masuk ke Akun Anda!</p>
                <p>Apoteker</p>
            </div>
            <div class="login-body">
                <form name="login_form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Alamat Email</label>
                        <input type="email" name="email" class="form-control" id="inputEmail" aria-describedby="emailHelp" placeholder="Masukkan email">
                        <small id="emailHelp" class="form-text text-muted">Kami tidak akan membagikan email Anda kepada siapapun.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Kata Sandi</label>
                        <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Kata Sandi">
                    </div>
                    <button type="submit" name="loginbtn" class="btn btn-primary btn-block button">Masuk</button>
                </form>
            </div>
            <div class="login-footer">
                <!-- <a class="text-muted">Tidak punya akun? <a href="register.php">Daftar</a></p> -->
            </div>
        </div>
    </div>
    <?php include JS_PATH; ?>
</body>

</html>
<?php
if (isset($_POST['loginbtn'])) {
    $inputEmail = $conn->real_escape_string($_POST['email']);

    $check = $conn->prepare("SELECT * FROM apoteker WHERE apoteker_email = ? ");
    $check->bind_param("s", $inputEmail);
    $check->execute();
    $q = $check->get_result();
    $r = $q->fetch_assoc();
    if (mysqli_num_rows($q) != 1) {
        echo "<script>Swal.fire({title: 'Error!', text: 'Email & Kata Sandi Tidak Ada', type: 'error', confirmButtonText: 'Coba Lagi'})</script>";
        exit();
    }

    $inputPassword = $_POST['password'];
    $hashedPassword = $r['apoteker_password'];

    try {
        if (empty($inputEmail)) {
            echo "<script>Swal.fire({title: 'Error!', text: 'Harap Masukkan Email', type: 'error'}).then(function() { $('#inputEmail').focus(); });</script>";
            exit();
        }

        if (empty($inputPassword)) {
            echo "<script>Swal.fire({title: 'Error!', text: 'Harap Masukkan Kata Sandi', type: 'error'}).then(function() { $('#inputPassword').focus(); });</script>";
            exit();
        }

        if ($inputPassword != $hashedPassword) {
            echo "<script>Swal.fire({title: 'Error!', text: 'Email & Kata Sandi Tidak Ada', type: 'error', confirmButtonText: 'Coba Lagi'})</script>";
            exit();
        } else {
            $_SESSION['ApotekerRoleID'] = $r['id_apoteker'];
            $_SESSION['ApotekerRoleEmail'] = $r['apoteker_email'];
            $_SESSION['ApotekerRoleLoggedIn'] = 1;
            header("Location: index.php");
        }
    } catch (Exception $error) {
        die('Ada kesalahan saat menjalankan query [' . $conn->error . ']');
    }

    $check->close();
    $conn->close();
}
?>
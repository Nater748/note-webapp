<?php include "../config/config.php";?>

<?php 
    if (isset($_POST['submit'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        $username = $_POST['username'];
        $sql1 = "SELECT id FROM users WHERE email = '$email'";
        $result1 = mysqli_query($connection, $sql1);
        if(mysqli_num_rows($result1) > 0){
            $_SESSION['logs'] = "Email already exists!";
            header("Location: ../front-end/register.php");
            exit();
        }else{
        if($password !== $cpassword){
            echo "Passwords do not match!";
        }else{
            $hashed_password = md5($password);
            $sql = "INSERT INTO users (email, password_hash, username) VALUES ('$email', '$hashed_password', '$username')";
            $result = mysqli_query($connection, $sql);

            if($result){
                $_SESSION['success'] = "Registration successful!. Please log in.";
                header("Location: ../front-end/login.php");
                exit();
            } else {
                $_SESSION['error'] = "Registration failed. Please try again.";
                header("Location: ../front-end/register.php");
            }
        }
    }
    }
?>
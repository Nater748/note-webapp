<?php 

include "../config/config.php";

    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        echo $username;
        echo $password;
        $sql = "SELECT * FROM USERS WHERE username = '$username'";
        $result = mysqli_query($connection, $sql);
    
        if($result==true){
          $count = mysqli_num_rows($result);
          if($count==1){
            $row = mysqli_fetch_assoc($result);
            if($row['password_hash'] == $password){
              $_SESSION['user'] = $username;
              $_SESSION['success'] = "welcome $username!!";
              $_SESSION['login'] = $row ['id'];
              header("Location: ../front-end/index.php");
              exit();
            } else {
              $_SESSION['error'] = "Incorrect password.";
              header("Location: ../front-end/login.php");
            }
          } else {
            $_SESSION['error'] = "Username not found.";
            header("Location: ../front-end/login.php");
            

          }
        } else {
          $_SESSION['error'] = "Database query failed.";
              echo"incorrect sql";

        }
    }
?>
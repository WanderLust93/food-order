<?php
    include("../config/constants.php");
?>
<html>
    <head>
        <title>Login-Food Order System</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>

    <body>
        <div class="login">
            <h1 class="text-center">Login</h1>

            <?php
                if(isset($_SESSION['login'])){
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }
                
                if(isset($_SESSION['no-login-message'])){
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }
            ?>
            <br>
            <!--Login form starts here-->
            <form action="" method="POST" class="text-center">
                Username:<br>
                <input type="text" name="username" placeholder="Enter username"><br><br>
                Password:<br>
                <input type="password" name="password" placeholder="Enter password"><br><br>
                <input type="submit" name="submit" value="Login" class="btn-primary"><br><br>
            </form>
            <!--Login form starts here-->

            <p class="text-center">Created By-<a href="www.google.com">WanderLust</a></p>
        </div>
    </body>
</html>
<?php
    //check whether submit button is clicked
    if(isset($_POST['submit'])){
        //process to login
        //1.get data from login form
        //$username=$_POST['username'];

        //sanitising the input values received from login page
        $username=mysqli_real_escape_string($conn,$_POST['username']);
        //we do not necessarily need to sanitise the password because it is already sanitised by md5 function, but the best practice is to sanitise password as well
        $password=mysqli_real_escape_string($conn,md5($_POST['password']));

        //2. SQL query to check whether the username and password exist
        $sql="SELECT * FROM tbl_admin WHERE 
            username='$username' AND 
            password='$password'
        ";

        //3. Executing the query
        $res=mysqli_query($conn,$sql);

        //4.count rows to check whether user exists
        $count=mysqli_num_rows($res);

        if($count==1){
            //user available and login success
            $_SESSION['login']="<div class='success'>Login Successful</div>";
            $_SESSION['user']=$username;//to check whether the user is logged in(logout will unset it)
            
            //redirect to homepage/dashboard
            header('location:'.SITEURL.'admin/');

        }else{
            //user not registered and login failed
            $_SESSION['login']="<div class='error text-center'>Username and password do not match.</div>";
            //redirect to homepage/dashboard
            header('location:'.SITEURL.'admin/login.php');
        }
    }
?>
<?php

    //Startng the session
    session_start();

    //creating constants to store non-repeating values
    define('LOCALHOST','localhost');
    define('DB_USERNAME','root');
    define('DB_PASSWORD','');
    define('DB_NAME','food-order');
    define('SITEURL','http://localhost/food-order/');

    //1.Connecting to the database
    $conn= mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error());
    $db_select=mysqli_select_db($conn,DB_NAME) or die(mysqli_error());        

    //checking whether database connected
    //the whole of below code will be used only when we need to check database connection
    /* if($conn==true){
        echo "Database connected.";
    }*/
    
?>
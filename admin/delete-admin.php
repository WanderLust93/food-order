<?php
    include('../config/constants.php');

    //1.get the id of admin to be deleted    
    //2.create SQL query to delete admin
    //3.redirect to the manage-admin page with message(success or failure)

    //1.get the id of admin from manage-admin to be deleted
    $id=$_GET['id'];

    //2.create SQL query to delete admin
    $sql="DELETE FROM tbl_admin WHERE 
        id=$id    
    ";
    //executing the query
    $res=mysqli_query($conn,$sql);
    //checking whether query executed successfully
    if($res==true)
    {
        $_SESSION['delete']="<div class='success'>Admin Deleted Successfully.</div>";
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else{
        $_SESSION['delete']="<div class='error'>Failed to delete Admin; try again.</div>";
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
?>
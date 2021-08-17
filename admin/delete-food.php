<?php
    include('../config/constants.php');

    //1.get the id of food to be deleted and check whether id and image_name value is set   
    //2.create SQL query to delete food
    //3.redirect to the manage-food page with message(success or failure)

    //checking whether id and image_name is passed through the manage-category page or it was put in by the user by typing into URL
    if(isset($_GET['id']) AND isset($_GET['image_name']))//use either && or AND
    {   
        //echo "here";
        
        //get these values and delete
        $id=$_GET['id'];
        $image_name=$_GET['image_name'];

        //check whether image is available and remove the physical image file if available
        if($image_name != '')
        {
            //image available;remove it
            $path="../images/food/".$image_name;
            //removing the image
            $remove=unlink($path);//gives out a boolean value
            if($remove=FALSE)
            {
                //if failed to remove the image, add an error message and stop further process
                $_SESSION['upload']="<div class='eroor'>Failed to remove Food Image.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
                die();

            }
        }

        //delete data from the database
        $sql="DELETE FROM tbl_food WHERE 
            id=$id    
        ";
        //executing the query
        $res=mysqli_query($conn,$sql);
        //checking whether query executed successfully
        if($res==true)
        {
            $_SESSION['delete']="<div class='success'>Food Deleted Successfully.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        
        else
        {
            $_SESSION['delete']="<div class='error'>Failed to delete Food; try again.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');

        }
    }
    else
    {
            //redirect to manage-categroy page
            //echo "redirect";
            $_SESSION['unauthorised']="<div class='error'>Unauthorised Access.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
    }

?>
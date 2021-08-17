<?php
    include('../config/constants.php');

    //1.get the id of admin to be deleted adn check whether id and image_name value is set   
    //2.create SQL query to delete admin
    //3.redirect to the manage-admin page with message(success or failure)

    //checking whether id and image_name is passed through the manage-category page or it was put in by the user by typing into URL
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        //get these values and delete
        $id=$_GET['id'];
        $image_name=$_GET['image_name'];

        //remove the physical image file if available
        if($image_name != '')
        {
            //image available;remove it
            $path="../images/category/".$image_name;
            //removing the image
            $remove=unlink($path);//gives out a boolean value
            if($remove=FALSE)
            {
                //if failed to remove the image, add an error message and stop further process
                $_SESSION['remove']="<div class='eroor'>Failed to remove Category Image.</div>";
                header('location:'.SITEURL.'admin/manage-category.php');
                die();

            }
        }

        //delete data from the database
        $sql="DELETE FROM tbl_category WHERE 
            id=$id    
        ";
        //executing the query
        $res=mysqli_query($conn,$sql);
        //checking whether query executed successfully
        if($res==true)
        {
            $_SESSION['delete']="<div class='success'>Category Deleted Successfully.</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        
        else
        {
            $_SESSION['delete']="<div class='error'>Failed to delete Category; try again.</div>";
            header('location:'.SITEURL.'admin/manage-categor.php');

        }
    }
    else
    {
            //redirect to manage-categroy page
            header('location:'.SITEURL.'admin/manage-category.php');
    }

?>
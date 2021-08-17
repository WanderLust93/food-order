<?php
    include('partials/menu.php');
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br><br>
       
        <?php
            //getting values from the database to display
            //check whether id is set
            if(isset($_GET['id']))
            {
                //get id and other details
                $id = $_GET['id'];
                //SQL query to get the details
                $sql="SELECT * FROM tbl_category WHERE id =$id";
                //executing the query
                $res=mysqli_query($conn,$sql);

                //count the rows to check if 'id' valid
                $count= mysqli_num_rows($res);

                if($count == 1)
                {
                    //get all the values
                    $row=mysqli_fetch_assoc($res);
                    $title=$row['title'];
                    $current_image=$row['image_name'];
                    $featured=$row['featured'];
                    $active=$row['active'];
                }
                else
                {
                    //redirect to manage-category with session message
                    $_SESSION['no-category-found']="<div class='error'>Category not found.</div>";
                    //redirect to manage category page
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                
            }
            else
            {
                $_SESSION['unauthorised']="<div class='error'>Unauthorised Access</div>";
                //redirect to manage category page
                header('location:'.SITEURL.'admin/manage-category.php');
            }
        ?>
        <!--Add Category Form starts here-->
        <form action="" method="POST" enctype="multipart/form-data">
        <!--"enctype="multipart/form-data" allows to upload image to the database-->
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" value="<?php echo $title;?>"></td>
                </tr>
                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                            if($current_image != '')
                            {
                                //display the image
                                ?>
                                <img src="<?php echo SITEURL;?>images/category/<?php echo $current_image;?>" width="165px">
                                <?php


                            }
                            else
                            {
                                //display message
                                echo "<div class='error'>Image not available.</div>";
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>New Image:</td>
                    <td>
                        <input type="file" name="image" enctype="multipart/form-data">
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <!--Below, php is added in the input tag to fetch the status of the Featured button, and checked is to show tick mark in the raido button-->
                        <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes">Yes

                        <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <!--Below, php is added in the input tag to fetch the status of the Featured button, and checked is to show tick mark in the raido button-->
                        <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes">Yes

                        <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No">No
                        
                    </td>

                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="current_image" value="<?php echo $current_image;?>">
                        <input type="hidden" name="id" value="<?php echo $id;?>"?>
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">

                    </td>
                </tr>
            </table>
        </form>
        <?php
            if(isset($_POST['submit']))
            {
                //echo "submit";
                //1.Get all the values from our form
                $id=$_POST['id'];
                $title=$_POST['title'];
                $current_image=$_POST['current_image'];
                $featured=$_POST['featured'];
                $active=$_POST['active'];

                //2.updating new image if selected
                //whether new image is selected
                if(isset($_FILES['image']['name']))//this is a function to retrieve file from the form
                {
                    //get image details
                    $image_name=$_FILES['image']['name'];

                    //check whether image available(when a user submits the form without choosing any image)
                    if($image_name != '')
                    {
                        //1. image availabe
                        //1.1 upload the image

                        //auto-renaming the image uploaded
                        //get the extension of our image, such as '.jpg' in case of 'xyz.jpg', xyz.xyz.jpg
                        $ext=end(explode('.',$image_name));//'explode' divides the name from the given parameter, '.' in case of above example, and end selects the last part of the division(in case a name has two dots in its name)

                        //renaming the image
                        $image_name="Food_Category_".rand(0000,9999).'.'.$ext;//e.g. Food_Category_545.jpg

                        $source_path=$_FILES['image']['tmp_name'];

                        $destination_path="../images/category/".$image_name;

                        //Finally, upload the image
                        $upload=move_uploaded_file($source_path, $destination_path);

                        //check whether image is uploaded, and if image is not uploaded, we will stop the process and redirect with error message
                        if($upload==FALSE)
                        {
                            $_SESSION['upload']="<div class='error'>Failed to upload the Image.</div>";
                            header('location:'.SITEURL.'admin/manage-category.php');
                            //stop the process
                            die();
                        }
                        if($current_image != '')
                        {
                            //1.2 remove current image
                            $remove_path="../images/category/".$current_image;
                            $remove=unlink($remove_path);

                            //check whether image is removed
                            //if failed to remvoe, display message and die
                            if($remove==FALSE)
                            {
                                $_SESSION['failed-remove']="<div class='error'>Failed to remove current image.</div>";
                                header('location:'.SITEURL.'admin/manage-category.php');
                                die();
                            }
                        }

                    }
                    else 
                    {
                        //upload the same image
                        $image_name=$current_image;
                    }

                }
                else
                {
                    $image_name=$current_image;
                }

                
                //3. update the database
                $sql2="UPDATE tbl_category SET 
                    title='$title',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active'
                    WHERE id='$id'
                ";
                //executing the query
                $res2=mysqli_query($conn,$sql2);

                if($res2==TRUE)
                {
                    //category update
                    $_SESSION['update']="<div class='success'>Category Updated successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else 
                {
                    //failed to update category
                    $_SESSION['update']="<div class='error'>Failed to Update category.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }

            }
        ?>

    </div>
</div>




<?php
    include('partials/footer.php');
?>
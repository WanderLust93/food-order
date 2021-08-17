<?php
    include("partials/menu.php");
?>
<?php
    //check whether id is set
    if(isset($_GET['id']))
    {
        $id=$_GET['id'];
        //SQL query to fetch all food-data
        $sql2="SELECT * FROM tbl_food 
            WHERE id=$id
        ";
        $res2=mysqli_query($conn,$sql2);
        $row2=mysqli_fetch_assoc($res2);

        $title=$row2['title'];
        $description=$row2['description'];
        $price=$row2['price'];
        $current_image=$row2['image_name'];
        $current_category=$row2['category_id'];
        $featured=$row2['featured'];
        $active=$row2['active'];
    }
    else {
        header('location:'.SITEURL.'admin/manage-food.php');
    }
?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>
                
        <form action="" method="POST" enctype="multipart/form-data">
        <!--"enctype="multipart/form-data" allows to upload image to the database-->
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" value="<?php echo $title;?>"></td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="22" rows="5"><?php echo $description;?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price;?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                            if($current_image=='')
                            {
                                //image not available
                                echo "<div class='error'>Image not added.</div>";
                            }
                            else 
                            {
                                //Image avaiable 
                                ?>
                                <img src='<?php echo SITEURL;?>images/food/<?php echo $current_image;?>' width='150px'>
                                <?php   
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Update Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">
                            <?php
                                //PHP code to display categories from database
                                //1. create SQL query to get all active categories from database
                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                                $res=mysqli_query($conn,$sql);
                                
                                $count=mysqli_num_rows($res);

                                if($count>0)
                                {
                                    //database has categories
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        $category_id=$row['id'];
                                        $category_title=$row['title'];
                                        //dropdown uses 'selected' whereas radio button uses 'checked'
                                        ?>
                                        <option <?php if($current_category==$category_id){echo "selected";}?> value='<?php echo $category_id; ?>'><?php echo $category_title;?></option>
                                        <?php
                                        
                                    }
                                }
                                else
                                {
                                    //no category to display
                                    ?>
                                    <option value="0">No category available.</option>
                                    <?php
                                }
                            ?>                          
                            
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input <?php if($featured=="Yes"){echo "checked";}?> type="radio" name="featured" value="Yes">Yes
                        <input <?php if($featured=="No"){echo "checked";}?> type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input <?php if($active=="Yes"){echo "checked";}?>  type="radio" name="active" value="Yes">Yes
                        <input <?php if($active=="No"){echo "checked";}?> type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image;?>">
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">

                    </td>
                </tr>
            </table>
        </form>

        <!--PHP to fetch data from the database-->
        <?php
            //processing the value from Form and saving in database
            //checking whether the 'submit' button is cliked
            if(isset($_POST['submit']))
            {
                //echo 'button clicked';
                //die();
                //echo "Button clicked";
                //getting the data from the Form
                $id= $_POST['id'];
                $title=$_POST['title'];
                $description= $_POST['description'];
                $price= $_POST['price'];
                $current_image=$_POST['current_image'];
                $category= $_POST['category'];
                $featured=$_POST['featured'];
                $active=$_POST['active'];


                //check whether select image button is clicked and upload only if the image is selected
                if(isset($_FILES['image']['name'])){
                    //1. upload the image if available
                    //to upload image we need image_name, source path, and destination path
                    $image_name=$_FILES['image']['name'];
                    //whether the file is available
                    if($image_name!='')
                    {

                        //auto-renaming the image uploaded
                        //get the extension of our image, such as '.jpg' in case of 'xyz.jpg', xyz.xyz.jpg
                        $ext=end(explode('.',$image_name));//'explode' divides the name from the given parameter, '.' in case of above example, and end selects the last part of the division(in case a name has two dots in its name)

                        //renaming the image
                        $image_name="Food-Name-".rand(0000,9999).'.'.$ext;//e.g. Food-Name-545.jpg
                        //'src',source path, is the current location of the image
                        $source_path=$_FILES['image']['tmp_name'];

                        $destination_path="../images/food/".$image_name;

                        //Finally, upload the image
                        $upload=move_uploaded_file($source_path, $destination_path);

                        //check whether image is uploaded, and if image is not uploaded, we will stop the process and redirect with error message
                        if($upload==FALSE){
                            $_SESSION['upload']="<div class='error'>Failed to upload the Image.</div>";
                            header('location:'.SITEURL.'admin/manage-food.php');
                            //stop the process
                            die();
                        }
                        //2. remove current image if available
                        if($current_image!="")
                        {
                            $remove_path="../images/food/".$current_image;
                            $remove= unlink($remove_path);
                            //cheking whether the image is removed
                            if($remove==FALSE)
                            {
                                //failed to remove the image
                                $_SESSION['remove-failed']="<div class='error'>Failed to remove current image.</div>";
                                header('location:'.SITEURL.'admin/manage-food.php');
                                die();
                            }

                        }
                    }
                    else {
                        $image_name=$current_image;//default image when image is not selected
                    }
                }
                else{
                    //Do not upload image and set the image_name value as blank(means that select image button was not clicked)
                    $image_name=$current_image;
                }

                //2.SQL query to insert the data into the database
                $sql3="UPDATE tbl_food SET
                    title='$title',
                    description='$description',
                    price=$price,/*for numerical value we do not need '',but for string value it is compulsory*/
                    image_name='$image_name',
                    category_id='$category',
                    featured='$featured',
                    active='$active'
                    WHERE id=$id/*for numerical value we do not need '',but for string value it is compulsory*/
                ";
                

                //3.executing the Query and Saving the data in database
                $res3=mysqli_query($conn,$sql3);

                if($res2==true)
                    {
                    //echo "Query executed, and category added";
                    //creating a variable to display success message
                    $_SESSION['update']="<div class='success'> Food updated Sucessfuly.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');

                    }
                    else
                    {
                        //echo "Failed to insert data.";
                        $_SESSION['update']="<div class='error'>Oops! Failed to update Food.</div>";
                        header('location:'.SITEURL.'admin/manage-food.php');
                    }
            }
                    ?>
    </div>

</div>
<?php
    include("partials/footer.php");
?>


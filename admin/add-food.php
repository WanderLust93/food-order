<?php
    include("partials/menu.php");
?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br><br>
        <?php

        if(isset($_SESSION['add']))
        {
            //displaying fail session message in case of addition failure
            echo $_SESSION['add'];
            unset($_SESSION['add']);//removing session message

        }

        if(isset($_SESSION['upload']))
        {
            //displaying fail session message in case of addition failure
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);//removing session message

        }
        ?>
        
        <form action="" method="POST" enctype="multipart/form-data">
        <!--"enctype="multipart/form-data" allows to upload image to the database-->
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" placeholder="Food-Title"></td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the Food"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>
                <tr>
                    <td>Select Image:</td>
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
                                        $id=$row['id'];
                                        $title=$row['title'];
                                        ?>
                                        <option value="<?php echo $id;?>"><?php echo $title;?></option>
                                        <?php
                                    }
                                }
                                else
                                {
                                    //no category to display
                                    ?>
                                    <option value="0">No category found.</option>
                                    <?php
                                }
                            ?>                          
                            
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">

                    </td>
                </tr>
            </table>
        </form>

        <!--PHP to insert data into the database-->
        <?php
            //processing the value from Form and saving in database
            //checking whether the 'submit' button is cliked
            if(isset($_POST['submit']))
            {
                //button clicked
                //echo "Button clicked";
                //getting the data from the Form
                $title= $_POST['title'];
                $description= $_POST['description'];
                $price= $_POST['price'];
                $category= $_POST['category'];

                //for radio input, we need to check whether radio button is ticked because there is a possibilit that the user did not choose any of the options.
                if(isset($_POST['featured'])){
                    $featured=$_POST['featured'];
                }
                else{
                    $featured="No";
                }
                
                if(isset($_POST['active'])){
                    $active=$_POST['active'];
                }
                else{
                    $active="No";
                }
                //check whether image is seleted and check the value for image name accordingly
                //print_r($_FILES['image']); //print_r is used here instead of 'echo' because 'echo' does not print the value of an array
                
                //die();//break the code here

                //check whether select image button is clicked and upload only if the image is selected
                if(isset($_FILES['image']['name'])){
                    //upload the image
                    //to upload image we need image_name, source path, and destination path
                    $image_name=$_FILES['image']['name'];
                    //whether image was selected, and upload image only if image is selected
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
                            header('location:'.SITEURL.'admin/add-food.php');
                            //stop the process
                            die();
                        }
                    }
                }
                else{
                    //Do not upload image and set the image_name value as blank(means that select image button was not clicked)
                    $image_name="";
                }

                //2.SQL query to insert the data into the database
                $sql2="INSERT INTO tbl_food SET
                    title='$title',
                    description='$description',
                    price=$price,/*for numerical value we do not need '',but for string value it is compulsory*/
                    image_name='$image_name',
                    category_id='$category',
                    featured='$featured',
                    active='$active'
                ";
                

                //3.executing the Query and Saving the data in database
                $res2=mysqli_query($conn,$sql2);

                if($res2==true)
                    {
                    //echo "Query executed, and category added";
                    //creating a variable to display success message
                    $_SESSION['add']="<div class='success'> Food added Sucessfuly.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');

                    }
                    else
                    {
                        //echo "Failed to insert data.";
                        $_SESSION['add']="<div class='error'>Oops! Failed to add Food.</div>";
                        header('location:'.SITEURL.'admin/add-food.php');
                    }
            }
                    ?>
    </div>

</div>
<?php
    include("partials/footer.php");
?>


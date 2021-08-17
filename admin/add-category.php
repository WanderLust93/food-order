<?php
    include("partials/menu.php");
?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
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
        <!--Add Category Form starts here-->
        <form action="" method="POST" enctype="multipart/form-data">
        <!--"enctype="multipart/form-data" allows to upload image to the database-->
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" placeholder="Category Title"></td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
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
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">

                    </td>
                </tr>
            </table>
        </form>
        <!--Add Category Form ends here-->
        <?php
            //processing the value from Form and saving in database
            //checking whether the 'submit' button is cliked
            if(isset($_POST['submit']))
            {
                //button clicked
                //echo "Button clicked";
                //getting the data from the Form
                $title= $_POST['title'];

                //for radio input, we need to check whether the button is clicked because there is a possibilit that the user did not choose any of the options.
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
                if(isset($_FILES['image']['name'])){
                    //upload the image
                    //to upload image we need image_name, source path, and destination path
                    $image_name=$_FILES['image']['name'];
                    //upload image only if image is selected
                    if($image_name!='')
                    {

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
                        if($upload==FALSE){
                            $_SESSION['upload']="<div class='error'>Failed to upload the Image.</div>";
                            header('location:'.SITEURL.'admin/add-category.php');
                            //stop the process
                            die();
                        }
                    }
                }
                else{
                    //Do not upload image and set the image_name value as blank
                    $image_name="";
                }

                //2.SQL query to insert the data into the database
                $sql="INSERT INTO tbl_category SET
                    title='$title',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active'
                ";

                //3.executing the Query and Saving the data in database
                $res=mysqli_query($conn,$sql) or die(mysqli_error());

                if($res==true)
                    {
                    //echo "Query executed, and category added";
                    //creating a variable to display success message
                    $_SESSION['add']="<div class='success'>Category Added Sucessfuly.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');

                    }
                    else
                    {
                        //echo "Failed to insert data.";
                        $_SESSION['add']="<div class='error'>Oops! Failed to add Category!</div>";
                        header('location:'.SITEURL.'admin/add-category.php');
                    }
            }
                    ?>
    </div>

</div>
<?php
    include("partials/footer.php");
?>


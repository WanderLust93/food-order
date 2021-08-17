<?php
    include("partials/menu.php");
?>

<div class='main-content'>
    <div class='wrapper'>
        <h1>Manage Category</h1>

        <br>
            <br>
            <!-- Button to add Admin -->
            <a href="<?php echo SITEURL;?>admin/add-category.php" class="btn-primary">Add Category</a>
            <br>
            <br>
            <?php
            if(isset($_SESSION['add']))
            {
            //displaying fail session message in case of addition failure
            echo $_SESSION['add'];
            unset($_SESSION['add']);//removing session message
            }

            //displaying session message from delete category page
            if(isset($_SESSION['remove']))
            {
            //displaying fail session message in case of deletion failure
            echo $_SESSION['remove'];
            unset($_SESSION['remove']);//removing session message
            }
            if(isset($_SESSION['delete']))
            {
            //displaying fail session message in case of deletion failure
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);//removing session message
            }

            //diplaying session message from update-category page
            if(isset($_SESSION['unauthorised']))
            {
            //displaying fail session message in case of deletion failure
            echo $_SESSION['unauthorised'];
            unset($_SESSION['unauthorised']);//removing session message
            }

            if(isset($_SESSION['no-category-found']))
            {
            //displaying fail session message in case of no category found
            echo $_SESSION['no-category-found'];
            unset($_SESSION['no-category-found']);//removing session message
            }

            if(isset($_SESSION['update']))
            {
            //displaying session message
            echo $_SESSION['update'];
            unset($_SESSION['update']);//removing session message
            }
            if(isset($_SESSION['upload']))
            {
            //displaying session message
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);//removing session message
            }
            if(isset($_SESSION['failed-remove']))
            {
            //displaying session message
            echo $_SESSION['failed-remove'];
            unset($_SESSION['failed-remove']);//removing session message
            }

            ?>
            <br>
                
                <table class="tbl-full">
                    <tr>
                        <th>S.N.</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Featured</th>
                        <th>Active</th>
                        <th><div class="text-center">Actions</div></th>
                    </tr>
                    <?php
                        $sql="SELECT * FROM tbl_category";
                        $res=mysqli_query($conn,$sql);
                        //checking whether query executed
                        if($res==TRUE)
                        {
                            //function to get all rows of the database
                            $count_rows=mysqli_num_rows($res);
                            //variable to increment serial no.
                            $sn=1;
                            //checking whether there is data in database; if count_rows is greater than 0,there is data in database
                            if($count_rows>0){
                                
                                while($rows=mysqli_fetch_assoc($res))
                                {
                                    $id=$rows['id'];
                                    $title=$rows['title'];
                                    $image_name=$rows['image_name'];
                                    $featured=$rows['featured'];
                                    $active=$rows['active'];
                                    //displaying the values in our table
                                    ?>
                                    <tr>
                                        <td><?php echo $sn++.'.';?></td>
                                        <td><?php echo $title;?></td>

                                        <td>
                                            <?php 
                                                //check whether image name is available
                                                if($image_name != ""){
                                                    //display the image
                                                    ?>

                                                    <img src="<?php echo SITEURL;?>images/category/<?php echo $image_name?>" width="100px">
                                                    
                                                    <?php

                                                }else{
                                                    //display message
                                                    echo "<div class='error'>No Image to display.</div>";
                                                }
                                                
                                            ?>
                                        </td>

                                        <td><?php echo $featured;?></td>
                                        <td><?php echo $active;?></td>
                                        <td>
                                            <a href="<?php echo SITEURL;?>admin/update-category.php?id=<?php echo $id;?>" class="btn-secondary">Update Category</a>
                                            <a href="<?php echo SITEURL;?>admin/delete-category.php?id=<?php echo $id;?>&image_name=<?php echo $image_name;?>" class="btn-danger">Delete Category</a>
                                        </td>
                                    </tr>

                                    <?php
                                }
                            }else
                            {
                                //there is no data
                                //we will diplay the message in the table
                                ?>
                                <tr>
                                    <td colspan="6"><div class="error">No category added.</div></td>
                                </tr>
                                <?php
                            }
                        }
                                    ?>
                    
                    
                </table>

    </div>

</div>



<?php
    include("partials/footer.php");
?>
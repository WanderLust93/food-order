<?php
    include("partials/menu.php");
?>

<div class='main-content'>
    <div class='wrapper'>
        <h1>Manage Food</h1>

        <br>
        <br>
        <!-- Button to add Admin -->
        <a href="<?php echo SITEURL;?>admin/add-food.php" class="btn-primary">Add Food</a>
        <br>
        <br>
        <?php

            if(isset($_SESSION['add']))
            {
                //displaying fail session message in case of addition failure
                echo $_SESSION['add'];
                unset($_SESSION['add']);//removing session message

            }
            if(isset($_SESSION['upload']))//from delete-food page
            {
                //displaying fail session message in case of addition failure
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);//removing session message

            }
            if(isset($_SESSION['delete']))//from delete-food page
            {
                //displaying fail session message in case of addition failure
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);//removing session message

            }
            if(isset($_SESSION['unauthorised']))//from delete-food page
            {
                //displaying fail session message in case of addition failure
                echo $_SESSION['unauthorised'];
                unset($_SESSION['unauthorised']);//removing session message

            }

            if(isset($_SESSION['update']))//from update-food page
            {
                //displaying fail session message in case of addition failure
                echo $_SESSION['update'];
                unset($_SESSION['update']);//removing session message

            }
            if(isset($_SESSION['remove-failed']))//from update-food page
            {
                //displaying fail session message in case of addition failure
                echo $_SESSION['remove-failed'];
                unset($_SESSION['remove-failed']);//removing session message

            }
        ?>
                    
        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Title</th>
                <th>Price</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
            <?php
                //create SQL query to get all the details
                $sql="SELECT * FROM tbl_food";

                $res=mysqli_query($conn,$sql);

                $count= mysqli_num_rows($res);
                $sn=1;

                if($count>0)
                {
                    //we have data to display
                    while($row=mysqli_fetch_assoc($res))
                    {
                        $id=$row['id'];
                        $title=$row['title'];
                        $price=$row['price'];
                        $image_name=$row['image_name'];
                        $featured=$row['featured'];
                        $active=$row['active'];

                        ?>
                        <tr>
                            <td><?php echo $sn++;?></td>
                            <td><?php echo $title;?></td>
                            <td><?php echo $price;?></td>
                            <td>
                                <?php 
                                    //check whether we have image attached in the database
                                    if($image_name=="")
                                    {
                                        echo "<div class='error'>Image not available.</div>";
                                    }
                                    else {
                                        ?>
                                        <img src="<?php echo SITEURL;?>images/food/<?php echo $image_name;?>" width="100px">
                                        <?php
                                    }
                                ?>
                            </td>
                            <td><?php echo $featured;?></td>
                            <td><?php echo $active;?></td>
                            <td>
                                <a href="<?php echo SITEURL;?>admin/update-food.php?id=<?php echo $id;?>" class="btn-secondary">Update Food</a>
                                <a href="<?php echo SITEURL;?>admin/delete-food.php?id=<?php echo $id;?> & image_name= <?php echo $image_name;?>" class="btn-danger">Delete Food</a>
                            </td>
                        </tr>

                        <?php
                    }
                }
                else
                {
                    //No data to display
                    echo "<tr><td colspan='7' class='error'>Food not added yet.</td></tr>";
                }
            ?>
        </table>

    </div>

</div>



<?php
    include("partials/footer.php");
?>
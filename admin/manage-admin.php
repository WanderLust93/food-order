<?php
    include("partials/menu.php");
?>
        <!--Main Content Section starts-->

        <div class= "main-content">
            <div class= "wrapper">
                
            <h1>Manage Admin</h1>
            <br>
            <?php
                //displaying successful session message from add-admin page
                if(isset($_SESSION['add']))
                {
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                }
                //displaying message from delete-admin page
                if(isset($_SESSION['delete']))
                {
                    echo $_SESSION['delete'];
                    unset($_SESSION['delete']);
                }
                //displaying message from update-admin page
                if(isset($_SESSION['update']))
                {
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }
                //displaying message from update-password page
                if(isset($_SESSION['user-not-found']))
                {
                    echo $_SESSION['user-not-found'];
                    unset($_SESSION['user-not-found']);
                }
                //displaying message from update-password page
                if(isset($_SESSION['pwd-not-match']))
                {
                    echo $_SESSION['pwd-not-match'];
                    unset($_SESSION['pwd-not-match']);
                }
                //displaying message from update-password page
                if(isset($_SESSION['change-pwd']))
                {
                    echo $_SESSION['change-pwd'];
                    unset($_SESSION['change-pwd']);
                }
            ?>
            <br><br><br>
            <!-- Button to add Admin -->
            <a href="add-admin.php" class="btn-primary">Add Admin</a>
            <br>
            <br>
                
                <table class="tbl-full">
                    <tr>
                        <th>S.N.</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                        $sql="SELECT * FROM tbl_admin";
                        $res=mysqli_query($conn,$sql);
                        //checking whether query executed
                        if($res==TRUE)
                        {
                            //function to get all rows of the database
                            $count_rows=mysqli_num_rows($res);
                            //variable to increment serial no.
                            $sn=1;
                            if($count_rows>0){
                                
                                while($rows=mysqli_fetch_assoc($res))
                                {
                                    $id=$rows['id'];
                                    $full_name=$rows['full_name'];
                                    $username=$rows['username'];
                                    //displaying the values in our table
                                    ?>
                                    <tr>
                                        <td><?php echo $sn++.'.'; ?></td>
                                        <td><?php echo $full_name; ?></td>
                                        <td><?php echo $username; ?></td>
                                        <td>
                                            <a href="<?php echo SITEURL;?>admin/update-password.php?id=<?php echo $id;?>" class="btn-primary">Change Password</a>
                                            <a href="<?php echo SITEURL;?>admin/update-admin.php?id=<?php echo $id;?>" class="btn-secondary">Update Admin</a>
                                            <a href="<?php echo SITEURL;?>admin/delete-admin.php?id=<?php echo $id;?>" class="btn-danger">Delete Admin</a>
                                        </td>
                                    </tr>


                                    <?php
                                }
                            }
                            else
                            {

                            }
                        }
                    ?>                 
                    
                </table>

                
            </div>
        


        </div>
        <!--Main Content Section starts-->
        
        
<?php
    include("partials/footer.php");
?>
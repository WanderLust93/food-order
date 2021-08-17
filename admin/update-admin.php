<?php
    include("partials/menu.php");
?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br>
        <?php
            //1.get the id from add-admin page
            $id=$_GET['id'];

            //2. create SQL query to fetch and display the details
            $sql="SELECT * FROM tbl_admin WHERE
                id=$id
            ";
            //executing the query
            $res=mysqli_query($conn,$sql);
            if($res==TRUE)
            {
                $count=mysqli_num_rows($res);
                if($count==1){
                    //get the details
                    $row=mysqli_fetch_assoc($res);
                    $full_name=$row['full_name'];
                    $username=$row['username'];
                }
                else{
                    //redirect to manage-admin page
                    header('location:'.SITEURL.'admin/manage-admin.php');

                }
                
            }

        ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <!--we need to put id value in hidden column because we need to retrieve it through form method,i.e., $_form and don't want it to be displayed on the screen, due to the fact that the user may change it.-->
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">

                    </td>
                </tr>
            </table>
        </form>
    </div>

</div>

<?php
    //checking whether submit button is clicked
    if(isset($_POST['submit']))
    {
        //echo 'buttton clicked.';
        //getting all the values from form to update
        $id=$_POST['id'];
        $full_name=$_POST['full_name'];
        $username=$_POST['username'];

        //create a SQL query to update admin
        $sql="UPDATE tbl_admin SET
            full_name='$full_name',
            username='$username'
            WHERE id='$id'
        ";

        //executing the query
        $res=mysqli_query($conn,$sql);
        if($res==TRUE){
            //Query executed and admin update
            $_SESSION['update']="<div class='success'>Admin Updated Successfully.</div>";
            //redirecting to manage-admin page
            header('location:'.SITEURL.'admin/manage-admin.php');
        }else{
            //Failed to update Admin
            $_SESSION['update']="<div class='success'>Failed to Delete Admin.</div>";
            //redirecting to manage-admin page
            header('location:'.SITEURL.'admin/manage-admin.php');
        }

    
    }
?>

<?php
    include("partials/footer.php");
?>

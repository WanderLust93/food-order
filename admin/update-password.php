<?php
    include("partials/menu.php");
?>
<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br>
        
        <?php
            if(isset($_GET['id'])){
                $id=$_GET['id'];
            }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Current Password:</td>
                    <td><input type="password" name="current_password" placeholder="Enter current password"></td>
                </tr>
                <tr>
                    <td>New Password:</td>
                    <td>
                        <input type="password" name="new_password" placeholder="Enter new passowrd">
                    </td>
                </tr>
                <tr>
                    <td>Confirm Password:</td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Re-enter new password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">

                    </td>
                </tr>
            </table>
        </form>
    </div>

</div>

<?php
    //checking whether change password button is clicked
    if(isset($_POST['submit'])){
        //1.Get the data from the form
        //2.check whether the user with current ID and Current Password exists
        //3.cheeck whether new password and confirm password match
        //4. change password if all of the above are true
         
        //echo "clicked.";


        //1.Get the data from the form
        $id=$_POST['id'];
        //here, passwords need to be encrypted in order to match them to the old password that is encrypted
        $current_password=md5($_POST['current_password']);
        $new_password=md5($_POST['new_password']);
        $confirm_password=md5($_POST['confirm_password']);
        
        //2.check whether the user with current ID and Current Password exists
        $sql="SELECT * FROM tbl_admin where id=$id AND password='$current_password'";
        //executing the query
        $res=mysqli_query($conn,$sql);
        if($res==TRUE){
            //checking whether the data is available
            $count=mysqli_num_rows($res);
            if($count==1){
                //user exists and the password can be changed

                //3.cheeck whether new password and confirm password match
                if($new_password==$confirm_password){
                    //update the password
                    //echo "Password Match.";

                    //4. change password if all of the above are true
                    $sql2="UPDATE tbl_admin SET
                        password='$new_password'
                        WHERE id=$id
                    ";
                    //executing the query
                    $res2=mysqli_query($conn,$sql2);
                    //whether query executed
                    if($res2==TRUE){
                        $_SESSION['change-pwd']="<div class='success'>Password changed successfully.</div>";
                        header('location:'.SITEURL.'admin/manage-admin.php');

                    }else{
                        //display error message
                        $_SESSION['change-pwd']="<div class='error'>Failed to change password.</div>";
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }

                }
                else{
                    //redirect the user to manage-admin page with error message
                    $_SESSION['pwd-not-match']="<div class='error'>Passwords do not match.</div>";
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }else{
                //user does not exist 
                $_SESSION['user-not-found']="<div class='error'>User not found.</div>";
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }
    }
?>

<?php
    include("partials/footer.php");
?>
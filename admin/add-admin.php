<?php
    include("partials/menu.php");
?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br>
        <?php

        if(isset($_SESSION['add']))
        {
            //displaying fail session message in case of addition failure
            echo $_SESSION['add'];
            unset($_SESSION['add']);//removing session message

        };
        ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td><input type="text" name="full_name" placeholder="Enter your name"></td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td>
                        <input type="text" name="username" placeholder="Provide your username">
                    </td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td>
                        <!-- input type 'password' does not show the text entered by the user-->
                        <input type="password" name="password" placeholder="Provide your password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">

                    </td>
                </tr>
            </table>
        </form>
    </div>

</div>
<?php
    include("partials/footer.php");
?>

<?php
    //processing the value from Form and saving in database
    //checking whether the 'submit' button is cliked
    if(isset($_POST['submit']))
    {
        //button clicked
        //echo "Button clicked";
        //getting the data from the Form
        $full_name= $_POST['full_name'];
        $username=$_POST['username'];
        $password=md5($_POST['password']);//md5 encrypts the password

        //2.SQL query to insert the data into the database
        $sql="INSERT INTO tbl_admin SET
            full_name='$full_name',
            username='$username',
            password='$password'
        ";

        //3.executing the Query and Saving the data in database
        $res=mysqli_query($conn,$sql) or die(mysqli_error());
        if($res==true)
        {
            //echo "data inserted";
            //creating a variable to display success message
            $_SESSION['add']="<div class='success'>Admin Added Sucessfuly.</div>";
            header('location:'.SITEURL.'admin/manage-admin.php');

        }
        else
        {
            //echo "Failed to insert data.";
            $_SESSION['add']="<div class='error'>Oops! Could not add Admin!</div>";
            header('location:'.SITEURL.'admin/add-admin.php');
        }

    }
    

?>
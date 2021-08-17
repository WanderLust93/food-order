<?php
    include('partials-front/menu.php');
?>
<?php
    //whether food_id is set
    if(isset($_GET['food_id']))
    {
        //food id and details of selected food
        $food_id=$_GET['food_id'];
        //create SQL query to display food from database
        $sql="SELECT * FROM tbl_food WHERE id=$food_id";//limits the no. of output data to only 6
        //execute the query
        $res=mysqli_query($conn, $sql);
        //counting rows to check whether category is available
        $count=mysqli_num_rows($res);
        if($count==1)
        {  
            //food available, display
            //display available foods
            while($row=mysqli_fetch_assoc($res))
            {
                //fetch all the values
                $title=$row['title'];
                $price=$row['price'];
                $image_name=$row['image_name'];

            }
        }
        else{
            //data not available
            header('location:'.SITEURL);
        }
    }
    else{
        //redirect to homepage
        header('location:'.SITEURL);
    }
?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">
                    <?php
                        if($image_name=='')
                        {
                            echo "<div class='error'>No Image to display.</div>";
                        }
                        else {
                            //image available
                            ?>
                            <img src="<?php echo SITEURL;?>images/food/<?php echo $image_name;?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                            <?php
                        }
                    ?>                   
                        
                    </div>
    
                    <div class="food-menu-desc">
                        <h3><?php echo $title;?></h3>
                        <input type="hidden" name="food" value="<?php echo $title;?>">
                        <input type="hidden" name="price" value="<?php echo $price;?>">
                        <p class="food-price">$<?php echo $price;?></p>

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Adarsh Raj" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. xxx@xxx.xx" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>
            <?php
                //check whether submit button is clicked
                if(isset($_POST['submit'])){
                    //proceed ahead and get all details from the form
                    $food =$_POST['food'];
                    $price =$_POST['price'];
                    $qty =$_POST['qty'];

                    $total =$price * $qty;
                    $order_date=date("Y-m-d h:i:sa");//order date
                    $status="Ordered";//four different status- Ordered, On delivery, delivered, cancelled 
                    $cutomer_name =$_POST['full-name'];
                    $customer_contact =$_POST['contact'];
                    $customer_email=$_POST['email'];
                    $cutomer_address=$_POST['address'];

                    //save above data to database
                    $sql2="INSERT INTO tbl_order SET
                        food='$food',
                        price=$price,
                        quantity=$qty,
                        total=$total,
                        order_date='$order_date',
                        status='$status',
                        customer_name='$cutomer_name',
                        customer_contact='$customer_contact',
                        customer_email='$customer_email',
                        customer_address='$cutomer_address'
                    ";

                    //echo $sql2; die();

                    $res2=mysqli_query($conn,$sql2);

                    if($res2==TRUE){
                        //query executed and order saved
                        $_SESSION['order']="<div class='success text-center'>Food Ordered Successfully.</div>";
                        header('location:'.SITEURL);
                    }
                    else{
                        //echo $sql2;die();
                        //failed to save order
                        $_SESSION['order']="<div class='error text-center'>Failed to place order.</div>";
                        header('location:'.SITEURL);
                    }
                }
            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

<?php
    include('partials-front/footer.php');
?>

                
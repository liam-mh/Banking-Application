<?php 
require("NavBar.php");
include_once("viewTableSQL.php");

$user = getUsers();
$result = $_GET['createUser'];

//Updating webpage if 'home' button is pressed
if (isset($_POST['home'])) {header('Location:index.php?');}
?>


<div class="container pb-5">
    <main role="main" class="pb-3">

        <br>
        <p style="text-align:center"><img alt="User Icon" src="/AssignmentProject/bread-icon.png" class="centerimage" width="60" height="60"></p>
        <h2 style="text-align:center">Welcome to Store Your Bread</h2><br>

        <div>   
            <?php if($result): ?>
              
                <!-- Successful registry and account details -->    
                <div class="row">

                    <div class="col-md-8" style="text-align:center">  
                        <div class="cream-box-no-height">
                            <h3>Congratulations, you've successfully registered!</h3>
                            <p>Here's your first slice of the bread</p>
                            <p><img alt="User Icon" src="/AssignmentProject/slice.png" class="centerimage" width="50" height="50"></p>
                            <p>Your application ID is : <br>
                                <b><?php echo $user[count($user)-1]['appID'];?></b></p>
                        </div> 
                    </div>
                    
                    <div class="col-md-4"> 
                        <div class="cream-box">
                        <h3 style="text-align:center">New Account Details</h3>
                        <hr style="height:1px; color:#b79557; background-color:#b79557">
                        <p>First Name : <b><?php echo $user[count($user)-1]['firstName'];?></b><br>
                        Last Name : <b><?php echo $user[count($user)-1]['lastName'];?></b><br>
                        Postcode : <b><?php echo $user[count($user)-1]['postcode'];?></b><br>
                        Date of application : <b><?php echo $user[count($user)-1]['appDate'];?></b><br>
                        Application ID : <b><?php echo $user[count($user)-1]['appID'];?></b></p>
                        </div> 
                    </div>

                </div>       
                        
                <br>

                <!-- Extra info -->         
                <div class="cream-box">
                    <h5>Extra Information</h5>
                    <hr style="height:1px; color:#b79557; background-color:#b79557">
                    <p>Thank you for your interest to open a Time Deposit Account with us under this campaign. Your application ID is <?php echo $user[count($user)-1]['appID'];?>. Only one application is allowed per customer.</p>
                    <p>You will have <b><?php echo $user[count($user)-1]['luckyDraw'];?></b> entries for the lucky draw (stand a chance to win £10,000) upon successful deposit placement until the end of account tenure.</p>
                    <p>Your record has been successfully submitted. You may update your record as long as your application status is “new” by providing your application ID.</p>       
                </div>

                <br>

                <!-- Home button -->
                <form method="post"> 
                    <div class="d-flex justify-content-center">                          
                        <input type="submit" value="Click here to return to the home page" class="btn btn-primary" name="home">
                    </div>
                </form>
                    
            <?php else: ?>
                <p>Sorry, an error has occured<a href=<?php echo "index.php" ?>> click me to go home</a></p>

            <?php endif; ?>

        </div>
        
    </main>
</div>

<br>

<?php require("Footer.php");?>
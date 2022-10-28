<?php 
require("userNavBar.php");
include("session.php");

//User session
$path = "Login.php"; 
session_start(); 
 if (!isset($_SESSION['appID'])) {
     session_unset();
     session_destroy();
     header("Location:".$path);
 }
$firstName = $_SESSION['userFirstName']; 
checkSession ($path); 

//Updating webpage if 'home' button is pressed
if (isset($_POST['home'])) {header('Location:Logout.php?');}
?>


<div class="container bgColor">
    <main role="main" class="pb-3">
        
        <br>
        <!-- Logo and withdrawn message -->
        <p style="text-align:center"><img alt="User Icon" src="/AssignmentProject/bread-icon.png" class="centerimage" width="60" height="60"></p>
        <h1 style="text-align:center">Store Your Bread</h1><br>    
        <div class="cream-box col-7">
            <div style="text-align:center">
                <h3>We're sorry to see you go <?php echo ucfirst($firstName);?></h3>
                <p>We hope you will come back and store your bread with us another day!<p>
                <br>
                <p><img alt="User Icon" src="/AssignmentProject/leave slice.png" class="centerimage" width="150" height="90"></p>
            </div>
        </div> 

        <br><br>

        <!-- Home button -->
        <form method="post"> 
            <div class="d-flex justify-content-center">                          
                <input type="submit" value="Click here to return to the home page" class="btn btn-primary" name="home">
            </div>
        </form>

    </main>
</div>

<?php require("Footer.php");?>
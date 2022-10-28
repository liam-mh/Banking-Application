<?php 
require("NavBar.php");
include_once("createNewSQL.php"); 
include_once("viewTableSQL.php");

$masterKey = "BR34D"; //Setting masterkey for admin creation
$errorMasterKey = $errorUsername = $errorPassword = ""; 
$allFields = "yes";

//Creating new Admin in Admin table
if (isset($_POST['submit'])) {

    if ($_POST['masterKey']!=$masterKey) {$errorMasterKey = "Incorrect master key"; $allFields = "no";}
    if ($_POST['masterKey']==null)       {$errorMasterKey = "Please enter the master key"; $allFields = "no";}
    if ($_POST['username']==null)        {$errorUsername = "Please enter a username"; $allFields = "no";}
    if ($_POST['password']==null)        {$errorPassword = "Please enter a password"; $allFields = "no";}

    if($allFields == "yes") {
        $createAdmin = createAdmin();
        header('Location: adminCreationSummary.php?createAdmin='.$createAdmin);
    }    
}

$admin = getAdmin();
$password = $admin[count($admin)-1]['password'];

//Creating hidden password to display
$first = substr($password, 0,1);
$last = substr($password, -1);
$length = strlen($password)-2;
$stars = str_repeat("*", $length);
$hiddenPassword = $first.$stars.$last;

//Updating webpage if buttons are pressed
if (isset($_POST['submit'])) {header('Location:createAdmin.php?submit=true');}
if (isset($_POST['home']))   {header('Location:index.php?');}
if (isset($_POST['admin']))  {header('Location:adminLogin.php?');}
?>


<div class="container bgColor">
    <main role="main" class="pb-3">

        <br>
        <div class="row">

            <!-- Login -->
            <div class="row col-md-7">
                <div class="col-12">
                    <h2>Create a new Admin account</h2>
                    <br>
                    <p class="text-danger"><b>This is a restricted access area</b><br>
                    If you are a Store Your Bread user please click <a href=<?php echo "index.php" ?>>here to go home.</a></p>
                    <br>

                    <!-- User Inputs to create admin -->
                    <div class="row">
            
                        <form method="post"> 
                            <div class="form-group col-md-12 ">
                                <label class="control-label labelFont">Username</label>
                                <input class="form-control" type="text" name="username">
                                <span class="text-danger"><?php echo $errorUsername; ?></span>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="control-label labelFont">Password</label>
                                <input class="form-control" type="text" name="password">
                                <span class="text-danger"><?php echo $errorPassword; ?></span>
                            </div>
                            <br><br>
                            <div class="form-group col-md-12 ">
                                <label class="control-label labelFont">Master Key</label>
                                <input class="form-control" type="text" name="masterKey">
                                <span class="text-danger"><?php echo $errorMasterKey; ?></span>
                            </div> 
                            <br>
                            <div class="form-group col-md-4">
                                <input class="btn btn-primary" type="submit" value="Create Admin" name ="submit">
                            </div>
                        </form>

                    </div>   

                    <br>
                    <p><b>Where to find Master Key?</b><br>
                        Speak to your Senior to obtain the key to create new Admin accounts.</p>

                </div>
            </div>

            <!-- admin creation summary -->
            <?php if(isset($_GET['submit'])): ?>
                <div class="col-md-5"> 
                    <div class="cream-box-no-height">

                        <div style="text-align:center">
                            <h4 style="text-align:center">New Admin Account Created</h4>
                            <hr style="height:1px; color:#b79557; background-color:#b79557">
                            <p>Username : <b><?php echo $admin[count($admin)-1]['username'];?></b><br>
                            Password : <b><?php echo $hiddenPassword;?></b></p> 
                            <p>What would you like to do next?</p>
                        </div>    

                        <form method="post">
                            <div class="row"> 

                                <!-- blank 2 box -->
                                <div class="col-md-2"></div> 
                                <!-- Home button -->
                                <div class="col-md-4" style="text-align:center">               
                                    <input type="submit" value="Home Page" class="btn btn-primary" name="home">
                                </div>
                                <!-- Admin Login --> 
                                <div class="col-md-4" style="text-align:center">                          
                                    <input type="submit" value="Admin Login" class="btn btn-primary" name="admin">
                                </div>

                            </div>
                        </form>
                        
                    </div> 
                </div>
            <?php endif; ?>

        </div>

    </main>
</div>

<?php require("Footer.php");?>



